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

        // Find the associated bill
        $bill = Bill::findOrFail($id);

        // Check if there are unpaid bills for previous months
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
        // Apply penalty to unpaid bills
        foreach ($unpaidBills as $unpaidBill) {
            // Apply your penalty logic here
            // For example, you can calculate penalty based on a fixed rate or other criteria
            // dd($unpaidBill->rent);
            $penaltyAmount = $unpaidBill->rent * 0.05; // Assuming 5% penalty, adjust as needed

            // dd($penaltyAmount);
            // Create a payment record for the penalty
            $penaltyPayment = new Payment([
                'transaction_number' => $unpaidBill->transaction_number,
                'amount' => $penaltyAmount,
                'payment_date' => $request->input('payment_date'),
                'payment_method' => 'penalty', // You might want to adjust this or add a penalty flag
                'tenant_id' => $unpaidBill->tenant_id,
                'remark' => 'Penalty for unpaid bill',
            ]);

            // Save the penalty payment
            $penaltyPayment->save();

            // Update the status of the associated bill to 'paid' with penalty
            $unpaidBill->status = 'paid';
            $unpaidBill->save();
        }

        // Check if the total payments cover the entire bill amount
        $totalPayments = $bill->payments->sum('amount');
        $billStatus = ($totalPayments + $request->input('amount')) >= $bill->amount ? 'paid' : 'unpaid';

        // Find the associated transaction number
        $transactionNumber = $bill->transaction_number;
        $tenant_id = $bill->tenant_id;
        $amount = $request->input('amount');

        // Calculate the previous balance
        $previousBalance =  $bill->rent-$totalPayments;

        // Create a new payment
        $payment = new Payment([
            'transaction_number' => $transactionNumber,
            'amount' => $amount,
            'previous_balance' => $previousBalance,
            'payment_date' => $request->input('payment_date'),
            'payment_method' => $request->input('payment_method'),
            'tenant_id' => $tenant_id,
            'remark' => $request->input('remark'),
        ]);

        // Check if the bill already has a transaction
        $transactionTable = Transaction::where('transaction_number', $transactionNumber)->first();
        if ($transactionTable) {
            // If it has, update the payment method and previous balance
            $transactionTable->update([
                'payment_method' => $request->input('payment_method'),
                'previous_balance' => $previousBalance,
            ]);
        }

        // Save the payment
        $payment->save();

        // Update the status of the associated bill
        $bill->status = $billStatus;
        $bill->save();

        return redirect()->route('bills.show', ['id' => $id])->with('success', 'Payment made successfully.');
    }

}
