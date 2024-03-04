@extends('client.clientui')

@section('title', 'Dashboard')

@section('body')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <!-- .container-fluid -->
            <div class="container-fluid">
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <!-- Info boxes -->


                        <div class="card">
                            <div class="card-header">Payment Information</div>
                            <div class="card-body">

                                <h4>Your Payments:</h4>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="bg-info">
                                            <th>ID</th>
                                            {{-- <th>Agreement ID</th> --}}
                                            <th>Transaction Number</th>
                                            {{-- <th>Shop ID</th> --}}
                                            {{-- <th>Shop Address</th> --}}
                                            <th>Tenant ID</th>
                                            <th>Amount</th>
                                            <th>Payment Date</th>
                                            <th>Payment Method</th>
                                            <th>Status</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($payments as $payment)
                                            <tr>
                                                <td>{{ $payment->id }}</td>
                                                <td>
                                                    <a href="#">{{ $payment->transaction_number }}</a>
                                                </td>
                                                {{-- <td>{{ $payment->transaction_number }}</td> --}}
                                                <td>{{ $payment->tenant_id }}</td>
                                                <td>{{ $payment->amount }}</td>
                                                <td>{{ $payment->payment_date }}</td>
                                                <td>{{ $payment->payment_method }}</td>
                                                <td>{{ $payment->status }}</td>
                                                <td>{{ $payment->remark }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11">No bills found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                </section>
                <!-- /.content -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
    </div>
    <!-- /.content-wrapper. Contains page content -->

@endsection
