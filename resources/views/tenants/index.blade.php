@extends('masterlist')

@section('title', 'tenant_list')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col">
                        <h1>Tenants list</h1>
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
                                <h3 class="card-title">Recently Tenant list</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="height:500px;overflow: scroll;">
                                <table id="" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="bg-info">
                                            <th>Tenants ID</th>
                                            <th>Govt ID</th>
                                            <th>ID Number</th>
                                            <th>Full Name</th>
                                            <th>Contact</th>
                                            <th>Address</th>
                                            <th>Email</th>
                                            <th>Image</th>
                                            <th>GST No</th>
                                            <th>Gender</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tenants as $tenant)
                                        @forelse($agreements as $agreement)
                                            @if ($tenant->tenant_id === $agreement->tenant_id)
                                            @if ($agreement->status == 'active')
                                            <tr>
                                                <td>{{ $tenant->tenant_id }}</td>
                                                <td>{{ $tenant->govt_id }}</td>
                                                <td>{{ $tenant->govt_id_number }}</td>
                                                <td>{{ $tenant->full_name }}</td>
                                                <td>{{ $tenant->contact }}</td>
                                                <td>{{ $tenant->address }}</td>
                                                <td>{{ $tenant->email }}</td>
                                                  <td>
                                                    @method('UPDATE')
                                                    @if ($tenant->image)
                                                        <img src="{{ asset('tenant-images/' . $tenant->image) }}"
                                                            alt="Shop Image" width="50">
                                                    @else
                                                        No Image
                                                    @endif
                                                </td>
                                                <td>{{ $tenant->gst_number}}</td>
                                                <td>{{ $tenant->gender }}</td>
                                              
                                                <td class="p-2">
                                                    <a title="Edit Tenant Details" href="{{ route('tenants.edit', $tenant->tenant_id) }}"
                                                        class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                    <a title="Show Tenant Details" href="{{ route('tenants.show', $tenant->tenant_id) }}"
                                                        class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                    <!--<form title="Delete Tenant" action="{{ route('tenants.destroy', $tenant->tenant_id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Are you sure?')"><i class="fa fa-trash"
                                                                aria-hidden="true"></i>
                                                        </button>
                                                    </form>-->
                                                </td>
                                            </tr>
                                            @endif
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="7">No Active tenants found. </td>
                                            </tr>
                                        @endforelse
                                        @empty
                                            <tr>
                                                <td colspan="7">No tenants found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div><!-- /.card-body -->
                        </div><!-- /.card -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection
