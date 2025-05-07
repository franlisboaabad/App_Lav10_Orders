<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $company = Company::first();
        return view('admin.companies.index', compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company = null)
    {
        if (!$company) {
            $company = new Company();
        }
        return view('admin.companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company = null)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ruc' => 'required|string|max:11|unique:companies,ruc,' . ($company ? $company->id : 'NULL'),
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:companies,email,' . ($company ? $company->id : 'NULL'),
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string'
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            if ($company && $company->logo) {
                Storage::delete('public/' . $company->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $logoPath;
        }

        if ($company) {
            $company->update($data);
        } else {
            $company = Company::create($data);
        }

        return redirect()->route('companies.index')
            ->with('success', 'Información de la empresa actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
