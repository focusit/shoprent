<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
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
        return view('client.index');
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
                // Regular user logged in, redirect to user dashboard
                return redirect()->route('userDashboard')->with('info', 'You have successfully logged in as a user.');
            } else {
                // Admin logged in, log them out
                Auth::logout();
                return back()->withErrors(['email' => 'Unauthorized. Please login as a user.'])->onlyInput('email');
            }
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput($request->only('email'));
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.`
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
