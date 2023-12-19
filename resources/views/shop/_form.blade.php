<section class="content">
    <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
            <!-- .card-body -->
            <div class="card-body">
                <form action="{{ isset($shop) ? route('shops.update', $shop->id) : route('shops.create') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($shop))
                        @method('PUT')
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Shop ID</label>
                                <input type="text" class="form-control" name="shop_id"
                                    value="{{ isset($shop) ? $shop->shop_id : '' }}">
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Shop Image</label>
                                <input class="form-control form-control-md" type="file" name="image">
                                @if (isset($shop) && $shop->image)
                                    <img src="{{ asset($shop->image) }}" alt="Shop Image">
                                @endif
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Latitude</label>
                                <input type="text" class="form-control" name="latitude"
                                    value="{{ isset($shop) ? $shop->latitude : '' }}">
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Longitude</label>
                                <input type="text" class="form-control" name="longitude"
                                    value="{{ isset($shop) ? $shop->longitude : '' }}">
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pincode</label>
                                <input type="number" class="form-control" name="pincode" minlength="6" maxlength="6"
                                    value="{{ isset($shop) ? $shop->pincode : '' }}">
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Rent</label>
                                <input type="text" class="form-control" name="rent"
                                    value="{{ isset($shop) ? $shop->rent : '' }}">
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status" required>
                                    <option value="" selected disabled>Select</option>
                                    <option value="occupied"
                                        {{ isset($shop) && $shop->status === 'occupied' ? 'selected' : '' }}>Occupied
                                    </option>
                                    <option value="vaccant"
                                        {{ isset($shop) && $shop->status === 'vaccant' ? 'selected' : '' }}>Vaccant
                                    </option>
                                </select>
                            </div>
                        </div>
                        <!-- /.col -->
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label>Tenant ID</label>
                                <input type="text" class="form-control" name="tenant_id"
                                    value="{{ isset($shop) ? $shop->tenant_id : '' }}">
                            </div>
                        </div> --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" name="address"
                                    value="{{ isset($shop) ? $shop->address : '' }}">
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">
                            {{ isset($shop) ? 'Update Shop' : 'Create Shop' }}
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        // Check if there's a success message in the session
        @if (session('success'))
            // Show the AdminLTE toast
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Success',
                body: '{{ session('success') }}',
                icon: 'fas fa-check'
            });
        @endif
    });
</script>
