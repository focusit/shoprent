@extends('masterindex')

@section('title', 'shop_list')

@section('body')
<!-- Content Wrapper. Contains page content -->
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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Recently shop list</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Shop ID</th>
                                                <th>Address</th>
                                                <th>Location</th>
                                                <th>Pincode</th>
                                                <th>Rent</th>
                                                <th>status</th>
                                                <th>Tenant ID</th>
                                            </tr>
                                        </thead>
                                            <tbody>
                                                @foreach($shops as $shop)
                                                    <tr>
                                                        <td>{{ $shop->shop_id }}</td>
                                                        <td>{{ $shop->address }}</td>
                                                        <td>{{ $shop->location }}</td>
                                                        <td>{{ $shop->pincode }}</td>
                                                        <td>{{ $shop->rent }}</td>
                                                        <td>{{ $shop->status }}</td>
                                                        <td>{{ $shop->tenant_id }}</td>
                                                    </tr>
                                                @endforeach
                                        </tbody>
                                        <tfoot>
                                            
                                        </tfoot>
                                    </table>
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