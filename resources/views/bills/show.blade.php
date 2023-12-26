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
                            <!-- Your card content goes here -->
                            <div class="card-header">
                                <h3 class="card-title">Recently Generated Bills</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- Add the Generate Bill form here -->
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Agreement ID</th>
                                            <th>Rent</th>
                                            <th>Payment Date</th>
                                            <th>Due Date</th>
                                            <th>Status</th>
                                            <th>Penalty</th>
                                            <th>Discount</th>
                                            {{-- <th>Regenerate</th> --}}
                                            <th>Print Bills</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $bill->id }}</td>
                                            <td> <a
                                                    href="{{ route('agreements.show', $bill->agreement_id) }}">{{ $bill->agreement_id }}</a>
                                            </td>
                                            <td>{{ $bill->rent }}</td>
                                            <td>{{ $bill->payment_date }}</td>
                                            <td>{{ $bill->due_date }}</td>
                                            <td>{{ $bill->status }}</td>
                                            <td>{{ $bill->penalty }}</td>
                                            <td>{{ $bill->discount }}</td>
                                            {{-- <td>
                                                <form action="{{ route('bills.regenerate', $bill->agreement_id) }}"
                                                    method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning">Regenerate</button>
                                                </form>
                                            </td> --}}
                                            <td>
                                                <a href="{{ route('bills.print', $bill->agreement_id) }}" target="_blank"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-print"></i> Print Bill
                                                </a>
                                            </td>
                                        </tr>

                                </table>
                                <div class=" text-center mt-3">
                                    <a href="{{ route('bills.index') }}" class="btn btn-primary">Back to List</a>
                                </div>
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
@endsection
