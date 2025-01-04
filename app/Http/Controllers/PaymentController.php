<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Tenant;
use App\Models\Agreement;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function create($id=null)
    {//Pay Now from bills 
        $bill = Bill::findOrFail($id);
        $transactions =Transaction::where('agreement_id',$bill->agreement_id)->get();
        $amount='0';
        foreach($transactions as $trans){
            $amount +=$trans->amount;
        }//all transaction amount added payment and rent
        if($amount > 0){//if amount is greater than 0 than pay now bill view else message biil already paid
            return view('payments.create', compact('bill','amount'));
        }else{
            return redirect()->back()->with('info', 'Bill paid already.');
        }
    }

    public function store(Request $request, $id)
    {//Save Bill Payment
        session_start();
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'nullable',
            'payment_date' => 'required|date',
        ]);
        $amount=$request->input('pay_amt');
        $payment_date = $request->input('payment_date');
        $payment_method = $request->input('payment_method');
        $bill = Bill::findOrFail($id);
        $agreement = Agreement::where('agreement_id',$bill->agreement_id)->first();
        $transactions= Transaction::where('agreement_id',$bill->agreement_id)->get();
        $total_amt='0';
        foreach($transactions as $trans){
            $total_amt +=$trans->amount;
        }//total amount to be against Bill
        $data=[];
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
        }elseif($payment_method == "rebate"){
            $data=[
                'method' =>'rebate',
            ];
            $amount =$amount*-1;
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
            'payment_method' => $payment_method,
            'user_id'=>$_SESSION['user_id'],
            'remarks' =>json_encode($data),
            'g8' => $request->input('g8_number'),
        ]);//create
        
        if($total_amt > $amount){
            //if total bill amount is less than bill paid than status= partial paid else paid
            $billdata=[
                'status'=>'partial paid',
                'user_id'=>$_SESSION['user_id'],
            ];
        } else{
            $billdata=[
                'status'=>'paid',
                'user_id'=>$_SESSION['user_id'],
            ];
        }//update
        $billl=Bill::where('id',$id)->update($billdata);
        $tenant = Tenant::where('id',$agreement->tenant_id)->first();
        if($tenant->contact){
            $status =$this->receipt();
            echo $status;
            echo $tenant->contact.'<br>';
        }//send message to tenant if there is contact 
        return redirect()->route('bills.show', ['id' => $id])->with('success', 'Payment made successfully.');
    }
    private function receipt(){
        //Write code for message send
        return "Done";
    }

    public function search()
    {//payment search view 
        return view('payments.search');
    }

    public function searchBy(Request $request)
    {//payment Seacrh 
        $search = $request->input('search');
        $searchby = $request->input('searchby');
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
            $b =Bill::where('id', $search)->get();
        }elseif($searchby ==='bill_id'){ 
            $b =Bill::where('id', $search)->get();
        }else{
            $b="";
        }
        foreach($b as $bill){
            if($bill->status=="unpaid"){
                $bills[]=$bill;
            }
        }//from all bill only where status = unpaid data is return to view
        return view('payments.search', compact('bills'));
    }
    public function payBill()
    {//Paybill View same as funtion create
        return view('payments.payBill');
    }

    public function autocompleteBills(Request $request)
    {//search Bill id for BIll Payment
        $query = $request->input('query');
        if (empty($query)) {
            $results = Bill::orderBy('id', 'desc')->where('id',$query)->limit(100)->get();
        } else {
            $results = Bill::where('id', 'like', '%' . $query . '%')
                ->orderBy('id', 'desc')
                ->limit(100)
                ->get();
        }
        return response()->json($results);
    }
    public function autocompleteAgree(Request $request){
        $query = $request->input('query');
        if (empty($query)) {
            $results = Bill::where('agreement_id',$query)
                        ->orderby('id','asc')
                        ->where(function($query) {
                            $query->where('status', 'unpaid')
                                ->orWhere('status', 'Partial Paid');
                        })->limit(100)
                        ->get();
        } else {
            $results = Bill::where('agreement_id', 'like', '%' . $query . '%')
                ->orderby('id','asc')
                ->where(function($query) {
                    $query->where('status', 'unpaid')
                        ->orWhere('status', 'Partial Paid');
                })->limit(100)
                ->get();
        }
        return response()->json($results);
    }
    public function checkTransAgree(Request $request)
    {//Get the amount of agreement id
        $query = $request->input('agreement_id');
        $transactions =Transaction::where('agreement_id',$query)
                            ->get();       
        $amount='0';
        foreach($transactions as $trans){
            $amount +=$trans->amount;
        }
        $result= [
            'label' => $amount,
            'value' => $amount,
        ];
        return response()->json($result);
    }

    public function payBillnow(Request $request)
    {//Pay Bill Now view
        $id=$request->input('bill_no');
        $bill=Bill::where('id',$id)->first();
        if($bill->status =='unpaid' || $bill->status =='Partial Paid'){
            return $this->store($request, $id);
        }else{
            return redirect()->back()->with('info', 'Bill paid already.');
        }
    }
    public function updateG8(){
        //Update G8 View With all transaction where G8 is not updated
        $payments = Transaction::where('type','payment')
                ->where('G8',null)
                ->get();
        //echo $payments;
        return view('payments.index', compact('payments'));
    }
    public function updateG8number($id){
        //Get id of transaction and than detail of that transaction to payment create view
        $payment =Transaction::where('id',$id)->first();
        $bill =Bill::where('id',$payment->bill_no)->first();
        return view('payments.create',compact('payment','bill'));
    }
    public function update(Request $request, $id)
    {//UPdate G8 
        session_start();
        $payment =Transaction::where('id',$id)->first();
        if($request->input('g8_number') != null){
            $trans=[
                'g8' => $request->input('g8_number'),
                'reconciled_by' => $_SESSION['user_id'], 
                'user_id'=>$_SESSION['user_id'],        
            ];
            Transaction::where('id',$id)->update($trans);
            return redirect()->route('payments.updateG8')->with('success', 'G8 number updated successfully!');
        }else{
            return redirect()->back()->with('danger', 'Please Enter G8 Number.');
        }
        
    }
}