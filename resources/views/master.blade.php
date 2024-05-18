<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <!--/GENERATE BILL/SHOP ADD/SHOPEDIT/TENANT ADD/TENENT EDIT-->

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('dashboard-asset/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('dashboard-asset/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dashboard-asset/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-asset/dist/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-asset/dist/css/add.css') }}">
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="{{ asset('dashboard-asset/dist/img/AdminLTELogo.png') }}"
                alt="AdminLTELogo" height="60" width="60">
        </div>

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
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf <!-- CSRF protection -->
                            <a href="{{ route('logout') }}" class="dropdown-item">
                                Logout
                            </a>
                        </form>
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
            <a href="dashboard" class="brand-link">
                <span class="brand-text font-weight-light">Welcome admin!!</span>
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
                            <a href="{{ route('dashboard') }}" class="nav-link active">
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
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    Shops
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('shops.create') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> add</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('shops.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>list</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('shops.edit') }}" class="btn btn-info">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>edit</p>
                                    </a>
                                </li>



                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-table"></i>
                                        <p>
                                            tanent
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="tenant_add" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p> add</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="tenant_edit" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>edit</p>
                                            </a>
                                        </li>
                                        <!-- <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>find</p>
                </a>
              </li> -->
                                        <li class="nav-item">
                                            <a href="tenant_list" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>list</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-table"></i>
                                        <p>
                                            bills
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="generate_bill" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>generate</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="bill_list" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>view-latest bill</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-table"></i>
                                        <p>
                                            payment
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>

                                </li>
                                <li class="nav-item">
                                    <a href="user" class="nav-link">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>
                                            User
                                        </p>
                                    </a>
                                </li>
        
                                <li class="nav-item">
                                    <a href="assessmentSummary" class="nav-link">
                                        <i class="nav-icon fas fa-table"></i>
                                        <p>
                                            Assessment Summary
                                        </p>
                                    </a>
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
            <strong>Copyright &copy; 2023 <a href="#">Property</a>.</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('dashboard-asset/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('dashboard-asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dashboard-asset/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
</body>

</html>


<!--TENANT ADD/TENANT EDIT/SHOPEDIT/SHOPADD/GENERATE BILL-->
