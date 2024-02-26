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
        $transactionTable = Transaction::where('transaction_number', $bill->transaction_number)->first();

        // Check if the total payments cover the entire bill amount
        $totalPayments = $bill->payments->sum('amount');
        $billStatus = ($totalPayments + $request->input('amount')) >= $bill->amount ? 'paid' : 'unpaid';

        // Check if the bill already has a transaction
        if ($transactionTable) {
            // If it has, update the payment method
            if ($transactionTable->payment_method) {
                $transactionTable->payment_method->update([
                    'payment_method' => $request->input('payment_method'),
                ]);
            }
        }

        // Find the associated transaction number
        $transactionNumber = $bill->transaction_number;

        // Create a new payment
        $payment = new Payment([
            'transaction_number' => $transactionNumber,
            'amount' => $request->input('amount'),
            'payment_date' => $request->input('payment_date'),
            'payment_method' => $request->input('payment_method'),
            'remark' => $request->input('remark'),
        ]);

        // Save the payment
        $payment->save();

        // Update the status of the associated bill
        $bill->status = $billStatus;
        $bill->save();

        return redirect()->route('bills.show', ['id' => $id])->with('success', 'Payment made successfully.');
    }
}
