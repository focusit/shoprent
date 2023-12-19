<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
 <!-- /SHOPLIST/TENANT LIST -->

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

        <!-- Font Awesome -->
        <link rel="stylesheet" href=" {{ asset('plugins/fontawesome-free/css/all.min.css') }}">

        <!-- DataTables -->
        <link rel="stylesheet" href=" {{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href=" {{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href=" {{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

        <!-- Theme style -->
        <link rel="stylesheet" href=" {{ asset('dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('dist/css/list.css') }}">
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
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <p>logout</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <p>logout</p>
            </a>
          </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
