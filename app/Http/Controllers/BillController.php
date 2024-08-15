<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Agreement;
use App\Models\Bill;
use App\Models\Tenant;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $agreementsData = Agreement::select('agreement_id', 'rent', 'shop_id', 'tenant_id')->get();
        $billingSettings = Bill::getBillingSettings();
        $bills = Bill::where('month',date('m'))->where('year',date('Y'))->get();
        //echo $selectedMonth;
        return view('bills.index', compact('agreementsData', 'billingSettings', 'bills'));
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
        $billingSettings=Bill::getBillingSettings();
        $billsByMonth = Bill::where('year', $selectedYear)
            ->where('month', $selectedMonth)
            ->get()
            ->groupBy(function ($bill) {
                return Carbon::createFromDate($bill->year, $bill->month, 1)->format('F Y');
            });
        $transaction=Transaction::All();
        //echo $transaction;               
        return view('bills.bills_list', compact('billsByMonth','transaction','billingSettings', 'selectedYear', 'selectedMonth'));
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
    public function generate(Request $request, $year = null, $month = null)
    {
        $year = $request->input('selectedYear') ?? date('Y');
        $month = $request->input('selectedMonth') ?? date('m');
        $activeAgreements = Agreement::where('status', 'active')->get();
        //echo $year ."<br>".$month."<br>";
        foreach ($activeAgreements as $agreement) {
            $existingTnx = Transaction::where('agreement_id', $agreement->agreement_id)//->get();
                ->where('year', $year)
                ->where('month', $month)
                ->first();
            
            if (!$existingTnx) {
                $billAndTransactionData = $this->generateBillData($agreement->agreement_id, $year, $month);
                //print_r($billAndTransactionData);
                //break;
                /*if ($billAndTransactionData && $billAndTransactionData['transactionData']) {
                    $transactionData = $billAndTransactionData['transactionData'];
                    logger('Transaction Data:', $transactionData);
                    try {
                        $createdTransaction = Transaction::create($transactionData);
                        //Entry in Transaction Table
                        if ($createdTransaction) {
                            Bill::create($billAndTransactionData['billData']);
                        } else {
                            logger('Transaction creation failed:', ['agreement_id' => $agreement->agreement_id]);
                        }
                    } catch (\Exception $e) {
                        // Log the exception
                        logger('Error creating transaction:', ['error' => $e->getMessage(), 'agreement_id' => $agreement->agreement_id]);
                    }
                }*/
            }
        }
        //echo "DONE";
        return redirect()->route('bills.billsList', ['year' => $year, 'month' => $month])->with('success', 'Bills generated successfully.');
        
    }
  
    private function generateBillData($agreement_id, $year, $month)
    {
        $agreement = Agreement::with('tenant', 'shop')->where('agreement_id', $agreement_id)->first();
        $transactions =Transaction::where('agreement_id',$agreement_id)->get();
       
        try {
            $billingSettings = Bill::getBillingSettings();
            //print_r($billingSettings); print_r($_POST);
            $datePrefix=$_POST['selectedYear'].'-'.$_POST['selectedMonth'].'-';
            $dueDate = Carbon::createFromFormat('Y-m-d', $datePrefix.$billingSettings['due_date']); //echo "Due date =" .$dueDate;
            $billDate = Carbon::createFromFormat('Y-m-d', $datePrefix.$billingSettings['billing_date']);// echo "Bill date =" .$billDate;
            $discountDate = Carbon::createFromFormat('Y-m-d', $datePrefix.$billingSettings['discount_date']);// echo "discount date =" .$discountDate;

        } catch (\Exception $e) {
            dd('Error: ' . $e->getMessage() . ' check whether file exist or not or contact admin');
        }

        if (!$billDate->isValid()) {
            $billDate = Carbon::now()->startOfMonth();
        }
        $penaltyamt = 0.00;
        if (now() <= $dueDate) {
            $penaltyamt = 0.00;
        } else {
            $penaltyamt = $agreement->rent*($billingSettings['penalty']/100);
        } //penelty
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
        $tax = $agreement->rent*($billingSettings['tax_rate']/100);//Tax on rent
        $total_bal=$agreement->rent +$tax +$prevbal+($penaltyamt+$penalty);//total balance
        $bill=null;//
        $transaction=null;//
        if($tranx->month > date('m') && $tranx->year >= date('Y')){
            $bill=null;
            $transaction=null;
        }else{
            if($prevbal > 0){
                $data=Transaction::create([
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
                    'remarks' => 'example_remarks',
                ]);
            }
            $transaction = Transaction::create([
                'transaction_number' => null,
                'agreement_id' => $agreement->agreement_id,
                'tenant_id' => $agreement->tenant->tenant_id,
                'shop_id' =>$agreement->shop_id,
                'tenant_name' => $agreement->tenant->full_name,
                'amount' => round($agreement->rent),
                'type' => 'Rent',
                'transaction_date' => Carbon::now()->toDateString(),
                'year' => $year,
                'month' => $month,
                'remarks' => 'example_remarks',
            ]);
            $bill = Bill::create([
                'agreement_id' => $agreement->agreement_id,
                'shop_id' => $agreement->shop->shop_id,
                'tenant_id' => $agreement->tenant->tenant_id,
                'tenant_full_name' => $agreement->tenant->full_name,
                'shop_address' => $agreement->shop->address,
                'rent' => round($agreement->rent),
                'year' => $year,
                'month' => $month,
                'bill_date' => $billDate->toDateString(),
                'due_date' => $dueDate->toDateString(),
                //'discount_date'=> $discountDate->toDateString(),
                'status' => 'unpaid',
                'penalty' => round($penalty),
                'tax' => round($tax),
                'prevbal' => round($prevbal),
                'total_bal' => round($total_bal),
                //'discount' => $discount,
                'transaction_number' => null,
            ]);    
        } 
        return ['billData' => $bill, 'transactionData' => $transaction];//->toArray()
        
    }

    private function generateUniqueTransactionNumber()
    {
        $uniqueTransactionNumber = Str::random(16);
        while (Transaction::where('transaction_number', $uniqueTransactionNumber)->exists()) {
            $uniqueTransactionNumber = Str::random(16);
        }
        return $uniqueTransactionNumber;
    }

    public function regenerate(Request $request, $transaction_number)
    {
        $existingBill = Bill::where('transaction_number', $transaction_number)
            ->first();
            echo "Hello";
            print_r($request);
        if ($existingBill) {
            $year = $existingBill->year;
            $month = $existingBill->month;
            $billingSettings = Bill::getBillingSettings();
            $existingBill->update([
                'bill_date' => $billingSettings['billing_date'],
                'due_date' => $billingSettings['due_date'],
            ]);
            
            //return redirect()->route('bills.index')->with('success', "Bill for {$year}-{$month} regenerated successfully.");
        } else {
            //return redirect()->route('bills.index')->with('error', 'No bill found for the specified agreement and transaction number.');
        }
    }

    public function update(Request $request, $id)
    {
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
        ]);

        return redirect()->route('bills.index')->with('success', 'Bill updated successfully!');
    }

    public function print($id, $agreement_id)
    {
        //$bill = Bill::where('agreement_id', $agreement_id)->first();
        $bill = Bill::where('id', $id)->first();
        $billingSettings=Bill::getBillingSettings();
        $transactions =Transaction::where('agreement_id',$agreement_id)->get();
        //echo $bill."<br>";
        $bill->duration="From ". date('Y-m-01', strtotime($bill->bill_date)) ." to " . date('Y-m-t', strtotime($bill->bill_date));
        $bill->tax= $bill->rent * ($billingSettings['tax_rate']/100);
        $amount=0;
        //echo $bill->month."<br>";
        $transaction=[];
        foreach($transactions as $tranx){
            if ($tranx->month > $bill->month && $tranx->year >= $bill->year){
                //echo $bill->month ." 1 ".$bill->year ."<br>";
            }elseif($tranx->month < $bill->month && $tranx->year >$bill->year){
                //echo $bill->month ." 2 ".$bill->year ."<br>";
            }else{
                if($tranx->type =="payment"){
                    $transaction=$tranx;
                }else{
                    $amount +=$tranx->amount;
                }
                //echo $tranx;
            } 
        }
        //echo '<pre>'; print_r($billingSettings);echo '</pre>'; 
        //echo $bill."<br>";
        return view('bills.print', compact('bill','amount','billingSettings','transaction'));
    }

    public function paidBills()
    {
        $bills = Bill::where('status','paid')->get();
        //return view('bills.bills_list', compact('bills'));
    }
}
