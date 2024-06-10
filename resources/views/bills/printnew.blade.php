@extends('masterlist')

@section('title', 'generate_bill')

@section('body')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="pdf-content">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Invoice</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <!-- Main content -->
                            <div class="invoice p-3 mb-3">
                                <!-- title row -->
                                <div class="row">
                                    <!-- .card-body -->
                                <div class="col-4"> 
                                        <h4>
                                            <i class="fas fa-globe"></i> Shop Rent Bill <br>
                                            <small class="float-left">{{ date('Y/m/d') }}</small><br>
                                            <br> MC 1
                                        </h4>
                                </div>
                                <div class="col-4">
                                        <address>
                                            <strong>Name:</strong>{{ $bill->tenant_full_name }}<br>
                                            <strong>Address:</strong>{{$bill->shop_address}}<br>
                                            <strong>Phone No:</strong>{{$bill->tenant->contact}}<br>
                                        </address>
                                </div>
                                <div class="col-4"> 
                                        <address>
                                            <strong>Bill date:</strong>
                                            {{ $bill->bill_date }}<br>
                                            <strong>Bill Month:</strong>{{ $bill->month }}<br>
                                        <strong>Bill Validity:</strong>{{ $bill->due_date }}<br>
                                        <strong>Agreement ID:</strong>{{ $bill->agreement_id }}
                                        </address>
                                </div>
                            </div>
                            </div>
                            <!-- /.invoice -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->

                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-6">
                              <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="email@example.com">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="email@example.com">
                              </div>
                          </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <!-- Main content -->
                            <div class="invoice p-3 mb-3">
    
                                <div class="row no-print">
                                    <a rel="noopener" target="_blank" class="btn btn-default" onclick="window.print();"
                                        class="noPrint"><i class="fas fa-print"></i> Print</a>
    
                                    <button type="button" class="btn btn-primary" id="downloadpdf" style="margin-right: 5px;">
                                        <i class="fas fa-download"></i>Generate PDF</button>
                                </div>
    
                            </div>
                            <!-- /.invoice -->
                        </div><!-- /.col -->
                    </div>

            </div><!-- /.container-fluid -->
        </section>
        
                        

                    {{-- <div class="row">
                        
                        <div class="col-5">
                            <div class="invoice p-3 mb-3" style="padding: 1.5rem !important">
                                <h4>
                                    <strong> Current Charges</strong>
                                    <small class="float-right">from -to </small><br>
                                </h4>
                                <div class="row">
                                    <div class="col-10"> 
                                     <strong>  Description </strong>  
                                     <address>
                                        Current Bill-<br>
                                        Penalty (late fee)-<br>
                                        Discount-<br>
                                        Tax-<br>
                                    </address>
                                    </div>
                                    <div class="col-2"> 
                                     <strong>  Amount </strong>
                                     <address>
                                        52456<br>
                                        0<br>
                                        455<br>
                                        452<br>
                                    </address>
                                    </div>
                               </div> &nbsp;&nbsp;
                               <h4>
                                    Total 
                                    <small class="float-right">5225</small><br>
                               </h4>
                            </div>
                        </div>
                        
                        <div class="col-7">
                            <div class="invoice p-3 mb-3">
                               <div class="row">
                                    <div class="col-12">
                                        <h5><strong> Payment Details </strong></h5>
                                        <div class="row">
                                            <div class="col-5"> 
                                                <strong>  Description </strong> <br>
                                                <address>
                                                    Pervious Bill:<br>
                                                    Last Payment:<br>
                                                    Balance:<br>
                                                </address>
                                            </div>
                                            <div class="col-5">
                                                <strong>  Date </strong><br>
                                                <address>
                                                    date:23/02/2004<br>
                                                    date:23/02/2004<br>
                                                    date:23/02/2004<br>
                                                </address>
                                            </div>
                                            <div class="col-2"> 
                                                <strong>  Amount </strong><br>
                                                <address>
                                                    2435<br>
                                                    245<br>
                                                    23547<br>
                                                </address>
                                            </div>
                                       </div>
                                    </div> 
                               </div>
                               
                            </div>
                            <div class="invoice p-3 mb-3">
                                <div class="row">
                                     <div class="col-12">
                                         <h5><strong> Tax details: </strong></h5>
                                         dsfhsj<br>
                                         sdfdg<br>
                                         sfseg<br>
                                         fdgdfghet<br>yhertyr5
                                         tgtrdgweyrthd<br>bf
                                         2w23654ubfsdhbuqwheiudweenf

                                         asjh
                                     </div> 
                                </div>
                                
                             </div>
                        </div>
                    </div> --}}


         {{-- <div class="row">
                        
                        <div class="col-5">
                            <div class="invoice p-3 mb-3" style="padding: 1.5rem !important">
                                <h4>
                                    <strong> Current Charges</strong>
                                    <small class="float-right">from -to </small><br>
                                </h4>
                                <div class="row">
                                    <div class="col-10"> 
                                     <strong>  Description </strong>  
                                     <address>
                                        Current Bill-<br>
                                        Penalty (late fee)-<br>
                                        Discount-<br>
                                        Tax-<br>
                                    </address>
                                    </div>
                                    <div class="col-2"> 
                                     <strong>  Amount </strong>
                                     <address>
                                        52456<br>
                                        0<br>
                                        455<br>
                                        452<br>
                                    </address>
                                    </div>
                               </div> &nbsp;&nbsp;
                               <h4>
                                    Total 
                                    <small class="float-right">5225</small><br>
                               </h4>
                            </div>
                        </div>
                        
                        <div class="col-7">
                            <div class="invoice p-3 mb-3">
                               <div class="row">
                                    <div class="col-12">
                                        <h5><strong> Payment Details </strong></h5>
                                        <div class="row">
                                            <div class="col-5"> 
                                                <strong>  Description </strong> <br>
                                                <address>
                                                    Pervious Bill:<br>
                                                    Last Payment:<br>
                                                    Balance:<br>
                                                </address>
                                            </div>
                                            <div class="col-5">
                                                <strong>  Date </strong><br>
                                                <address>
                                                    date:23/02/2004<br>
                                                    date:23/02/2004<br>
                                                    date:23/02/2004<br>
                                                </address>
                                            </div>
                                            <div class="col-2"> 
                                                <strong>  Amount </strong><br>
                                                <address>
                                                    2435<br>
                                                    245<br>
                                                    23547<br>
                                                </address>
                                            </div>
                                       </div>
                                    </div> 
                               </div>
                               
                            </div>
                            <div class="invoice p-3 mb-3">
                                <div class="row">
                                     <div class="col-12">
                                         <h5><strong> Tax details: </strong></h5>
                                         dsfhsj<br>
                                         sdfdg<br>
                                         sfseg<br>
                                         fdgdfghet<br>yhertyr5
                                         tgtrdgweyrthd<br>bf
                                         2w23654ubfsdhbuqwheiudweenf

                                         asjh
                                     </div> 
                                </div>
                                
                             </div>
                        </div>
                    </div> --}}
        <!-- /.content -->
{{-- <h4>Payment Details</h4>
                                    <div class="row">
                                        <div class="col-5"> 
                                            <strong>  Description </strong> <br>
                                            <address>
                                                Pervious Bill:<br>
                                                Last Payment:<br>
                                                Balance:<br>
                                            </address>
                                        </div>
                                        <div class="col-5">
                                            <strong>  Date </strong><br>
                                            <address>
                                                date:23/02/2004<br>
                                                date:23/02/2004<br>
                                                date:23/02/2004<br>
                                            </address>
                                        </div>
                                        <div class="col-2"> 
                                            <strong>  Amount </strong><br>
                                            <address>
                                                2435<br>
                                                245<br>
                                                23547<br>
                                            </address>
                                        </div>
                                  </div> --}}
        


    </div>
    <!-- /.content-wrapper -->
@endsection

<!-- Add this in your Blade template -->
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
