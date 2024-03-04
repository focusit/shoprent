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
                            <div class="card-header">Bills Information</div>
                            <div class="card-body">

                                <h4>Your Bills:</h4>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="bg-info">
                                            <th>ID</th>
                                            <th>Agreement ID</th>
                                            {{-- <th>Transaction Number</th> --}}
                                            <th>Shop ID</th>
                                            <th>Shop Address</th>
                                            <th>Tenant Name</th>
                                            <th>Month</th>
                                            <th>Year</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Bill Date</th>
                                            <th>Print Bills</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($bills as $bill)
                                            <tr>
                                                <td>{{ $bill->id }}</td>
                                                <td>
                                                    {{ $bill->agreement_id }}
                                                </td>
                                                {{-- <td>{{ $bill->transaction_number }}</td> --}}
                                                <td>{{ $bill->shop_id }}</td>
                                                <td>{{ $bill->shop_address }}</td>
                                                <td>{{ $bill->tenant_full_name }}</td>
                                                <td>{{ $bill->month }}</td>
                                                <td>{{ $bill->year }}</td>
                                                <td>{{ $bill->rent }}</td>
                                                <td>{{ $bill->status }}</td>
                                                <td>{{ $bill->bill_date }}</td>
                                                <td>
                                                    @if ($bill->status !== 'paid')
                                                        <button type="button" class="btn btn-warning btn-sm">
                                                            <a href="{{ route('payments.create', $bill->id) }}">
                                                                Pay Now
                                                            </a>
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-info btn-danger" disabled>
                                                            Paid
                                                        </button>
                                                    @endif
                                                </td>
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
