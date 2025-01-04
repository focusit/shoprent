<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\Bill;
use App\Models\Payment;
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
        foreach($agreement as $agree){
            if($agree->valid_till < date('Y-m-d') && $agree->status=="active"){
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
                if($shop->shop_id ==$agree->shop_id && $agree->status=="inactive"){
                    if($shop->status =="Occupied"){
                        $data =[
                            'status'=>"vacant",
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
                'linkCreate' => '',
                'linkTextCreate' => 'Pay Now',
                'linkView' => '',
                'linkTextView' => 'Check Payments',
            ],
        ];
        $billingSettings=Bill::getBillingSettings();
        //print_r($billingSettings);
        if($billingSettings['month']>date('m') && $billingSettings['year']>=date('Y')){

        } if($billingSettings['month']<date('m') && $billingSettings['year']>date('Y')){
            //echo '<script>alert("Generated bills")</script>';
        }elseif($billingSettings['month'] <= date('m')-1 && $billingSettings['year']==date('Y')){
            if(date('d')>=$billingSettings['billing_date'] ){
                echo '<script>alert("Please Generate bills for this month")</script>';
            }
        }
        return view('dashboard', compact('cards'));
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
