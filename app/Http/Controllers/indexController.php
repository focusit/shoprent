<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class indexController extends Controller
{
    public function dashboard(){
        $cards = [
            [
                'title' => 'Shops',
                'badge' => 'Shops',
                'body' => 'The body of the card for Shops.',
                'linkCreate' => '/shops/create',
                'linkTextCreate' => 'Add Shops',
                'linkView' => '/shops',
                'linkTextView' => 'View Shops',
            ],
            [
                'title' => 'Tenants',
                'badge' => 'Tenants',
                'body' => 'The body of the card for Tenants.',
                'linkCreate' => '/tenants/create',
                'linkTextCreate' => 'Add Tenants',
                'linkView' => '/tenants',
                'linkTextView' => 'View Tenants',
            ],
            [
                'title' => 'Allocate Property',
                'badge' => 'Agreements',
                'body' => 'The body of the card for Allocate Property.',
                'linkCreate' => '/shops/create', 
                'linkTextCreate' => 'Allocate Shops',
                'linkView' => '/shops', 
                'linkTextView' => 'View Agreements',
            ],
            [
                'title' => 'Generate Bills',
                'badge' => 'Bills',
                'body' => 'The body of another card.',
                'linkCreate' => '/bills', 
                'linkTextCreate' => 'Genrate Bills',
                'linkView' => '/bills', 
                'linkTextView' => 'View Bills',
            ],
            [
                'title' => 'Payments',
                'badge' => 'Payments',
                'body' => 'The body of another card.',
                'linkCreate' => '/bills', 
                'linkTextCreate' => 'Pay Now',
                'linkView' => '/bills', 
                'linkTextView' => 'Check Payments',
            ],
        ];
        return view('dashboard',compact('cards'));
    }

    public function logout(){
        auth()->logout();
        return redirect('/login')->with('success', 'you have been Logged out successfully');
    }
}
