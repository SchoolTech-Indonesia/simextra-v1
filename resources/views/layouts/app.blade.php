<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{ $title ?? 'Default Title' }} &mdash; {{ config('app.name') }}</title>


  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- CSS Libraries -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  {{-- <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}"> --}}
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"> <!-- Path to Stisla CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}"> <!-- Path to Stisla Components CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <!-- Add jQuery dependency -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Add Toaster library -->
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

  @stack('styles') <!-- Stack for additional styles -->
</head>

<body>
  <div id="app">
      <div class="main-wrapper">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
          <form class="form-inline mr-auto">
            <ul class="navbar-nav mr-3">
              <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
              <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
            </ul>
          
          </form>
          <ul class="navbar-nav navbar-right">
            
            <li class="dropdown">
      <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
          <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
          <div class="dropdown-title">Logged in 5 min ago</div>

          <!-- Profile Link -->
          <a href="{{ route('profile.show') }}" class="dropdown-item has-icon">
              <i class="far fa-user"></i> Profile
          </a>

          <!-- Settings Link (Optional, adjust route if needed) -->
          <div class="dropdown-divider"></div>

          <!-- Logout Form -->
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
          
          <!-- Logout Link -->
          <a href="#" class="dropdown-item has-icon text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt"></i> Logout
          </a>
      </div>
  </li>


          </ul>
        </nav>
        <div class="main-sidebar sidebar-style-2">
          <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
              <a href="index.html">SchoolTech</a>
            </div>
            <div class="sidebar-brand sidebar-brand-sm">
              <a href="index.html">St</a>
            </div>
            @include('layouts.menu')

          </aside>
        </div>

        <!-- Main Content -->
        <div class="main-content">
          @yield('content')
        </div>
        <footer class="main-footer">
          <div class="footer-left">
            Copyright &copy; 2024 <div class="bullet">SchoolTech Indonesia</div> 
          </div>
          <div class="footer-right">
            
          </div>
        </footer>
      </div>
    </div>


  <!-- General JS Scripts -->

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src=" {{ asset('assets/js/stisla.js') }}" ></script>

  <!-- JS Libraies -->
<!-- JS Libraries -->
<script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>


  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js')}}" ></script>
  <script src="{{ asset('assets/js/custom.js')}}" ></script>

  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="{{ asset('assets/js/page/modules-datatables.js')}}" ></script>
</body>
</html>
