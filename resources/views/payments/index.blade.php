@extends('masterlist')

@section('title', 'Payments')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Update G8 in Payments</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr class="bg-info">
                            <th>Transaction Date </th>
                            <th>Agreement ID</th>
                            <th>Shop ID</th>
                            <th>Tenant Name</th>
                            <th>Amount </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                            <tr>
                                <td>{{ date('d-m-Y',strtotime($payment->transaction_date)) }}</td>
                                <td>{{ $payment->agreement_id }}</td>
                                <td>{{ $payment->shop_id }}</td>
                                <td>{{ $payment->tenant_name }}</td>
                                <td class="d-flex justify-content-end">{{ -1*$payment->amount }}</td>
                                <td> 
                                    <a href="{{ route('payments.updateG8No', ['id' => $payment->id])}}"
                                        title="Update G8" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No payments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- End of custom content -->
    </div>
@endsection
