@extends('masterlist')

@section('title', 'Bills')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Bills List</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 ">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Recently Generated Bills</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="bg-info">
                                            <th>ID</th>
                                            <th>Agreement ID</th>
                                            <th>Shop ID</th>
                                            <th>Shop Address</th>
                                            <th>Tenant ID</th>
                                            <th>Tenant Name</th>
                                            <th>Rent</th>
                                            <th>Status</th>
                                            <th>Bill Date</th>
                                            <th>Action</th>
                                            <th>Print Bills</th>
                                            <th>Pay Now</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($bills as $bill)
                                            <tr>
                                                <td>{{ $bill->id }}</td>
                                                <td>
                                                    <a href="{{ route('agreements.show', $bill->agreement_id) }}">
                                                        {{ $bill->agreement_id }}
                                                    </a>
                                                </td>
                                                <td>{{ $bill->shop_id }}</td>
                                                <td>{{ $bill->shop_address }}</td>
                                                <td>{{ $bill->tenant_id }}</td>
                                                <td>{{ $bill->tenant_full_name }}</td>
                                                <td>{{ $bill->rent }}</td>
                                                <td>{{ $bill->status }}</td>
                                                <td>{{ $bill->bill_date }}</td>
                                                <td>
                                                    <form action="{{ route('bills.regenerate', $bill->agreement_id) }}"
                                                        method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-warning">Regenerate</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a href="{{ route('bills.print', $bill->agreement_id) }}"
                                                        target="_blank" class="btn btn-info btn-sm">
                                                        <i class="fas fa-print"></i> Print Bill
                                                    </a>
                                                </td>
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
                                <form action="{{ route('bills.generate') }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Generate Bills</button>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script></script>
@endsection
