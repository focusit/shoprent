<!-- resources/views/agreements/show.blade.php -->

@extends('masterlist')

@section('title', 'Agreement Details')

@section('body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!-- /.card-header -->
        <div class="card-body ">
            <table class="table sm-table-bordered">
                <tr>
                    <th class="text-center table-success" colspan="2">Agreement Details</th>
                </tr>
                <tr>
                    <!-- Display the image if available -->
                    @if ($agreement->image)
                <tr>
                    <td class="text-center" colspan="2">
                        <figure>
                            <img src="{{ asset('images/' . $agreement->image) }}" alt="agreement Image"
                                style="max-width: 100%;">
                        </figure>
                    </td>
                </tr>
                @endif
                </tr>
                <tr>
                    <th>agreement ID</th>
                    <td>{{ $agreement->agreement_id }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $agreement->address }}</td>
                </tr>
                <tr>
                    <th>Latitude</th>
                    <td>{{ $agreement->latitude }}</td>
                </tr>
                <tr>
                    <th>Longitude</th>
                    <td>{{ $agreement->longitude }}</td>
                </tr>
                <tr>
                    <th>Pincode</th>
                    <td>{{ $agreement->pincode }}</td>
                </tr>
                <tr>
                    <th>Rent</th>
                    <td>{{ $agreement->rent }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $agreement->status }}</td>
                </tr>
                {{-- <tr>
                    <th>Tenant ID</th>
                    <td>{{ $agreement->tenant_id }}</td>
                </tr> --}}
            </table>
            <div class=" text-center mt-3">
                <a href="{{ route('agreements.index') }}" class="btn btn-primary">Back to List</a>
            </div>
        @endsection
