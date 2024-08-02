<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Agreement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::paginate(200);
        $agreements = Agreement::all();
        return view('tenants.index', ['tenants' => $tenants, 'agreements'=> $agreements]);
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
        if($request->hasFile('image')){
            $imageName = time() . '.' . $request->image->extension();
    
            if (!$request->image->move(public_path('images'), $imageName)) {
                return redirect()->back()->with('error', 'Failed to upload the image.');
            }
        }
        Tenant::create([
            'tenant_id' => $request->input('tenant_id'),
            'full_name' => $request->input('full_name'),
            'govt_id' => $request->input('govt_id'),
            'govt_id_number' => $request->input('govt_id_number'),
            'address' => $request->input('address'),
            'pincode' => $request->input('pincode'),
            'gst_number'=> $request->input('gst_number') ,
            'contact' => $request->input('contact'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'image' => $imageName ??"",
            'gender'=> $request->input('gender'),
        ]);
        // dd($request);
        // User::create([
        //     'name' => $request->input('full_name'),
        //     'email' => $request->input('email'),
        //     'password' => bcrypt($request->input('password')),
        //     'tenant_id' => $request->input('tenant_id'),
        //     'is_admin' => 0,
        // ]);

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
    public function checkTenantId(Request $request)
    {
        $TenantId = $request->input('tenant_id');

        $exists = Tenant::where('tenant_id', $TenantId)->exists();

        return response()->json(['exists' => $exists]);
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
            'govt_id_number' => 'nullable|string',
            'address' => 'nullable|string',
            'contact' => 'nullable|numeric',
            'pincode' => 'nullable|numeric|regex:/^\d{6}$/',
            'email' => 'nullable|string',
            'password' => 'nullable|string',
            'gst_number'=> 'nullable|string',
            'gender'=> 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

    if (!empty($tenant->image)) {
        $filePath = public_path('images/' . $tenant->image);
        if (file_exists($filePath) && is_file($filePath)) {
            if (!unlink($filePath)) {
                return redirect()->route('tenants.index')->withErrors('Error deleting the image file.');
            }
        } else {
            return redirect()->route('tenants.index')->withErrors('Image file does not exist.');
        }
    }
    $tenant->delete();
    return redirect()->route('tenants.index')->with('success', 'Tenant deleted successfully.');
}

    protected function validateTenants(Request $request, $tenant_id = null)
    {
        return $request->validate([
            'tenant_id' => 'required|string|unique:tenants,tenant_id,' . $tenant_id,
            'full_name' => 'required|string',
            'govt_id' => 'nullable|string',
            'govt_id_number' => 'nullable|string',
            'address' => 'nullable|string',
            'contact' => 'nullable|numeric',
            'pincode' => 'nullable|numeric|regex:/^\d{6}$/',
            'email' => 'nullable|string|unique:tenants,email,' . $tenant_id,
            'password' => 'nullable|string',
            'gst_number'=>'nullable|string',
            'gender'=>'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
    public function search()
    {
        return view('tenants.search');
    }
    public function searchTenant(Request $request)
    {
        $search = $request->input('search');
        echo $search;
    }
}
