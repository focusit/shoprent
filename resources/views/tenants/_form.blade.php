        <style>
            .astrikes{
                color:red;
            }
            </style>
        <div class="card card-default">
            <!-- .card-body -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tenant ID <span class="astrikes">*</span></label>
                            <input type="text" name="tenant_id" id="tenant_id" class="form-control"
                                value="{{ old('tenant_id', $tenant->tenant_id ?? '') }}" oninput="checkTenantId()">
                            <span id="tenantIdStatus"></span>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Govt ID</label>
                            <select class="form-control select2" name="govt_id" style="width: 100%;">
                                <option value="" selected disabled>Select</option>
                                <option value="PAN Card"
                                    {{ isset($tenant) && $tenant->govt_id === 'occupied' ? 'selected' : '' }}>
                                    PAN Card
                                </option>
                                <option value="Driving License"
                                    {{ isset($tenant) && $tenant->govt_id === 'vacant' ? 'selected' : '' }}>
                                    Driving License
                                </option>
                                <option value="Passport"
                                    {{ isset($tenant) && $tenant->govt_id === 'vacant' ? 'selected' : '' }}>
                                    Passport
                                </option>
                                <option value="Passport"
                                    {{ isset($tenant) && $tenant->govt_id === 'vacant' ? 'selected' : '' }}>
                                    Other
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control"
                                value="{{ old('address', $tenant->address ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control"
                                value="{{ old('email', $tenant->email ?? '') }}">
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Full Name <span class="astrikes">*</span></label>
                            <input type="text" name="full_name" class="form-control"
                                value="{{ old('full_name', $tenant->full_name ?? '') }}">
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Govt ID Number</label>
                            <input type="text" name="govt_id_number" class="form-control"
                                value="{{ old('govt_id_number', $tenant->govt_id_number ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label>Contact</label>
                            <input type="text" name="contact" class="form-control"
                                value="{{ old('contact', $tenant->contact ?? '') }}">
                        </div>
                        
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control"
                                value="{{ old('password', $tenant->password ?? '') }}">
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->

                    <!-- Tenant Image Section -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>GST no</label>
                            <input type="text" name="gst_number" class="form-control"
                                value="{{ old('gst_number', $tenant->gst_number ?? '') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tenant Image </label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="image"placeholder="image">
                                    <label class="custom-file-label">{{ isset($tenant) ? $tenant->image : 'Choose file ' }}</label>
                                    {{-- @if (isset($shop) && $shop->image)
                                        <img src="{{ asset($shop->image) }}" alt="Shop Image">
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pincode</label>
                            <input type="number" name="pincode" class="form-control"
                                value="{{ old('pincode', $tenant->pincode ?? '') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Gender<span class="astrikes">*</span></label>
                            <select class="form-control select2" name="gender" style="width: 100%;">
                                <option value="" selected disabled>Select</option>
                                <option value="male"
                                    {{ isset($tenant) && $tenant->gender === '' ? 'selected' : '' }}>
                                    Male
                                </option>
                                <option value="female"
                                    {{ isset($tenant) && $tenant->gender === '' ? 'selected' : '' }}>
                                    Female
                                </option>
                                <option value="other"
                                    {{ isset($tenant) && $tenant->gender === '' ? 'selected' : '' }}>
                                    Other
                                </option>
                            </select>
                            {{-- <input type="text" name="gender" class="form-control"
                                value="{{ old('gender', $tenant->gender ?? '') }}"> --}}
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        </section>
          </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
            <script>
                  
                  document.addEventListener('DOMContentLoaded', function() {
                        var fileInput = document.querySelector('.custom-file-input');
                        var label = document.querySelector('.custom-file-label');

                        fileInput.addEventListener('change', function() {
                            var fileName = this.files[0].name;

                            label.innerHTML = fileName;
                        });
                    });
                function checkTenantId() {
                    var tenantId = document.getElementById('tenant_id').value;
                    var tenantIdStatus = document.getElementById('tenantIdStatus');

                    if (tenantId.trim() === '') {
                        tenantIdStatus.innerHTML = '<span style="color: red;">Please enter a Tenant ID</span>';
                        return;
                    } 
                    console.log('Checking Tenant ID:', tenantId);

                    // Perform an AJAX request to check the Tenant ID
                    fetch('/checkTenantId', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token
                            },
                            body: JSON.stringify({
                                tenant_id: tenantId
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            // console.log('Response Data:', data);

                            tenantIdStatus.innerHTML = data.exists ?
                                '<span style="color: red;">Tenant ID already exists!</span>' :
                                '<span style="color: green;">Tenant ID is available!</span>';
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    document.getElementById('tenant_id').addEventListener('input', checkTenantId);

                }
              
            </script>
