@extends('client.clientui')

@section('title', 'Dashboard')

@section('body')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <!-- .container-fluid -->
            <div class="container-fluid">
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <!-- Info boxes -->
                        <div class="row">
                            <!-- .col -->
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon elevation-1 bg-success"><i
                                            class="fas fa-shopping-bag"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Properties</span>
                                        <span
                                            class="info-box-number">{{ DB::table('shop_rents')->where('tenant_id', Auth::user()->tenant_id)->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->

                            <!-- fix for small devices only -->
                            <div class="clearfix hidden-md-up"></div>
                            <!--.col -->
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-coins"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Bills</span>
                                        <span class="info-box-number">{{ $totalBills }}</span>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                            <!--.col -->
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-coins"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Agreements</span>
                                        <span class="info-box-number">{{ $totalAgreements }}</span>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-success elevation-1"><i
                                            class="fas fa-credit-card"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Payments</span>
                                        <span class="info-box-number">
                                            {{ $totalPayments }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /Info boxes -->

                        <!-- Main row -->
                        <div class="row">
                            <div class="content">
                                <div class="container-fluid">
                                    <h1>Dashboard</h1>
                                </div><!-- /.container-fluid -->
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
    </div>
    <!-- /.content-wrapper. Contains page content -->

@endsection
