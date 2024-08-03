<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create($id)
    {
        $bill = Bill::findOrFail($id);
        return view('payments.create', compact('bill'));
    }
    
    public function store(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'nullable',
            'payment_date' => 'required|date',
        ]);
        $bill = Bill::findOrFail($id);
        $unpaidBills = Bill::where('tenant_id', $bill->tenant_id)
            ->where('status', 'unpaid')
            ->where('year', '<', $bill->year)
            ->orWhere(function ($query) use ($bill) {
                $query->where('tenant_id', $bill->tenant_id)
                    ->where('status', 'unpaid')
                    ->where('year', $bill->year)
                    ->where('month', '<', $bill->month);
            })
            ->get();
        foreach ($unpaidBills as $unpaidBill) {
            // dd($unpaidBill->rent);
            $penaltyAmount = $unpaidBill->rent * 0.05; 
            // dd($penaltyAmount);
            $penaltyPayment = new Payment([
                'transaction_number' => $unpaidBill->transaction_number,
                'amount' => $penaltyAmount,
                'payment_date' => $request->input('payment_date'),
                'payment_method' => 'penalty', 
                'tenant_id' => $unpaidBill->tenant_id,
                'remark' => 'Penalty for unpaid bill',
            ]);
            $penaltyPayment->save();
            $unpaidBill->status = 'paid';
            $unpaidBill->save();
        }
        $totalPayments = $bill->payments->sum('amount');
        $billStatus = ($totalPayments + $request->input('amount')) >= $bill->amount ? 'paid' : 'unpaid';
        $transactionNumber = $bill->transaction_number;
        $tenant_id = $bill->tenant_id;
        $amount = $request->input('amount');
        $previousBalance =  $bill->rent-$totalPayments;
        google$payment = new Payment([
            'transaction_number' => $transactionNumber,
            'amount' => $amount,
            'previous_balance' => $previousBalance,
            'payment_date' => $request->input('payment_date'),
            'payment_method' => $request->input('payment_method'),
            'tenant_id' => $tenant_id,
            'remark' => $request->input('remark'),
        ]);
        $transactionTable = Transaction::where('transaction_number', $transactionNumber)->first();
        if ($transactionTable) {
            $transactionTable->update([
                'payment_method' => $request->input('payment_method'),
                'previous_balance' => $previousBalance,
            ]);
        }
        $payment->save();
        $bill->status = $billStatus;
        $bill->save();
        return redirect()->route('bills.show', ['id' => $id])->with('success', 'Payment made successfully.');
    }
}