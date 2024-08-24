


<html>
@foreach($data as $d)
    <style>
        @page{size:8.27in 11.69in;}
        div.page{
        page-break-after: always;
        }
        div.page:last-child{
        page-break-after: avoid;
        }
        * {
            box-sizing: border-box;
        }
        .box {
            float: left;
            max-width: 33.33%;
            padding:2px;
        }
        .box2{
            margin:10px;
            padding:10px;
            float: left;
            border: 1px solid black;
        }
        .f_left{
            float:none;
            max-width:50%;
        }
        .f_right{
            max-width:25%;
            float:right;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
    <body>
        
        <?php
                $prev_bal= $d['last_total_bal'] ;
                $lpay= $d['lastamt'] < 0 ? -1*($d['lastamt']):$d['lastamt'];//last payment
                $balance=$prev_bal-$lpay ;
                $bal=$prev_bal<$lpay ? 0 :$balance;//balance
                $penalty=$prev_bal<$lpay ? 0 :$d['bill_penalty'];//penalty
                $total_bal=$penalty + $balance;
        ?>
        <div class="page">
            <h1 style="text-align:left"><strong> Shop Rent Bill </strong></h1>
            <div  class="clearfix">
                <div class="box">
                    <strong>MC Name : </strong> {{ $d['mc_name'] }} <br>
                    <strong>MC Address : </strong>{{ $d['mc_address'] }}<br>
                    <strong>MC Phone : </strong>{{ $d['mc_phone'] }}<br>
                    <strong>MC Email : </strong>{{ $d['mc_email'] }} 
                </div> 
                <div class="box">
                    <strong>Name:</strong>{{ $d['tenant_full_name'] }}<br>
                    <strong>Address:</strong>{{$d['shop_address']}}<br>
                    <strong>Phone No:</strong>{{$d['contact']}}<br>
                </div>
                <div class="box">
                    <strong>Bill Number : </strong>{{ $d['bill_id'] }}<br>
                    <strong>Bill date : </strong>{{ $d['bill_date'] }}<br>
                    <strong>Bill Month : </strong> {{ date("F",strtotime($d['bill_date'] ))}}<br>
                    <strong>Bill Validity : </strong>{{ $d['due_date'] }}<br>
                    <strong>Agreement ID : </strong>{{ $d['agreement_id'] }}
                </div>
            </div><br>
            <div class="clearfix">
                <div class="box2" style="width:62%;">
                    <h3><strong> Current Charges</strong><small> ( {{ $d['duration'] }} )</small> </h3><br>
                    <address>
                        <b class="f_left"> Description </b>
                        <b class="f_right">Amount</b><br>
                        <span class="f_left">Current Bill</span>
                        <span class="f_right">{{ (int)$d['rent'] }}</span><br>
                        <span class="f_left">Tax</span>
                        <span class="f_right">{{ (int)$d['tax'] }}</span><br>
                        <span class="f_left">Previous Balance</span>
                        <span class="f_right">{{ $total_bal }}</span><br><br>
                        <span class="f_left"><strong>Total</strong></span>
                        <span class="f_right"><strong >{{ $total = round($total_bal,2) +round(($d['rent'] + $d['tax']),2)}}</strong></span><br><br>
                        <span class="f_left">Payable by due date: {{ $d['due_date'] }}</span>
                        <span class="f_right"><strong>{{$total}}</strong></span></br>
                        <span class="f_left">Payable after dute date charges will be:  {{ $d['due_date'] }}</span>
                        <span class="f_right"><strong>{{ round($total+$total*($d['penalty']/100))}}</strong></span><br>
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
                        <span class="f_left">Penalty (late fee)-</span>
                        <span class="f_right">{{ (int)$penalty }}</span><br><br>
                        <span class="f_left"><strong>Total Balance</strong></span>
                        <span class="f_right"><strong>{{ $total_bal }}</strong></span><br><br>
                    </address>
                </div>
            </div>
        </div>
    </body>
@endforeach
</html>