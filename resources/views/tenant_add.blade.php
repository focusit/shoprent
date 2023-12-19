@extends('masterindex')

@section('title', 'tenant_add')

@section('body')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>tenants Add</h1>
            </div>
            
          </div>
        </div><!-- /.container-fluid -->
      </section>

       <!-- Main content -->
       <section class="content">
         
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <!-- /.card-header -->
                        <!-- .card-body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>tenants id</label>
                                        <input type="text" name="tenant_id" class="form-control">
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label> govt-id- name</label>
                                        <select class="form-control select2" style="width: 100%;">
                                            <option selected="selected">aadhaar card</option>
                                            <option>pan card</option>
                                            <option>voter id card</option>
                                            <option>licence</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>address</label>
                                        <input type="text" name="address" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>email</label>
                                        <input type="text" name="email" class="form-control">
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>full name</label>
                                        <input type="text" name="name" class="form-control">
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label>  govt-id-number</label>
                                        <input type="text" name="gov_id_no" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label> contect</label>
                                        <input type="text" name="contact" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label> password</label>
                                        <input type="password" name="password"  class="form-control">
                                    </div>
                                    <!-- /.form-group -->
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            
       </section>
    <!-- /.Main content -->
    </div>
    <!-- /.content-wrapper -->
@endsection