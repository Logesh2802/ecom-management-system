@include('layouts.header')
<style>
  .w-95 {
      width: 95% !important;
  }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  {{-- <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset(' admin/dist/img/AdminLTELogo.png ') }}" alt="AdminLTELogo" height="60" width="60">
  </div> --}}

  @include('layouts.navbar')
  @include('layouts.sidebar')
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper bg-white">
    @yield('content')
  </div>
  <!-- /.content-wrapper --> 
  @include('layouts.footer')

  
{{-- </div> --}}
@include('layouts.js')
<!-- ./wrapper -->
@stack('scripts')

</body>
</html>
