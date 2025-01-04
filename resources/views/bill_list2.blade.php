@extends('masterlist')

@section('title', 'bill_list')

@section('body')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>bill list</h1>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Recently bills list</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>date</th>
                                                    <th>Shop ID</th>
                                                    <th>Tenant ID</th>
                                                    <th>amount</th>
                                                    <th>prev_bal</th>
                                                    <th>due bate</th>
                                                    <th>status</th>
                                                    <th>remark</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th></th>
                                                    <td>1</td>
                                                    <td>12</td>
                                                    <td>12300</td>
                                                    <td><a href="#" class="nav-link active"><h4>one</h4></a></td>
                                                    <td></td>
                                                    <td>paid</td>
                                                    <td></td>
                                                
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>2</td>
                                                    <td>13</td>
                                                    <td>52300</td>
                                                    <td><a href="#" class="nav-link active"><h4>one</h4></a></td>
                                                    <td></td>
                                                    <td>paid</td>
                                                    <td></td>
                                                
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>3</td>
                                                    <td>16</td>
                                                    <td>23000</td>
                                                    <td><a href="#" class="nav-link active"><h4>one</h4></a></td>
                                                    <td></td>
                                                    <td>not paid</td>
                                                    <td></td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>4</td>
                                                    <td>15</td>
                                                    <td>98750</td>
                                                    <td><a href="#" class="nav-link active"><h4>one</h4></a></td>
                                                    <td></td>
                                                    <td>paid</td>
                                                    <td></td>
                                                
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>5</td>
                                                    <td>45</td>
                                                    <td>26500</td>
                                                    <td><a href="#" class="nav-link active"><h4>one</h4></a></td>
                                                    <td></td>
                                                    <td>not paid</td>
                                                    <td></td>
                                                    
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>date</th>
                                                    <th>Shop ID</th>
                                                    <th>Tenant ID</th>
                                                    <th>amount</th>
                                                    <th>prev_bal</th>
                                                    <th>due bate</th>
                                                    <th>status</th>
                                                    <th>remark</th>
                                                </tr>
                                            </tfoot>
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