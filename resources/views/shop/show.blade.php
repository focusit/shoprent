<!-- resources/views/shops/show.blade.php -->

@extends('masterlist')

@section('title', 'Shop Details')

@section('body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!-- /.card-header -->
        <div class="card-body ">
            <table class="table sm-table-bordered">
                <tr>
                    <th class="text-center table-success" colspan="2">Shop Details</th>
                </tr>
                <tr>
                    <!-- Display the image if available -->
                    @if ($shop->image)
                <tr>
                    <td class="text-center" colspan="2">
                        <figure>
                            <img src="{{ asset('images/' . $shop->image) }}" alt="Shop Image" style="max-width: 100%;">
                        </figure>
                    </td>
                </tr>
                @endif
                </tr>
                <tr>
                    <th>Shop ID</th>
                    <td>{{ $shop->shop_id }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $shop->address }}</td>
                </tr>
                <tr>
                    <th>Latitude</th>
                    <td>{{ $shop->latitude }}</td>
                </tr>
                <tr>
                    <th>Longitude</th>
                    <td>{{ $shop->longitude }}</td>
                </tr>
                <tr>
                    <th>Pincode</th>
                    <td>{{ $shop->pincode }}</td>
                </tr>
                <tr>
                    <th>Rent</th>
                    <td>{{ $shop->rent }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $shop->status }}</td>
                </tr>
                {{-- <tr>
                    <th>Tenant ID</th>
                    <td>{{ $shop->tenant_id }}</td>
                </tr> --}}
            </table>

            <!-- Display the map based on latitude and longitude -->
            <div class="card">
                <!-- Display the map based on latitude and longitude using iframe (without API key) -->
                <div class="card-wrapper">
                    @if ($shop->latitude && $shop->longitude)
                        <iframe width="100%" height="500" frameborder="0" style="border:0"
                            src="https://www.google.com/maps/?q={{ $shop->latitude }},{{ $shop->longitude }}&t=h&z=18&output=embed"
                            allowfullscreen>
                        </iframe>
                    @endif
                </div>

                <!-- /.card-body -->
                <div class="text-center m-3">
                    <a href="{{ route('shops.index') }}" class="btn btn-primary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
@endsection
