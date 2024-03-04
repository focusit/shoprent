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
                            <div class="card-header">Shop Information</div>
                            <div class="card-body">

                                <h4>Your Shops:</h4>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="bg-info">
                                            <th>ID</th>
                                            <th>Shop ID</th>
                                            <th>Address</th>
                                            <th>Latitude</th>
                                            <th>Longitude</th>
                                            <th>Pincode</th>
                                            <th>Rent</th>
                                            <th>Tenant ID</th>
                                            <th>Images</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($shops as $shop)
                                            <tr>
                                                <td>{{ $shop->id }}</td>
                                                <td>{{ $shop->shop_id }}</td>
                                                <td>{{ $shop->address }}</td>
                                                <td>{{ $shop->latitude }}</td>
                                                <td>{{ $shop->longitude }}</td>
                                                <td>{{ $shop->pincode }}</td>
                                                <td>{{ $shop->rent }}</td>
                                                <td>{{ $shop->tenant_id }}</td>
                                                <td>
                                                    @if ($shop->image)
                                                        <img src="{{ asset('images/' . $shop->image) }}" alt="Shop Image"
                                                            width="50">
                                                    @else
                                                        No Image
                                                    @endif
                                                </td>
                                                
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11">No shops found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
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
