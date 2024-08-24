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
        $tenants = Tenant::all();
        return view('agreements.index', ['agreements'=> $agreements, 'tenants' =>$tenants]);
    }

    public function showAllocateShopForm()
    {
        $shops = ShopRent::where('status', 'vacant')->get();
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
        session_start();
        try {
            $request->validate([
                'tenant_id' => 'required|exists:tenants,tenant_id',
                'shop_id' => 'required|exists:shop_rents,shop_id',
                'with_effect_from' => 'required|date',
                'valid_till' => 'required|date|after_or_equal:with_effect_from',
                'rent' => 'required|numeric',
                'status' => 'required|in:active,inactive',
                'remark' => 'nullable|string',
                'document_field' => 'nullable|file|mimes:pdf,jpeg,jpg',
                'agreement_id' => 'required|unique:agreements,agreement_id',
            ], [
                'tenant_id.required' => 'The tenant ID field is required.',
                'tenant_id.exists' => 'The selected tenant is invalid.',
                'shop_id.required' => 'The shop ID field is required.',
                'shop_id.exists' => 'The selected shop is invalid.',
                'with_effect_from.required' => 'The With Effect From field is required.',
                'with_effect_from.date' => 'The With Effect From field must be a valid date.',
                'valid_till.required' => 'The Valid Till field is required.',
                'valid_till.date' => 'The Valid Till field must be a valid date.',
                'valid_till.after_or_equal' => 'The Valid Till field must be a date after or equal to With Effect From.',
                'rent.required' => 'The Rent field is required.',
                'rent.numeric' => 'The Rent field must be a numeric value.',
                'status.required' => 'The Status field is required.',
                'status.in' => 'The selected Status is invalid.',
                // 'document_field.required' => 'The Document Field field is required.',
                'document_field.file' => 'The Document Field must be a file.',
                'document_field.mimes' => 'The Document Field must be a file of type: pdf, jpeg, jpg.',
                'agreement_id.required' => 'The Agreement ID field is required.',
                'agreement_id.unique' => 'The Agreement ID has already been taken.',
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
                'user_id'=>$_SESSION['user_id'],
            ]);

            $this->handleDocument($request, $agreement);
            $agreement->save();

            $shop = ShopRent::where('shop_id', $request->input('shop_id'))->first();

            if (!$shop) {
                return redirect()->back()->with('error', 'Shop not found. Please select a valid shop.');
            }

            $shop->allocateToTenant($request->input('tenant_id'));

            return redirect()->route('allocation.list')->with('success', 'Shop allocated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    public function showAgreementDetails($agreement_id)
    {
        $agreement = Agreement::with('bills')->where('agreement_id', $agreement_id)->first();

        if (!$agreement) {
            abort(404); 
        }

        return view('agreements.show', compact('agreement'));
    }
    public function allocationList()
    {
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
        ]);

        $agreement = new Agreement([
        ]);
        $documentPath = $request->file('document_field')->store('public/documents');
        $agreement->document_field = $documentPath;
        $agreement->save();
        return redirect()->route('agreements.index')->with('success', 'Agreement has been created successfully');
    }
    public function checkAgreementId(Request $request)
    {
        $TenantId = $request->input('agreement_id');

        $exists = Agreement::where('agreement_id', $TenantId)->exists();

        return response()->json(['exists' => $exists]);
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
                'valid_till' => 'required|date|after_or_equal:with_effect_from',
                'rent' => 'required|numeric',
                'status' => 'required|in:active,inactive',
                'remark' => 'nullable|string',
                'document_field' => 'nullable|file|mimes:pdf,jpeg,jpg',
            ]);

            $agreement = Agreement::findOrFail($agreement_id);
            $this->handleDocument($request, $agreement);
            // Update agreement details
            // $agreement->update([
            //     'shop_id' => $request->input('shop_id'),
            //     'tenant_id' => $request->input('tenant_id'),
            //     'with_effect_from' => $request->input('with_effect_from'),
            //     'valid_till' => $request->input('valid_till'),
            //     'rent' => $request->input('rent'),
            //     'status' => $request->input('status'),
            //     'document_field' => $request->input('document_field'),
            //     'remark' => $request->input('remark'),
            // ]);

            $agreement->update($request->except(['document_field', '_method', '_token']));


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
    public function allocatevacantShop($shop_id){
        $shop = ShopRent::findOrFail($shop_id);
        //echo $shop;
        
        return view('property-allocation.allocate_shop', compact('shop'));
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
