<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\Bill;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index()
    {
        $agreementsData = Agreement::select('agreement_id', 'rent', 'shop_id', 'tenant_id')->get();
        $billingSettings = Bill::getBillingSettings();
        $bills = Bill::all();
        return view('bills.index', compact('agreementsData', 'billingSettings', 'bills'));
    }
    public function show($id)
    {
        $bill = Bill::findOrFail($id);
        return view('bills.show', compact('bill'));
    }

    public function create()
    {
        return view('bills.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('bills.index')->with('success', 'Bill created successfully!');
    }

    public function edit($id)
    {
        $bill = Bill::findOrFail($id);
        return view('bills.edit', compact('bill'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('bills.index')->with('success', 'Bill updated successfully!');
    }

    public function destroy($id)
    {
        $bill = Bill::findOrFail($id);
        $bill->delete();

        return redirect()->route('bills.index')->with('success', 'Bill deleted successfully!');
    }
    public function generate()
    {
        $activeAgreements = Agreement::where('status', 'active')->get();

        foreach ($activeAgreements as $agreement) {
            // Check if a bill already exists for the agreement
            $existingBill = Bill::where('agreement_id', $agreement->agreement_id)->first();

            if (!$existingBill) {
                // If no existing bill, generate and create a new one
                $billData = $this->generateBillData($agreement->agreement_id);
                Bill::create($billData);
            } else {
                // If an existing bill is found, update it with new data
                $newBillData = $this->generateBillData($agreement->agreement_id);
                $existingBill->update($newBillData);
            }
        }

        return redirect()->route('bills.index')->with('success', 'Bills generated successfully.');
    }



    private function generateBillData($agreement_id)
    {
        $agreement = Agreement::with('tenant', 'shop')->where('agreement_id', $agreement_id)->first();
        $billingSettings = Bill::getBillingSettings();
        $dueDate = $billingSettings['due_date'];

        if (Carbon::now() <= $dueDate) {
            $penalty = 0;
            $discount = $billingSettings['discount'];
        } else {
            $penalty = $billingSettings['penalty'];
            $discount = 0;
        }
        // Prepare the data for the new bill
        $billData = [
            'agreement_id' => $agreement->agreement_id,
            'shop_id' => $agreement->shop_id,
            'tenant_id' => $agreement->tenant_id,
            'tenant_full_name' => $agreement->tenant->full_name,
            'shop_address' => $agreement->shop->address,
            'rent' => $agreement->rent,
            'bill_date' => Carbon::now(),
            'due_date' => $dueDate,
            'status' => 'unpaid',
            'penalty' => $penalty,
            'discount' => $discount,
        ];

        return $billData;
    }



    public function regenerate($agreement_id)
    {
        $existingBill = Bill::where('agreement_id', $agreement_id)->first();
        if ($existingBill) {
            $newBillData = $this->generateBillData($agreement_id);
            $existingBill->update($newBillData);
            return redirect()->route('bills.index')->with('success', 'Bill regenerated successfully.');
        } else {
            return redirect()->route('bills.index')->with('error', 'No bill found for the specified agreement.');
        }
    }
    public function print($agreement_id)
    {
        $bill = Bill::where('agreement_id', $agreement_id)->first();
        return view('bills.print', compact('bill'));
    }
}
