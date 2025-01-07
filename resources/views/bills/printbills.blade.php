<html>

@foreach($data as $d)

    <style>
        @page {

            size: 8.27in 11.69in;

        }



        div.page {

            page-break-after: always;

        }



        div.page:last-child {

            page-break-after: avoid;

        }



        * {

            box-sizing: border-box;

        }



        .box {

            float: left;

            max-width: 33%;

            padding: 2px;

        }



        .box2 {

            padding: 10px;

            float: left;

            border: 1px solid black;

        }



        .f_left {

            float: none;

            max-width: 50%;

        }



        .f_right {

            max-width: 25%;

            float: right;

        }



        .clearfix::after {

            content: "";

            clear: both;

            display: table;

        }
    </style>



    <body>



        <?php

        $prev_bal = $d['last_total_bal'];

        $lpay = $d['lastamt'] < 0 ? -1 * ($d['lastamt']) : $d['lastamt'];//last payment

        $balance = $prev_bal - $lpay;

        $bal = $prev_bal < $lpay ? 0 : $balance;//balance

        $penalty = $prev_bal < $lpay ? 0 : $d['bill_penalty'];//penalty

        $total_bal = $penalty + $balance;

                                                ?>

        <div class="page">

            <h1 style="text-align:left"><img src="{{$d['logo']}}" alt=" " height="50px" weight="50px"><strong> Shop Rent

                    Bill </strong></h1>

            <div class="clearfix">

                <div class="box">

                    <strong>MC Name : </strong> {{ $d['mc_name'] }} <br>

                    <strong>MC Address : </strong>{{ $d['mc_address'] }}<br>

                    <strong>MC Phone : </strong>{{ $d['mc_phone'] }}<br>

                    <strong>MC Email : </strong>{{ $d['mc_email'] }}<br>

                </div>

                <div class="box">

                    <strong>Name:</strong>{{ $d['tenant_full_name'] }}<br>

                    <strong>Address:</strong>{{$d['shop_address']}}<br>

                    <strong>Shop Id: </strong>{{$d['shop_id']}}<br>

                    <strong>Phone No:</strong>{{$d['contact']}}<br>

                </div>

                <div class="box">

                    <strong>Bill Number : </strong>{{ $d['bill_id'] }}<br>

                    <strong>Bill date : </strong>{{ date('d-m-Y', strtotime($d['bill_date'])) }}<br>

                    <strong>Bill Month : </strong> {{ date("F", strtotime($d['bill_date']))}}<br>

                    <strong>Bill Validity : </strong>{{ date('d-m-Y', strtotime($d['due_date'])) }}<br>

                    <strong>Agreement ID : </strong>{{ $d['agreement_id'] }}<br>

                </div>

            </div>

            <div class="clearfix">

                <div class="box2" style="width:62%;margin-right:10px;">

                    <h3><strong> Current Charges</strong><small> ( {{ $d['duration'] }} )</small> </h3><br>

                    <address>

                        <b class="f_left"> Description </b>

                        <b class="f_right">Amount</b><br>

                        <?php    if ($d['billcycle'] > '1') { ?>

                        <span class="f_left">Rent Per Month  (Rs. {{ (int) $d['rent'] }})</span>

                        <span class="f_right"></span><br>

                        <span class="f_left">Previous Balance as on {{$d['prevDate']}} </span>

                        <span class="f_right">{{ $total_bal }}</span><br><br>

                        <span class="f_left">Shoprent w.e.f {{ $d['durationM'] }} </span>

                        <span class="f_right">{{ (int) $d['totalRent']  }}</span><br>

                        <?php        if ($d['tax'] > 0) { ?>

                        <span class="f_left">Tax if any</span>

                        <span class="f_right">{{ (int) $d['tax'] }}</span><br>

                        <?php        }

            if ($d['penalty'] > 0) { ?>

                        <span class="f_left">Interest if any</span>

                        <span class="f_right">{{ (int) $d['penalty'] }}</span><br>

                        <?php        } ?>

                        <span class="f_left"><strong>Total Balance as on {{$d['totalBalDate']}}</strong></span>

                        <span class="f_right"><strong>{{ $total = round($total_bal, 2) +

                round(($d['totalRent']), 2) +

                round(($d['tax'] + $d['penalty']), 2)}}</strong></span><br>

                        <?php    } else {?>

                        <span class="f_left">Current Bill</span>

                        <span class="f_right"></span><br>

                        <span class="f_left">Tax</span>

                        <span class="f_right">{{ (int) $d['tax'] }}</span><br>

                        <span class="f_left">Previous Balance</span>

                        <span class="f_right">{{ $total_bal }}</span><br><br>

                        <span class="f_left"><strong>Total</strong></span>

                        <span
                            class="f_right"><strong>{{ $total = round($total_bal, 2) + round(($d['rent'] + $d['tax']), 2)}}</strong></span><br><br>

                        <span class="f_left">Payable by due date: {{ date('d-m-Y', strtotime($d['due_date'])) }}</span>

                        <span class="f_right"><strong>{{$total}}</strong></span></br>

                        <span class="f_left">Payable after dute date charges will be:

                            {{ date('d-m-Y', strtotime($d['due_date'])) }}</span>

                        <span
                            class="f_right"><strong>{{ round($total + $total * ($d['penalty'] / 100))}}</strong></span><br>

                        <?php    }?>

                    </address>

                </div>

                <div class="box2" style="width:33%;">

                    <address>

                        <h3><strong> Payment Details </strong></h3>

                        <strong class="f_left">Description </strong>

                        <strong class="f_right"> Amount </strong><br>

                        <span class="f_left">Previous Bill Amount:</span>

                        <span class="f_right">{{ $prev_bal}}</span><br>

                        <span class="f_left">Payment/s Received:</span>

                        <span class="f_right">{{ $lpay}}</span><br>

                        <span class="f_left">Balance:</span>

                        <span class="f_right">{{ $bal }}</span><br>

                        <?php    if ($d['penalty'] > 0) { ?>

                        <span class="f_left">Penalty (late fee)-</span>

                        <span class="f_right">{{ (int) $penalty }}</span>

                        <?php    } ?>

                        <br><br><span class="f_left"><strong>Total Balance</strong></span>

                        <span class="f_right"><strong>{{ $total_bal }}</strong></span>

                        <br>

                        <?php    echo $d['tax'] > 0 ? "<br>" : "";?>

                        <?php    echo $d['penalty'] > 0 ? "<br><br>" : "";?>

                    </address>

                </div>

                <div>

                    <b>GST = {{$d['tax_rate']}}% , Late Fee ={{$d['penalty']}}%, Rebate ={{$d['discount']}}%</b>

                </div>

            </div>

            <div class="clearfix" style="width:100%">

                <div style="float:left;width: 50%">

                    <h3><strong> Our Bank Details for NEFT/RTGS/IMPS:</strong></h3>

                    <strong>{{$d['bank_name']}}</strong><br>

                    <strong>Account No:{{$d['account_no']}}</strong><br>

                    <strong>IFSC : {{$d['IFSC']}} </strong><br>

                    <strong>email ID: {{ $d['mc_email'] }}</strong>

                </div>

                <div style="float:right;width: 49%;text-align:right;">

                    <div style="float:left;width: 50%;text-align:right;padding-top:50px;">

                        {!! QrCode::size(150)->generate(

            'Name ' . $d['tenant_full_name'] .

            ' Shop Id ' . $d['shop_id'] .

            ' Rent Per Month ' . (int) $d['rent'] .

            ' Total Rent ' . $total

        ) 

                            !!}

                    </div>

                    <div style="float:right;width: 49%;text-align:right;padding-top:50px;">

                        <span><img src="{{ $d['sign'] }}" height="50px" width="100px" alt="sign"></span><br>

                        <strong>{{$d['authority']}}</strong></br>

                        <strong> {{ $d['auth'] }} </strong></br>

                        <strong>Phone No.: {{$d['mc_phone']}}</strong></br>

                        <strong>{{$d['rec']}}</strong></br>

                    </div>

                </div>

            </div>

            <div>

                <strong>Note:<br>

                    Please inform us by sending email along with Bill No, Shop ID (UID) and transaction ID/UTR No

                    Payment of House Tax does not regularize unauthorized construction</strong>

            </div>

        </div>

    </body>

@endforeach



</html>