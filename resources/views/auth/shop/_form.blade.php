<form action="{{ $action }}" method="POST">
    @csrf

    @if(isset($method))
        @method($method)
    @endif

    <label for="shop_id">Shop ID:</label>
    <input type="text" name="shop_id" value="{{ old('shop_id', $shop->shop_id ?? '') }}" required>

    <label for="address">Address:</label>
    <input type="text" name="address" value="{{ old('address', $shop->address ?? '') }}" required>

    <label for="location">Location:</label>
    <input type="text" name="location" value="{{ old('location', $shop->location ?? '') }}" required>

    <label for="pincode">Pincode:</label>
    <input type="text" name="pincode" value="{{ old('pincode', $shop->pincode ?? '') }}" required>

    <label for="rent">Rent:</label>
    <input type="text" name="rent" value="{{ old('rent', $shop->rent ?? '') }}" required>

    <label for="status">Status:</label>
    <select name="status" required>
        <option value="available" {{ (old('status', $shop->status ?? '') == 'available') ? 'selected' : '' }}>Available</option>
        <option value="occupied" {{ (old('status', $shop->status ?? '') == 'occupied') ? 'selected' : '' }}>Occupied</option>
    </select>

    <label for="tenant_id">Tenant ID:</label>
    <input type="text" name="tenant_id" value="{{ old('tenant_id', $shop->tenant_id ?? '') }}">

    <!-- Add other fields here -->

    <button type="submit">Submit</button>
</form>
