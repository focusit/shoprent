
@extends('masterlist')

@section('title', 'generate_bill')

@section('body')
    
    @endphp
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
                                        <small class="float-left">{{ $bill->mc_name }}</small><br>
                                        <small class="float-left">{{ $bill->mc_address }}</small><br>
                                        <small class="float-left">{{ $bill->mc_phone }}</small><br>
                                        <small class="float-left">{{ $bill->mc_email }}</small> 
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
                                        Discount-<br>
                                        Tax-<br>
                                        Previous Balance-<br>
                                    </address>
                                </div>
                                <div class="col-2"> 
                                    <strong class="float-right">  Amount </strong><br>
                                    <address class="float-right">                   
                                        {{ $bill->rent }}<br>
                                        {{ $bill->discount }}<br>
                                       ..8%<br>
                                       522 
                                       <br>(total balance)<br>
                                    </address>
                                </div>
                            </div> &nbsp;&nbsp;
                            <h4>
                                <strong>Total</strong> 
                                <small class="float-right"><strong>..5665</strong></small><br>
                            </h4>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <h6>Payable befor discount date: 
                                            {{    $bill->discount_date }}
                                        <medium class="float-right"><strong>..amount</strong></medium><br>
                                    </h6>
                                    <h6>Payable by due date:  {{ $bill->due_date }}
                                        <medium class="float-right"><strong>..amount</strong></medium><br>
                                    </h6>
                                    <h6>Payable after dute date charges will be:  {{ $bill->due_date }}
                                        <medium class="float-right"><strong>..amount</strong></medium><br>
                                    </h6>
                        </div>
                    </div>
                                
                    <div class="col-4">
                        <div class="invoice p-2 mb-2">
                            <div class="row">
                                <div class="col-12">
                                    <h4><strong> Payment Details </strong></h4>
                                    <div class="row">
                                        <div class="col-8"> 
                                            <strong>  Description </strong> <br>
                                            <address>
                                                Previous Amount:<br>
                                                Last Payment:<br>
                                                Balance:<br>
                                                Penalty (late fee)-<br>
                                            </address>
                                        </div>
                                        <div class="col-4"> 
                                            <strong class="float-right"> Amount </strong><br>
                                            <address class="float-right">
                                                500<br>
                                               200<br>
                                               ..<br>
                                               {{ $bill->penalty }}<br>
                                            </address>
                                        </div>
                                    </div>
                                </div> 
                            </div>&nbsp;&nbsp;
                            <h5>
                                <strong>Total Balance</strong> 
                                <small class="float-right"><strong>..522</strong></small><br>
                            </h5>
                        </div>
                         
                        <div class="row">
                            <div class="col-12"> 
                                qr code<br>
                            </div>
                        </div>&nbsp;&nbsp;
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