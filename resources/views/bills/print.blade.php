
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
                $lpay=$transaction !=null?(
                    $transaction->amount < 0 ? -1*($transaction->amount):$transaction->amount
                ) :'0.00';//last payment
                $bal=$bill->prevbal-$lpay ;//balance
                $penalty=$bal*($billingSettings['penalty']/100);//penalty
                $total_bal=$bal+$penalty;
            ?>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="invoice p-3 mb-3">
                            <h4><i class="fas fa-globe"></i> <strong>Shop Rent Bill</strong> </h4><br>
                            <div class="row">
                                <div class="col-4"> 
                                    <h5>
                                        <small class="float-left">{{ $billingSettings['mc_name'] }} </small><br>
                                        <small class="float-left">{{ $billingSettings['mc_address'] }}</small><br>
                                        <small class="float-left">{{ $billingSettings['mc_phone'] }}</small><br>
                                        <small class="float-left">{{ $billingSettings['mc_email'] }}</small> 
                                    </h5>
                                </div>
                                <div class="col-4">
                                    <address class="float-center">
                                        <strong>Name:</strong>{{ $bill->tenant_full_name }}<br>
                                        <strong>Address:</strong>{{$bill->shop_address}}<br>
                                        <strong>Phone No:</strong>{{$bill->tenant->contact}}<br>
                                    </address>
                               </div>
                               <div class="col-4"> 
                                    <address class="float-left">
                                        <strong>Bill Number:</strong>
                                        {{ $bill->id }}<br>
                                        <strong>Bill date:</strong>
                                        {{ $bill->bill_date }}<br>
                                        <strong>Bill Month:</strong>{{ $bill->month }}<br>
                                    <strong>Bill Validity:</strong>{{ $bill->due_date }}<br>
                                    <strong>Agreement ID:</strong>{{ $bill->agreement_id }}
                                    </address>
                               </div>

                           </div>
                        </div>
                    </div>
                </div>
                <div class="row">                    
                    <div class="col-md-8">
                        <div class="invoice p-3 mb-3">
                           <h4>
                               <strong> Current Charges</strong>
                               <small> {{ $bill->duration }}</small>
                            </h4>
                            <div class="row">
                                <div class="col-9"> 
                                    <address>
                                        <strong>  Description </strong> <br> 
                                        Current Bill<br>
                                        Tax<br>
                                        Previous Balance<br>
                                    </address>
                                </div>
                                <div class="col-2"> 
                                    <strong class="float-right">  Amount </strong><br>
                                    <address>                   
                                        <span class="float-right">{{ $bill->rent }}</span><br>
                                        <span class="float-right">{{ $bill->tax}}</span><br>
                                        <span class="float-right">{{ $total_bal}}</span><br>
                                    </address>
                                </div>
                                <div class="col-1"></div> 
                            </div> &nbsp;
                            <h4><div class="row">
                                <div class="col-9"> 
                                    <strong>Total</strong>
                                </div>
                                <div class="col-2">
                                    <strong class="float-right">{{ $total =$bill->rent + $bill->tax +$total_bal}}</strong>
                                </div>
                                <div class="col-1"></div>
                            </div></h4>
                            &nbsp;
                            <div class="row">
                                <div class="col-9">
                                    Payable by due date: {{ $bill->due_date }}</br>
                                    Payable after dute date charges will be:  {{ $bill->due_date }}</br>
                                </div>
                                <div class="col-2">
                                    <strong class="float-right">{{$total}}</strong></br>
                                    <strong class="float-right">{{$total+$total*($billingSettings['penalty']/100)}}</strong></br>
                                </div>
                                <div class="col-1"></div>
                            </div>
                        </div>
                    </div>
                                
                    <div class="col-md-4">
                        <div class="invoice p-2 mb-2">
                            <div class="row">
                                <div class="col-12">
                                    <h4><strong> Payment Details </strong></h4>
                                    <div class="row">
                                        <div class="col-8"> 
                                            <strong>  Description </strong> <br>
                                                Previous Bill Amount:<br>
                                                Last Payment:<br>
                                                Balance:<br>
                                                Penalty (late fee)-<br>
                                        </div>
                                        <div class="col-4"> 
                                            <strong class="float-right"> Amount </strong><br>
                                            <address class="float-right">
                                                {{ $prev_bal= $bill->prevbal}}<br>
                                                {{ $lpay}}<br>
                                                {{ $bal }}<br>
                                                {{ $penalty }}<br>
                                            </address>
                                        </div>
                                    </div>
                                </div> 
                            </div>&nbsp;&nbsp;
                            <h5>
                                <strong>Total Balance</strong> 
                                <strong class="float-right" id="total_prevbal">{{ $total_bal }}</strong><br>
                            </h5>
                        </div>
                         
                        <div class="row">
                            <div class="col-12"> 
                                qr code<br>
                            </div>
                        </div>&nbsp;
                        <h5>
                            <small class="float-right"><strong>..Signature</strong></small><br>
                        </h5>
                    </div>
                </div>
                <!-- Main content -->
                    <div class="row no-print">
                        <a rel="noopener" target="_blank" class="btn btn-default" onclick="window.print();"
                            class="noPrint"><i class="fas fa-print"></i> Print
                        </a>&nbsp;&nbsp;
                        <button type="button" class="btn btn-primary" id="downloadpdf" style="margin-right: 5px;">
                            <i class="fas fa-download"></i>Generate PDF
                        </button>
                    </div>
            </div>
        </section>

    </div>

@endsection

<!-- script file for print and pdf -->
@section('scripts')
    <script>
        document.getElementById('downloadpdf').addEventListener('click', function() {
            var printWindow = window.open('', '_blank');
            printWindow.document.write(
                '<html><head><link rel="stylesheet" type="text/css" href="path/to/your/print.css"></head><body>'
            );
            printWindow.document.write(document.getElementById('pdf-content').innerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });

    </script>
@endsection