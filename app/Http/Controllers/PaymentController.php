<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create($id)
    {
        // Assuming you have a 'bills' relationship on the Payment model
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

        // Create a new payment
        $payment = new Payment([
            'bill_id' => $id,
            'amount' => $request->input('amount'),
            'payment_date' => $request->input('payment_date'),
            'payment_method' => $request->input('payment_method'),
        ]);

        $payment->save();

        // Check if the total payments cover the entire bill amount
        if ($bill->payments && $bill->payments->count() > 0) {
            $totalPayments = $bill->payments->sum('amount');

            // Assuming 'amount' field in 'bills' table represents the total bill amount
            if ($totalPayments >= $bill->amount) {
                // Update the status of the associated bill to 'paid'
                $bill->status = 'paid';
                $bill->save();
            }
        }

        return redirect()->route('bills.show', ['id' => $id])->with('success', 'Payment made successfully.');
    }
}
