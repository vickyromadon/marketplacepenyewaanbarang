<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="viewport" content="initial-scale=1.0">
  
  <title>Admin RentOnCome</title>
  
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="{{ mix('/css/bootstrap.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  @yield('css')
</head>

<body class="hold-transition skin-yellow fixed sidebar-mini">
  <div class="wrapper">

    <!-- Main Header -->
  <header class="main-header">

  <!-- Logo -->
  <a href="{{ route('admin.home.index') }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>A</b>RC</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Admin</b>ROC</span>
  </a>

  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account Menu -->
        <li class="dropdown user user-menu">
          <!-- Menu Toggle Button -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <!-- The user image in the navbar-->
            <img src="{{ asset('images/avatar_admin.png') }}" class="user-image" alt="User Image">
            <!-- hidden-xs hides the username on small devices so only the image appears. -->
            <span class="hidden-xs">{{ Auth::user()->name }}</span>
          </a>
          <ul class="dropdown-menu">
            <!-- The user image in the menu -->
            <li class="user-header">
              <img src="{{ asset('images/avatar_admin.png') }}" class="img-circle" alt="User Image">

              <p>
                {{ Auth::user()->name }} - Super Admin
                <small>Admin since {{ date_format(Auth::user()->created_at, 'M. Y') }}</small>
              </p>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                <a href="{{ route('admin.home.profile', ['id' => Auth::user()->id]) }}" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat"onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Sign out
                  </a>

                  <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                  </form>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
  </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('images/avatar_admin.png') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      {!! $MenuAdmin->asUl( ['class' => 'sidebar-menu', 'data-widget' => 'tree'] ) !!}
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      @yield('header')
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->

        @yield('content')

    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2018 <a href="#">RentOnCome~Dev</a>.</strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="pull-right-container">
                    <span class="label label-danger pull-right">70%</span>
                  </span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->
  <!-- REQUIRED JS SCRIPTS -->
  <script src="{{ mix('/js/jquery.min.js') }}"></script>
  <script src="{{ mix('/js/bootstrap.min.js') }}"></script>
  <script src="{{ mix('/js/jquery.slimscroll.min.js') }}"></script>
  <script src="{{ mix('/js/fastclick.js') }}"></script>
  <script src="{{ mix('/js/icheck.min.js') }}"></script>
  <script src="{{ mix('/js/adminlte.min.js') }}"></script>
  <script src="{{ mix('/js/jquery.toast.min.js') }}"></script>
  <script src="{{ mix('/js/jquery.dataTables.js') }}"></script>
  <script src="{{ mix('/js/dataTables.bootstrap.js') }}"></script>
  <script src="{{ mix('/js/moment.js') }}"></script>
  <script src="{{ mix('/js/summernote.js') }}"></script>
  <script src="{{ mix('/js/bootstrap-timepicker.min.js') }}"></script>
  <script src="{{ mix('/js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ mix('/js/app.js') }}"></script>

  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('.sidebar ul .header a').remove();
      $('.sidebar ul .header').text('MAIN NAVIGATION');
      $('.sidebar .treeview ul').addClass('treeview-menu');

      $('#transactionPaymentAdmin').text('{{ count($transactionPaymentAdmin) }}');
      $('#refundAdmin').text('{{ count($refundAdmin) }}');
    });
  </script>

  @yield('js')
</body>
</html>