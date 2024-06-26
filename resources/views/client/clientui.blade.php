<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <!-- /SHOPLIST/TENANT LIST -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href=" {{ asset('dashboard-asset/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- DataTables -->
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
        <nav class="main-header navbar navbar-expand navbar-dark">
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
                        <form method="POST" action="{{ route('userLogout') }}">
                            @csrf
                            <a href="#" class="dropdown-item"
                                onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                        </form>
                        <a href="{{ route('profile') }}" class="dropdown-item">
                            Profile
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
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/dashboard" class="brand-link">
                <span class="brand-text font-weight-light">
                    @auth
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
                        <li class="nav-item menu-open">
                            <a href="{{ route('userDashboard') }}" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p> Dashboard </p>
                            </a>
                        </li><br>
                        <li class="nav-item menu-open">
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
                        {{-- shops --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>Shops
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('viewUserShops') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> View My Shops</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- agreements --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>Agreements
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('viewUserAgreements') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> View My Agreements</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- bills --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>Bills
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('viewUserBills') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> View My Bills</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- payments --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>Payments
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('viewUserPayments') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> View My Payments</p>
                                    </a>
                                </li>
                            </ul>
                            
                        </li>


                        </li>
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
