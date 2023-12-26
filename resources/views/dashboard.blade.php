@extends('masterlist')

@section('title', 'Dashboard')

@section('body')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <!-- .container-fluid -->
            <div class="container-fluid">
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->
                <div class="row">

                    <!--.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon elevation-1"><i class="fas fa-shopping-bag"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Shop</span>
                                <span class="info-box-number">{{ DB::table('shop_rents')->count() }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->

                    <!--.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon  elevation-1"><i class="fas fa-user-friends"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Tenants</span>
                                <span class="info-box-number">{{ DB::table('tenants')->count() }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>
                    <!--.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon  elevation-1"><i class="fas fa-coins"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Bills</span>
                                <span class="info-box-number">{{ DB::table('bills')->count() }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <!--.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon  elevation-1"><i class="fas fa-credit-card"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Payment</span>
                                <span class="info-box-number">41,410</span>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /Info boxes -->

                <!-- Main row -->
                <div class="row">
                </div>
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card card-primary card-outline">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>

                                        <p class="card-text">
                                            Some quick example text to build on the card title and make up the bulk of the
                                            card's
                                            content.
                                        </p>
                                        <a href="#" class="card-link">Card link</a>
                                        <a href="#" class="card-link">Another link</a>
                                    </div>
                                </div><!-- /.card -->
                            </div>
                            <div class="col-lg-6">
                                <div class="card card-primary card-outline">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>

                                        <p class="card-text">
                                            Some quick example text to build on the card title and make up the bulk of the
                                            card's
                                            content.
                                        </p>
                                        <a href="#" class="card-link">Card link</a>
                                        <a href="#" class="card-link">Another link</a>
                                    </div>
                                </div><!-- /.card -->
                            </div>
                            <div class="col-lg-12">
                                <div class="card card-primary card-outline">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>

                                        <p class="card-text">
                                            Some quick example text to build on the card title and make up the bulk of the
                                            card's
                                            content.
                                        </p>
                                        <a href="#" class="card-link">Card link</a>
                                        <a href="#" class="card-link">Another link</a>
                                    </div>
                                </div><!-- /.card -->
                            </div>
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.row -->
            </div>
        </section>
    </div>
    <!-- /.content-wrapper. Contains page content -->


@endsection
