@extends('client.clientui')

@section('title', 'Dashboard')

@section('body')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <!-- .container-fluid -->
            <div class="container-fluid">
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <!-- Info boxes -->


                        <div class="card">
                            <div class="card-header">Agreements Information</div>
                            <div class="card-body">

                                <h4>Your Agreements:</h4>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center bg-info">
                                            <th>ID</th>
                                            <th>Agreement ID</th>
                                            <th>Shop ID</th>
                                            <th>Tenant ID</th>
                                            <th>With Effect From</th>
                                            <th>Valid Till</th>
                                            <th>Rent</th>
                                            <th>Status</th>
                                            <th>Remarks</th>
                                            <th>Document</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($agreements as $agreement)
                                            <tr class="text-center">
                                                <td>{{ $agreement->id }}</td>
                                                <td>{{ $agreement->agreement_id }}</td>
                                                <td>{{ $agreement->shop_id }}</td>
                                                <td>{{ $agreement->tenant_id }}</td>
                                                <td>{{ $agreement->with_effect_from }}</td>
                                                <td>{{ $agreement->valid_till }}</td>
                                                <td>{{ $agreement->rent }}</td>
                                                <td>{{ $agreement->status }}</td>
                                                <td>{{ $agreement->remark }}</td>
                                                <td>
                                                    @if ($agreement->document_field)
                                                        @php
                                                            $extension = pathinfo(
                                                                $agreement->document_field,
                                                                PATHINFO_EXTENSION,
                                                            );
                                                        @endphp

                                                        @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                                            <a href="{{ asset('documents/' . $agreement->document_field) }}"
                                                                target="_blank">
                                                                <img src="{{ asset('documents/' . $agreement->document_field) }}"
                                                                    alt="Agreement Image" width="50">
                                                            </a>
                                                        @elseif (strtolower($extension) === 'pdf')
                                                            <a href="{{ asset('documents/' . $agreement->document_field) }}"
                                                                target="_blank">
                                                                View PDF
                                                            </a>
                                                        @else
                                                            No Data
                                                        @endif
                                                    @else
                                                        No Data
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11">No agreements found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                </section>
                <!-- /.content -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
    </div>
    <!-- /.content-wrapper. Contains page content -->

@endsection
