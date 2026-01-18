<?php
namespace App\Http\Controllers\DashBoard;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class SubCategoryController extends Controller
{
    /**
     * Display a listing of the subcategories.
     */
    public function index()
    {
        $subCategories = SubCategory::with('category')->get();
        return view('dashboard.pages.sub-categories.subcategories', compact('subCategories'));
    }

    /**
     * Show the form for creating a new subcategory.
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.pages.sub-categories.add-subcategory', compact('categories'));
    }

    /**
     * Store a newly created SubCategory in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,tiff',
            'category_id' => 'required|exists:categories,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sub_category_images', 'public');
        }

        SubCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imagePath,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('sub-categories.index')->with('success', 'SubCategory created successfully.');
    }

    /**
     * Show the form for editing the specified subcategory.
     *
     *
     *
     */
    public function show(SubCategory $sub_category)
    {
        return view('dashboard.pages.sub-categories.show-subcategory', compact('sub_category'));
    }
    public function edit($id)
    {
        $sub_category = SubCategory::find($id);
        $categories = Category::all();
        return view('dashboard.pages.sub-categories.edit-subcategory', compact('sub_category', 'categories'));
    }
    /**
     * Update the specified SubCategory in the database.
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:sub_categories,slug,' . $subCategory->id . '|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,tiff',
            'category_id' => 'required|exists:categories,id',
        ]);

        $imagePath = $subCategory->image;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::delete('public/' . $imagePath);
            }
            // Store the new image
            $imagePath = $request->file('image')->store('sub_category_images', 'public');
        }

        $subCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imagePath,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('sub-categories.index')->with('success', 'SubCategory updated successfully.');
    }


    /**
     * Remove the specified subcategory from storage.
     */
    public function destroy(SubCategory $subCategory)
    {
        if ($subCategory->image) {
            Storage::delete('public/' . $subCategory->image);
        }

        $subCategory->delete();

        return redirect()->route('sub-categories.index')->with('success', 'SubCategory deleted successfully.');
    }

    public function getSubcategoriesByCategory($categoryId)
    {

        $subcategories = SubCategory::where('category_id', $categoryId)->get(['id', 'name']);
        return response()->json($subcategories);
    }
}
