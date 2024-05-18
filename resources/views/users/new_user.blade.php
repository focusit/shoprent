@extends('masterlist')

@section('title', 'Shop_list')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col">
                        <h3>Add/Edit User</h3>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-lightblue">
                            <div class="card-header">
                                Enter User Details
                            </div>
                            <div class="card-body">
                                <div class="card card-default">
                                    <!-- .card-body -->
                                    <div class="card-body">
                                        <form>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Full Name</label>
                                                        <input type="text" class="form-control" >
                                                    </div>
                                                </div>
                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="number" class="form-control">
                                                    </div>
                                                </div>  
                                            </div>
                                
                                            <div class="row">
                                                <!-- Add other input fields as needed -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label> Password</label>
                                                        <input type="text" class="form-control" >
                                                    </div>
                                                </div>
                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Conforrm Password</label>
                                                        <input type="number" class="form-control">
                                                    </div>
                                                </div>
                                
                                            </div>
                                
                                            <div class="row">
                                                <!-- Add other input fields as needed -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Mobile no</label>
                                                        <input type="text" class="form-control" name="rent"
                                                            value="{{ isset($shop) ? $shop->rent : '' }}">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Role</label>
                                                        <select class="form-control" name="status" required>
                                                            <option value="" selected disabled>Select the Role</option>
                                                            <option value="Manager" >Manager </option>
                                                            <option value="employ"> employ </option>
                                                            <option value="custmor"> custmor </option>
                                                        </select>
                                                    </div>
                                                </div> 
                                            </div>
                                
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-success">
                                                    {{ isset($shop) ? 'Update Shop' : 'Submit' }}
                                                </button>
                                                <button type="submit" class="btn btn-success">
                                                    {{ isset($shop) ? 'Update Shop' : 'restart' }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>

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
