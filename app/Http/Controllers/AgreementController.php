<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\ShopRent;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AgreementController extends Controller
{
    public function index()
    {
        $agreements = Agreement::all();
        return view('agreements.index', compact('agreements'));
    }

    public function showAllocateShopForm()
    {
        $shops = ShopRent::where('status', 'vaccant')->get();
        $tenants = Tenant::all();
        return view('property-allocation.allocate_shop', ['shops' => $shops, 'tenants' => $tenants]);
    }

    private function handleDocument(Request $request, Agreement $agreement)
    {
        if ($request->hasFile('document_field')) {
            $oldFilePath = public_path('documents/' . $agreement->document_field);

            if (is_file($oldFilePath)) {
                // Check if it's a file before attempting to delete
                unlink($oldFilePath);
            }

            $fileName = time() . '.' . $request->document_field->extension();
            $request->document_field->move(public_path('documents'), $fileName);
            $agreement->document_field = $fileName;
        }
    }

    public function allocateShop(Request $request)
    {
        try {
            $request->validate([
                'tenant_id' => 'required|exists:tenants,tenant_id',
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
                'tenant_id' => $request->input('tenant_id'),
                'with_effect_from' => $request->input('with_effect_from'),
                'valid_till' => $request->input('valid_till'),
                'rent' => $request->input('rent'),
                'status' => $request->input('status'),
                'remark' => $request->input('remark'),
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
    }

    public function allocationList()
    {
        $allocations = ShopRent::with('tenant')->where('status', 'occupied')->get();
        $allocations = ShopRent::with('agreements')->where('status', 'active')->get();
        return redirect()->route('agreements.index')->with('allocations', $allocations);
    }

    public function create()
    {
        return view('agreements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // Add your validation rules here
        ]);

        $agreement = new Agreement([
            // Assign request data to agreement properties
        ]);

        // Handle file upload
        $documentPath = $request->file('document_field')->store('public/documents');
        $agreement->document_field = $documentPath;

        $agreement->save();

        return redirect()->route('agreements.index')->with('success', 'Agreement has been created successfully');
    }

    public function show($agreement_id)
    {
        $agreement = Agreement::findOrFail($agreement_id);
        return view('agreements.show', compact('agreement'));
    }

    public function edit($agreement_id)
    {
        $agreement = Agreement::findOrFail($agreement_id);
        return view('property-allocation.allocate_shop', compact('agreement'));
    }

    public function update(Request $request, $agreement_id)
    {
        try {
            $request->validate([
                'tenant_id' => 'required|exists:tenants,tenant_id',
                'shop_id' => 'required|exists:shop_rents,shop_id',
                'with_effect_from' => 'required|date',
                'valid_till' => 'required|date',
                'rent' => 'required|numeric',
                'status' => 'required|in:active,inactive',
                'remark' => 'nullable|string',
                'document_field' => 'sometimes|file|mimes:pdf,jpeg,jpg',
            ]);

            // Find the agreement by agreement_id
            $agreement = Agreement::findOrFail($agreement_id);

            // Update agreement details
            $agreement->update([
                'shop_id' => $request->input('shop_id'),
                'tenant_id' => $request->input('tenant_id'),
                'with_effect_from' => $request->input('with_effect_from'),
                'valid_till' => $request->input('valid_till'),
                'rent' => $request->input('rent'),
                'status' => $request->input('status'),
                'document_field' => 'sometimes|file|mimes:pdf,jpeg,jpg',
                'remark' => $request->input('remark'),
            ]);

            // Handle document update
            $this->handleDocument($request, $agreement);

            // Allocate the shop to the tenant
            $shop = ShopRent::where('shop_id', $request->input('shop_id'))->first();

            if (!$shop) {
                return redirect()->back()->with('error', 'Shop not found. Please select a valid shop.');
            }

            $shop->allocateToTenant($request->input('tenant_id'));

            return redirect()->route('allocation.list')->with('success', 'Shop allocation updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update shop allocation. ' . $e->getMessage());
        }
    }

    public function destroy($agreement_id)
    {
        $agreement = Agreement::findOrFail($agreement_id);
        $agreement->delete();

        return redirect()->route('agreements.index')->with('success', 'Agreement has been deleted successfully');
    }
}

//     public function handleDocument($request, $agreement)
//     {
//         if ($request->hasFile('document_field')) {
//             $oldFilePath = public_path('documents/' . $agreement->document_field);
//             if (file_exists($oldFilePath)) {
//                 unlink($oldFilePath);
//             }
//             $fileName = time() . '.' . $request->document_field->extension();
//             $request->document_field->move(public_path('documents'), $fileName);
//             $agreement->document_field = $fileName;
//         }
//     }
// }
