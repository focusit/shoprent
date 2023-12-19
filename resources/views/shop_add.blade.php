@extends('masterindex')

@section('title', 'shop_add')

@section('body')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>shop Add</h1>
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
                            <form method="POST" action="{{ route('shops.store') }}">
                              @csrf
                                <div class="form-group">
                                  <label>shop id</label>
                                  <input type="text" class="form-control" name="shop_id" >
                              </div>
                              <!-- /.form-group -->
                              <div class="form-group">
                                  <label>location</label>
                                  {{-- <select class="form-control select2" style="width: 100%;">
                                      <option selected="selected">solan</option>
                                      <option>bypass</option>
                                      <option>mall roal</option>
                                      <option>new busstand</option>
                                      <option>dc office</option>
                                      <option>thodu</option>
                                      <option>shamti</option>
                                  </select> --}}
                                  <input type="text" class="form-control" name="location">
                              </div>
                              <!-- /.form-group -->
                          </div>
                          <!-- /.col -->
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>address</label>
                                  <input type="text" class="form-control" name="address" >
                              </div>
                              <!-- /.form-group -->
                              <div class="form-group">
                                  <label>pincode</label>
                                  <input type="text" class="form-control" name="pincode">
                                 
                              </div>
                             
                              <!-- /.form-group -->
                          </div>

                          <!-- /.col -->
                      </div>

                      <div class="row">
                          <div class="col-12 col-sm-6">
                              <div class="form-group">
                                  <label>rent</label>
                                 <input type="text" class="form-control" name ="rent">
                              </div>
                          </div>
                      </div>
                      <div class="card-footer">
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                  </div>
                </form>
                  <!-- /.card-body -->
              </div>
          </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection