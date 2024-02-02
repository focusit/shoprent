<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::paginate(20);
        return view('tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tenants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateTenants($request);
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('tenant-images'), $imageName);

        Tenant::create([
            'tenant_id' => $request->input('tenant_id'),
            'full_name' => $request->input('full_name'),
            'govt_id' => $request->input('govt_id'),
            'govt_id_number' => $request->input('govt_id_number'),
            'address' => $request->input('address'),
            'pincode' => $request->input('pincode'),
            'contact' => $request->input('contact'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'image' => $imageName,
        ]);

        return redirect()->route('tenants.index')->with('success', 'Tenant created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($tenant_id)
    {
        $tenant = Tenant::findOrFail($tenant_id);
        return view('tenants.show', compact('tenant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($tenant_id)
    {
        $tenant = Tenant::findOrFail($tenant_id);
        return view('tenants.edit', compact('tenant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $tenant_id)
    {
        $validatedData = $request->validate([
            'tenant_id' => 'nullable|string',
            'full_name' => 'nullable|string',
            'govt_id' => 'nullable|string',
            'govt_id_number' => 'nullable|numeric',
            'address' => 'nullable|string',
            'contact' => 'nullable|numeric',
            'pincode' => 'nullable|numeric|regex:/^\d{6}$/',
            'email' => 'nullable|string',
            'password' => 'nullable|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $tenant = Tenant::findOrFail($tenant_id);

        if ($request->hasFile('image')) {
            $oldImagePath = public_path('tenant-images/' . $tenant->image);

            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('tenant-images'), $imageName);
            $tenant->image = $imageName;
        }

        $tenant->update($request->except(['image', '_method', '_token']), $validatedData);

        return redirect()->route('tenants.index')->with('success', 'Tenant updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($tenant_id)
    {
        $tenant = Tenant::findOrFail($tenant_id);

        // Delete the associated image
        $filePath = public_path('tenant-images/' . $tenant->image);

        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $tenant->delete();

        return redirect()->route('tenants.index')->with('success', 'Tenant deleted successfully.');
    }

    protected function validateTenants(Request $request, $tenant_id = null)
    {
        return $request->validate([
            'tenant_id' => 'required|string|unique:tenants,tenant_id,' . $tenant_id,
            'full_name' => 'required|string',
            'govt_id' => 'required|string',
            'govt_id_number' => 'required|numeric',
            'address' => 'required|string',
            'contact' => 'required|numeric',
            'pincode' => 'required|numeric|regex:/^\d{6}$/',
            'email' => 'required|string|unique:tenants,email,' . $tenant_id,
            'password' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    }
    public function autocompleteSearch(Request $request)
    {

        $query = $request->input('query');

        $tenants = Tenant::where('tenant_id', 'like', '%' . $query . '%')->orderBy('tenant_id', 'asc')
            ->limit(100)
            ->get();

        $result = [];

        foreach ($tenants as $tenant) {
            $result[] = [
                'label' => $tenant->tenant_id,
                'value' => $tenant->tenant_id,
            ];
        }

        return response()->json($result);
    }
}
