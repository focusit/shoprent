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
                                <div class="col-12">
                                    <h4>
                                        <i class="fas fa-globe"></i> AdminLTE, Inc.
                                        <small class="float-right">{{ date('Y/m/d') }}</small>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    <strong>From</strong>
                                    <address>
                                        <strong>Admin, Inc.</strong><br>
                                        795 Folsom Ave, Suite 600<br>
                                        San Francisco, CA 94107<br>
                                        Phone: (804) 123-5432<br>
                                        Email: info@almasaeedstudio.com
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <strong>To</strong>
                                    <address>
                                        <strong>{{ $bill->tenant_full_name }}</strong><br>
                                        {{ $bill->tenant->address }}<br>
                                        <strong>Phone:</strong> {{ $bill->tenant->contact }}<br>
                                        <strong>Email:</strong> {{ $bill->tenant->email }}<br>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>Invoice #00{{ $bill->id }}</b><br>
                                    <b>Order ID:</b> 4F3S8J<br>
                                    <b>Payment Due:</b> {{ $bill->due_date }}<br>
                                    <b>Account:</b> 968-34567
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="table-responsive mx-auto">
                                    <!-- Add mx-auto and table-responsive classes here -->
                                    <table class="table table-bordered border-dashed table-striped ">
                                        <thead>
                                            <tr>
                                                <th>Sr No</th>
                                                <th>Agreement id</th>
                                                <th>Rent</th>
                                                <th>Payment Date</th>
                                                <th>Due Date</th>
                                                <th>Previous Balance</th>
                                                <th>Penalty</th>
                                                <th>Discount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $bill->id }}</td>
                                                <td>{{ $bill->agreement_id }}</td>
                                                <td>{{ $bill->rent }}</td>
                                                <td>{{ date('Y/m/d') }}</td>
                                                <td>{{ $bill->due_date }}</td>
                                                <td></td>
                                                <td>{{ $bill->penalty }}</td>
                                                <td>{{ $bill->discount }}</td>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-6">

                                </div>
                                <!-- /.col -->
                                <div class="col-6">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                @php
                                                    $subtotal = $bill->subtotal = $bill->rent - $bill->discount + $bill->penalty;
                                                    $tax = $subtotal * (9.3 / 100);
                                                    $total = $subtotal + $tax;
                                                @endphp
                                                <th style="width:50%">Subtotal: </th>
                                                <td>{{ $subtotal }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tax (9.3%)</th>
                                                <td>{{ $tax }}</td>
                                            </tr>
                                            {{-- <tr>
                                                <th>Shipping:</th>
                                                <td></td>
                                            </tr> --}}
                                            <tr>
                                                <th>Total:</th>
                                                <td>{{ $total }}</td>
                                                <td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                            <!-- Modify this in your Blade template -->
                            <div class="row no-print">
                                <a rel="noopener" target="_blank" class="btn btn-default" onclick="window.print();"
                                    class="noPrint"><i class="fas fa-print"></i> Print</a>

                                <button type="button" class="btn btn-primary" id="downloadpdf" style="margin-right: 5px;">
                                    <i class="fas fa-download"></i> Generate PDF</button>
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
