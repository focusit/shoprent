<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\ShopRent;
use App\Models\Tenant;
use App\Models\Agreement;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class reportController extends Controller
{
    public function index(){
        
    }

    public function monthReport($selectedYear=null,$selectedMonth=null){
        $selectedYear = $selectedYear ?? date('Y');
        $selectedMonth = $selectedMonth ?? date('m');
        $shop=ShopRent::count();
        $agreement=Agreement::where('status','active')->count();
        $bills = Bill::where('year', $selectedYear)->where('month', $selectedMonth)->get();
        $rent=$tax=$penalty =$total_amt=$prevbal=0;
        foreach($bills as $b){
            $rent +=$b->rent;
            $tax +=$b->tax;
            $prevbal +=$b->prevbal;
            $penalty +=$b->penalty;
            $total_amt +=$b->total_bal;
        }
        $data= [
            'rent' => $rent,
            'tax' => $tax,
            'prevbal' => $prevbal,
            'penalty' =>$penalty,
            'total_amt' => $total_amt,
            'shop'=>$shop,
            'agreement' =>$agreement
        ];
        //print_r ($data) ;
        return view('reports.monthwise',compact('bills' ,'data', 'selectedYear', 'selectedMonth'));
    }

    public function collectionReport($selectedYear=null,$selectedMonth=null){
        $selectedYear = $selectedYear ?? date('Y');
        $selectedMonth = $selectedMonth ?? date('m');
        $bills = Bill::where('year', $selectedYear)->where('month', $selectedMonth)->get();
        return view('reports.collection', compact('bills', 'selectedYear','selectedMonth'));
    }

    public function peneltyReport(){

    }
}