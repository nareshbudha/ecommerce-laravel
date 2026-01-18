<?php

namespace App\Http\Controllers\WebView;

use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function globalSearch(Request $request)
    {
        $query = trim($request->input('query'));
        $categoryId = $request->input('category_id');
        $brandId = $request->input('brand_id');
        $categories = Category::all();
        $brands = Brand::all();
        $perPage = 12;
        $productQuery = Product::query();
        if ($query) {
            $productQuery->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhere('short_description', 'like', "%{$query}%")
                    ->orWhere('regular_price', 'like', "%{$query}%")
                    ->orWhere('sale_price', 'like', "%{$query}%")
                    ->orWhere('sku', 'like', "%{$query}%")
                    ->orWhere('slug', 'like', "%{$query}%");
            });
        }
        if ($categoryId) {
            $productQuery->where('category_id', $categoryId);
        }
        if ($brandId) {
            $productQuery->where('brand_id', $brandId);
        }
        $productResults = $productQuery->paginate($perPage, ['*'], 'products_page');

        $categoryResults = Category::where('name', 'like', "%{$query}%")
            ->paginate($perPage, ['*'], 'categories_page');

        $brandResults = Brand::where('name', 'like', "%{$query}%")
            ->paginate($perPage, ['*'], 'brands_page');

        $userResults = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->paginate($perPage, ['*'], 'users_page');

        return view('globalsearch', compact('productResults', 'categoryResults', 'brandResults', 'userResults', 'categories', 'brands'));
    }
}
