<?php

namespace App\Http\Controllers\DashBoard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $categories = Category::paginate(20);
        $categories = Category::with('subcategories')->get();
        return view('dashboard.pages.categories.categories', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('dashboard.pages.categories.add-category');
    }

    /**
     * Store a newly created Category in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|numeric|unique:categories,position',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,tiff',
        ]);

        $slug = $request->slug ?? Str::slug($request->name, '-');

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'position'=>$request->position,
            'image' => $imagePath,
        ]);

        return redirect()->route('categories.index')->with('status', 'Category added successfully');
    }

    /**
     * Display the specified Category.
     */
    public function show(Category $category)
    {
    
        return view('dashboard.pages.categories.category-show', compact('category'));
    }

    /**
     * Show the form for editing the specified Category.
     */
    public function edit(Category $category)
    {
        return view('dashboard.pages.categories.edit-category', compact('category'));
    }

    /**
     * Update the specified Category in the database.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|numeric|',
            'slug' => 'nullable|string|unique:categories,slug,' . $category->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,tiff'
        ]);


        $slug = $request->slug ?? Str::slug($request->name, '-');

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $imagePath = $request->file('image')->store('categories', 'public');
            $category->image = $imagePath;
        }

        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'position'=> $request->position,
            'image' => $category->image,
        ]);

        return redirect()->route('categories.index')->with('status', 'Category updated successfully');
    }

    /**
     * Remove the specified Category from the database.
     */
    public function destroy(Category $category)
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();
        return redirect()->route('categories.index')->with('status', 'Category deleted successfully');
    }
}
