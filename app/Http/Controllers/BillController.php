<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Agreement;
use App\Models\Bill;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $agreementsData = Agreement::select('agreement_id', 'rent', 'shop_id', 'tenant_id')->get();
        $billingSettings = Bill::getBillingSettings();
        $paybill='';
        if($billingSettings['month']==date('m')  && $billingSettings['year']==date('Y')){
            $paybill="enable";
        }else{
            $paybill="disable";
        }
        $bills = Bill::where('month',date('m'))->where('year',date('Y'))->get();
        //echo $selectedMonth;
        return view('bills.index', compact( 'paybill','bills'));
    }

    public function show($agreement_id)
    {
        $bill = Bill::findOrFail($agreement_id);
        return view('bills.show', compact('bill'));
    }
    public function create()
    {
        return view('bills.create');
    }

    public function billsList($selectedYear=null,$selectedMonth=null)
    {
        // If $selectedYear or $selectedMonth are not provided, use the current year and month
        $selectedYear = $selectedYear ?? date('Y');
        $selectedMonth = $selectedMonth ?? date('m');
        $var ="all";
        $billsByMonth = Bill::where('year', $selectedYear)
            ->where('month', $selectedMonth)
            ->get()
            ->groupBy(function ($bill) {
                return Carbon::createFromDate($bill->year, $bill->month, 1)->format('F Y');
            });
        $billingSettings = Bill::getBillingSettings();
        $paybill='';
        if($billingSettings['month'] == $selectedMonth && $billingSettings['year']==$selectedYear){
            $paybill="enable";
        }else{
            $paybill="disable";
        }
        return view('bills.bills_list', compact('billsByMonth','var','paybill' ,'selectedYear', 'selectedMonth'));
    }

    public function paidBills($selectedYear=null,$selectedMonth=null)
    {
        $selectedYear = $selectedYear ?? date('Y');
        $selectedMonth = $selectedMonth ?? date('m');
        $billsByMonth = Bill::where('year', $selectedYear)
            ->where('month', $selectedMonth)
            ->where('status','paid')
            ->get()
            ->groupBy(function ($bill) {
                return Carbon::createFromDate($bill->year, $bill->month, 1)->format('F Y');
            });
          
        return view('bills.bills_list', compact('billsByMonth','selectedYear', 'selectedMonth'));
    }

    public function store(Request $request)
    {
        return redirect()->route('bills.index')->with('success', 'Bill created successfully!');
    }

    public function edit($agreement_id)
    {
        $bill = Bill::findOrFail($agreement_id);
        return view('bills.edit', compact('bill'));
    }

    public function destroy($agreement_id)
    {
        $bill = Bill::findOrFail($agreement_id);
        $bill->delete();
        return redirect()->route('bills.index')->with('success', 'Bill deleted successfully!');
    }

    public function singlebillGen($agreement_id){
        session_start();
        $year=date('Y');
        $month=date('m');
        $lastBill=Bill::where('agreement_id',$agreement_id)
                            ->orderby('id','desc')
                            ->first();
        $bill_id=$lastBill->id;
        $billingSettings = Bill::getBillingSettings();
        if($billingSettings['month'] =='12'){
            $month ="1";
            $year =$billingSettings['year']+1;
        }else{
            $month=$billingSettings['month']+1;
            $year =$billingSettings['year'];
        }
        $existingTnx = Transaction::where('agreement_id', $agreement_id)
                ->where('year', $year)
                ->where('month', $month)
                ->first();
        if(!$existingTnx) {
            $data = $this->generateBillData($agreement_id, $year, $month,$bill_id);
            if($data!=null){
                return redirect()->route('agreements.index')->with('success', 'Bill Generated successfully!');
            }else{
                return redirect()->route('agreements.index')->with('Warning', 'Bill can/t be Generated!');
            }
        }else{
            return redirect()->route('agreements.index')->with('info', 'Bill Already Generated!');
        }
    }

    public function generate(Request $request, $year = null, $month = null)
    {
        session_start();
        $year = $request->input('selectedYear') ?? date('Y');
        $month = $request->input('selectedMonth') ?? date('m');
        $activeAgreements = Agreement::all();
        foreach ($activeAgreements as $agreement) {
            $lastBill=Bill::where('agreement_id',$agreement->agreement_id)
                            ->orderby('id','desc')
                            ->first();
            $bill_id=$lastBill->id;
            $existingTnx = Transaction::where('agreement_id', $agreement->agreement_id)
                ->where('year', $year)
                ->where('month', $month)
                ->first();
            if (!$existingTnx) {
                $billAndTransactionData = $this->generateBillData($agreement->agreement_id, $year, $month,$bill_id);
            }
        }
        $billingSettings = Bill::getBillingSettings();
        $billingSettings['month'] = date('m');
        $billingSettings['year'] = date('Y');
        $newJsonString = json_encode($billingSettings);
        file_put_contents(public_path('billing_settings.json'), $newJsonString);
        return redirect()->route('bills.billsList', ['year' => $year, 'month' => $month])->with('success', 'Bills generated successfully.');
        
    }
    private function generateBillData($agreement_id, $year, $month, $bill_id)
    {
        $agreement = Agreement::with('tenant', 'shop')->where('agreement_id', $agreement_id)->first();
        $transactions =Transaction::where('agreement_id',$agreement_id)->get();
        $rent=0;
        if($agreement->status =='active'){
            $rent=$agreement->rent;
            $m =date('m',strtotime($agreement->with_effect_from));
            $y=date('Y',strtotime($agreement->with_effect_from));
            if($month =="1"){
                if($m=="12" && $y==$year-1){
                    $rent=$agreement->rent *(date('d',strtotime($agreement->with_effect_from))/date('t', strtotime(now())));
                }
            }else{
                if($m==$month-1 && $y==$year){
                    $rent=$agreement->rent *(date('d',strtotime($agreement->with_effect_from))/date('t', strtotime(now())));
                }
            }//check from starting date
        }elseif($month==date('m',strtotime($agreement->valid_till)) && $year==date('Y',strtotime($agreement->valid_till))){
            $rent=$agreement->rent * (date('d',strtotime($agreement->valid_till))/date('t', strtotime(now())));
            //check from valid till
        }
        try {
            $billingSettings = Bill::getBillingSettings();
            $datePrefix=$year.'-'.$month.'-';
            $dueDate = Carbon::createFromFormat('Y-m-d', $datePrefix.$billingSettings['due_date']); //echo "Due date =" .$dueDate;
            $billDate = Carbon::createFromFormat('Y-m-d', $datePrefix.$billingSettings['billing_date']);// echo "Bill date =" .$billDate;
            //$discountDate = Carbon::createFromFormat('Y-m-d', $datePrefix.$billingSettings['discount_date']);// echo "discount date =" .$discountDate;
        } catch (\Exception $e) {
            dd('Error: ' . $e->getMessage() . ' check whether file exist or not or contact admin');
        }
        if (!$billDate->isValid()) {
            $billDate = Carbon::now()->startOfMonth();
        }
        $uniqueTransactionNumber = $this->generateUniqueTransactionNumber();
        Log::info('Generated Transaction Number:', ['transaction_number' => $uniqueTransactionNumber]);
        $prevbal= 0;
        foreach($transactions as $tranx){
            if ($tranx->month >= $month && $tranx->year >= $year){
                //echo "NO PENELTY year".$tranx->year  ." month ".$tranx->month."<br>";
            }elseif($tranx->month < $month && $tranx->year >$year){
                //echo "NO PENELTY year".$tranx->year  ." month ".$tranx->month."<br>";
            }else{
                $prevbal +=$tranx->amount;
                //echo $tranx."<br>";
            }
        }
        $penalty=0;
        if($prevbal >0){
            $penalty =$prevbal*($billingSettings['penalty']/100);
        }
        $tax = $rent*($billingSettings['tax_rate']/100);//Tax on rent
        $total_bal=$rent +$tax +$prevbal+$penalty;//total balance
        if($rent != 0){
            if($prevbal > 0){
                $data=Transaction::create([
                    'bill_no'=>$bill_id,
                    'transaction_number' => null,
                    'agreement_id' => $agreement->agreement_id,
                    'tenant_id' => $agreement->tenant->tenant_id,
                    'shop_id' =>$agreement->shop_id,
                    'tenant_name' => $agreement->tenant->full_name,
                    'amount' =>round($penalty),
                    'type' => 'Penelty',
                    'transaction_date' => Carbon::now()->toDateString(),
                    'year' => $year,
                    'month' => $month,
                    'user_id'=>$_SESSION['user_id'],
                    'remarks' =>' ',
                ]);
            }
            $transaction = Transaction::create([
                'bill_no'=>$bill_id,
                'transaction_number' => null,
                'agreement_id' => $agreement->agreement_id,
                'tenant_id' => $agreement->tenant->tenant_id,
                'shop_id' =>$agreement->shop_id,
                'tenant_name' => $agreement->tenant->full_name,
                'amount' => round($rent + $tax),
                'type' => 'Rent',
                'transaction_date' => Carbon::now()->toDateString(),
                'year' => $year,
                'month' => $month,
                'user_id'=>$_SESSION['user_id'],
                'remarks' =>' ',
            ]);
            $bill = Bill::create([
                'agreement_id' => $agreement->agreement_id,
                'shop_id' => $agreement->shop->shop_id,
                'tenant_id' => $agreement->tenant->tenant_id,
                'tenant_full_name' => $agreement->tenant->full_name,
                'shop_address' => $agreement->shop->address,
                'rent' => round($rent),
                'year' => $year,
                'month' => $month,
                'bill_date' => $billDate->toDateString(),
                'due_date' => $dueDate->toDateString(),
                //'discount_date'=> $discountDate->toDateString(),
                'status' => 'unpaid',
                'penalty' => round($penalty),
                'tax' => (int)($tax),
                'prevbal' => round($prevbal),
                'total_bal' => round($total_bal),
                //'discount' => $discount,
                'transaction_number' => null,
                'user_id'=>$_SESSION['user_id'],
            ]); 
            $lastB = Bill::where('id',$bill_id)->first();
            if($lastB->status =='unpaid'){
                $billdata=[
                    'status'=>'Carried Forward',
                    'user_id'=>$_SESSION['user_id'],
                ];
                Bill::where('id',$bill_id)->update($billdata);
            }elseif($lastB->status =='partial paid'){
                $billdata=[
                    'status'=>'Partialy paid Carried Forward',
                    'user_id'=>$_SESSION['user_id'],
                ];
                Bill::where('id',$bill_id)->update($billdata);
            }
            return ['billData' => $bill, 'transactionData' => $transaction];//->toArray()
        }else{
            return ['billData' => null, 'transactionData' => null];//->toArray()
        }
    }

    private function generateUniqueTransactionNumber()
    {
        $uniqueTransactionNumber = Str::random(16);
        while (Transaction::where('transaction_number', $uniqueTransactionNumber)->exists()) {
            $uniqueTransactionNumber = Str::random(16);
        }
        return $uniqueTransactionNumber;
    }

    public function regenerate(Request $request, $bill_no)
    {   
        $bills =Bill::where('id',$bill_no)->first();
        session_start();
        $agreement = Agreement::with('tenant', 'shop')->where('agreement_id', $bills->agreement_id)->first();
        $transactions =Transaction::where('agreement_id',$bills->agreement_id)->get();
        try {
            $billingSettings = Bill::getBillingSettings();
            $datePrefix=$_POST['selectedYear'].'-'.$_POST['selectedMonth'].'-';
            $dueDate = Carbon::createFromFormat('Y-m-d', $datePrefix.$billingSettings['due_date']); //echo "Due date =" .$dueDate;
            $billDate = Carbon::createFromFormat('Y-m-d', $datePrefix.$billingSettings['billing_date']);// echo "Bill date =" .$billDate;
        } catch (\Exception $e) {
            dd('Error: ' . $e->getMessage() . ' check whether file exist or not or contact admin');
        }
        if (!$billDate->isValid()) {
            $billDate = Carbon::now()->startOfMonth();
        }
        $prevbal= 0;
        foreach($transactions as $tranx){
            if ($tranx->month >= $billingSettings['month'] && $tranx->year >= $billingSettings['year']){
                //echo "NO PENELTY year".$tranx->year  ." month ".$tranx->month."<br>";
            }elseif($tranx->month < $billingSettings['month'] && $tranx->year >$billingSettings['year']){
                //echo "NO PENELTY year".$tranx->year  ." month ".$tranx->month."<br>";
            }else{
                $prevbal +=$tranx->amount;
                //$tnxMonth =$tranx->month;
                //$tnxYear =$tranx->year;
                //echo $tranx."<br>";
            }
        }
        $penalty=0;
        if($prevbal >0){
            $penalty =$prevbal*($billingSettings['penalty']/100);
        }
        $tax = $agreement->rent*($billingSettings['tax_rate']/100);//Tax on rent
        $total_bal=$agreement->rent +$tax +$prevbal+$penalty;//total balance
        echo $prevbal ." ".round($penalty)." ".$tax." ".$total_bal."<br>";
        $billdata =[
            'rent' => round($agreement->rent),
            'year' => $billingSettings['year'],
            'month' => $billingSettings['month'],
            'bill_date' => $billDate->toDateString(),
            'due_date' => $dueDate->toDateString(),
            'status' => 'unpaid',
            'penalty' => round($penalty),
            'tax' => (int)($tax),
            'prevbal' => round($prevbal),
            'total_bal' => round($total_bal),
            'user_id'=>$_SESSION['user_id'],
        ];
        Bill::where('id',$bill_no)->update($billdata);
        return redirect()->route('bills.index')->with('success', "Bill regenerated successfully.");
    }

    public function update(Request $request, $id)
    {
        session_start();
        $bill = Bill::findOrFail($id);
        if ($bill->status == 'paid') {
            return redirect()->route('bills.index')->with('error', 'Cannot update a paid bill.');
        }

        $updatedData = $request->only(['bill_date', 'rent', 'status', 'due_date']);

        $penalty = $this->$updatedData['due_date'];
        $discount = $this->$updatedData['due_date'];

        $bill->update([
            // 'bill_date' => $updatedData['bill_date'],
            'rent' => $updatedData['rent'],
            'status' => $updatedData['status'],
            'due_date' => $updatedData['due_date'],
            'penalty' => $penalty,
            'discount' => $discount,
            'user_id'=>$_SESSION['user_id'],
        ]);

        return redirect()->route('bills.index')->with('success', 'Bill updated successfully!');
    }

    public function print($id, $agreement_id)
    {
        $bill = Bill::where('id', $id)->first();
        $billingSettings=Bill::getBillingSettings();
        $transactions =Transaction::where('agreement_id',$agreement_id)->where('type','payment')->get();
        $bill->duration="From ". date('Y-m-01', strtotime($bill->bill_date)) ." to " . date('Y-m-t', strtotime($bill->bill_date));
        $lastbill=[];
        if($bill->month =="1"){
            $lastbill=Bill::where('agreement_id',$agreement_id)
                        ->where('month','12')
                        ->where('year',$bill->year-1)
                        ->orderby('id','desc')
                        ->first();
        }else{
            $lastbill=Bill::where('agreement_id',$agreement_id)
                        ->where('month', $bill->month - 1)
                        ->where('year', $bill->year)
                        ->orderby('id','desc')
                        ->first();
        }
        $transaction=[];
        $lastamt=0;
        foreach($transactions as $tranx){
            if($bill->month =='1' && $tranx->type =="payment"){
                if ($tranx->month == "12" && $tranx->year == $bill->year-1){
                    $transaction=$tranx;
                    $lastamt += $tranx->amount;
                }
            }elseif($bill->month !='1' && $tranx->type =="payment"){
                if ($tranx->month == $bill->month-1 && $tranx->year == $bill->year){
                    $transaction=$tranx;
                    $lastamt += $tranx->amount;
                }
            }
        }
        return view('bills.print',['bill'=>$bill ,'lastbill'=>$lastbill], compact('billingSettings','lastamt','transaction'));
    }

    public function showLastbill($agreement_id){
        $bills =Bill::where('agreement_id', $agreement_id)->orderBy('id','desc')->first();
        return $this->print($bills->id, $agreement_id);
    }
    
    public function printBills(){
        $data=[];
        $billingSettings=Bill::getBillingSettings();
        $bills =Bill::where('month',date('m'))->where('year',date('Y'))->get();
        foreach($bills as $bill){
            $bill->duration="From ". date('Y-m-01', strtotime($bill->bill_date)) ." to " . date('Y-m-t', strtotime($bill->bill_date));
            $transactions =Transaction::where('agreement_id',$bill->agreement_id)->where('type','payment')->get();
            $lastbill=null;
            if($bill->month =="1"){
                $lastbill=Bill::where('agreement_id',$bill->agreement_id)
                            ->where('month','12')
                            ->where('year',$bill->year-1)
                            ->first();
            }else{
                $lastbill=Bill::where('agreement_id',$bill->agreement_id)
                            ->where('month',$bill->month-1)
                            ->where('year',$bill->year)
                            ->first();
            }
            $transaction=[];
            $lastamt=0;
            foreach($transactions as $tranx){
                if($bill->month =='1' && $tranx->type =="payment"){
                    if ($tranx->month == "12" && $tranx->year == $bill->year-1){
                        $transaction=$tranx;
                        $lastamt += $tranx->amount;
                    }
                }elseif($bill->month !='1' && $tranx->type =="payment"){
                    if ($tranx->month == $bill->month-1 && $tranx->year == $bill->year){
                        $transaction=$tranx;
                        $lastamt += $tranx->amount;
                    }
                }
            }
            $printdata=[
                'lastamt'=>$lastamt,
                'mc_name'=>$billingSettings['mc_name'],
                'mc_address'=>$billingSettings['mc_address'],
                'mc_email'=>$billingSettings['mc_email'],
                'mc_phone'=>$billingSettings['mc_phone'],
                'penalty'=>$billingSettings['penalty'],
                'bill_id'=>$bill->id ,
                'tenant_full_name'=>$bill->tenant_full_name,
                'shop_address'=>$bill->shop_address,
                'contact'=>$bill->tenant->contact,
                'bill_date'=> $bill->bill_date,
                'bill_month'=>date("F",strtotime($bill->bill_date )),
                'due_date'=> $bill->due_date ,
                'agreement_id'=> $bill->agreement_id ,
                'duration'=>$bill->duration,
                'rent'=>$bill->rent,
                'tax'=> $bill->tax, 
                'bill_penalty'=>$bill->penalty,
                'last_total_bal'=>$lastbill->total_bal,
            ];
            $data[]=$printdata;
        }
        $pdf = Pdf::loadview('bills/printbills', compact('data'));
        //return $pdf->stream();
        return $pdf->download('bills.pdf');
    }

}