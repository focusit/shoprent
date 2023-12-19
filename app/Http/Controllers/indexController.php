<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class indexController extends Controller
{
    public function dashboard(){
        return view('dashboard');
    }

    public function logout(){
        auth()->logout();
        return redirect('/login')->with('success', 'you have been Logged out successfully');
    }
}
