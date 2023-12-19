@extends('masterindex')

@section('title', 'shop_edit')

@section('body')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Shop Edit</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-secondary">
                    <!-- ... (existing card content) ... -->
                </div>
                <!-- /.card -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Edit</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <form action="{{ route('shops.update', ['shop' => $shop->shop_id]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Your form fields go here -->
                            <div class="form-group">
                                <label for="shop_id">Shop ID</label>
                                <input type="text" name="shop_id" class="form-control" value="{{ $shop->shop_id }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" name="address" class="form-control" value="{{ $shop->address }}">
                            </div>
                            <!-- Add other fields as needed -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Save Changes</button>
                                <a href="{{ route('shops.index') }}" class="btn btn-secondary">Cancel</a>

                                <!-- Edit Button -->
                                <a href="{{ route('shops.edit', ['shop' => $shop->shop_id]) }}" class="btn btn-info">Edit</a>

                                <!-- Delete Button (You can use a form for delete as well) -->
                                <a href="{{ route('shops.destroy', ['shop' => $shop->shop_id]) }}" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-form').submit();">Delete</a>

                                <!-- Delete Form (hidden) -->
                                <form id="delete-form" action="{{ route('shops.destroy', ['shop' => $shop->shop_id]) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
