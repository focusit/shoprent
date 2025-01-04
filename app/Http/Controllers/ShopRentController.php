<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\ShopRent;
use App\Models\Tenant;
use Illuminate\Http\Request;

class ShopRentController extends Controller
{
    public function index()
    {
        $shops = ShopRent::all();
        $tenants = Tenant::all();
        $totalAgreements = Agreement::all();
        return view('shop.index', ['shops'=> $shops, 'tenants'=>$tenants, 'agreements'=>$totalAgreements]);
    }//View all Shops

    public function create()
    {
        return view('shop.create');//Add Shop view
    }

    public function store(Request $request)
    {
        session_start();
        $this->validateShop($request);//Validate Values
        if($request->hasFile('image')){
            $imageName = time() . '.' . $request->image->extension();
            if (!$request->image->move(public_path('images'), $imageName)) {
                return redirect()->back()->with('error', 'Failed to upload the image.');
            }
        }
        ShopRent::create([
            'shop_id' => $request->input('shop_id'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'address' => $request->input('address'),
            'pincode' => $request->input('pincode'),
            'construction_year'=> $request->input('construction_year'),
            'owner_name' => $request->input('owner_name'),
            'rent' => $request->input('rent'),
            'status' => $request->input('status'),
            'image' => $imageName ??"",
            'user_id'=>$_SESSION['user_id'],
        ]);//Save New shop into ShopRent Table
        return redirect()->route('shops.index')->with('success', 'Shop created successfully.');
    }

    public function show($id)
    {
        $shop = ShopRent::where('id',$id)->first();
        return view('shop.show', compact('shop'));
    }//Show Shop Details in View all Shops 

    public function edit($id)
    {
        $shop = ShopRent::where('id',$id)->first();
        return view('shop.edit', compact('shop'));
    }//Edit Shop Details (View) in View all Shops

    public function update(Request $request, $id)
    {
        $request->validate([
            'shop_id' => 'nullable|string',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'address' => 'nullable|string',
            'owner_name' => 'nullable|string',
            'construction_year' => 'nullable|string',
            'pincode' => 'nullable|numeric|regex:/^\d{6}$/',
            'rent' => 'nullable|numeric',
            'status' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $shop = ShopRent::findOrFail($id);
        $this->handleImage($request, $shop);
        if ($shop->status === 'occupied' && $request->input('status') === 'vacant') {
            // Set tenant_id to null
            $shop->tenant_id = null;
        }
        $shop->update($request->except(['image', '_method', '_token']));
        //Update Shop Details Except Image
        return redirect()->route('shops.index')->with('success', 'Shop updated successfully.');
    }

    public function inactive($id)
    {
    session_start();
    $shop = ShopRent::where('id',$id)->first();
    if (!empty($shop->image)) {
        $filePath = public_path('images/' . $shop->image);
        if (file_exists($filePath) && is_file($filePath)) {
            if (!unlink($filePath)) {
                return redirect()->route('shops.index')->withErrors('Error deleting the image file.');
            }
        } else {
            return redirect()->route('shops.index')->withErrors('Image file does not exist.');
        }
    }
    $data= [
        'status' => 'inactive',
        'user_id'=>$_SESSION['user_id'],
    ];
    $shop=ShopRent::where('id',$id)->update($data);
    return redirect()->route('shops.index')->with('success', 'Shop inactivated successfully.');
    }//Inactive shop if inactive can't be activated from frontend
    
    protected function validateShop(Request $request)
    {
        return $request->validate([
            'shop_id' => 'required|string|unique:shop_rents,shop_id',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'address' => 'nullable|string',
            'pincode' => 'nullable|numeric|regex:/^\d{6}$/',
            'status' => 'required|string',
            'rent' => 'required|numeric',
            'owner_name' => 'nullable|string',
            'construction_year' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);//validating shop Details
    }

    private function handleImage(Request $request, ShopRent $shop)
    {
        if ($request->hasFile('image')) {
            $oldImagePath = public_path('images/' . $shop->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $shop->image = $imageName;
        }
    }

    private function handleDocument(Request $request, Agreement $agreement)
    {
        if ($request->hasFile('document_field')) {
            $oldFilePath = public_path('documents/' . $agreement->document_field);
            if (is_file($oldFilePath)) {
                unlink($oldFilePath);
            }

            $fileName = time() . '.' . $request->document_field->extension();
            $request->document_field->move(public_path('documents'), $fileName);
            $agreement->document_field = $fileName;
        }
    }
    public function checkShopId(Request $request)
    {
        $shopId = $request->input('shop_id');
        $exists = ShopRent::where('shop_id', $shopId)->exists();
        return response()->json(['exists' => $exists]);
    }//Check if Shop ID exist
    public function showAllocateShopForm()
    {
        $shops = ShopRent::where('status', 'vacant')->get();
        $tenants = Tenant::all();
        return view('property-allocation.allocate_shop', ['shops' => $shops, 'tenants' => $tenants]);
    }//Not Working
    public function allocateShop(Request $request)
    {
        try {
            $request->validate([
                // 'tenant_id' => 'required|exists:tenants,tenant_id',
                'shop_id' => 'required|exists:shop_rents,shop_id',
                'with_effect_from' => 'required|date',
                'valid_till' => 'required|date',
                'rent' => 'required|numeric',
                'status' => 'required|in:active,inactive',
                'remark' => 'nullable|string',
                'document_field' => 'required|file|mimes:pdf,jpeg,jpg',
                'agreement_id' => 'required|unique:agreements,agreement_id',
            ]);
            $agreement = new Agreement([
                'agreement_id' => $request->input('agreement_id'),
                'shop_id' => $request->input('shop_id'),
                // 'tenant_id' => $request->input('tenant_id'),
                'with_effect_from' => $request->input('with_effect_from'),
                'valid_till' => $request->input('valid_till'),
                'rent' => $request->input('rent'),
                'status' => $request->input('status'),
                'remark' => $request->input('remark'),
                'user_id'=> $_SESSION['user_id'],
            ]);
            $this->handleDocument($request, $agreement);
            $agreement->save();
            // Allocate the shop to the tenant
            $shop = ShopRent::where('shop_id', $request->input('shop_id'))->first();
            if (!$shop) {
                return redirect()->back()->with('error', 'Shop not found. Please select a valid shop.');
            }
            $shop->allocateToTenant($request->input('tenant_id'));
            return redirect()->route('allocation.list')->with('success', 'Shop allocated successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }//Not Working
    
    public function allocationList()
    {
        $allocations = ShopRent::with('tenant')->where('status', 'occupied')->get();
        $allocations = ShopRent::with('agreements')->where('status', 'active')->get();
        return redirect()->route('agreements.index')->with('allocations', $allocations);
    }//Not Working

    public function autocompleteSearch(Request $request)
    {
        $query = $request->input('query');
        if (empty($query)) {
            $results = ShopRent::where('status','vacant')->orderBy('shop_id', 'asc')->limit(100)->get();
        } else {
            $results = ShopRent::where('status','vacant')
                ->where('shop_id', 'like', '%' . $query . '%')
                ->orderBy('shop_id', 'asc')
                ->limit(100)
                ->get();
        }
        return response()->json($results);
    }//Search Shop id in allocated shop if shop id is vacant
}
