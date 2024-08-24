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
        echo "Tax Collection";
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

    public function collectionReport($start=null,$end=null){
        $start = $start ?? date('Y-m-d');
        $end = $end ?? date('Y-m-d');
        $transaction=Transaction::where('type','payment')->get();
        $b =Bill::where('status','paid')
                    ->where('month',date("m",strtotime($end)))
                    ->where('year',date("Y",strtotime($end)))
                    ->get();
        if($start == $end){
            $duration="of ". date('d-m-Y', strtotime($start));
        }else{
            $duration="From ". date('d-m-Y', strtotime($start)) ." to " . date('d-m-Y', strtotime($end));
        }
        $bills=[];
        $count=$payment=$tax=$rent=$penalty=$prevbal=0;
        //echo $b;
        foreach($transaction as $trans){
            if($trans->transaction_date >= $start && $trans->transaction_date <= $end){
                $count +=1;
                $payment +=$trans->amount;
                foreach($b as $bill){
                    if($bill->agreement_id ==$trans->agreement_id){
                        $tax +=$bill->tax;
                        $rent +=$bill->rent;
                        $penalty +=$bill->penalty;
                        $prevbal +=$bill->prevbal;
                        $bills[]=json_decode($bill,true);
                        //echo $bill."<br>";
                    }
                }
                //echo $trans."<br>";
            }
        }
        $data= [
            'duration' =>$duration,
            'count' =>$count,
            'payment' =>$payment,
            'tax' =>$tax,
            'rent' =>$rent,
            'penalty' =>$penalty,
            'prevbal' =>$prevbal,
        ];
        //print_r($bills);
        //$bills = Bill::where('year', $selectedYear)->where('month', $selectedMonth)->get();
        return view('reports.collection', compact( 'start','end','data','bills'));
    }

    public function peneltyReport(){

    }
}