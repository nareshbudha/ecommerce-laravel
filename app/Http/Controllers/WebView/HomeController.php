<?php

namespace App\Http\Controllers\WebView;

use App\Models\Brand;
use App\Models\Slider;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;


class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sliders = Slider::where('status', 1)->get();
        $subCategories = SubCategory::whereHas('products')->get();
        $products = Product::all();
        $brands = Brand::whereHas('products')->get();
        $cartItems = CartItem::where('user_id', auth()->id())->get();
        return view('webview.index.index', compact('sliders', 'subCategories', 'products', 'cartItems', 'brands'));
    }

    public function showProductsByBrand(Request $request, Brand $brand)
    {
        $query = Product::with(['brand', 'reviews', 'category', 'subCategory'])
            ->where('brand_id', $brand->id);

        // Filter by category
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }
        // Filter by sub-category
        if ($request->filled('sub_category')) {
            $subCategory = SubCategory::where('slug', $request->sub_category)->first();
            if ($subCategory) {
                $query->where('sub_category_id', $subCategory->id);
            }
        }

        // Filter by color
        if ($request->filled('color')) {
            $query->where(function ($q) use ($request) {
                $q->whereJsonContains('variants', [['color' => $request->color]]);
            });
        }

        // Filter by size
        if ($request->filled('size')) {
            $query->where(function ($q) use ($request) {
                $q->whereJsonContains('variants', [['size' => $request->size]]);
            });
        }

        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('regular_price', [$request->min_price, $request->max_price]);
        }

        // Apply sorting
        $sort = $request->get('sort');
        $query = $this->applySorting($query, $sort);

        // Paginate
        $products = $query->paginate(12)->withQueryString();

        // All brands with product count
        $brands = Brand::whereHas('products')->withCount('products')->get();

        // Categories & sub-categories for this brand (with counts)
        $categoryCounts = Product::where('brand_id', $brand->id)
            ->select('category_id', DB::raw('count(*) as total'))
            ->groupBy('category_id')
            ->pluck('total', 'category_id');

        $subCategoryCounts = Product::where('brand_id', $brand->id)
            ->select('sub_category_id', DB::raw('count(*) as total'))
            ->groupBy('sub_category_id')
            ->pluck('total', 'sub_category_id');

        $categoryIds = $categoryCounts->keys()->toArray();
        $subCategoryIds = $subCategoryCounts->keys()->toArray();

        $categories = Category::whereIn('id', $categoryIds)->get();
        $subCategories = SubCategory::whereIn('id', $subCategoryIds)->get();

        // Variants for filters
        $allVariants = $products->flatMap(fn($p) => is_string($p->variants) ? json_decode($p->variants, true) : $p->variants);
        // first variant for image

        $colors = collect($allVariants)->pluck('color')->filter()->flatten()->unique()->values();
        $sizes = collect($allVariants)->pluck('size')->filter()->flatten()->unique()->values();

        return view('webview.shop.brands', compact(
            'products',
            'brands',
            'categories',
            'subCategories',
            'colors',
            'sizes',
            'brand',
            'categoryCounts',
            'subCategoryCounts'
        ));
    }
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



    public function newarrival(Request $request)
    {
        $query = Product::with(['brand', 'reviews', 'category', 'subCategory'])
            ->where('new_arrivals', 1);
        if ($request->filled('brand')) {
            $brand = Brand::where('slug', $request->brand)->first();
            if ($brand) {
                $query->where('brand_id', $brand->id);
            }
        }

        // Filter by category
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Filter by sub-category
        if ($request->filled('sub_category')) {
            $subCategory = SubCategory::where('slug', $request->sub_category)->first();
            if ($subCategory) {
                $query->where('sub_category_id', $subCategory->id);
            }
        }

        // Filter by color
        if ($request->filled('color')) {
            $query->where(function ($q) use ($request) {
                $q->whereJsonContains('variants', [['color' => $request->color]]);
            });
        }

        // Filter by size
        if ($request->filled('size')) {
            $query->where(function ($q) use ($request) {
                $q->whereJsonContains('variants', [['size' => $request->size]]);
            });
        }

        // Filter by price
        $minPrice = floatval($request->min_price);
        $maxPrice = floatval($request->max_price);

        if ($minPrice && $maxPrice) {
            $query->whereBetween('regular_price', [$minPrice, $maxPrice]);
        }

        // Apply sorting
        $sort = $request->get('sort');
        $query = $this->applySorting($query, $sort);

        // Paginate
        $products = $query->paginate(12)->withQueryString();

        // Get categories associated with the filtered products
        $categoryIds = $products->pluck('category.id')->unique()->filter();
        $categories = Category::whereIn('id', $categoryIds)->get();
        $subcategories = SubCategory::whereIn('category_id', $categoryIds)->get();

        // Get brands associated with the filtered products
        $brandIds = $products->pluck('brand.id')->unique()->filter();
        $brands = Brand::whereIn('id', $brandIds)->get();

        // Variants for filters
        $allVariants = $products->flatMap(fn($p) => is_string($p->variants) ? json_decode($p->variants, true) : $p->variants);


        $colors = collect($allVariants)->pluck('color')->filter()->flatten()->unique()->values();
        $sizes = collect($allVariants)->pluck('size')->filter()->flatten()->unique()->values();

        return view('webview.shop.new-arrivals', compact(
            'products',
            'brands',
            'categories',
            'subcategories',
            'colors',
            'sizes',
        ));
    }
    public function hotdeal(Request $request)
    {
        $query = Product::with(['brand', 'reviews', 'category', 'subCategory'])
            ->where('hot_deals', 1);

        // Filter by category
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }
        if ($request->filled('brand')) {
            $brand = Brand::where('slug', $request->brand)->first();
            if ($brand) {
                $query->where('brand_id', $brand->id);
            }
        }

        // Filter by sub-category
        if ($request->filled('sub_category')) {
            $subCategory = SubCategory::where('slug', $request->sub_category)->first();
            if ($subCategory) {
                $query->where('sub_category_id', $subCategory->id);
            }
        }

        // Filter by color
        if ($request->filled('color')) {
            $query->where(function ($q) use ($request) {
                $q->whereJsonContains('variants', [['color' => $request->color]]);
            });
        }

        // Filter by size
        if ($request->filled('size')) {
            $query->where(function ($q) use ($request) {
                $q->whereJsonContains('variants', [['size' => $request->size]]);
            });
        }

        // Filter by price
        $minPrice = floatval($request->min_price);
        $maxPrice = floatval($request->max_price);

        if ($minPrice && $maxPrice) {
            $query->whereBetween('regular_price', [$minPrice, $maxPrice]);
        }

        // Apply sorting
        $sort = $request->get('sort');
        $query = $this->applySorting($query, $sort);

        // Paginate
        $products = $query->paginate(12)->withQueryString();

        // Get categories associated with the filtered products
        $categoryIds = $products->pluck('category.id')->unique()->filter();
        $categories = Category::whereIn('id', $categoryIds)->get();
        $subcategories = SubCategory::whereIn('category_id', $categoryIds)->get();

        // Get brands associated with the filtered products
        $brandIds = $products->pluck('brand.id')->unique()->filter();
        $brands = Brand::whereIn('id', $brandIds)->get();

        // Variants for filters
        $allVariants = $products->flatMap(fn($p) => is_string($p->variants) ? json_decode($p->variants, true) : $p->variants);
        $colors = collect($allVariants)->pluck('color')->filter()->flatten()->unique()->values();
        $sizes = collect($allVariants)->pluck('size')->filter()->flatten()->unique()->values();

        return view('webview.shop.hot-deals', compact(
            'products',
            'brands',
            'categories',
            'subcategories',
            'colors',
            'sizes',
       
        ));
    }
    public function featured(Request $request)
    {
        $query = Product::with(['brand', 'reviews', 'category', 'subCategory'])
            ->where('featured', 1);

        // Filter by category
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }
        if ($request->filled('brand')) {
            $brand = Brand::where('slug', $request->brand)->first();
            if ($brand) {
                $query->where('brand_id', $brand->id);
            }
        }

        // Filter by sub-category
        if ($request->filled('sub_category')) {
            $subCategory = SubCategory::where('slug', $request->sub_category)->first();
            if ($subCategory) {
                $query->where('sub_category_id', $subCategory->id);
            }
        }

        // Filter by color
        if ($request->filled('color')) {
            $query->where(function ($q) use ($request) {
                $q->whereJsonContains('variants', [['color' => $request->color]]);
            });
        }

        // Filter by size
        if ($request->filled('size')) {
            $query->where(function ($q) use ($request) {
                $q->whereJsonContains('variants', [['size' => $request->size]]);
            });
        }

        // Filter by price
        $minPrice = floatval($request->min_price);
        $maxPrice = floatval($request->max_price);

        if ($minPrice && $maxPrice) {
            $query->whereBetween('regular_price', [$minPrice, $maxPrice]);
        }

        // Apply sorting
        $sort = $request->get('sort');
        $query = $this->applySorting($query, $sort);

        // Paginate
        $products = $query->paginate(12)->withQueryString();

        // Get categories associated with the filtered products
        $categoryIds = $products->pluck('category.id')->unique()->filter();
        $categories = Category::whereIn('id', $categoryIds)->get();
        $subcategories = SubCategory::whereIn('category_id', $categoryIds)->get();

        // Get brands associated with the filtered products
        $brandIds = $products->pluck('brand.id')->unique()->filter();
        $brands = Brand::whereIn('id', $brandIds)->get();

        // Variants for filters
        $allVariants = $products->flatMap(fn($p) => is_string($p->variants) ? json_decode($p->variants, true) : $p->variants);
        $colors = collect($allVariants)->pluck('color')->filter()->flatten()->unique()->values();
        $sizes = collect($allVariants)->pluck('size')->filter()->flatten()->unique()->values();

        return view('webview.shop.featured', compact(
            'products',
            'brands',
            'categories',
            'subcategories',
            'colors',
            'sizes',
       
        ));
    }
}
