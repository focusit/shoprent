@extends('masterlist')

@section('title', 'Shop_list')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col">
                        <h1>Shop List</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Shop Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" id="myTabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="allShopsTab" data-toggle="tab" href="#allShops">All
                                            Shops</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="occupiedShopsTab" data-toggle="tab"
                                            href="#occupiedShops">Occupied Shops</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="vacantShopsTab" data-toggle="tab" 
                                           href="#vacantShops">Vacant Shops</a>
                                    </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <!-- All Shops Tab -->
                                    <div class="tab-pane active" id="allShops">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="bg-info">
                                                    <th>ID</th>
                                                    <th>Shop ID</th>
                                                    <th>Address</th>
                                                    <th>Latitude</th>
                                                    <th>Longitude</th>
                                                    <th>owner_name</th>
                                                    <th>construction_year</th>
                                                    <th>Pincode</th>
                                                    <th>Rent</th>
                                                    <th>Status</th>
                                                    <th>Tenant ID</th>
                                                    <th>Images</th>
                                                    <th>Action</th>
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
                                                        <td>{{ $shop->owner_name }}</td>
                                                        <td>{{ $shop->construction_year}}</td>
                                                        <td>{{ $shop->pincode }}</td>
                                                        <td>{{ $shop->rent }}</td>
                                                        <td>{{ $shop->status }}</td>
                                                        <td>{{ $shop->tenant_id }}</td>
                                                        
                                                        <td>
                                                            @if ($shop->image)
                                                                <img src="{{ asset('images/' . $shop->image) }}"
                                                                    alt="Shop Image" width="50">
                                                            @else
                                                                No Image
                                                            @endif
                                                            
                                                        </td>
                                                        <td class="p-2">
                                                            <a href="{{ route('shops.edit', $shop->shop_id) }}"
                                                                class="btn  btn-info btn-sm">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="{{ route('shops.show', $shop->shop_id) }}"
                                                                class="btn  btn-success btn-sm">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                            <form action="{{ route('shops.destroy', $shop->shop_id) }}"
                                                                method="post" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn  btn-danger btn-sm"
                                                                    onclick="return confirm('Are you sure?')">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </button>
                                                            </form>
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

                                    <!-- Occupied Shops Tab -->
                                    <div class="tab-pane" id="occupiedShops">
                                        <table id="occupiedShopsTable" class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="bg-info">
                                                    <th>ID</th>
                                                    <th>Shop ID</th>
                                                    <th>Address</th>
                                                    <th>Latitude</th>
                                                    <th>Longitude</th>
                                                    <th>owner_name</th>
                                                    <th>construction_year</th>
                                                    <th>Pincode</th>
                                                    <th>Rent</th>
                                                    <th>Tenant ID</th>
                                                    <th>Images</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($shops as $shop)
                                                    @if ($shop->status === 'occupied')
                                                        <tr>
                                                            <td>{{ $shop->id }}</td>
                                                            <td>{{ $shop->shop_id }}</td>
                                                            <td>{{ $shop->address }}</td>
                                                            <td>{{ $shop->latitude }}</td>
                                                            <td>{{ $shop->longitude }}</td>
                                                            <td>{{ $shop->owner_name }}</td>
                                                            <td>{{ $shop->construction_year}}</td>
                                                            <td>{{ $shop->pincode }}</td>
                                                            <td>{{ $shop->rent }}</td>
                                                            <td>{{ $shop->tenant_id }}</td>
                                                            <td>
                                                                @if ($shop->image)
                                                                    <img src="{{ asset('images/' . $shop->image) }}"
                                                                        alt="Shop Image" width="50">
                                                                @else
                                                                    No Image
                                                                @endif
                                                            </td>
                                                            <td class="p-2">
                                                                <a href="{{ route('shops.edit', $shop->shop_id) }}"
                                                                    class="btn  btn-info btn-sm">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <a href="{{ route('shops.show', $shop->shop_id) }}"
                                                                    class="btn  btn-success btn-sm">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                                <form action="{{ route('shops.destroy', $shop->shop_id) }}"
                                                                    method="post" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn  btn-danger btn-sm"
                                                                        onclick="return confirm('Are you sure?')">
                                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @empty
                                                    <tr>
                                                        <td colspan="10">No occupied shops found.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Vacant Shops Tab -->
                                    <div class="tab-pane" id="vacantShops">
                                        <table id="vacantShopsTable" class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="bg-info">
                                                    <th>ID</th>
                                                    <th>Shop ID</th>
                                                    <th>Address</th>
                                                    <th>Latitude</th>
                                                    <th>Longitude</th>
                                                    <th>owner_name</th>
                                                    <th>construction_year</th>
                                                    <th>Pincode</th>
                                                    <th>Rent</th>
                                                    <th>Tenant ID</th>
                                                    <th>Images</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($shops as $shop)
                                                    @if ($shop->status === 'vacant')
                                                        <tr>
                                                            <td>{{ $shop->id }}</td>
                                                            <td>{{ $shop->shop_id }}</td>
                                                            <td>{{ $shop->address }}</td>
                                                            <td>{{ $shop->latitude }}</td>
                                                            <td>{{ $shop->longitude }}</td>
                                                            <td>{{ $shop->owner_name }}</td>
                                                            <td>{{ $shop->construction_year}}</td>
                                                            <td>{{ $shop->pincode }}</td>
                                                            <td>{{ $shop->rent }}</td>
                                                            <td>{{ $shop->tenant_id }}</td>
                                                            <td>
                                                                @if ($shop->image)
                                                                    <img src="{{ asset('images/' . $shop->image) }}"
                                                                        alt="Shop Image" width="50">
                                                                @else
                                                                    No Image
                                                                @endif
                                                            </td>
                                                            <td class="p-2">
                                                                <a href="{{ route('shops.edit', $shop->shop_id) }}"
                                                                    class="btn  btn-info btn-sm">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <a href="{{ route('shops.show', $shop->shop_id) }}"
                                                                    class="btn  btn-success btn-sm">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                                <form action="{{ route('shops.destroy', $shop->shop_id) }}"
                                                                    method="post" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn  btn-danger btn-sm"
                                                                        onclick="return confirm('Are you sure?')">
                                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @empty
                                                    <tr>
                                                        <td colspan="10">No vacant shops found.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
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

    <script>
        $(document).ready(function() {
            $('#allShopsTable').DataTable({});

            $('#occupiedShopsTable').DataTable({});

            $('#vacantShopsTable').DataTable({});
        });
    </script>
@endsection
