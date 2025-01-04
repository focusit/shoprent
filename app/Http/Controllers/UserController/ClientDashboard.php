<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\ShopRent;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientDashboard extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }

    public function userDashboard()
    {
        $tenantId = Auth::user()->tenant_id;
        $tenantId = Auth::user()->tenant_id;
        $totalShops = ShopRent::all()->where('tenant_id', $tenantId)->count();
        $allocatedShops = ShopRent::where('tenant_id', $tenantId)->where('status', '=', 'occupied')->count();
        $vacantShops = ShopRent::where('tenant_id', $tenantId)->where('status', '=', 'vacant')->count();

        //tenants
        // $totalTenants = Tenant::all()->count();
        // $activeTenants = Tenant::where('status', '=', 'active')->count();
        // $inactiveTenants = Tenant::where('status', '=', 'inactive')->count();

        //agreements
        $totalAgreements = Agreement::all()->where('tenant_id', $tenantId)->count();
        $activeAgreements = Agreement::where('tenant_id', $tenantId)->where('status', '=', 'active')->count();
        $inactiveAgreements = Agreement::where('tenant_id', $tenantId)->where('status', '=', 'inactive')->count();

        //biills
        $totalBills = Bill::all()->where('tenant_id', $tenantId)->count();
        $unpaidBills = Bill::where('tenant_id', $tenantId)->where('status', '=', 'unpaid')->count();
        $paidBills = Bill::where('tenant_id', $tenantId)->where('status', '=', 'paid')->count();

        //payments
        $totalPayments = Payment::all()->where('tenant_id', $tenantId)->count();
        $unpaidPayments = Payment::where('tenant_id', $tenantId)->where('status', '=', 'unpaid')->count();
        $paidPayments = Payment::where('tenant_id', $tenantId)->where('status', '=', 'success')->count();

        $cards = [
            [
                'title' => 'Shops',
                'badge' => 'Shops',
                'body' => $this->generateCardBody([
                    'Total Shops' => $totalShops,
                    'Allocated Shops' => $allocatedShops,
                    'Vacant Shops' => $vacantShops,
                ]),
                'linkView' => route('viewUserShops'),
                'linkTextView' => 'View My Shops',
            ],
            // [
            //     'title' => 'Tenants',
            //     'badge' => 'Tenants',
            //     'body' => $this->generateCardBody([
            //         'Total Tenants' => $totalTenants,
            //         // 'Active Tenants' => $activeTenants,
            //         // 'Inactive Tenants' => $inactiveTenants,
            //     ]),
            //     'linkCreate' => '/tenants/create',
            //     'linkTextCreate' => 'Add Tenants',
            //     'linkView' => '/tenants',
            //     'linkTextView' => 'View Tenants',
            // ],
            [
                'title' => 'My Agreements',
                'badge' => 'Agreements',
                'body' => $this->generateCardBody([
                    'Total Agreements' => $totalAgreements,
                    'Active Agreements' => $activeAgreements,
                    'Inactive Agreements' => $inactiveAgreements,
                ]),
                'linkView' => route('viewUserAgreements'),
                'linkTextView' => 'View Agreements',
            ],
            [
                'title' => 'My Bills',
                'badge' => 'Bills',
                'body' => $this->generateCardBody([
                    'Total Bills' => $totalBills,
                    'Unpaid Bills' => $unpaidBills,
                    'Paid Bills' => $paidBills,
                ]),

                'linkView' => route('viewUserBills'),
                'linkTextView' => 'View My Bills',
            ],
            [
                'title' => 'My Payments',
                'badge' => 'Payments',
                'body' => $this->generateCardBody([
                    'Total Payments' => $totalPayments,
                    'Unpaid Payments' => $unpaidPayments,
                    'Paid Payments' => $paidPayments,
                ]),
                'linkView' => route('viewUserPayments'),
                'linkTextView' => 'Check Payments',
            ],
        ];
        return view('client.index', compact('totalShops', 'totalBills', 'totalAgreements', 'totalPayments', 'cards'));
    }
    /**
     * Show the form for creating a new resource.
     */

    public function showUserLoginForm()
    {
        return view('client.userlogin');
    }
    public function userLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->is_admin) {
                $message=" You have successfully logged in as a user.";
                return redirect()->route('userDashboard')->with('info', 'You have successfully logged in as a user.');
            } else {
                Auth::logout();
                return back()->withErrors(['email' => 'Unauthorized. Please login as a user.'])->onlyInput('email');
            }
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput($request->only('email'));
    }
    public function userLogout()
    {
        Auth::logout();

        return redirect()->route('login.form')->with('info', 'You have been successfully logged out.');
    }

    public function getShops()
    {
        $tenantId = Auth::user()->tenant_id;
        $shops = ShopRent::where('tenant_id', $tenantId)->get();

        return $shops;
    }

    /**
     * Get all agreements for the given tenant_id.
     */
    public function getAgreements()
    {
        $tenantId = Auth::user()->tenant_id;
        $agreements = Agreement::where('tenant_id', $tenantId)->get();

        return $agreements;
    }

    /**
     * Get all bills for the given tenant_id.
     */
    public function getBills()
    {
        $tenantId = Auth::user()->tenant_id;
        $bills = Bill::where('tenant_id', $tenantId)->get();

        return $bills;
    }

    /**
     * Get all payments for the given tenant_id.
     */
    public function getPayments()
    {
        $tenantId = Auth::user()->tenant_id;

        // Assuming you have a relationship between Agreement and Payment models
        $payments = Payment::where('tenant_id', $tenantId)->get();

        return $payments;
    }
    /**
     * Show All the Transactions of the User.
     */
    public function getTransactions()
    {
        $transactions = Transaction::where('tenant_id', Auth::user()->tenant_id)->get();
        return $transactions;
    }
    public function viewAllTransactions()
    {
        return view('client.view_transactions');
    }

    public function viewUserShops()
    {
        $shops = $this->getShops();
        return view('client.view_shops', compact('shops'));
    }

    public function viewUserAgreements()
    {
        $agreements = $this->getAgreements();
        return view('client.view_agreements', compact('agreements'));
    }

    public function viewUserBills()
    {
        $bills = $this->getBills();
        return view('client.view_bills', compact('bills'));
    }

    public function viewUserPayments()
    {
        $payments = $this->getPayments();
        $transactions = $this->getTransactions();
        return view('client.view_payments', compact('payments', 'transactions'));
    }

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
