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
                <tr><!-- Display the image if available -->
                @if ($tenant->image)
                    <tr>
                        <td class="text-center" colspan="2">
                            <figure>
                                <img src="{{ asset('tenant-images/' . $tenant->image) }}" alt="Shop Image"
                                    style="max-width: 100%;">
                            </figure>
                        </td>
                    </tr>
                @endif
                </tr>
                <tr>
                    <th>Government Id</th>
                    <td>{{ $tenant->govt_id }}</td>
                </tr>
                <tr>
                    <th>Id Number</th>
                    <td>{{ $tenant->govt_id_number }}</td>
                </tr>
                <tr>
                    <th>Full Name</th>
                    <td>{{ $tenant->full_name }}</td>
                </tr>
                <tr>
                    <th>Pincode</th>
                    <td>{{ $tenant->pincode }}</td>
                </tr>
                <tr>
                    <th>Contact</th>
                    <td>{{ $tenant->contact }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $tenant->address }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $tenant->email }}</td>
                </tr>
                <tr>
                    <th>GST No</th>
                    <td>{{ $tenant->gst_number }}</td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>{{ $tenant->gender }}</td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td>{{ $tenant->image }}</td>
                </tr>
            </table>
        </div>
        <!-- /.card-body -->

        <div class="text-center m-3">
            <a href="{{ route('tenants.index') }}" class="btn btn-primary">Back to List</a>
        </div>
    </div>
@endsection
