@extends('masterindex')

@section('content')
    <h1>Shop Details</h1>

    <p>ID: {{ $shop->shop_id }}</p>
    <p>Address: {{ $shop->address }}</p>
    <p>Location: {{ $shop->location }}</p>
    <p>Pincode: {{ $shop->pincode }}</p>
    <p>Rent: {{ $shop->rent }}</p>
    <p>Status: {{ $shop->status }}</p>
    <p>Tenant ID: {{ $shop->tenant_id }}</p>

    <a href="{{ route('shops.edit', $shop->id) }}">Edit</a>
    <form action="{{ route('shops.destroy', $shop->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
    <a href="{{ route('shops.index') }}">Back to Shop List</a>
@endsection
