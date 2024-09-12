@extends('masterlist')

@section('title', 'Dashboard')

@section('body')

    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            @if($message!=null)
            <marquee width="100%" direction="left" style="background:red;">
                {{ $message}}
            </marquee>
            @endif
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->
                <div class="row">
                 <h1>Rent a Shop </h1>
                </div>
                <div class="row">
                    <!--.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box  mb-3">
                            <span class="info-box-icon elevation-1 bg-success"><i class="fas fa-shopping-bag"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Shop</span>
                                <span class="info-box-number">{{ $data['allocatedShops'] }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->

                    <!--.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3 ">
                            <span class="info-box-icon  elevation-1 bg-success"><i class="fas fa-user-friends"></i></span>
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
                        <div class="info-box  mb-3">
                            <span class="info-box-icon bg-success  elevation-1"><i class="fas fa-coins"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Bills</span>
                                <span class="info-box-number">{{ $data['bills'] }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <!--.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3 ">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-credit-card"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Payments</span>
                                <span class="info-box-number">{{ $data['payments'] }}</span>
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
                            <div class="row">
                                @foreach ($cards as $card)
                                    <div class="col-lg-4 mb-4 d-flex h-100 card card-success w-100">
                                        <div class="card-header">
                                        <h3 class="card-title">{{ $card['title'] }}</h3>
                                            <div class="card-tools">
                                                <span class="badge badge-danger">{{ $card['badge'] }}</span>
                                            </div>        
                                        </div>
                                        <div class="card-body">
                                            @if (isset($card['body']))
                                                {!! $card['body'] !!} 
                                            @else
                                                No data available
                                            @endif
                                        </div>
                                        <div class="card-footer">
                                            <a href="{{ $card['linkCreate'] }}" class="card-link">
                                                {{ $card['linkTextCreate'] }}</a>
                                            <a href="{{ $card['linkView'] }}" class="card-link">
                                                {{ $card['linkTextView'] }}</a>
                                         </div>
                                    </div>
                                @endforeach
                            </div>
                        </div><!-- /.container-fluid -->
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection