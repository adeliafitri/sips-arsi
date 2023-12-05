<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.admin.header')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">



  <!-- Navbar -->
  @include('layouts.admin.navbar')


  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('layouts.admin.sidebar')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  @include('layouts.admin.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
@include('layouts.admin.script')
</body>
</html>
