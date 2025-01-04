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
        //Report Month Wise Report
        $selectedYear = $selectedYear ?? date('Y');//if selected year else this year
        $selectedMonth = $selectedMonth ?? date('m');//if Selected Month else this Month
        $shop=ShopRent::count();//Count all Shops
        $shops=ShopRent::all();//Get all Shops
        $agreement=Agreement::where('status','active')->count();//All Active Agreements
        $bills = Bill::where('year', $selectedYear)->where('month', $selectedMonth)->get();
        //All bills for selectedYear and selectedMonth
        $rent=$tax=$penalty =$total_amt=$prevbal=0;
        foreach($bills as $b){
            $rent +=$b->rent;
            $tax +=$b->tax;
            $prevbal +=$b->prevbal;
            $penalty +=$b->penalty;
            $total_amt +=$b->total_bal;
        }//added rent, tax, pervious bal, penalty and total amount of all bills
        $data= [
            'rent' => $rent,
            'tax' => $tax,
            'prevbal' => $prevbal,
            'penalty' =>$penalty,
            'total_amt' => $total_amt,
            'shop'=>$shop,
            'agreement' =>$agreement
        ];//data for summary
        return view('reports.monthwise',compact('bills' ,'data','shops', 'selectedYear', 'selectedMonth'));
    }

    public function collectionReport($start=null,$end=null)
    {//Collection Report    
        $start = $start ?? date('Y-m-d');//if start date else today
        $end = $end ?? date('Y-m-d');//if end date else today
        $shops=ShopRent::all();//All Shops
        $transaction=Transaction::where('type','payment')->get();//All paid Transaction
        $b =Bill::where(function($query) {
                $query->where('status', 'paid')
                    ->orWhere('status', 'Partial Paid');
                })->where('month',date("m",strtotime($end)))
                ->where('year',date("Y",strtotime($end)))
                ->orderby('id','desc')
                ->get();
                //all bills which are paid or partial paid where month is month and year is year from end date 
        if($start == $end){
            $duration="of ". date('d-m-Y', strtotime($start));
            //if end and start Date are same than Duration
        }else{
            $duration="From ". date('d-m-Y', strtotime($start)) ." to " . date('d-m-Y', strtotime($end));
            //if end and start date are different than Duration
        }
        $a=$bills=[];//Empty Arrays
        $count=$payment=$tax=$rent=$penalty=$prevbal=0;//Empty Variables
        foreach($transaction as $trans){
            if($trans->transaction_date >= $start && $trans->transaction_date <= $end){
                //if Transaction Date is between start and end date
                $count +=1;
                $payment +=$trans->amount;//add transaction amount
                foreach($b as $bill){
                    if($bill->agreement_id == $trans->agreement_id){
                        //for every transaction check if bill->agreement_id is same as transactions than add that bill to Bills array
                        //$bill->amount =$trans->amount;//for view
                        $bills[]=json_decode($bill,true);
                        if(in_array($bill->agreement_id, $a)) {
                            //if bill's agreement id is in $a array than tax, rent, penalty, prevbal is not added
                        } else {
                             //if bill's agreement id is not in $a array than tax, rent, penalty, prevbal is added
                            $tax +=$bill->tax;
                            $rent +=$bill->rent;
                            $penalty +=$bill->penalty;
                            $prevbal +=$bill->prevbal;
                            
                        }
                    }
                    $a[]=$bill->agreement_id;//adding agreement_id in $a Array
                }
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
        ];//data for summary
        //$bills = Bill::where('year', $selectedYear)->where('month', $selectedMonth)->get();
        return view('reports.collection', compact('shops','start','end','data','bills'));
    }

    public function peneltyReport(){

    }
}