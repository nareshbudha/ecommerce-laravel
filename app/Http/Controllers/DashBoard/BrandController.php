<?php

namespace App\Http\Controllers\DashBoard;

use App\Models\Brand;
use Illuminate\Support\Str;
use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Contracts\Dashboard\BrandInterface;
use App\Http\Requests\Dashboard\Brand\CreateBrandRequest;
use App\Http\Requests\Dashboard\Brand\UpdateBrandRequest;

class BrandController extends Controller
{
    protected BrandInterface $repo;

    public function __construct(BrandInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $brands = $this->repo->get();
        return view('dashboard.pages.brands.brands', compact('brands'));
    }


    public function create()
    {
        return view('dashboard.pages.brands.add-brand');
    }

    public function store(CreateBrandRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = ImageHelper::upload($request->file('image'), 'brands');
            $validated['image'] = $imagePath;
        }
        $validated['slug'] = $request->slug ?? Str::slug($request->name, '-');
        $this->repo->create($validated);



        return redirect()->route('brands.index')->with('status', 'Brand added successfully');
    }



    public function show(Brand $brand)
    {
        return view('dashboard.pages.brands.brand-show', compact('brand'));
    }

    public function edit(string $id)
    {
        $brand = $this->repo->find($id);
        return view('dashboard.pages.brands.edit-brand', compact('brand'));
    }



    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = ImageHelper::upload($request->file('image'), 'brands');
        }
        $validated['slug'] = $request->slug ?? Str::slug($request->name, '-');
        $brand->update($validated);

        return redirect()->route('brands.index')->with('status', 'Brand updated successfully');
    }



    public function destroy(string $id)
    {
        $this->repo->delete($id);
        return redirect()->route('brands.index')->with('status', 'Brand deleted successfully');
    }
}
