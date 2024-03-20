<!-- SELECT2 EXAMPLE -->
<div class="card card-default">
    <!-- .card-body -->
    <div class="card-body">
        <form action="{{ isset($shop) ? route('shops.update', $shop->id) : route('shops.create') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @if (isset($shop))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Shop ID</label>
                        <input type="text" class="form-control" name="shop_id" id="shop_id"
                            value="{{ isset($shop) ? $shop->shop_id : '' }}" oninput="checkShopId()">
                        <span id="shopIdStatus"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Shop Image</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image"placeholder="image">
                                <label class="custom-file-label">{{ isset($shop) ? $shop->image : 'Choose file ' }}</label>
                                {{-- @if (isset($shop) && $shop->image)
                                    <img src="{{ asset($shop->image) }}" alt="Shop Image">
                                @endif --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Latitude</label>
                        <input type="text" class="form-control" name="latitude"
                            value="{{ isset($shop) ? $shop->latitude : '' }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Longitude</label>
                        <input type="text" class="form-control" name="longitude"
                            value="{{ isset($shop) ? $shop->longitude : '' }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Add other input fields as needed -->

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Pincode</label>
                        <input type="number" class="form-control" name="pincode" minlength="6" maxlength="6"
                            value="{{ isset($shop) ? $shop->pincode : '' }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Rent</label>
                        <input type="text" class="form-control" name="rent"
                            value="{{ isset($shop) ? $shop->rent : '' }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Add other input fields as needed -->

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status" required>
                            <option value="" selected disabled>Select</option>
                            <option value="occupied"
                                {{ isset($shop) && $shop->status === 'occupied' ? 'selected' : '' }}>Occupied
                            </option>
                            <option value="vacant" {{ isset($shop) && $shop->status === 'vacant' ? 'selected' : '' }}>
                                Vacant
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address"
                            value="{{ isset($shop) ? $shop->address : '' }}">
                    </div>
                </div>
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
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var fileInput = document.querySelector('.custom-file-input');
        var label = document.querySelector('.custom-file-label');

        fileInput.addEventListener('change', function() {
            // Get the selected file name
            var fileName = this.files[0].name;

            // Update the custom file label with the selected file name
            label.innerHTML = fileName;
        });
    });
    // Check Shop ID
    document.addEventListener('DOMContentLoaded', function() {
        var fileInput = document.querySelector('.custom-file-input');
        var label = document.querySelector('.custom-file-label');

        fileInput.addEventListener('change', function() {
            var fileName = this.files[0].name;

            label.innerHTML = fileName;
        });
    });
    function checkShopId() {
        var shopId = document.getElementById('shop_id').value;
        var shopIdStatus = document.getElementById('shopIdStatus');
        if (shopId.trim() === '') {
            shopIdStatus.innerHTML = '<span style="color: red;">Please enter a Shop ID</span>';
            return;
        }
        console.log('Checking Shop ID:', shopId);

        // Perform an AJAX request to check the shop ID
        // Example using fetch API
        fetch('/checkShopId', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token
                },
                body: JSON.stringify({
                    shop_id: shopId
                }),
            })
            .then(response => response.json())
            .then(data => {
                // console.log('Response Data:', data);

                shopIdStatus.innerHTML = data.exists ?
                    '<span style="color: red;">Shop ID already exists!</span>' :
                    '<span style="color: green;">Shop ID is available!</span>';
            })
            .catch(error => {
                console.error('Error:', error);
            });
        document.getElementById('shop_id').addEventListener('input', checkShopId);
    }
</script>
