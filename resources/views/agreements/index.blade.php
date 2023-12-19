@extends('masterlist')

@section('title', 'Agreement List')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Agreement List</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-success">
                            <!-- Your card content goes here -->
                            <div class="card-header">
                                <h3 class="card-title">Recent Agreements List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center">
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
                                            <th class="col-2">Action</th>
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
                                                            $extension = pathinfo($agreement->document_field, PATHINFO_EXTENSION);
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
                                                <td class="px-2">
                                                    <a href="{{ route('agreements.edit', $agreement->agreement_id) }}"
                                                        class=".btn.btn-app btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('agreements.show', $agreement->agreement_id) }}"
                                                        class=".btn.btn-app btn-success btn-sm"><i class="fa fa-eye"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                    <form action="" method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class=".btn.btn-app btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure?')"><i class="fa fa-trash"
                                                                aria-hidden="true"></i>
                                                        </button>
                                                    </form>
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
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
