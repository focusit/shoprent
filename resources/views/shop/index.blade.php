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
                                    <div class="tab-pane active" id="allShops" style="height:500px;overflow: auto;">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="bg-info">
                                                    <th>ID</th>
                                                    <th>Shop ID</th>
                                                    <th>Address</th>
                                                    <th>Latitude</th>
                                                    <th>Longitude</th>
                                                    <th>Construction year</th>
                                                    <th>Pincode</th>
                                                    <th>Rent</th>
                                                    <th>Status</th>
                                                    {{-- <th>Tenant ID</th> --}}
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
                                                        <td>{{ $shop->construction_year}}</td>
                                                        <td>{{ $shop->pincode }}</td>
                                                        <td>{{ $shop->rent }}</td>
                                                        <td>{{ $shop->status }}</td>
                                                        {{-- <td>{{ $shop->tenant_id }}</td> --}}
                                                        
                                                        <td>
                                                            @if ($shop->image)
                                                                <img src="{{ asset('images/' . $shop->image) }}"
                                                                    alt="Shop Image" width="50">
                                                            @else
                                                                No Image
                                                            @endif
                                                            
                                                        </td>
                                                        <td class="p-2">
                                                            <a title="Edit Shop" href="{{ route('shops.edit', $shop->id) }}"
                                                                class="btn  btn-info btn-sm">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a title="Show Details" href="{{ route('shops.show', $shop->id) }}"
                                                                class="btn  btn-success btn-sm">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                            <form title="Inactive Shop" action="{{ url('/shops/inactive/', $shop->id) }}"
                                                                method="post" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn  btn-danger btn-sm"
                                                                    onclick="return confirm('Are you sure you want to inactivate shop?')">
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
                                    <div class="tab-pane" id="occupiedShops" style="height:500px;overflow: auto;">
                                        <table  class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="bg-info">
                                                    <th>ID</th>
                                                    <th>Shop ID</th>
                                                    <th>Address</th>
                                                    <th>Latitude</th>
                                                    <th>Longitude</th>
                                                    <th>Tenant Name</th>
                                                    <th>Construction year</th>
                                                    <th>Pincode</th>
                                                    <th>Rent</th>
                                                    {{-- <th>Tenant ID</th> --}}
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
                                                            <!-- tenant name from shop_id -->
                                                            @forelse($agreements as $agreement)
                                                                @if($agreement->shop_id == $shop->id)
                                                                    @forelse($tenants as $tenant)
                                                                        @if($agreement->status =="active")
                                                                            @if($tenant->tenant_id === $agreement->tenant_id)
                                                                                <td>{{ $tenant->full_name }}</td>
                                                                            @endif
                                                                        @endif
                                                                    @empty
                                                                        <td> </td>
                                                                    @endforelse
                                                                @endif
                                                            @empty
                                                                <td> </td>
                                                            @endforelse
                                                            <td>{{ $shop->construction_year}}</td>
                                                            <td>{{ $shop->pincode }}</td>
                                                            <td>{{ $shop->rent }}</td>
                                                            {{-- <td>{{ $shop->tenant_id }}</td> --}}
                                                            <td>
                                                                @if ($shop->image)
                                                                    <img src="{{ asset('images/' . $shop->image) }}"
                                                                        alt="Shop Image" width="50">
                                                                @else
                                                                    No Image
                                                                @endif
                                                            </td>
                                                            <td class="p-2">
                                                                <a title=" Edit Shop" href="{{ route('shops.edit', $shop->id) }}"
                                                                    class="btn  btn-info btn-sm">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <a title="Show Details" href="{{ route('shops.show', $shop->id) }}"
                                                                    class="btn  btn-success btn-sm">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                                <form title="Inactive Shop" action="{{ url('/shops/inactive/', $shop->id) }}"
                                                                    method="post" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="btn  btn-danger btn-sm"
                                                                        onclick="return confirm('Are you sure you want to inactivate shop?')">
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
                                    <div class="tab-pane" id="vacantShops" style="height:500px;overflow:auto;">
                                        <table id="vacantShopsTable" class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="bg-info">
                                                    <th>ID</th>
                                                    <th>Shop ID</th>
                                                    <th>Address</th>
                                                    <th>Latitude</th>
                                                    <th>Longitude</th>
                                                    <th>Construction Year</th>
                                                    <th>Pincode</th>
                                                    <th>Rent</th>
                                                    {{-- <th>Tenant ID</th> --}}
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
                                                            <td>{{ $shop->construction_year}}</td>
                                                            <td>{{ $shop->pincode }}</td>
                                                            <td>{{ $shop->rent }}</td>
                                                            {{-- <td>{{ $shop->tenant_id }}</td> --}}
                                                            <td>
                                                                @if ($shop->image)
                                                                    <img src="{{ asset('images/' . $shop->image) }}"
                                                                        alt="Shop Image" width="50">
                                                                @else
                                                                    No Image
                                                                @endif
                                                            </td>
                                                            <td class="p-2">
                                                                <a title="Edit Shop" href="{{ route('shops.edit', $shop->id) }}"
                                                                    class="btn  btn-info btn-sm">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <a title="Show Details" href="{{ route('shops.show', $shop->id) }}"
                                                                    class="btn  btn-success btn-sm">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                                <form title="Inactivate Shop" action="{{ url('/shops/inactive/', $shop->id) }}"
                                                                    method="post" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="btn  btn-danger btn-sm"
                                                                        onclick="return confirm('Are you sure you want to inactivate shop?')">
                                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                                    </button>
                                                                </form>
                                                                <a title="Allocate Shop" href="{{ route('shop.index', $shop->id) }}"
                                                                    class="btn  btn-primary btn-sm">
                                                                    <i class="fa fa-file" aria-hidden="true"></i>
                                                                </a>
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
