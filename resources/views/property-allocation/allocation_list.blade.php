<!-- resources/views/allocation_list.blade.php -->

@extends('masterlist')
@section('title', 'Allocation List')
@section('body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>shop list</h1>
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
                                <h3 class="card-title">Allocation list</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @if ($allocations->isEmpty())
                                    <p>No shops allocated yet.</p>
                                @else
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Shop ID</th>
                                                <th>Shop Location</th>
                                                <th>Tenant ID</th>
                                                <th>Tenant Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($allocations as $allocation)
                                                <tr>
                                                    <td>{{ $allocation->shop_id }}</td>
                                                    <td>{{ $allocation->address }}</td>
                                                    <td>{{ $allocation->tenant_id }}</td>
                                                    <td>{{ $allocation->tenant->full_name }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    {{ session('success') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
