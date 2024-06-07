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
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        


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
