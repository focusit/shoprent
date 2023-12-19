@extends('masterindex')

@section('content')
    <h1 class="text-center">Shop List</h1>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Address</th>
                <th>Location</th>
                <th>Pincode</th>
                <th>Rent</th>
                <th>Status</th>
                <th>Tenant ID</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shops as $shop)
                <tr>
                    <td>{{ $shop->shop_id }}</td>
                    <td>{{ $shop->address }}</td>
                    <td>{{ $shop->location }}</td>
                    <td>{{ $shop->pincode }}</td>
                    <td>{{ $shop->rent }}</td>
                    <td>{{ $shop->status }}</td>
                    <td>{{ $shop->tenant_id }}</td>
                    <td>
                        <a href="{{ route('shops.show', $shop->id) }}">Show</a>
                        <a href="{{ route('shops.edit', $shop->id) }}">Edit</a>
                        <form action="{{ route('shops.destroy', $shop->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('shops.create') }}">Add a Shop</a>
@endsection
