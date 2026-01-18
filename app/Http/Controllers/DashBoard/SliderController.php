<?php

namespace App\Http\Controllers\DashBoard;
use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Slider\CreateSliderRequest;
use App\Http\Requests\Slider\UpdateSliderRequest;
use App\Repositories\Contracts\Slider\SliderInterface;

class SliderController extends Controller
{
    protected SliderInterface $repo;

    public function __construct(SliderInterface $repo)
    {
        $this->repo = $repo;
    }
    public function index()
    {
        $sliders = $this->repo->get();
        return view('dashboard.pages.slider.slider', compact('sliders'));
    }


    public function create()
    {
        return view('dashboard.pages.slider.add-slider');
    }


    public function store(CreateSliderRequest $request)
    {
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $imagePath = ImageHelper::upload($request->file('image'), 'sliders');
            $validated['image'] = $imagePath;
        }
        $this->repo->create($validated);
        return redirect()->route('slider.index')
            ->with('success', 'Slider created successfully.');
    }


    public function show(string $id)
    {
        $slider = $this->repo->find($id);
        return view('dashboard.pages.slider.slider', compact('slider'));
    }


    public function edit(string $id)
    {
        $slider = $this->repo->find($id);
        return view('dashboard.pages.slider.edit-slider', compact('slider'));
    }


    public function update(UpdateSliderRequest $request, string $id)
    {
        $validated = $request->validated();
        $slider = $this->repo->find($id);
        if ($request->hasFile('image')) {
            ImageHelper::delete($slider->image ?? null);
            $imagePath = ImageHelper::upload($request->file('image'), 'sliders');
            $validated['image'] = $imagePath;
        }

        $this->repo->update($id, $validated);

        return redirect()->route('slider.index')
            ->with('success', 'Slider updated successfully.');
    }



    public function destroy(string $id)
    {
        $this->repo->delete($id);

        return redirect()->route('slider.index')
            ->with('success', 'Slider deleted successfully.');
    }
}
