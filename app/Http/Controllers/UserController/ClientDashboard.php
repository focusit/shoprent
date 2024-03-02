<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\ShopRent;
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

        $totalShops = ShopRent::where('tenant_id', $tenantId)->count();
        $totalAgreements = Agreement::all()->where('tenant_id', $tenantId)->count();
        $agreementId = Agreement::all()->where('tenant_id', $tenantId);
        $totalBills = Bill::all()->where('tenant_id', $tenantId)->count();
        $totalPayments = Payment::all()->where('agreement_id', $agreementId)->count();

        return view('client.index', compact('totalShops', 'totalBills', 'totalAgreements', 'totalPayments'));
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
                return redirect()->route('userDashboard')->with('info', 'You have successfully logged in as a user.');
            } else {
                Auth::logout();
                return back()->withErrors(['email' => 'Unauthorized. Please login as a user.'])->onlyInput('email');
            }
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput($request->only('email'));
    }
}
