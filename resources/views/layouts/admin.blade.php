
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Theme style -->
  @yield('css')
</head>

<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  @include('layouts.navigation.navbar')
  @include('layouts.navigation.slidesbar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>@yield('content-header')</h1>
        </div>
        <div class="col-sm-6 text-right">
          @yield('content-actions')
        </div>
      </div>
    </div>
    <!-- Main content -->
    <section class="content">
      @include('layouts.alert.success')
      @include('layouts.alert.error')
      @yield('content')
    </section>    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('layouts.navigation.footer')
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('js')
</body>
</html>
