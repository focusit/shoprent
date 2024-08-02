<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Agreement;
use App\Models\Bill;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BillController extends Controller
{
    public function index()
    {
        $agreementsData = Agreement::select('agreement_id', 'rent', 'shop_id', 'tenant_id')->get();
        $billingSettings = Bill::getBillingSettings();
        $bills = Bill::all();

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

    public function billsList($selectedYear = null, $selectedMonth = null)
    {
        // If $selectedYear or $selectedMonth are not provided, use the current year and month
        $selectedYear = $selectedYear ?? date('Y');
        $selectedMonth = $selectedMonth ?? date('m');

        $billsByMonth = Bill::where('year', $selectedYear)
            ->where('month', $selectedMonth)
            ->orderBy('month')
            ->get()
            ->groupBy(function ($bill) {
                return Carbon::createFromDate($bill->year, $bill->month, 1)->format('F Y');
            });

        // $sqlQuery = DB::getQueryLog()[0]['query'];

        // Log or dd() the SQL query for debugging
        // dd($sqlQuery);

        return view('bills.bills_list', compact('billsByMonth', 'selectedYear', 'selectedMonth'));
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

        foreach ($activeAgreements as $agreement) {
            $existingBill = Bill::where('agreement_id', $agreement->agreement_id)
                ->where('year', $year)
                ->where('month', $month)
                ->first();

            if (!$existingBill) {
                $billAndTransactionData = $this->generateBillData($agreement->agreement_id, $year, $month);

                if ($billAndTransactionData && $billAndTransactionData['transactionData']) {
                    $transactionData = $billAndTransactionData['transactionData'];

                    logger('Transaction Data:', $transactionData);

                    try {
                        $createdTransaction = Transaction::create($transactionData);

                        if ($createdTransaction) {
                            Bill::create($billAndTransactionData['billData']);
                        } else {
                            logger('Transaction creation failed:', ['agreement_id' => $agreement->agreement_id]);
                        }
                    } catch (\Exception $e) {
                        // Log the exception
                        logger('Error creating transaction:', ['error' => $e->getMessage(), 'agreement_id' => $agreement->agreement_id]);
                    }
                }
            }
        }

        return redirect()->route('bills.billsList', ['year' => $year, 'month' => $month])->with('success', 'Bills generated successfully.');
    }
    private function generateBillData($agreement_id, $year, $month)
    {
        $agreement = Agreement::with('tenant', 'shop')->where('agreement_id', $agreement_id)->first();

        try {
            $billingSettings = Bill::getBillingSettings();
            //print_r($billingSettings); print_r($_POST);
            $datePrefix=$_POST['selectedYear'].'-'.$_POST['selectedMonth'].'-';
            $dueDate = Carbon::createFromFormat('Y-m-d', $datePrefix.$billingSettings['due_date']); //echo "Due date =" .$dueDate;
            $billDate = Carbon::createFromFormat('Y-m-d', $datePrefix.$billingSettings['billing_date']);// echo "Bill date =" .$billDate;
            $discountDate = Carbon::createFromFormat('Y-m-d', $datePrefix.$billingSettings['discount_date']);// echo "discount date =" .$discountDate;

        } catch (\Exception $e) {
            dd('Error: ' . $e->getMessage() . ' check wether file exist or not or contact admin');
        }



        if (!$billDate->isValid()) {
            $billDate = Carbon::now()->startOfMonth();
        }

        if (now() <= $dueDate) {
            $penalty = 0;
            $discount = $billingSettings['discount'];
        } else {
            $penalty = $billingSettings['penalty'];
            $discount = 0;
        }

        $uniqueTransactionNumber = $this->generateUniqueTransactionNumber();
        Log::info('Generated Transaction Number:', ['transaction_number' => $uniqueTransactionNumber]);

        $transaction = Transaction::create([
            'transaction_number' => $uniqueTransactionNumber,
            'property_type' => $agreement->agreement_id,
            'tenant_id' => $agreement->tenant->tenant_id,
            'tenant_name' => $agreement->tenant->full_name,
            'transaction_date' => Carbon::now()->toDateString(),
            'year' => $year,
            'month' => $month,
            'type' => 'example_type',
            'remarks' => 'example_remarks',
        ]);

        $bill = Bill::create([
            'agreement_id' => $agreement->agreement_id,
            'shop_id' => $agreement->shop->shop_id,
            'tenant_id' => $agreement->tenant->tenant_id,
            'tenant_full_name' => $agreement->tenant->full_name,
            'shop_address' => $agreement->shop->address,
            'rent' => $agreement->rent,
            'year' => $year,
            'month' => $month,
            'bill_date' => $billDate->toDateString(),
            'due_date' => $dueDate->toDateString(),
            'discount_date'=> $discountDate->toDateString(),
            'status' => 'unpaid',
            'penalty' => $penalty,
            'discount' => $discount,
            'transaction_number' => $uniqueTransactionNumber,
        ]);

        return ['billData' => $bill, 'transactionData' => $transaction->toArray()];
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

        if ($existingBill) {
            $year = $existingBill->year;
            $month = $existingBill->month;

            $billingSettings = Bill::getBillingSettings();

            $existingBill->update([
                'bill_date' => $billingSettings['billing_date'],
                'due_date' => $billingSettings['due_date'],

            ]);

            return redirect()->route('bills.index')->with('success', "Bill for {$year}-{$month} regenerated successfully.");
        } else {
            return redirect()->route('bills.index')->with('error', 'No bill found for the specified agreement and transaction number.');
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
        $settings=Bill::getBillingSettings();

        //echo '<pre>'; print_r($bill); echo '</pre>';
        
        $bill->duration="From ". date('Y-m-01', strtotime($bill->bill_date)) ." to " . date('Y-m-t', strtotime($bill->bill_date));
        $bill->tax= $bill->rent * ($settings['tax_rate']/100);


        print_r($bill);

        return view('bills.print', compact('bill'));
    }

    public function paidBills()
    {
        $bills = Bill::all();
        return view('bills.billpay', compact('bills'));
    }
}
