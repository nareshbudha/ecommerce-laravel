<?php
namespace App\Http\Controllers\DashBoard;
use App\Models\Tax;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taxes = Tax::all();
        return view('dashboard.pages.setting.tax.tax', compact('taxes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pages.setting.tax.add-tax');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);
        Tax::create($request->all());
        return redirect()->route('tax.index')
            ->with('success', 'Tax created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tax = Tax::findOrFail($id);
        return view('dashboard.pages.setting.tax.show-tax', compact('tax'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tax = Tax::findOrFail($id);
        return view('dashboard.pages.setting.tax.edit-tax', compact('tax'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'value' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $tax = Tax::findOrFail($id);
        $tax->update($request->all());

        return redirect()->route('tax.index')
            ->with('success', 'Tax updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tax = Tax::findOrFail($id);
        $tax->delete();

        return redirect()->route('taxes.index')
            ->with('success', 'Tax deleted successfully.');
    }
}
