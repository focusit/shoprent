@extends('masterlist')

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
                    <div class="col-12 ">
                        <div class="card card-success">
                            <!-- Your card content goes here -->
                            <div class="card-header">
                                <h3 class="card-title">Recently shop list</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Shop ID</th>
                                            <th>Address</th>
                                            <th>Latitude</th>
                                            <th>Longitude</th>
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
                                                <td>{{ $shop->pincode }}</td>
                                                <td>{{ $shop->rent }}</td>
                                                <td>{{ $shop->status }}</td>
                                                <td>{{ $shop->tenant_id }}</td>
                                                <td>
                                                    @if ($shop->image)
                                                        <img src="{{ asset('images/' . $shop->image) }}" alt="Shop Image"
                                                            width="50">
                                                    @else
                                                        No Image
                                                    @endif
                                                </td>
                                                <td class="p-2">
                                                    <a href="{{ route('shops.edit', $shop->shop_id) }}"
                                                        class=".btn.btn-app btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('shops.show', $shop->shop_id) }}"
                                                        class=".btn.btn-app btn-success btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                    <form action="{{ route('shops.destroy', $shop->shop_id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class=".btn.btn-app btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure?')"><i class="fa fa-trash"
                                                                aria-hidden="true"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7">No shops found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
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

<!-- Add this script at the end of your blade file -->
<script>
    $(document).ready(function() {
        $('.show-image').click(function() {
            var imageUrl = $(this).attr('data-image-url');
            $('#largeImageModal img').attr('src', imageUrl);
            $('#largeImageModal').modal('show');
        });
    });
</script>

<!-- Add a modal at the end of your blade file -->
<div class="modal fade" id="largeImageModal" tabindex="-1" role="dialog" aria-labelledby="largeImageModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <img src="" alt="Large Image" id="largeImage" class="img-fluid">
            </div>
        </div>
    </div>
</div>
