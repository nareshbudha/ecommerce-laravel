<?php

namespace App\Http\Controllers\DashBoard;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Product\CreateProductRequest;
use App\Http\Requests\Dashboard\Product\UpdateProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        return view('dashboard.pages.products.products', compact('products'));
    }

    public function create()
    {
        $brands = Brand::all();
        return view('dashboard.pages.products.add-product', compact('brands'));
    }

    public function store(CreateProductRequest $request)
    {
        $data = $request->validated();

        // Handle main product image
        if ($request->hasFile('image')) {
            $data['image'] = ImageHelper::upload($request->file('image'), 'product_main_images');
        }

        $totalQuantity = 0;

        if ($request->has('variants')) {
            $variants = $request->variants;

            foreach ($variants as $key => $variant) {
                // Handle variant images
                if (isset($variant['images'])) {
                    $variantImages = [];
                    foreach ($variant['images'] as $img) {
                        if ($img instanceof \Illuminate\Http\UploadedFile) {
                            $variantImages[] = ImageHelper::upload($img, 'product_images/variants');
                        }
                    }
                    $variants[$key]['images'] = $variantImages;
                }

                // Calculate total quantity
                if (isset($variant['quantity'])) {
                    $totalQuantity += (int) $variant['quantity'];
                }
            }

            $data['variants'] = $variants;
        }

        $data['quantity'] = $totalQuantity;

        // Generate slug
        $data['slug'] = Str::slug($data['name']);

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function show(Product $product)
    {
        $reviews = $product->reviews()->with('user')->latest()->get();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->distinct('id')
            ->take(8)
            ->get();

        return view('dashboard.pages.products.product-detail', compact('product', 'relatedProducts', 'reviews'));
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        $brands = Brand::all();

        return view('dashboard.pages.products.product-edit', compact('product', 'categories', 'brands'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            // Delete old main image if exists
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $data['image'] = ImageHelper::upload($request->file('image'), 'product_main_images');
        }

        $totalQuantity = 0;

        if ($request->has('variants')) {
            $variants = $request->variants;

            foreach ($variants as $key => $variant) {
                // Get existing images for this variant, if any
                $existingImages = $product->variants[$key]['images'] ?? [];

                $variantImages = [];

                if (isset($variant['images'])) {
                    foreach ($variant['images'] as $img) {
                        if ($img instanceof \Illuminate\Http\UploadedFile) {
                            $variantImages[] = ImageHelper::upload($img, 'product_images/variants');
                        } elseif (is_string($img)) {
                            // Keep old image path
                            $variantImages[] = $img;
                        }
                    }
                } else {
                    // If no new images provided, keep existing images
                    $variantImages = $existingImages;
                }

                $variants[$key]['images'] = $variantImages;

                // Calculate total quantity
                if (isset($variant['quantity'])) {
                    $totalQuantity += (int) $variant['quantity'];
                }
            }

            $data['variants'] = $variants;
        }

        $data['quantity'] = $totalQuantity;

        // Update slug if name changed
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }



    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    public function showBySubCategory($slug)
    {
        $subCategory = SubCategory::where('slug', $slug)->firstOrFail();
        $product = Product::where('sub_category_id', $subCategory->id)->firstOrFail();

        $reviews = $product->reviews()->with('user')->latest()->get();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->distinct('id')
            ->take(8)
            ->get();

        return view('dashboard.pages.products.product-detail', compact(
            'product',
            'subCategory',
            'reviews',
            'relatedProducts'
        ));
    }

    public function detail($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $variants = is_string($product->variants) ? json_decode($product->variants, true) : $product->variants;

        $colors = collect($variants)->pluck('color')
            ->map(fn($c) => explode(',', $c))
            ->flatten()
            ->map(fn($c) => trim($c))
            ->unique()
            ->values();

        $sizes = collect($variants)->pluck('size')
            ->map(fn($s) => explode(',', $s))
            ->flatten()
            ->map(fn($s) => trim($s))
            ->unique()
            ->values();

        $colorImages = [];
        foreach ($variants as $v) {
            $vColors = array_map('trim', explode(',', $v['color']));
            foreach ($vColors as $c) {
                if (!isset($colorImages[strtolower($c)])) {
                    $colorImages[strtolower($c)] = $v['images'][0] ?? $product->image;
                }
            }
        }

        $reviews = $product->reviews()->with('user')->latest()->get();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(8)
            ->get();

        return view('dashboard.pages.products.product-detail', compact(
            'product',
            'variants',
            'colors',
            'sizes',
            'colorImages',
            'reviews',
            'relatedProducts'
        ));
    }

    public function getVariants($id)
    {
        $product = Product::findOrFail($id);

        $variants = collect($product->variants)->map(function ($v) {
            return [
                'color' => $v['color'] ?? '',
                'size' => $v['size'] ?? '',
            ];
        })->toArray();

        return response()->json(['variants' => $variants]);
    }
}
