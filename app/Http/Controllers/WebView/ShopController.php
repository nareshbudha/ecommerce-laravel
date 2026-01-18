<?php

namespace App\Http\Controllers\WebView;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    // -------------------------------
    // Get filter data for sidebar
    // -------------------------------
    private function getFilterData($query)
    {
        $products = $query->get(['id', 'variants']);
        $productIds = $products->pluck('id');
        $categories = Category::whereHas('products', function ($q) use ($productIds) {
            $q->whereIn('id', $productIds);
        })->get();

        $subcategories = $categories->isNotEmpty()
            ? SubCategory::whereIn('category_id', $categories->pluck('id'))
            ->withCount(['products as products_count' => function ($q) use ($productIds) {
                $q->whereIn('id', $productIds);
            }])->get()
            : SubCategory::all();

        $brands = Brand::whereHas('products', function ($q) use ($productIds) {
            $q->whereIn('id', $productIds);
        })->withCount(['products as products_count' => function ($q) use ($productIds) {
            $q->whereIn('id', $productIds);
        }])->get();

        // Flatten variants from all products
        $variants = $products->flatMap(function ($p) {
            return is_string($p->variants) ? json_decode($p->variants, true) ?? [] : ($p->variants ?? []);
        });

        // Extract unique colors and sizes
        $colors = [];
        $sizes = [];
        foreach ($variants as $variant) {
            if (!empty($variant['color'])) {
                $variantColors = array_map('trim', explode(',', str_ireplace('and', '', $variant['color'])));
                $colors = array_merge($colors, $variantColors);
            }
            if (!empty($variant['size'])) {
                $variantSizes = array_map('trim', explode(',', $variant['size']));
                $sizes = array_merge($sizes, $variantSizes);
            }
        }

        return [
            'categories' => $categories,
            'subcategories' => $subcategories,
            'brands' => $brands,
            'colors' => collect(array_unique($colors)),
            'sizes' => collect(array_unique($sizes)),
        ];
    }

    // -------------------------------
    // Apply filters to product query
    // -------------------------------
    private function applyFilters($query, Request $request, $category = null, $subcategory = null, $brand = null)
    {
        if ($category) $query->where('category_id', $category->id);
        if ($subcategory) $query->where('sub_category_id', $subcategory->id);
        if ($brand) $query->where('brand_id', $brand->id);

        if ($colors = $request->get('color')) {
            $colors = is_array($colors) ? $colors : [$colors];
            $query->where(function ($q) use ($colors) {
                foreach ($colors as $color) {
                    $q->orWhere('variants', 'like', '%' . $color . '%');
                }
            });
        }

        if ($sizes = $request->get('size')) {
            $sizes = is_array($sizes) ? $sizes : [$sizes];
            $query->where(function ($q) use ($sizes) {
                foreach ($sizes as $size) {
                    $q->orWhere('variants', 'like', '%' . $size . '%');
                }
            });
        }

        if ($request->filled(['min_price', 'max_price'])) {
            $query->whereBetween('sale_price', [$request->min_price, $request->max_price]);
        }

        return $query;
    }

    // -------------------------------
    // Apply sorting to product query
    // -------------------------------
    private function applySorting($query, $sort)
    {
        return match ($sort) {
            'featured' => $query->where('featured', true),
            'bestselling' => $query->orderByDesc('sales_count'),
            'name_asc' => $query->orderBy('name', 'asc'),
            'name_desc' => $query->orderBy('name', 'desc'),
            'price_asc' => $query->orderBy('sale_price', 'asc'),
            'price_desc' => $query->orderBy('sale_price', 'desc'),
            'date_old' => $query->orderBy('created_at', 'asc'),
            'date_new' => $query->orderBy('created_at', 'desc'),
            default => $query->latest(),
        };
    }

    // -------------------------------
    // Generic shop page renderer
    // -------------------------------
    private function renderShopPage(Request $request, $view, $categorySlug = null, $subcategorySlug = null, $brandSlug = null)
    {
        $category = $categorySlug ? Category::where('slug', $categorySlug)->first() : null;
        $subcategory = $subcategorySlug ? SubCategory::where('slug', $subcategorySlug)->first() : null;
        $brand = $brandSlug ? Brand::where('slug', $brandSlug)->first() : null;

        $query = Product::with('reviews')->whereNotNull('variants');
        $query = $this->applyFilters($query, $request, $category, $subcategory, $brand);
        $query = $this->applySorting($query, $request->get('sort'));

        $filters = $this->getFilterData(clone $query);
        $products = $query->paginate(8)->appends($request->query());

        return view($view, array_merge($filters, [
            'products' => $products,
            'activeCategory' => $category,
            'activeSubcategory' => $subcategory,
            'activeBrand' => $brand,
        ]));
    }

    // -------------------------------
    // Public shop pages
    // -------------------------------
    public function shop(Request $request, $categorySlug = null, $subcategorySlug = null, $brandSlug = null)
    {
        return $this->renderShopPage($request, 'webview.shop.shop', $categorySlug, $subcategorySlug, $brandSlug);
    }

        public function hotDeals(Request $request, $categorySlug = null, $subcategorySlug = null, $brandSlug = null, $color = null, $size = null, $price = null)
    {
        return $this->renderShopPage($request, 'webview.shop.hot-deals', $categorySlug, $subcategorySlug, $brandSlug, $color, $size, $price);
    }

    public function newArrivals(Request $request, $categorySlug = null, $subcategorySlug = null, $brandSlug = null, $color = null, $size = null, $price = null)
    {
        return $this->renderShopPage($request, 'webview.shop.new-arrivals', $categorySlug, $subcategorySlug, $brandSlug, $color, $size, $price);
    }

    public function featured(Request $request, $categorySlug = null, $subcategorySlug = null, $brandSlug = null, $color = null, $size = null, $price = null)
    {
        return $this->renderShopPage($request, 'webview.shop.featured', $categorySlug, $subcategorySlug, $brandSlug, $color, $size, $price);
    }

    public function allshop(Request $request, $categorySlug = null, $subcategorySlug = null, $brandSlug = null, $color = null, $size = null, $price = null)
    {
        return $this->renderShopPage($request, 'webview.shop.allshop', $categorySlug, $subcategorySlug, $brandSlug, $color, $size, $price);
    }
}
