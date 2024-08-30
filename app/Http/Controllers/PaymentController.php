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
        $amount=$request->input('amount');
        $payment_date = $request->input('payment_date');
        $payment_method = $request->input('payment_method');
        $bill = Bill::findOrFail($id);
        $agreement = Agreement::where('agreement_id',$bill->agreement_id)->first();
        $transactions= Transaction::where('agreement_id',$bill->agreement_id)
                    ->where('type','payment')
                    ->orderBy('id','desc')
                    ->first();
        $data=[];
        //echo $transactions."<br>";
        if($payment_method=="cheque"){
            $data = [
                'cheque_number' =>  $request->input('cheque_number'),
                'cheque_date' => $request->input('cheque_date'),
                'bank_name' => $request->input('bank_name'),
            ];
        }elseif($payment_method == "upi"){
            $data=[
                'upi_id' =>$request->input('upi_id'),
            ];
        }elseif($payment_method == "netbanking"){
            $data=[
                'utr_no' =>$request->input('utr_no'),
            ];
        }elseif($payment_method == "card"){
            $data=[
                'card_no' =>$request->input('card_no'),
            ];
        }else{
            $data=[
                'method'=>'cash',
            ];
        }
        
        $trans=Transaction::create([
            'bill_no' => $bill->id,
            'transaction_date' => $payment_date,
            'agreement_id' => $agreement->agreement_id,
            'tenant_id' =>  $agreement->tenant_id,
            'tenant_name' => $bill->tenant_full_name,
            'amount' => -1*$amount,
            'shop_id' =>  $agreement->shop_id,
            'type' => 'payment',
            'month' => date('m'),
            'year' => date('Y'),
            'payment_method' => $payment_method,
            'user_id'=>$_SESSION['user_id'],
            'remarks' =>json_encode($data),
        ]);//create
        
        if($bill->total_bal > $amount){
            $billdata=[
                'status'=>'partial paid',
                'user_id'=>$_SESSION['user_id'],
            ];
        } else{
            $billdata=[
                'status'=>'paid',
                'user_id'=>$_SESSION['user_id'],
                //id from transaction table
            ];
        }
        //update
        $billl=Bill::where('id',$id)->update($billdata);

        /*
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
            //$penaltyPayment->save();
            $unpaidBill->status = 'paid';
            //$unpaidBill->save();
        }
        echo $penaltyPayment."<br>";
        
        $totalPayments = $bill->payments->sum('amount');
        //$billStatus = ($totalPayments + $request->input('amount')) >= $bill->amount ? 'paid' : 'unpaid';
        echo $totalPayments."<br>";
       
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
        //$payment->save();
        $bill->status = $billStatus;
        //$bill->save(); 
        */
        return redirect()->route('bills.show', ['id' => $id])->with('success', 'Payment made successfully.');
    }
    public function search()
    {
        return view('payments.search');
    }

    public function searchBy(Request $request)
    {
        $search = $request->input('search');
        $searchby = $request->input('searchby');
        //echo $search."<br>";
        //echo $searchby."<br>";
        if($searchby =='full_name'){
            $b =Bill::where('tenant_full_name','LIKE','%'.$search.'%')->get();
        }elseif($searchby ==='govt_id_number'){
            $tenant =Tenant::where('govt_id_number', $search)->first();
            $b=Bill::where('tenant_id',$tenant->tenant_id)->get();
        }elseif($searchby ==='email'){
            $tenant =Tenant::where('email', $search)->first();
            $b=Bill::where('tenant_id',$tenant->tenant_id)->get();
        }elseif($searchby ==='contact'){
            $tenant =Tenant::where('contact' ,$search)->first();
            $b=Bill::where('tenant_id',$tenant->tenant_id)->get();
        }elseif($searchby ==='agreement_id'){
            $b =Bill::where('agreement_id', $search)->get();
        }elseif($searchby ==='tenant_id'){
            $b =Bill::where('tenant_id', $search)->get();
        }elseif($searchby ==='shop_id'){ 
            $b =Bill::where('shop_id', $search)->get();
        }elseif($searchby ==='bill_id'){ 
            $b =Bill::where('id', $search)->get();
        }else{
            $b="";
        }  
        //$bill = Bill::findOrFail($bills[0]->id);//only first bills id 
        foreach($b as $bill){
            if($bill->status=="unpaid"){
                $bills[]=$bill;
            }
        }
        //print_r($bills);
        return view('payments.search', compact('bills'));
    }

}