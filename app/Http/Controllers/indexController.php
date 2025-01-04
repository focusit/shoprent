<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\Bill;
use App\Models\Payment;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\ShopRent;
use App\Models\Tenant;

class indexController extends Controller
{
    public function dashboard()
    {
        session_start();
        //agreements
        $totalAgreements = Agreement::all()->count();
        $agreement=Agreement::all();
        $inactiveCount = 0;
        $inactiveAgree = [];
        foreach($agreement as $agree){
            if($agree->valid_till < date('Y-m-d') && $agree->status=="active"){
                $inactiveCount ++;
                $inactiveAgree[]=$agree->agreement_id;
                $data =[
                    'status'=>"inactive",
                    'user_id'=>$_SESSION['user_id'],
                ];
                Agreement::where('id',$agree->id)->update($data);
            }
        }
        $activeAgreements = Agreement::where('status', '=', 'active')->count();
        $inactiveAgreements = Agreement::where('status', '=', 'inactive')->count();

        //Shops
        $totalShops = ShopRent::all()->count();
        $shops=ShopRent::all();
        foreach($agreement as $agree){
            foreach($shops as $shop){
                if($shop->id ==$agree->shop_id && $agree->status=="active"){
                    if($shop->status =="vacant" ){
                        $data =[
                            'status'=>"occupied",
                            'user_id'=>$_SESSION['user_id'],
                        ];
                        ShopRent::where('id',$shop->id)->update($data);
                    }
                }
            }           
        }
        $allocatedShops = ShopRent::where('status', '=', 'occupied')->count();;
        $vacantShops = ShopRent::where('status', '=', 'vacant')->count();

        //tenants
        $totalTenants = Tenant::all()->count();
        // $activeTenants = Tenant::where('status', '=', 'active')->count();
        // $inactiveTenants = Tenant::where('status', '=', 'inactive')->count();

        //biills
        $totalBills = Bill::all()->count();
        $unpaidBills = Bill::where('status', '=', 'unpaid')->count();
        $paidBills = Bill::where('status', '=', 'paid')->count();

        //payments
        $totalPayments = Payment::all()->count();
        $unpaidPayments = Payment::where('status', '=', 'unpaid')->count();
        $paidPayments = Payment::where('status', '=', 'paid')->count();

        $cards = [
            [
                'title' => 'Shops',
                'badge' => 'Shops',
                'body' => $this->generateCardBody([
                    'Total Shops' => $totalShops,
                    'Allocated Shops' => $allocatedShops,
                    'Vacant Shops' => $vacantShops,
                ]),
                'linkCreate' => '/shops/create',
                'linkTextCreate' => 'Add Shops',
                'linkView' => '/shops',
                'linkTextView' => 'View Shops',
            ],
            [
                'title' => 'Tenants',
                'badge' => 'Tenants',
                'body' => $this->generateCardBody([
                    'Total Tenants' => $totalTenants,
                    // 'Active Tenants' => $activeTenants,
                    // 'Inactive Tenants' => $inactiveTenants,
                ]),
                'linkCreate' => '/tenants/create',
                'linkTextCreate' => 'Add Tenants',
                'linkView' => '/tenants',
                'linkTextView' => 'View Tenants',
            ],
            [
                'title' => 'Allocate Property',
                'badge' => 'Agreements',
                'body' => $this->generateCardBody([
                    'Total Agreements' => $totalAgreements,
                    'Active Agreements' => $activeAgreements,
                    'Inactive Agreements' => $inactiveAgreements,
                ]),
                'linkCreate' => '/allocate-shop',
                'linkTextCreate' => 'Allocate Shops',
                'linkView' => '/agreements',
                'linkTextView' => 'View Agreements',
            ],
            [
                'title' => 'Generate Bills',
                'badge' => 'Bills',
                'body' => $this->generateCardBody([
                    'Total Bills' => $totalBills,
                    'Unpaid Bills' => $unpaidBills,
                    'Paid Bills' => $paidBills,
                ]),
                'linkCreate' => '/bills',
                'linkTextCreate' => 'Genrate Bills',
                'linkView' => 'bills/bills_list',
                'linkTextView' => 'View Bills',
            ],
            [
                'title' => 'Payments',
                'badge' => 'Payments',
                'body' => $this->generateCardBody([
                    'Total Payments' => $totalPayments,
                    'Unpaid Payments' => $unpaidPayments,
                    'Paid Payments' => $paidPayments,
                ]),
                'linkCreate' => '/payments/payBill',
                'linkTextCreate' => 'Pay Now',
                'linkView' => '/billpay',
                'linkTextView' => 'Check Payments',
            ],
        ];
        $billingSettings=Bill::getBillingSettings();
        $datePrefix=$billingSettings['year'].'-'.$billingSettings['month'].'-';
        $date = Carbon::createFromFormat('Y-m-d', $datePrefix.$billingSettings['billing_date']);
        $data=[
            'allocatedShops'=>$allocatedShops,
            'bills' => Bill::where('month', $billingSettings['month'])
                        ->where('year',$billingSettings['year'])
                        ->count(),
            'payments' => Transaction::where('type','payment')
                            ->where('transaction_date','>=',$date)
                            ->count(),
        ];
        $message=null;
        $y = $billingSettings['year'];
        $m = $billingSettings['month'];
        $date = date_create($y . "-" . $m . "-01");//last bill generated date
        $dateAdded = date_add($date, date_interval_create_from_date_string($billingSettings['billcycle'] . " month"));//add billcycle in last bill month
        $month = date_format($dateAdded, "m");
        $year = date_format($dateAdded, "Y");
        if(date('m') < $month && date('Y') <= $year){ 

        }elseif(date('m') >= $month && date('m') >= $year){
            if(date('d')>=$billingSettings['billing_date'] ){
                $message = "Please Generate bills for this month.";
            }
        }
        if($inactiveCount > 0){
            foreach($inactiveAgree as $inAgree){
                $message .="Agreement NO. ".$inAgree." is expired today";
            }
        }
        return view('dashboard',['data'=>$data], compact('cards','message'));
    }

    // public function logout()
    // {
    //     auth()->logout();
    //     return redirect('/admin')->with('success', 'you have been Logged out successfully');
    // }
    private function generateCardBody($data)
    {
        $tableRows = '';

        foreach ($data as $label => $count) {
            $tableRows .= '<tr">
                              <td>' . $label .  '</td>
                              <td>' . $count .  '</td>
                           </tr>';
        }

        return '<table class="table " style="border:dashed 1.5px #ddd; width: 100%; hover:transform:scale(1.01);">
                    <thead>
                        <tr>
                            <th >Category</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . $tableRows . '
                    </tbody>
                </table>';
    }
}
