<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{ $title ?? 'Simextra - SchoolTech' }}</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
  
  <!-- SweetAlert CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <!-- Add jQuery dependency -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Add Toaster library -->
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

  @stack('styles') <!-- Stack for additional styles -->

  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
  <style>
        .select2-container--default .select2-selection--multiple {
            background-color: #ffffff;
            border: 1px solid #433f3f; 
            color: white; 
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #0056b3;
            color: white;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white; 
        }

        .select2-container--default .select2-selection--multiple .select2-selection__placeholder {
            color: white; 
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: white; 
        }

        .form-control-file {
            border: 1px solid #433f3f; 
            border-radius: 4px;
            padding: 5px;
        }

        .form-control-file:focus {
            border-color: #433f3f; 
            outline: none;
        }
    </style>
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
                  <a href="{{ route('profile.show') }}" class="dropdown-item has-icon">
                      <i class="far fa-user"></i> Profile
                  </a>
                  <div class="dropdown-divider"></div>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
                  <a href="#" class="dropdown-item has-icon text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      <i class="fas fa-sign-out-alt"></i> Logout
                  </a>
              </div>
            </li>
          </ul>
        </nav>
        <div class="main-sidebar sidebar-style-2">
          <aside id="sidebar-wrapper">
            <div class="navbar-brand"></div>
            <div class="sidebar-brand mb-3">
              <img src="{{ asset('assets/img/logo/SchoolTech-Logo1full.png') }}" alt="logo" width="100">
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
          <div class="footer-right"></div>
        </footer>
      </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{ asset('assets/js/stisla.js') }}"></script>

  <!-- SweetAlert JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

  <!-- Bootstrap Multiselect JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"></script>

  <!-- Select2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>

  <!-- Page Specific JS File -->
  <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>

  <script>
    $(document).ready(function() {
        // Initialize DataTable
        $('majors').DataTable();
        $('classroom').DataTable(); // Replace 'yourTableId' with the actual ID of your table
        $('major_classroom').DataTable();
        $('#majorsclassrooms').select2();  // Initialize the select2 plugin
        $('#edit-classrooms').multiselect({
                includeSelectAllOption: true,
                enableFiltering: true
            });
      });

  </script>


  <!-- Tambahkan sebelum penutup </body> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</body>
</html>
