@extends('masterlist')

@section('title', 'generate_bill')

@section('body')

    <div class="content-wrapper" id="pdf-content">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <h1><strong> Invoice </strong></h1>
            </div>
            <!-- /.page header -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="invoice p-3 mb-3">
                            <div class="row">

                                <div class="col-4"> 
                                    <h4>
                                        <i class="fas fa-globe"></i> Shop Rent Bill <br>
                                        <small class="float-left">{{ date('Y/m/d') }}</small><br>
                                        <br> MC 1
                                    </h4>
                                </div>
                                <div class="col-4">
                                    <address class="float-center">
                                        <strong>Name:</strong>{{ $bill->tenant_full_name }}<br>
                                        <strong>Address:</strong>{{$bill->shop_address}}<br>
                                        <strong>Phone No:</strong>{{$bill->tenant->contact}}<br>
                                    </address>
                               </div>
                               <div class="col-4"> 
                                    <address class="float-right">
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
                    <div class="col-8">
                        <div class="invoice p-3 mb-3">
                           <h4>
                               <strong> Current Charges</strong><br>
                               <small>01/01/2023 - 01/31/2024 </small>
                            </h4>
                            <div class="row">
                                <div class="col-10"> 
                                    <address>
                                        <strong>  Description </strong> <br> 
                                        Current Bill-<br>
                                        Penalty (late fee)-<br>
                                        Discount-<br>
                                        Tax-<br>
                                    </address>
                                </div>
                                <div class="col-2"> 
                                    <strong class="float-right">  Amount </strong><br>
                                    <address class="float-right">                   
                                        ??{{ $bill->agreement_id }}<br>
                                        {{ $bill->penalty }}<br>
                                        {{ $bill->discount }}<br>
                                       ?? {{ $bill->agreement_id }}<br>
                                    </address>
                                </div>
                            </div> &nbsp;&nbsp;
                            <h4>
                                <strong>Total</strong> 
                                <small class="float-right"><strong>??5665</strong></small><br>
                            </h4>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <h6>Payable ??(amount)by due date:
                                        <medium class="float-right"><strong>??{{ $bill->agreement_id }}</strong></medium><br>
                                    </h6>
                                    <h6>Payable ??(amount) befor discount date:
                                        <medium class="float-right"><strong>??{{ $bill->agreement_id }}</strong></medium><br>
                                    </h6>
                                    <h6>Payable ??(amount)after dute date charges will be:
                                        <medium class="float-right"><strong>??{{ $bill->agreement_id }}</strong></medium><br>
                                    </h6>
                        </div>
                    </div>
                                
                    <div class="col-4">
                        <div class="invoice p-3 mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <h4><strong> Payment Details </strong></h4>
                                    <div class="row">
                                        <div class="col-8"> 
                                            <strong>  Description </strong> <br>
                                            <address>
                                                Previous Bill:<br>
                                                Last Payment:<br>
                                                Balance:<br>
                                            </address>
                                        </div>
                                        <div class="col-4"> 
                                            <strong class="float-right">  Amount </strong><br>
                                            <address class="float-right">
                                                ??{{ $bill->agreement_id }}<br>
                                               ?? {{ $bill->agreement_id }}<br>
                                               ?? {{ $bill->agreement_id }}<br>
                                            </address>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
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