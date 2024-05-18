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
        $totalShops = ShopRent::all()->count();
        $allocatedShops = ShopRent::where('status', '=', 'occupied')->count();;
        $vacantShops = ShopRent::where('status', '=', 'vacant')->count();

        //tenants
        $totalTenants = Tenant::all()->count();
        // $activeTenants = Tenant::where('status', '=', 'active')->count();
        // $inactiveTenants = Tenant::where('status', '=', 'inactive')->count();

        //agreements
        $totalAgreements = Agreement::all()->count();
        $activeAgreements = Agreement::where('status', '=', 'active')->count();
        $inactiveAgreements = Agreement::where('status', '=', 'inactive')->count();

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
            // [
            //     'title' => 'Allocate Property',
            //     'badge' => 'Agreements',
            //     'body' => $this->generateCardBody([
            //         'Total Agreements' => $totalAgreements,
            //         'Active Agreements' => $activeAgreements,
            //         'Inactive Agreements' => $inactiveAgreements,
            //     ]),
            //     'linkCreate' => '/shops/create',
            //     'linkTextCreate' => 'Allocate Shops',
            //     'linkView' => '/shops',
            //     'linkTextView' => 'View Agreements',
            // ],
            // [
            //     'title' => 'Generate Bills',
            //     'badge' => 'Bills',
            //     'body' => $this->generateCardBody([
            //         'Total Bills' => $totalBills,
            //         'Unpaid Bills' => $unpaidBills,
            //         'Paid Bills' => $paidBills,
            //     ]),
            //     'linkCreate' => '/bills',
            //     'linkTextCreate' => 'Genrate Bills',
            //     'linkView' => '/bills',
            //     'linkTextView' => 'View Bills',
            // ],
            // [
            //     'title' => 'Payments',
            //     'badge' => 'Payments',
            //     'body' => $this->generateCardBody([
            //         'Total Payments' => $totalPayments,
            //         'Unpaid Payments' => $unpaidPayments,
            //         'Paid Payments' => $paidPayments,
            //     ]),
            //     'linkCreate' => '/bills',
            //     'linkTextCreate' => 'Pay Now',
            //     'linkView' => '/bills',
            //     'linkTextView' => 'Check Payments',
            // ],
        ];
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
