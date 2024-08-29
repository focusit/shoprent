<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Tenant;
use App\Models\Agreement;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function create($id=null)
    {
        $bill = Bill::findOrFail($id);
        $transactions =Transaction::where('agreement_id',$bill->agreement_id)->get();
        $amount='0';
        foreach($transactions as $trans){
            $amount +=$trans->amount;
        }
        return view('payments.create', compact('bill','amount'));
    }
    
    public function store(Request $request, $id)
    {
        session_start();
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'nullable',
            'payment_date' => 'required|date',
        ]);

        $bill = Bill::findOrFail($id);

        $unpaidBills = Bill::where('tenant_id', $bill->tenant_id)
            ->where('status', 'unpaid')
            ->orwhere(function($query) use ($bill){
                $query->orWhere('year', $bill->year)
                ->where('year', '<', $bill->year);
            })->where('status', 'unpaid')
            ->get();
        
        //echo $unpaidBills."<br>";   
        foreach ($unpaidBills as $unpaidBill) {
            // dd($unpaidBill->rent);
            $penaltyAmount = $unpaidBill->rent * 0.05; 
            // dd($penaltyAmount);
            $penaltyPayment = new Payment([
                //'transaction_number' => $unpaidBill->transaction_number,
                'amount' => $penaltyAmount,
                'payment_date' => $request->input('payment_date'),
                'payment_method' => 'penalty', 
                'tenant_id' => $unpaidBill->tenant_id,
                'remark' => 'Penalty for unpaid bill',
            ]);

            $penaltyPayment->save();

            $unpaidBill->status = 'paid';
            //$unpaidBill->save();
        }

        $totalPayments = $bill->payments->sum('amount');
        $billStatus = ($totalPayments + $request->input('amount')) >= $bill->amount ? 'paid' : 'unpaid';

        $transactionNumber = $bill->transaction_number;
        $tenant_id = $bill->tenant_id;
        $amount = $request->input('amount');
        $previousBalance =  $bill->rent-$totalPayments;

        $payment = new Payment([
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
