<?php

namespace App\Http\Controllers\DashBoard;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ShippingInterface;
use App\Http\Requests\Dashboard\Shipping\CreateShippingRequest;
use App\Http\Requests\Dashboard\Shipping\UpdateShippingRequest;

class ShippingController extends Controller
{
    protected ShippingInterface $repo;

    public function __construct(ShippingInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $shippings = $this->repo->get();
        return view('dashboard.pages.shipping.shipping', compact('shippings'));
    }


    public function create()
    {
        return view('dashboard.pages.shipping.add-shipping');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateShippingRequest $request)
    {
        $validated = $request->validated();
        $validated['method'] = $validated['method'] ?? 'standard';
        $this->repo->create($validated);
        return redirect()->route('shipping.index')
            ->with('success', 'Shipping created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $shipping = $this->repo->find($id);
        $localLevels = json_decode($shipping->local_level, true);
        return view('dashboard.pages.shipping.show-shipping', compact('shipping', 'localLevels'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $shipping = $this->repo->find($id);
        $localLevels = json_decode($shipping->local_level, true);
        return view('dashboard.pages.shipping.edit-shipping', compact('shipping', 'localLevels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShippingRequest $request, string $id)
    {
        $validated = $request->validated();
        $this->repo->update($id, $validated);

        return redirect()->route('shipping.index')
            ->with('success', 'Shipping updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->repo->delete($id);

        return redirect()->route('shipping.index')
            ->with('success', 'Shipping deleted successfully.');
    }
}
