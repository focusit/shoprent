<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Services\BillingService;

class BillController extends Controller
{
    protected $billingService;
    public function __construct(BillingService $billingService)
    {
        $this->billingService = $billingService;
    }
    public function index()
    {
        $bills = Bill::all();
        return view('bills.index', compact('bills'));
    }
    public function generate()
    {
        $shops = $this->billingService->getShopsToGenerateBills();
        return view('bills.generate', compact('shops'));
    }

    public function storeGeneratedBills(Request $request)
    {
        $request->validate([
            'shop_ids' => 'required|array',
        ]);

        $shopIds = $request->input('shop_ids', []);

        foreach ($shopIds as $shopId) {
            $this->billingService->generateBill($shopId);
        }

        return redirect()->route('bills.index')->with('success', 'Bills generated successfully!');
    }

    public function create()
    {
        return view('bills.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'shop_id' => 'required|exists:shop_rents,id',
            'tenant_id' => 'required|exists:tenants,id',
            'bill_amount' => 'required|numeric',
            'due_date' => 'required|date',
            'status' => 'required|in:unpaid,partial,paid',
            'paid_at' => $request->input('status') == 'paid' ? 'required|date' : '',
        ]);

        $bill = Bill::create([
            'shop_id' => $request->input('shop_id'),
            'tenant_id' => $request->input('tenant_id'),
            'bill_amount' => $request->input('bill_amount'),
            'due_date' => $request->input('due_date'),
            'status' => $request->input('status'),
            'paid_at' => $request->input('status') == 'paid' ? $request->input('paid_at') : null,
        ]);

        return redirect()->route('bills.index')->with('success', 'Bill created successfully!');
    }

    public function show(Bill $bill)
    {
        return view('bills.show', compact('bill'));
    }

    public function edit(Bill $bill)
    {
        return view('bills.edit', compact('bill'));
    }

    public function update(Request $request, Bill $bill)
    {
        $request->validate([
            'shop_id' => 'required|exists:shop_rents,id',
            'tenant_id' => 'required|exists:tenants,id',
            'bill_amount' => 'required|numeric',
            'due_date' => 'required|date',
            'status' => 'required|in:unpaid,partial,paid',
            'paid_at' => $request->input('status') == 'paid' ? 'required|date' : '',
            // Add more validation rules as needed
        ]);

        $bill->update([
            'shop_id' => $request->input('shop_id'),
            'tenant_id' => $request->input('tenant_id'),
            'bill_amount' => $request->input('bill_amount'),
            'due_date' => $request->input('due_date'),
            'status' => $request->input('status'),
            'paid_at' => $request->input('status') == 'paid' ? $request->input('paid_at') : null,
            // Update more fields as needed
        ]);

        return redirect()->route('bills.index')->with('success', 'Bill updated successfully!');
    }

    public function destroy(Bill $bill)
    {
        $bill->delete();
        return redirect()->route('bills.index')->with('success', 'Bill deleted successfully!');
    }
}
