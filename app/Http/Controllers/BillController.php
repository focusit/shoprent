<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Agreement;
use App\Models\Bill;
use App\Models\ShopRent;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\QrCodeServiceProvider;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $agreementsData = Agreement::select('agreement_id', 'rent', 'shop_id', 'tenant_id')->get();
        $billingSettings = Bill::getBillingSettings();//billing_setting.json 
        $y = $billingSettings['year'];
        $m = $billingSettings['month'];
        $date = date_create($y . "-" . $m . "-01");//last bill generated date
        $dateAdded = date_add($date, date_interval_create_from_date_string($billingSettings['billcycle'] . " month"));//add billcycle in last bill month
        $month = date_format($dateAdded, "m");
        $year = date_format($dateAdded, "Y");
        $paybill = '';
        if ($billingSettings['billcycle'] > 1) {
            if ($billingSettings['month'] == $month && $billingSettings['year'] == $year) {
                $paybill = "enable";
            } elseif ($billingSettings['month'] <= $month && $billingSettings['year'] <= $year) {
                $paybill = "enable";
            } else {
                $paybill = "disable";
            }//have to check logic
        } else {
            if ($billingSettings['month'] == date('m') && $billingSettings['year'] == date('Y')) {
                $paybill = "enable";
            } else {
                $paybill = "disable";
            }
        }
        $bills = Bill::where('month', $m)->where('year', $y)->get();
        $shops = ShopRent::all();
        return view('bills.index', compact('paybill', 'bills', 'shops'));
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

    public function billsList($selectedYear = null, $selectedMonth = null)
    {
        $billingSettings = Bill::getBillingSettings();
        // If $selectedYear or $selectedMonth are not provided, use the current year and month
        $selectedYear = $selectedYear ?? $billingSettings['year'];
        $selectedMonth = $selectedMonth ?? $billingSettings['month'];
        $var = "all";//to check
        $billsByMonth = Bill::where('year', $selectedYear)
            ->where('month', $selectedMonth)
            ->get()
            ->groupBy(function ($bill) {
                return Carbon::createFromDate($bill->year, $bill->month, 1)->format('F Y');
            });
            //get all bills from selected year and month
        $billingSettings = Bill::getBillingSettings();
        $y = $billingSettings['year'];
        $m = $billingSettings['month'];
        $date = date_create($y . "-" . $m . "-01");
        $dateAdded = date_add($date, date_interval_create_from_date_string($billingSettings['billcycle'] . " month"));
        $month = date_format($dateAdded, "m");
        $year = date_format($dateAdded, "Y");
        $paybill = '';
        if ($billingSettings['month'] == $selectedMonth && $billingSettings['year'] == $selectedYear) {
            $paybill = "enable";
        } else {
            $paybill = "disable";
        }//to enable and disable bill payment by checking if bills are generated
        $shops = ShopRent::all();
        //echo "<pre>"; print_r($billsByMonth);echo '</pre>';
        return view('bills.bills_list', compact('shops', 'billsByMonth', 'var', 'paybill', 'selectedYear', 'selectedMonth'));
    }

    public function paidBills($selectedYear = null, $selectedMonth = null)
    {
        $selectedYear = $selectedYear ?? date('Y');
        $selectedMonth = $selectedMonth ?? date('m');
        $billsByMonth = Bill::where('year', $selectedYear)
            ->where('month', $selectedMonth)
            ->where('status', 'paid')
            ->get()
            ->groupBy(function ($bill) {
                return Carbon::createFromDate($bill->year, $bill->month, 1)->format('F Y');
            });//select bills where status is paid
        $shops = ShopRent::all();
        return view('bills.bills_list', compact('billsByMonth', 'selectedYear', 'selectedMonth', 'shops'));
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

    public function singlebillGen($agreement_id)
    {
        session_start();
        $billingSettings = Bill::getBillingSettings();
        $y = $billingSettings['year'];
        $m = $billingSettings['month'];
        $date = date_create($y . "-" . $m . "-01");
        $dateAdded = date_add($date, date_interval_create_from_date_string($billingSettings['billcycle'] . " month"));
        $month = date_format($dateAdded, "m");
        $year = date_format($dateAdded, "Y");
        /*if ($billingSettings['month'] == '12') {
            $month = "1";
            $year = $billingSettings['year'] + 1;
        } else {
            $month = $billingSettings['month'] + 1;
            $year = $billingSettings['year'];
        } */
        $existingBills = Bill::where('agreement_id', $agreement_id)
            ->where('year', $year)
            ->where('month', $month)
            ->first();
            //to check if bill for this month is already generated or not
        if (!$existingBills) {
            //if not generated
            $data = $this->generateBillData($agreement_id, $year, $month);
            if ($data != null) {
                return redirect()->route('agreements.index')->with('success', 'Bill Generated successfully!');
            } else {
                return redirect()->route('agreements.index')->with('Warning', 'Bill can/t be Generated!');
            }
        } else {
            return redirect()->route('agreements.index')->with('info', 'Bill Already Generated!');
        }
    }

    public function generate(Request $request, $year = null, $month = null)
    {
        //If $selectedYear or $selectedMonth are not provided, use the current year and month
        session_start();
        $year = $request->input('selectedYear') ?? date('Y');
        $month = $request->input('selectedMonth') ?? date('m');
        $billingSettings = Bill::getBillingSettings();
        $y = $billingSettings['year'];
        $m = $billingSettings['month'];
        $date = date_create($y . "-" . $m . "-01");
        $dateAdded = date_add($date, date_interval_create_from_date_string($billingSettings['billcycle'] . " month"));
        $Tmonth = date_format($dateAdded, "m");
        $Tyear = date_format($dateAdded, "Y");
        $activeAgreements = Agreement::all();
        if ($year == $Tyear && $month == $Tmonth) {
            //if selected month is = month in which bills can be generated
            foreach ($activeAgreements as $agreement) {
                $existingBills = Bill::where('agreement_id', $agreement->agreement_id)
                    ->where('year', $year)
                    ->where('month', $month)
                    ->first();
                    //check if bill for this month is already generated or not
                if (!$existingBills) {
                    //if bill not generated
                    $billAndTransactionData = $this->generateBillData($agreement->agreement_id, $year, $month);
                    
                }
            }
            $billingSettings = Bill::getBillingSettings();
            $billingSettings['month'] = $Tmonth;
            $billingSettings['year'] =$Tyear;
            $newJsonString = json_encode($billingSettings);
            //after bill is generated billing json month and year get update
            file_put_contents(public_path('billing_settings.json'), $newJsonString);
        }
        return redirect()->route('bills.billsList', ['year' => $year, 'month' => $month])->with('success', 'Bills generated successfully.');
    }
    private function generateBillData($agreement_id, $year, $month)
    {
        //Generate bill Data single and overall
        $agreement = Agreement::with('tenant', 'shop')->where('agreement_id', $agreement_id)->first();
        $transactions = Transaction::where('agreement_id', $agreement_id)->get();
        $lastBill = Bill::where('agreement_id', $agreement_id)
            ->orderby('id', 'desc')
            ->first();
            //last bill of an agreement_id
        if (!$lastBill) {
            $bill_id = null;
        } else {
            $bill_id = $lastBill->id;
        }// if last bill get id from last bill 
        $rentPM = $agreement->rent;//rent per month
        $billingSettings = Bill::getBillingSettings();
        $rent=0;
        for ($x = 1; $x <= $billingSettings['billcycle']; $x++) {
            //if billcycle is greater than 1 
            if ($agreement->status == 'active') {
                $B_month = $billingSettings['month'];
                $B_year = $billingSettings['year'];
                $m = date('m', strtotime($agreement->with_effect_from));
                $y = date('Y', strtotime($agreement->with_effect_from));
                if ($B_month == "1") {
                    if ($m == "12" && $y == $B_year - 1) {
                        $rentPM = $agreement->rentPM * (date('t', strtotime(now())) - date('d', strtotime($agreement->with_effect_from))) / date('t', strtotime(now()));
                    }
                } else {
                    if ($m == $B_month - 1 && $y == $B_year) {
                        $rentPM = $agreement->rentPM * (date('t', strtotime(now())) - date('d', strtotime($agreement->with_effect_from))) / date('t', strtotime(now()));
                    }
                }//checking which is start month from starting month 
                if ($m == $B_month && $y == $B_year) {
                    $rentPM = 0;
                    //if agreement generated this month than do not generate Bill
                }
            } else {
                $m = date('m', strtotime($agreement->valid_till));
                $y = date('Y', strtotime($agreement->valid_till));
                if ($B_month == "1") {
                    if ($m == "12" && $y == $B_year - 1) {
                        $rentPM = $agreement->rentPM * (date('d', strtotime($agreement->valid_till)) / date('t', strtotime(now())));
                    }
                } else {
                    if ($m == $B_month - 1 && $y == $B_year) {
                        $rentPM = $agreement->rentPM * (date('d', strtotime($agreement->valid_till)) / date('t', strtotime(now())));
                    }
                }//checking last month of valid month for last bill 
            }

            if ($B_month == 12) {
                $B_month = 1;
                $B_year = $B_year + 1;
            } else {
                $B_month++;
            }
            $rent += $rentPM;
            //set month = +1 month and year if month is 12 than year +1 
        }
        try {
            $datePrefix = $year . '-' . $month . '-';
            $dueDate = Carbon::createFromFormat('Y-m-d', $datePrefix . $billingSettings['due_date']); //echo "Due date =" .$dueDate;
            $billDate = Carbon::createFromFormat('Y-m-d', $datePrefix . $billingSettings['billing_date']);// echo "Bill date =" .$billDate;
            //$discountDate = Carbon::createFromFormat('Y-m-d', $datePrefix.$billingSettings['discount_date']);// echo "discount date =" .$discountDate;
        } catch (\Exception $e) {
            dd('Error: ' . $e->getMessage() . ' check whether file exist or not or contact admin');
        }
        if (!$billDate->isValid()) {
            $billDate = Carbon::now()->startOfMonth();
        }
        $uniqueTransactionNumber = $this->generateUniqueTransactionNumber();
        Log::info('Generated Transaction Number:', ['transaction_number' => $uniqueTransactionNumber]);

        $prevbal = 0;
        foreach ($transactions as $tranx) {
            $t_Month = date('m', strtotime($tranx->transaction_date));
            $t_Year = date('Y', strtotime($tranx->transaction_date));
            if ($t_Month >= $month && $t_Year >= $year) {
                //echo "NO PENELTY year".$tranx->year  ." month ".$tranx->month."<br>";
            } elseif ($t_Month < $month && $t_Year > $year) {
                //echo "NO PENELTY year".$tranx->year  ." month ".$tranx->month."<br>";
            } else {
                $prevbal += $tranx->amount;
                //echo $tranx."<br>";
            }
            //checking if there is amy prevbal or not
        }
        $penalty = 0;
        if ($prevbal > 0) {
            $penalty = $prevbal * ($billingSettings['penalty'] / 100);
        }//checking Penalty on previous balance
        $tax = $rent * ($billingSettings['tax_rate'] / 100);//Tax on rent
        $total_bal = $rent + $tax + $prevbal + $penalty;//total
        //DB::transaction(function(Request $request) {
        //});
        if ($rent !== null) {//if rent is not null
            if ($billingSettings['penalty'] > 0) {//if penalty is greater than 0
                if ($prevbal > 0) {
                    $data = Transaction::create([
                        'bill_no' => $bill_id,
                        'transaction_number' => null,
                        'agreement_id' => $agreement->agreement_id,
                        'tenant_id' => $agreement->tenant->tenant_id,
                        'shop_id' => $agreement->shop_id,
                        'tenant_name' => $agreement->tenant->full_name,
                        'amount' => round($penalty),
                        'type' => 'Penelty',
                        'transaction_date' => Carbon::now()->toDateString(),
                        'user_id' => $_SESSION['user_id'],
                        'remarks' => ' ',
                    ]);//if there is any prevbal save this
                }
            }
            $transaction = Transaction::create([
                'bill_no' => $bill_id,
                'transaction_number' => null,
                'agreement_id' => $agreement->agreement_id,
                'tenant_id' => $agreement->tenant->tenant_id,
                'shop_id' => $agreement->shop_id,
                'tenant_name' => $agreement->tenant->full_name,
                'amount' => round($rent + $tax),
                'type' => 'Rent',
                'transaction_date' => Carbon::now()->toDateString(),
                'user_id' => $_SESSION['user_id'],
                'remarks' => ' ',
            ]);//Transaction Table
            $bill = Bill::create([
                'agreement_id' => $agreement->agreement_id,
                'shop_id' => $agreement->shop->id,
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
                'tax' => (int) ($tax),
                'prevbal' => round($prevbal),
                'total_bal' => round($total_bal),
                //'discount' => $discount,
                'transaction_number' => null,
                'user_id' => $_SESSION['user_id'],
            ]);//Bill table
            $lastB = Bill::where('id', $bill_id)->first();
            if ($lastB != null) {
                if ($lastB->status == 'unpaid') {
                    $billdata = [
                        'status' => 'Carried Forward',
                        'user_id' => $_SESSION['user_id'],
                    ];
                    Bill::where('id', $bill_id)->update($billdata);
                } elseif ($lastB->status == 'partial paid') {
                    $billdata = [
                        'status' => 'Partially paid Carried Forward',
                        'user_id' => $_SESSION['user_id'],
                    ];
                    Bill::where('id', $bill_id)->update($billdata);
                }
            }//checking if last bill is paid or not if not paid status change into Carried forward
            return ['billData' => $bill, 'transactionData' => $transaction];//->toArray()
        } else {
            return ['billData' => null, 'transactionData' => null];//->toArray()
        }//return array 
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
        //regenerate bill for this month
        $bills = Bill::where('id', $bill_no)->first();
        session_start();
        $agreement = Agreement::with('tenant', 'shop')->where('agreement_id', $bills->agreement_id)->first();
        $transactions = Transaction::where('agreement_id', $bills->agreement_id)->get();
        try {
            $billingSettings = Bill::getBillingSettings();
            $datePrefix = $_POST['selectedYear'] . '-' . $_POST['selectedMonth'] . '-';
            $dueDate = Carbon::createFromFormat('Y-m-d', $datePrefix . $billingSettings['due_date']); //echo "Due date =" .$dueDate;
            $billDate = Carbon::createFromFormat('Y-m-d', $datePrefix . $billingSettings['billing_date']);// echo "Bill date =" .$billDate;
        } catch (\Exception $e) {
            dd('Error: ' . $e->getMessage() . ' check whether file exist or not or contact admin');
        }
        if (!$billDate->isValid()) {
            $billDate = Carbon::now()->startOfMonth();
        }
        $prevbal = 0;
        foreach ($transactions as $tranx) {
            $t_Month = date('m', strtotime($tranx->transaction_date));
            $t_Year = date('Y', strtotime($tranx->transaction_date));
            if ($t_Month >= $billingSettings['month'] && $t_Year >= $billingSettings['year']) {
                //echo "NO PENELTY year".$tranx->year  ." month ".$tranx->month."<br>";
            } elseif ($t_Month < $billingSettings['month'] && $t_Year > $billingSettings['year']) {
                //echo "NO PENELTY year".$tranx->year  ." month ".$tranx->month."<br>";
            } else {
                $prevbal += $tranx->amount;
                //$tnxMonth =$tranx->month;
                //$tnxYear =$tranx->year;
                //echo $tranx."<br>";
            }
        }//check bill for that month
        $penalty = 0;
        if ($prevbal > 0) {
            $penalty = $prevbal * ($billingSettings['penalty'] / 100);
        }
        $tax = $agreement->rent * ($billingSettings['tax_rate'] / 100);//Tax on rent
        $total_bal = $agreement->rent + $tax + $prevbal + $penalty;//total balance
        //echo $prevbal ." ".round($penalty)." ".$tax." ".$total_bal."<br>";
        $billdata = [
            'rent' => round($agreement->rent),
            'year' => $billingSettings['year'],
            'month' => $billingSettings['month'],
            'bill_date' => $billDate->toDateString(),
            'due_date' => $dueDate->toDateString(),
            'status' => 'unpaid',
            'penalty' => round($penalty),
            'tax' => (int) ($tax),
            'prevbal' => round($prevbal),
            'total_bal' => round($total_bal),
            'user_id' => $_SESSION['user_id'],
        ];
        Bill::where('id', $bill_no)->update($billdata);
        //update data in bill Table 
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
            'user_id' => $_SESSION['user_id'],
        ]);
        return redirect()->route('bills.index')->with('success', 'Bill updated successfully!');
    }

    public function print($id, $agreement_id)
    {

        //print single bill 

        $bill = Bill::where('id', $id)->first();

        $billingSettings = Bill::getBillingSettings();

        $shop = ShopRent::where('id', $bill->shop_id)->first();

        $transactions = Transaction::where('agreement_id', $agreement_id)->where('type', 'payment')->get();

        //from transaction where type is payment 

        $tran = Transaction::where('agreement_id', $bill->agreement_id)->where('type', 'Opening balance')->first();

        //from transaction where type is Opening Balance 
        $lastbill = [];
        //$y = $bill->year;
        //$m = $bill->month;
        $y = $billingSettings['year'];
        $m = $billingSettings['month'];
        $lastDate = date("01-" . $m . "-" . $y);
        $date1 = date_create($y . "-" . $m . "-01");
        date_add($date1, date_interval_create_from_date_string($billingSettings['billcycle']-1 . " month"));
        $duration = $lastDate. " to " . date_format($date1, "t-m-Y");//Duration of Bill to be on print Bill
        $bill->duration = "From " .$lastDate . " to " . date_format($date1, "t-m-Y");
        $dateAdd = date_sub($date1, date_interval_create_from_date_string($billingSettings['billcycle'] . " month"));
        $prevDate = date_format($date1, "t-m-Y");
        date_add($date1, date_interval_create_from_date_string($billingSettings['billcycle']+1 . " month"));
        $totalBalDate =date_format($date1, "01-m-Y");

        $date = date_create($y . "-" . $m . "-01");//last bill generated date
        date_sub($date, date_interval_create_from_date_string($billingSettings['billcycle']-1 . " month"));
        $month = date_format($date, "m");
        $year = date_format($date, "Y");//For last generated Bills
        $lastbill = Bill::where('agreement_id', $agreement_id)
            ->where('month', $month)
            ->where('year', $year)
            ->orderby('id', 'desc')
            ->first();
        //Check last bill if there is any
        /*if ($bill->month == "1") {
            $lastbill = Bill::where('agreement_id', $agreement_id)
                ->where('month', '12')
                ->where('year', $bill->year - 1)
                ->orderby('id', 'desc')
                ->first();
        } else {
            $lastbill = Bill::where('agreement_id', $agreement_id)
                ->where('month', $bill->month - 1)
                ->where('year', $bill->year)
                ->orderby('id', 'desc')
                ->first();
        }*/
        $transaction = [];
        $lastamt = 0;
        foreach ($transactions as $tranx) {
            $t_Month = date('m', strtotime($tranx->transaction_date));
            $t_Year = date('Y', strtotime($tranx->transaction_date));
            if ($tranx->type == "payment") {
                if ($t_Month == $month && $t_Year == $year) {
                    $transaction = $tranx;
                    $lastamt += $tranx->amount;
                }
            }
            /*elseif ($bill->month != '1' && $tranx->type == "payment") {
             if ($t_Month == $bill->month - 1 && $t_Year == $bill->year) {
                 $transaction = $tranx;
                 $lastamt += $tranx->amount;
             }
         }*/
        }
        if ($lastbill != null) {
            $total_bal = $lastbill->total_bal;
        } elseif ($tran != null) {
            $total_bal = $tran->amount;
        } else {
            $total_bal = 0;
        }
        return view(
            'bills.print',
            ['bill' => $bill, 'lastbill' => $lastbill, 'lastbal' => $total_bal],
            compact('billingSettings', 'duration', 'lastamt', 'transaction', 'shop', 'prevDate', 'totalBalDate')
        );
    }

    public function showLastbill($agreement_id)
    {

        $bills = Bill::where('agreement_id', $agreement_id)->orderBy('id', 'desc')->first();

        if (!$bills) {

            return redirect()->back()->with('error', 'There is no Previous Bill against this agreement.');

        } else {

            return $this->print($bills->id, $agreement_id);

        }

    }



    public function printBills($bill_no = null)
    {

        $data = [];

        $billingSettings = Bill::getBillingSettings();

        if ($bill_no != null) {

            $bills = Bill::where('id', $bill_no)->get();

        } else {

            $bills = Bill::where('month', $billingSettings['month'])->where('year', date('Y'))->get();

            //if not bill number than month is billingSetting month

        }

        foreach ($bills as $bill) {

            $bill->duration = "From " . date('01-m-Y', strtotime($bill->bill_date)) . " to " . date('t-m-Y', strtotime($bill->bill_date));

            $transactions = Transaction::where('agreement_id', $bill->agreement_id)->where('type', 'payment')->get();

            $tran = Transaction::where('agreement_id', $bill->agreement_id)->where('type', 'Opening balance')->first();

            $lastbill = null;

            //$y = $bill->year;
            //$m = $bill->month;
            $y = $billingSettings['year'];
            $m = $billingSettings['month'];
            $lastDate = date("01-" . $m . "-" . $y);
            $date1 = date_create($y . "-" . $m . "-01");
            date_add($date1, date_interval_create_from_date_string($billingSettings['billcycle']-1 . " month"));
            $duration = $lastDate. " to " . date_format($date1, "t-m-Y");//Duration of Bill to be on print Bill
            $bill->duration = "From " .$lastDate . " to " . date_format($date1, "t-m-Y");
            $dateAdd = date_sub($date1, date_interval_create_from_date_string($billingSettings['billcycle'] . " month"));
            $prevDate = date_format($date1, "t-m-Y");
            date_add($date1, date_interval_create_from_date_string($billingSettings['billcycle']+1 . " month"));
            $totalBalDate =date_format($date1, "01-m-Y");
    
            $date = date_create($y . "-" . $m . "-01");//last bill generated date
            date_sub($date, date_interval_create_from_date_string($billingSettings['billcycle']-1 . " month"));
            $month = date_format($date, "m");
            $year = date_format($date, "Y");//For last generated Bills
            
            $lastbill = Bill::where('agreement_id', $bill->agreement_id)

                ->where('month', $month)

                ->where('year', $year)

                ->first();

            $transaction = [];

            $lastamt = 0;

            foreach ($transactions as $tranx) {

                $t_Month = date('m', strtotime($tranx->transaction_date));

                $t_Year = date('Y', strtotime($tranx->transaction_date));

                if ($tranx->type == "payment") {

                    if ($t_Month == $month && $t_Year == $year) {

                        $transaction = $tranx;

                        $lastamt += $tranx->amount;

                    }

                } /*elseif ($bill->month != '1' && $tranx->type == "payment") {

             if ($t_Month == $bill->month - 1 && $t_Year == $bill->year) {

                 $transaction = $tranx;

                 $lastamt += $tranx->amount;

             }

         }*/

            }

            if (isset($lastbill)) {

                $total_bal = $lastbill->total_bal;

            } elseif (isset($tran)) {

                $total_bal = $tran->amount;

            } else {

                $total_bal = 0;

            }

            $shop = ShopRent::where('id', $bill->shop_id)->first();

            $printdata = [

                'lastamt' => $lastamt,

                'mc_name' => $billingSettings['mc_name'],

                'mc_address' => $billingSettings['mc_address'],

                'mc_email' => $billingSettings['mc_email'],

                'mc_phone' => $billingSettings['mc_phone'],

                'penalty' => $billingSettings['penalty'],

                'tax_rate' => $billingSettings['tax_rate'],

                'discount' => $billingSettings['discount'],

                'bill_id' => $bill->id,

                'shop_id' => $shop->shop_id,

                'tenant_full_name' => $bill->tenant_full_name,

                'shop_address' => $bill->shop_address,

                'contact' => $bill->tenant->contact,

                'bill_date' => $bill->bill_date,

                'bill_month' => date("F", strtotime($bill->bill_date)),

                'due_date' => $bill->due_date,

                'agreement_id' => $bill->agreement_id,

                'duration' => $bill->duration,

                'rent' => $bill->rent,

                'tax' => $bill->tax,

                'bill_penalty' => $bill->penalty,

                'last_total_bal' => $total_bal,

                'bank_name' => $billingSettings['bank']['bank_name'],

                'IFSC' => $billingSettings['bank']['ifsc_code'],

                'account_no' => $billingSettings['bank']['account_no'],

                'sign' => $billingSettings['sign'],

                'logo' => $billingSettings['logo'],

                'authority' => $billingSettings['authority'],

                'auth' => $billingSettings['auth'],

                'rec' => $billingSettings['rec'],

                'billcycle' => $billingSettings['billcycle'],

                'prevDate' => $prevDate,

                'totalBalDate' => $totalBalDate,

                'durationM' => $duration,

            ];

            $data[] = $printdata;

        }

        $pdf = Pdf::loadview('bills/printbills', compact('data'));

        //return $pdf->stream();

        if ($bill_no != null) {

            $name = "billno-" . $bill_no . ".pdf";

            return $pdf->download($name);

        } else {

            return $pdf->download('bills.pdf');

        }

    }

}