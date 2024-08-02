@extends('masterlist')  

@section('body')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Search Tenant</h1>
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
                            <h3 class="card-title">Search Tenants</h3>
                        </div>
    <!-- Main content 
    <section class="content">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif  -->

    <form action="{{ route('tenants.searchTenant') }}" method="post" enctype="multipart/form-data">
    @csrf
        <div class="card card-default">
            <!-- .card-body -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-6 ">
                        <label style="font-size:22px"> Search Tenants By</label><br>
                        <div class="row">
                            <div class="col-md-6 ">
                                <input type="checkbox" id="full_name" name="full_name" checked>
                                <label for="full_name"> Full Name</label>
                            </div>
                            <div class="col-md-6 ">
                                <input type="checkbox" id="email" name="email" >
                                <label for="email"> Email</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 ">
                                <input type="checkbox" id="govt_id_number" name="govt_id_number">
                                <label for="govt_id_number"> Govt ID Number</label>
                            </div>
                            <div class="col-md-6 ">
                                <input type="checkbox" id="contact" name="contact" >
                                <label for="contact"> Contact Number</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" name="search" id="search" class="form-control" >
                        </div>  
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
$(document).ready(function(){
    $('input:checkbox').click(function() {
        $('input:checkbox').not(this).prop('checked', false);

    });
});

</script>
@endsection