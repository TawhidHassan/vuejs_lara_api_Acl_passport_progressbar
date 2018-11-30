<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>AdminLTE 3 | Starter</title>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

  <!-- <link rel="stylesheet" href="dist/css/adminlte.min.css"> -->

  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<link rel="stylesheet" href="/css/app.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" @keyup="searchit" v-model="search" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" @click="searchit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="./img/rating.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">My project 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="./img/customer-support.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
          <p class="badge badge-info">{{Auth::user()->type}}</p>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
           <li class="nav-item">
            <router-link to="/dashbord" class="nav-link">
              <i class="fas fa-tachometer-alt text-blue"></i>
              <p>
                Dashbord
                <span class="right badge badge-danger">Main</span>
              </p>
            </router-link>
          </li>
           @can('isAdmin') <!-- to accses this option for admin -->
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              <i class="fas fa-torii-gate text-green"></i>
              <p>
                Managment
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/users" class="nav-link ">
                  <i class="fas fa fa-users nav-icon"></i>
                  <p>User</p>
                </router-link>
              </li>
            </ul>
          </li>
          @endcan
          <li class="nav-item">
            <router-link to="/profile" class="nav-link">
              <i class="fas fa-user text-orange"></i>
              <p>
                Profile
              </p>
            </router-link>
          </li>
          @can('isAdmin') <!-- to accses this option for admin -->
          <li class="nav-item">
            <router-link to="/developer" class="nav-link">
              <i class="fas fa-cogs text-orange"></i>
              <p>
                Devloper
              </p>
            </router-link>
          </li>
          @endcan
          <li class="nav-item has-treeview ">
             <a class="dropdown-item" class="nav-link" href="{{ route('logout') }}"
               onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt text-red"></i>
                Logout
              </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
         <router-view></router-view>
         <vue-progress-bar></vue-progress-bar>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <a href="" @click.prevent="printme" target="_blank" class="btn btn-info"><i class="fa fa-print"></i> Print</a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2018 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
@auth
<script>
  window.user=@json(auth()->user());
</script>
@endauth
<script src="/js/app.js"></script>
</body>
</html>
