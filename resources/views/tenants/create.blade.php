@extends('masterlist')

@section('title', 'Create Tenant')

@section('body')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Tenant</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-lightblue">
                        <div class="card-header">
                            <h3 class="card-title">Add new Tenants</h3>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <span style="color: red;">* Marked Fields are Compulsory</span>
                                <!-- Main content -->
                                <section class="content">
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <form action="{{ route('tenants.store') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @include('tenants._form')
                                    </form>
                                </section><!-- /.content -->
                            </div><!-- /.content-wrapper -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection