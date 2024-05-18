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
                        <h1>User Management</h1>
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
                                <h3 class="card-title">User list</h3>
                            </div>
                            <div class="card-body">
                                
                                <div class="tab-content">
                                    <div class="row">
                                        <div class="col-12">
                                          <div class="card">
                                            <div class="card-header"><a href="newuser"
                                                class="btn  btn-primary btn-sm">
                                                <i class="fas fa-plus"> Add new</i>
                                            </a>
                              
                                              <div class="card-tools">
                                                <div class="input-group input-group-sm" style="width: 150px;">
                                                  <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                              
                                                  <div class="input-group-append">
                                                    <button type="submit" class="btn btn-default">
                                                      <i class="fas fa-search"></i>
                                                    </button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body table-responsive p-0">
                                              <table class="table table-hover text-nowrap">
                                                <thead>
                                                  <tr>
                                                    <th>ID</th>
                                                    <th>User Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Role</th>
                                                    <th>Action</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <tr>
                                                    <td>183</td>
                                                    <td>John Doe</td>
                                                    <td>11-7-2014</td>
                                                    <td><span class="tag tag-success">Approved</span></td>
                                                    <td>Bacon ipsum dolor sit</td>
                                                    <td class="p-2">
                                                        <a href="#"
                                                            class="btn  btn-info btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="#"
                                                            class="btn  btn-success btn-sm">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </a>
                                                        <form action="#"
                                                            method="post" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn  btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure?')">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td>175</td>
                                                    <td>Mike Doe</td>
                                                    <td>11-7-2014</td>
                                                    <td><span class="tag tag-danger">Denied</span></td>
                                                    <td>Bacon ipsum dolor </td>
                                                    <td class="p-2">
                                                        <a href="#"
                                                            class="btn  btn-info btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="#"
                                                            class="btn  btn-success btn-sm">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </a>
                                                        <form action="#"
                                                            method="post" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn  btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure?')">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </div>
                                            <!-- /.card-body -->
                                          </div>
                                          <!-- /.card -->
                                        </div>
                                      </div>
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
