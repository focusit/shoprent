<style>
            .astrikes{
                color:red;
            }
            </style>
        <div class="card card-default"><!-- .card-body -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tenant ID <span class="astrikes">*</span></label>
                            <input type="text" name="tenant_id" id="tenant_id" class="form-control"
                                value="{{ old('tenant_id', $tenant->tenant_id ?? '') }}" oninput="checkTenantId()">
                            <span id="tenantIdStatus"></span>
                        </div>
                    </div> <!-- /.form-group -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Full Name <span class="astrikes">*</span></label>
                            <input type="text" name="full_name" id="full_name" class="form-control"
                                value="{{ old('full_name', $tenant->full_name ?? '') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Govt ID</label>
                            <select class="form-control select2" id="govt_id" style="width: 100%;">
                                <option value="" selected disabled>Select</option>
                                <option value="AADHAR Card" {{ isset($tenant) ? $tenant->govt_id : '' }}>
                                    AADHAR Card
                                </option>
                                <option value="PAN Card" {{ isset($tenant)  ? $tenant->govt_id : '' }}>
                                    PAN Card
                                </option>
                                <option value="Driving License" {{ isset($tenant)  ? $tenant->govt_id : '' }}>
                                    Driving License
                                </option>
                                <option value="Passport" {{ isset($tenant)  ? $tenant->govt_id : '' }}>
                                    Passport
                                </option>
                                <option value="Other" {{ isset($tenant)  ? $tenant->govt_id : '' }}>
                                    Other
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Govt ID Number</label>
                            <input type="text" name="govt_id_number" id="govt_id_number" class="form-control"
                                value="{{ old('govt_id_number', $tenant->govt_id_number ?? '') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" id="address" class="form-control"
                                value="{{ old('address', $tenant->address ?? '') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Contact</label>
                            <input type="text" name="contact" id="contact" class="form-control"
                                value="{{ old('contact', $tenant->contact ?? '') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pincode</label>
                            <input type="number" name="pincode" id="pincode" class="form-control"
                                value="{{ old('pincode', $tenant->pincode ?? '') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                             <label>Gender<!--<span class="astrikes">*</span>--></label> 
                            <select class="form-control select2" name="gender" id="gender" style="width: 100%;">
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" id="email" class="form-control"
                                value="{{ old('email', $tenant->email ?? '') }}">
                        </div> 
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control"
                                value="{{ old('password', $tenant->password ?? '') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>GST no</label>
                            <input type="text" name="gst_number" id="gst_number" class="form-control"
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
                </div>
                <div class="card-footer">
                <?php if(isset($tenant)){ ?>
                    <button type="button" id="button" class="btn btn-warning" data-toggle="modal" data-target="#alertModel">Update</button>
                <?php }else{ ?>
                    <button type="button" id="button" class="btn btn-success" data-toggle="modal" data-target="#alertModel">Create Tenant</button>
                <?php }?>
                    <button type="submit" id="save" class="btn btn-success" hidden>Submit</button>
                </div>
            </div>
        </div>
        <!-- Modal -->
    <div class="modal fade" id="alertModel" role="dialog">
        <div class="modal-dialog">
                                        
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                    <h4 class="modal-title">Are you sure you want to {{ isset($tenant) ? 'Update ' : 'Create ' }} </h4>
                </div>
                <div class="modal-body row">
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <span>Tenant ID</span><br>
                        <span>Full Name</span><br>
                        <span>Govt Id</span><br>
                        <span>Govt Id Number</span><br>
                        <span>Contact</span><br>
                        <span>Gender</span><br>
                        <span>Email</span><br>
                        <span>GST No</span><br>
                     </div>
                    <div class="col-md-6">
                        <span id="data1"></span><br>
                        <span id="data2"></span><br>
                        <span id="data3"></span><br>
                        <span id="data4"></span><br>
                        <span id="data5"></span><br>
                        <span id="data6"></span><br>
                        <span id="data7"></span><br>
                        <span id="data8"></span><br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="submit" value="submit">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>                    
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#button').click(function(){
                document.getElementById("data1").innerText = $('#tenant_id').val();
                document.getElementById("data2").innerText = $('#full_name').val();
                document.getElementById("data3").innerText = $('#govt_id').val();
                document.getElementById("data4").innerText = $('#govt_id_number').val();
                document.getElementById("data5").innerText = $('#contact').val();
                document.getElementById("data6").innerText = $('#gender').val();
                document.getElementById("data7").innerText = $('#email').val();
                document.getElementById("data8").innerText = $('#gst_number').val();
            });
            $('#submit').click(function(){
                $('#save').trigger('click');
            });
        });
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
