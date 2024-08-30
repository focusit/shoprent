<!-- SELECT2 EXAMPLE -->
<style>
    .astrikes{
        color:red;
    }
    </style>

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
                            <label>Shop ID <span class="astrikes"><span class="astrikes">*</span></span></label>
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
                            <label>Address</label>
                            <input type="text" class="form-control" id="address" name="address"
                            value="{{ isset($shop) ? $shop->address : '' }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pincode</label>
                            <input type="number" class="form-control" id="pincode" name="pincode" minlength="6" maxlength="6"
                            value="{{ isset($shop) ? $shop->pincode : '' }}">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <!-- Add other input fields as needed -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Construction Year</label>
                            <input type="year" class="form-control" name="construction_year"
                            value="{{ isset($shop) ? $shop->construction_year : '' }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Property Owner Name</label>
                            <input type="text" class="form-control" name="owner name" 
                            value="{{ isset($shop) ? $shop->owner_name : '' }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Add other input fields as needed -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Rent <span class="astrikes">*</span></label>
                            <input type="text" class="form-control" name="rent" id="rent"
                            value="{{ isset($shop) ? $shop->rent : '' }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status <span class="astrikes">*</span></label>
                            <select class="form-control" name="status" id="status" required>
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
                </div>
                
                <div class="card-footer">
                    <button type="button" class="btn btn-success" id="button" data-toggle="modal" data-target="#alertModel">
                        {{ isset($shop) ? 'Update Shop' : 'Create Shop' }}
                    </button>
                    <button type="submit" id="save" class="btn btn-success" hidden></button>
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
</section>
</div>
</div>
<!-- /.card -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->
</div>
<!-- Modal -->
<div class="modal fade" id="alertModel" role="dialog">
    <div class="modal-dialog">
  
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                <h4 class="modal-title">Are you sure you want to {{ isset($shop) ? 'Update ' : 'Create ' }} </h4>
            </div>
            <div class="modal-body row">
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <span>Shop ID</span><br>
                    <span>Address</span><br>
                    <span>Pincode</span><br>
                    <span>Rent</span><br>
                    <span>Status</span><br>
                </div>
                <div class="col-md-6">
                    <span id="data1"></span><br>
                    <span id="data2"></span><br>
                    <span id="data3"></span><br>
                    <span id="data4"></span><br>
                    <span id="data5"></span><br>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="submit" value="submit">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
</section>
<script>
    $(document).ready(function() {
        $('#button').click(function(){
            document.getElementById("data1").innerText = $('#shop_id').val();
            document.getElementById("data2").innerText = $('#address').val();
            document.getElementById("data3").innerText = $('#pincode').val();
            document.getElementById("data4").innerText = $('#rent').val();
            document.getElementById("data5").innerText = $('#status').val();
        });
        $('#submit').click(function(){
            $('#save').trigger('click');
        });
    });
    
    
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
