<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Tenant ID</label>
                <input type="text" name="tenant_id" class="form-control"
                    value="{{ old('tenant_id', $tenant->tenant_id ?? '') }}">
            </div>
            <!-- /.form-group -->
            <div class="form-group">
                <label>Govt ID</label>
                <select class="form-control select2" name="govt_id" style="width: 100%;">
                    <option value="" selected disabled>Select</option>
                    <option value="PAN Card" {{ isset($tenant) && $tenant->govt_id === 'occupied' ? 'selected' : '' }}>
                        PAN Card
                    </option>
                    <option value="Driving License"
                        {{ isset($tenant) && $tenant->govt_id === 'vacant' ? 'selected' : '' }}>
                        Driving License
                    </option>
                    <option value="Passport" {{ isset($tenant) && $tenant->govt_id === 'vacant' ? 'selected' : '' }}>
                        Passport
                    </option>
                    <option value="Passport" {{ isset($tenant) && $tenant->govt_id === 'vacant' ? 'selected' : '' }}>
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
                <label>Full Name</label>
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
                <label>Tenant Image</label>
                <input class="form-control form-control-md" type="file" name="image">
                @if (isset($tenant) && $tenant->image)
                    <img src="{{ asset($tenant->image) }}" alt="Tenant Image" class="mt-2" style="max-width: 100%;">
                @endif
            </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
            <label>Pincode</label>
            <input type="number" name="pincode" class="form-control"
                value="{{ old('pincode', $tenant->pincode ?? '') }}">
        </div>
        </div>
        <!-- /.col -->
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
