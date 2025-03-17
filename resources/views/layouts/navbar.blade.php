  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">

<div class="ml-auto">
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="btn btn-danger d-flex justify-content-right">Logout</button>
  </form>
  </div>
  </nav>
  <!-- /.navbar -->