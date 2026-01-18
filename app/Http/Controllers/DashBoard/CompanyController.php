<?php

namespace App\Http\Controllers\DashBoard;
use App\Models\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view('dashboard.pages.setting.company.company', compact('companies'));
    }

    public function create()
    {
        return view('dashboard.pages.setting.company.add-company');
    }

    public function store(CreateCompanyRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $imagePath = $file->storeAs('company', $fileName, 'public');
            $data['logo'] = $imagePath;
        }

        Company::create($data);

        return redirect()->route('company.index')
            ->with('success', 'Company created successfully.');
    }


    public function edit(Company $company)
    {
        return view('dashboard.pages.setting.company.edit-company', compact('company'));
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $data = $request->all();
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $data['logo'] = $file->storeAs('company', $filename, 'public');
        }

        $company->update($data);

        return redirect()->route('company.index')->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        // Delete logo file if exists
        if ($company->logo && file_exists(public_path($company->logo))) {
            unlink(public_path($company->logo));
        }

        $company->delete();

        return redirect()->route('company.index')->with('success', 'Company deleted successfully.');
    }
}
