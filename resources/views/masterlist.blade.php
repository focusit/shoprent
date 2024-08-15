<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <!-- /SHOPLIST/TENANT LIST -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href=" {{ asset('dashboard-asset/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet"
        href=" {{ asset('dashboard-asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href=" {{ asset('dashboard-asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href=" {{ asset('dashboard-asset/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href=" {{ asset('dashboard-asset/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-asset/dist/css/list.css') }}">
    <!-- <link rel="stylesheet" href="dist/css/list.css"> -->
</head>

<body class="hold-transition sidebar-mini">
    <!-- .wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand ">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="#" class="dropdown-item"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt">Logout</i>
                            </a>
                        </form>
                        <a href="{{ route('profile') }}" class="dropdown-item">
                         <i class="fas fa-user-circle"> Profile</i>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-0" style="background-color:#0f59871f">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <span class="brand-text font-weight-light">@auth
                        Welcome {{ auth()->user()->name }}
                    @else
                        Welcome Guest
                    @endauth
                </span>
            </a>
            <!--/ Brand Logo -->

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
                        <li class="nav-item menu-open" style="background-color: #3c8dbc;border-radius:10px">
                            <a href="{{ route('dashboard') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt danger"></i>
                                <p style="color:white" > Dashboard </p>
                            </a>
                        </li><br>
                    <li class="nav-item menu-open" >
                            <div class="form-inline">
                                <div class="input-group" data-widget="sidebar-search">
                                    <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                                        aria-label="Search">
                                    <div class="input-group-append">
                                        <button class="btn btn-sidebar">
                                            <i class="fas fa-search fa-fw"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li><br>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-building"></i>
                                <p>Shops
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item pl-4">
                                    <a href="{{ route('shops.create') }}" class="nav-link">
                                        <i class="fa fa-plus"></i>
                                        <p class="pl-1"> Add Shops</p>
                                    </a>
                                </li>
                                <li class="nav-item pl-4">
                                    <a href="{{ route('shops.index') }}" class="nav-link">
                                        <i class="fa fa-eye"></i>
                                        <p  class="pl-1">View All Shops</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user-friends"></i>
                                <p>Tenants
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item pl-4">
                                    <a href="{{ route('tenants.create') }}" class="nav-link">
                                        <i class="fa fa-plus"></i>
                                        <p class="pl-1"> Add Tenants</p>
                                    </a>
                                </li>
                                <li class="nav-item pl-4">
                                    <a href="{{ route('tenants.index') }}" class="nav-link">
                                        <i class="fa fa-list-alt"></i>
                                        <p class="pl-1"> View Active Tenants</p>
                                    </a>
                                </li>
                                <li class="nav-item pl-4">
                                    <a href="{{ route('tenants.index') }}" class="nav-link">
                                        <i class="fa fa-eye"></i>
                                        <p class="pl-1"> All Tenants</p>
                                    </a>
                                </li>
                                <li class="nav-item pl-4">
                                    <a href="{{  route('tenants.search') }}" class="nav-link">
                                        <i class="fa fa-search"></i>
                                        <p class="pl-1"> Search Tenants</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tasks"></i>
                                <p>
                                    Property Allocation
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('allocate-shop') }}" class="nav-link">
                                        <i class="fa fa-plus"></i>
                                        <p>Allocate Properties</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('agreements') }}" class="nav-link">
                                        <i class="fa fa-eye"></i>
                                        <p>All Agreements</p>
                                    </a>
                                </li>
                            </ul>
                        </li> 
                        
                        {{--<li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tasks"></i>
                                <p>
                                    Transaction <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href=# class="nav-link">
                                        <i class="fa fa-plus "></i>
                                        <p>Tenant ID </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-eye"></i>
                                        <p>All Agreements</p>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                                <p>
                                    Bills
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                {{-- <li class="nav-item">
                                    <a href="{{ url('generate_bill') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Bill Format</p>
                                    </a>
                                </li> --}}
                                <li class="nav-item">
                                    <a href="{{ url('bills') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Generate Bills</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('bills/bills_list') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>view-latest bill</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('bills') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Paid Bills</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{  route('payments.search') }}" class="nav-link">
                                <i class="nav-icon fas fa-credit-card"></i>
                                <p>
                                    Payments
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                        </li> 

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>
                                    Reports
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('reports.monthwise') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Month wise Reports</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('reports.collection') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Collection Report</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Penalty Report</p>
                                    </a>
                                </li>
                            </ul>
                        </li> 

                        {{-- <li class="nav-item">
                            <a href="user" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    User
                                </p>
                            </a>
                        </li> --}}

                        {{-- <li class="nav-item">
                            <a href="assessmentSummary" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    Assessment Summary
                                </p>
                            </a>
                        </li> --}}
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        @yield('body')

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
            </div>
            <strong>Copyright &copy; 2023 <a href="#">Property</a>.</strong> All rights
            reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src=" {{ asset('dashboard-asset/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src=" {{ asset('dashboard-asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src=" {{ asset('dashboard-asset/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src=" {{ asset('dashboard-asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src=" {{ asset('dashboard-asset/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src=" {{ asset('dashboard-asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src=" {{ asset('dashboard-asset/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src=" {{ asset('dashboard-asset/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src=" {{ asset('dashboard-asset/plugins/jszip/jszip.min.js') }}"></script>
    <script src=" {{ asset('dashboard-asset/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src=" {{ asset('dashboard-asset/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src=" {{ asset('dashboard-asset/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src=" {{ asset('dashboard-asset/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src=" {{ asset('dashboard-asset/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src=" {{ asset('dashboard-asset/dist/js/adminlte.min.js') }}"></script>
    

    <!-- Page specific script -->
    <script src="{{ asset('dashboard-asset/dist/js/list.js') }}"></script>
</body>

</html>

<!--telent list/SHOPLIST/BILL LIST/-->
