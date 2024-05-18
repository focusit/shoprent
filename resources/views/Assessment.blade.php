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
                        <h1>Shop Management</h1>
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
                                <h3 class="card-title">View List of all Shops</h3>
                            </div>
                            <div class="card-body">
                                
                                <div class="tab-content">
                                    <div class="row">
                                        <div class="col-12">
                                            <!-- /.card-header -->
                                            <div class="card-body table-responsive p-0">
                                              <table class="table table-hover text-nowrap">
                                                <thead>
                                                  <tr>
                                                    <th>Shops Number</th>
                                                    <th>Number of lessees</th>
                                                    <th>Estimated Assessment Cost</th>
                                                    <th>List of Shops</th>
                                                   
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <tr>
                                                    <th>01shop</th>
                                                    <td>01</td>
                                                    <td>₹1110</td>
                                                    <td class="p-2"style="font-size: 1.2rem; font-weight: bold;">
                                                        <a href="#">
                                                            <i>view/</i>
                                                        </a>
                                                        <a href="#">
                                                            <i>Print/</i>
                                                        </a>
                                                        <a href="#">
                                                            <i>Download xls</i>
                                                        </a>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <th>02shop</th>
                                                    <td>01</td>
                                                    <td>₹1110</td>
                                                    <td class="p-2"style="font-size: 1.2rem; font-weight: bold;">
                                                        <a href="#">
                                                            <i>view/</i>
                                                        </a>
                                                        <a href="#">
                                                            <i>Print/</i>
                                                        </a>
                                                        <a href="#">
                                                            <i>Download xls</i>
                                                        </a>
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
