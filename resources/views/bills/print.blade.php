@extends('masterlist')



@section('title', 'generate_bill')



@section('body')



<div class="content-wrapper" id="pdf-content">



    <!-- Content Header (Page header) -->

    <section class="content-header">

        <div class="container-fluid">

            <h1><strong> Invoice </strong></h1>

        </div>

        <?php

$prev_bal = isset($lastbill) ? $lastbill->total_bal : $lastbal; 

$lpay = $transaction != null ? (

    $lastamt < 0 ? -1 * ($lastamt) : $lastamt) : '0';//last payment

$balance = $prev_bal - $lpay;

$bal = $prev_bal < $lpay ? 0 : $balance;//balance

$penalty = $prev_bal < $lpay ? 0 : $bill->penalty;//penalty

$total_bal = $penalty + $balance;

        ?>

    </section>

    <section class="content">

        <div class="container-fluid">

            <div class="row">

                <div class="col-12">

                    <div class="invoice p-3 mb-3">

                        <h4 style="text-align:left"><img src="/images/mclogo.png" alt="logo" height="40px" width="40px">

                            <strong>Shop Rent Bill</strong>

                        </h4><br>



                        <div class="row">

                            <div class="col-4">

                                <address class="float-left">

                                    <strong>MC Name : </strong> {{ $billingSettings['mc_name'] }} <br>

                                    <strong>MC Address : </strong> {{ $billingSettings['mc_address'] }}<br>

                                    <strong>MC Phone : </strong>{{ $billingSettings['mc_phone'] }}<br>

                                    <strong>MC Email : </strong>{{ $billingSettings['mc_email'] }}

                                </address>

                            </div>

                            <div class="col-4">

                                <address class="float-center">

                                    <strong>Name: </strong>{{ $bill->tenant_full_name }}<br>

                                    <strong>Address: </strong>{{$bill->shop_address}}<br>

                                    <strong>Shop Id: </strong>{{$shop->shop_id}}<br>

                                    <strong>Phone No: </strong>{{$bill->tenant->contact}}<br>

                                </address>

                            </div>

                            <div class="col-4">

                                <address class="float-left">

                                    <strong>Bill Number: </strong>{{ $bill->id }}<br>

                                    <strong>Bill date: </strong>{{ date('d-m-Y', strtotime($bill->bill_date)) }}<br>

                                    <strong>Bill Month: </strong>{{ date("F", strtotime($bill->bill_date))}}<br>

                                    <strong>Bill Validity: </strong>{{ date('d-m-Y', strtotime($bill->due_date)) }}<br>

                                    <strong>Agreement ID: </strong>{{ $bill->agreement_id }}

                                </address>

                            </div>

                        </div>

                        <div class="clearfix">

                            <div style="width:62%;padding:10px;float:left;border:1px solid black;">

                                <h3><strong> Current Charges</strong><small> ( {{ $bill->duration }} )</small> </h3><br>

                                <div style="float:left;width: 70%">

                                    <b class="f_left"> Description </b><br>

                                    <?php if ($billingSettings['billcycle'] > '1') { ?>

                                    <span class="f_left">Rent Per Month ( Rs. {{ (int) $bill->rent }})</span><br>

                                    <span class="f_left">Previous Balance as on {{$prevDate}}</span><br><br>

                                    <span class="f_left">Shoprent w.e.f {{ $duration }} </span><br>

                                    <?php    if ($bill->tax > 0) { ?>

                                    <span class="f_left">Tax if any</span><br>

                                    <?php    }

    if ($bill->penalty > 0) { ?>

                                    <span class="f_left">Interest if any</span><br>

                                    <?php    } ?>

                                    <span class="f_left"><strong>Total Balance as on
                                            {{$totalBalDate}}</strong></span><br>

                                    <?php } else { ?>

                                    <span class="f_left">Current Bill</span><br>

                                    <?php    if ($bill->tax > 0) { ?>

                                    <span class="f_left">Tax</span><br>

                                    <?php    } ?>

                                    <span class="f_left">Previous Balance</span><br><br>

                                    <span class="f_left"><strong>Total</strong></span><br><br>

                                    <span class="f_left">Payable by due date: {{

        date('d-m-Y', strtotime($bill->due_date)) }}</span><br>

                                    <?php    if ($bill->penalty > 0) { ?>

                                    <span class="f_left">Payable after due date charges will be: {{

            date('d-m-Y', strtotime($bill->due_date)) }}</span>

                                    <?php    }

} ?>

                                </div>

                                <div style="float:right;width: 29%;text-align:right;">

                                    <b class="f_right">Amount</b><br>

                                    <?php if ($billingSettings['billcycle'] > '1') { ?>

                                    <span class="f_right"></span><br>

                                    <span class="f_right">{{ $total_bal }}</span><br><br>

                                    <span class="f_right">{{ $totalRent }}</span><br>

                                    <?php    if ($bill->tax > 0) { ?>

                                    <span class="f_right">{{ (int) $bill->tax }}</span><br>

                                    <?php    }

    if ($bill->penalty > 0) { ?>

                                    <span class="f_right">{{ (int) $bill->penalty }}</span><br>

                                    <?php    } ?>

                                    <span class="f_right"><strong>{{ $total = round($total_bal, 2) +

        round(($totalRent), 2) + round(($bill->tax + $bill->penalty), 2)}}</strong></span><br>

                                    <?php } else { ?>

                                    <span class="f_right">{{ (int) $bill->rent }}</span><br>

                                    <?php    if ($bill->tax > 0) { ?>

                                    <span class="f_right">{{ (int) $bill->tax }}</span><br>

                                    <?php    } ?>

                                    <span class="f_right">{{ $total_bal }}</span><br><br>

                                    <span class="f_right"><strong>{{ $total = round($total_bal, 2) + round(($bill->rent +

        $bill->tax), 2)}}</strong></span><br><br>

                                    <span class="f_right"><strong>{{$total}}</strong></span></br>

                                    <?php    if ($bill->penalty > 0) { ?>

                                    <span class="f_right"><strong>{{

            round($total + $total * ($billingSettings['penalty'] / 100))}}</strong></span><br>

                                    <?php    }

} ?>

                                </div>

                            </div>

                            <div style="width:33%;float:right;padding:10px;border: 1px solid black;">

                                <h3><strong> Payment Details </strong></h3>

                                <div style="float:left;width: 50%">

                                    <strong class="f_left">Description </strong></br>

                                    <span class="f_left">Previous Bill Amount:</span></br>

                                    <span class="f_left">Payment/s Received:</span></br>

                                    <span class="f_left">Balance:</span></br>

                                    <?php if ($bill->penalty > 0) { ?>

                                    <span class="f_left">Penalty (late fee)-</span></br>

                                    <?php } ?>

                                    <br><span class="f_left"><strong>Total Balance</strong></span></br>

                                </div>

                                <div style="float:right;width: 49%;text-align:right;">

                                    <strong class="f_right"> Amount </strong><br>

                                    <span class="f_right">{{ $prev_bal}}</span><br>

                                    <span class="f_right">{{ $lpay}}</span><br>

                                    <span class="f_right">{{ $bal }}</span><br>

                                    <?php if ($bill->penalty > 0) { ?>

                                    <span class="f_right">{{ (int) $penalty }}</span><br>

                                    <?php } ?>

                                    <br><span class="f_right"><strong>{{ $total_bal }}</strong></span>

                                </div>

                            </div>

                        </div>

                        <div>

                            <b>GST = {{$billingSettings['tax_rate']}}% , Late Fee ={{$billingSettings['penalty']}}%,

                                Rebate ={{$billingSettings['discount']}}%</b>

                        </div><br>

                        <div class="clearfix" style="width:100%">

                            <div style="float:left;width: 50%">

                                <h3><strong> Our Bank Details for NEFT/RTGS/IMPS:</strong></h3>

                                <strong>{{$billingSettings['bank']['bank_name']}}</strong><br>

                                <strong>Account No:{{$billingSettings['bank']['account_no']}}</strong><br>

                                <strong>IFSC : {{$billingSettings['bank']['ifsc_code']}} </strong><br>

                                <strong>email ID: {{ $billingSettings['mc_email'] }}</strong>

                            </div>

                            <div style="float:right;width: 49%;text-align:right;">

                                <div style="float:left;width: 50%;text-align:right;padding-top:50px;">

                                    {!! QrCode::size(150)->generate(

    'Name ' . $bill->tenant_full_name .

    ' Shop Id ' . $shop->shop_id .

    ' Rent Per Month ' . (int) $bill->rent .

    ' Total Rent ' . $total
) 

                                     !!}

                                </div>

                                <div style="float:right;width: 49%;text-align:right;padding-top:50px;">

                                    <span><img src="/images/eo_mc_bilaspur.png" height="50px" width="100px"
                                            alt="sign"></span><br>

                                    <strong>{{$billingSettings['authority']}}</strong></br>

                                    <strong> {{ $billingSettings['auth'] }} </strong></br>

                                    <strong>Phone No.: {{$billingSettings['mc_phone']}}</strong></br>

                                    <strong>{{$billingSettings['rec']}}</strong></br>

                                </div>

                            </div>

                        </div>

                        <div>

                            <strong>Note:<br>

                                Please inform us by sending email along with Bill No, Shop ID (UID) and transaction

                                ID/UTR No

                                Payment of House Tax does not regularize unauthorized construction</strong>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="row no-print">

            <a rel="noopener" target="_blank" class="btn btn-info" onclick="window.print();">

                <i class="fas fa-print"></i> Print

            </a>&nbsp;&nbsp;

            <a href="{{ route('bills.generatePdf', $bill->id) }}" class="btn btn-info">

                <i class="fas fa-download"></i>Generate PDF

            </a>

        </div>

    </section>

</div>



@endsection



<!-- script file for print and pdf -->

@section('scripts')

<script>



</script>

@endsection