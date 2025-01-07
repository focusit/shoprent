<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Agreement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenantController extends Controller
{
    public function index( $type=null)
    {//View Active Tenants
        echo $type;
        $tenants = Tenant::get();
        $agreements = Agreement::all();
        return view('tenants.index', ['tenants' => $tenants, 'agreements'=> $agreements]);
    }
    public function create()
    {//Create Tenant View
        return view('tenants.create');
    }
    public function store(Request $request)
    {//Save New Tenant In Tenant Table
        session_start();
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
            'user_id'=>$_SESSION['user_id'],
        ]);
        return redirect()->route('tenants.index')->with('success', 'Tenant created successfully.');
    }
    public function show($tenant_id)
    {//Show Tenant Details from All Tenants SHow Details Button
        $tenant = Tenant::findOrFail($tenant_id);
        return view('tenants.show', compact('tenant'));
    }
    public function checkTenantId(Request $request)
    {//Return Tenant Detail if exist
        $TenantId = $request->input('tenant_id');
        $exists = Tenant::where('tenant_id', $TenantId)->exists();
        return response()->json(['exists' => $exists]);
    }
    public function edit($tenant_id)
    {//Edit Tenant Details from All Tenant Edit Button (View)
        $tenant = Tenant::findOrFail($tenant_id);
        return view('tenants.edit', compact('tenant'));
    }
    public function update(Request $request, $tenant_id)
    {//Update Tenant Details from All Tenant  Edit Button
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
        //update
        return redirect()->route('tenants.index')->with('success', 'Tenant updated successfully.');
    }
    public function destroy($tenant_id)
    {//Delete Tenant detials 
    //currently not showing 
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
    {//Validate Tenants Details
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
    {//Search Tenant id in allocated shop 
        $query = $request->input('query');
        $tenants = Tenant::where('full_name', 'like', '%' . $query . '%')->orderBy('tenant_id', 'asc')
            ->limit(100)
            ->get();
        $result = [];
        foreach ($tenants as $tenant) {
            $result[] = [
                'label' => $tenant->tenant_id." - ".$tenant->full_name,
                'value' => $tenant->tenant_id,
                'full_name' =>$tenant->full_name,
            ];
        }
        return response()->json($result);
    }

    public function search()
    {//Search Tenants View
        return view('tenants.search');
    }

    public function searchTenant(Request $request)
    {//Search Tenants Name, Govt Id, Email, COntact and than return value to same page 
        $search = $request->input('search');
        $searchby = $request->input('searchby');
        if($searchby =='full_name'){
            $tenants =Tenant::where('full_name','LIKE','%'.$search.'%')->get();
        }elseif($searchby ==='govt_id_number'){
            $tenants =Tenant::where('govt_id_number','LIKE','LIKE','%'.$search.'%')->get();
        }elseif($searchby ==='email'){
            $tenants =Tenant::where('email', 'LIKE','%'.$search.'%')->get();
        }elseif($searchby ==='contact'){
            $tenants =Tenant::where('contact', 'LIKE','%'.$search.'%')->get();
        }else{
            $tenants="";
        }
        return view('tenants.search', compact('tenants'));
    }

    public function tenantTranx(){
        echo "Hello";
    }

}
