<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistem Inventaris - Star Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
      body {
        font-family: 'Inter', sans-serif !important;
        background-color: #f4f5f7;
        color: #334155;
      }
      h1, h2, h3, h4, h5, h6, .welcome-text {
        font-family: 'Inter', sans-serif !important;
        color: #0f172a !important;
        font-weight: 600;
      }
      .navbar .navbar-menu-wrapper .navbar-nav .nav-item.user-dropdown .dropdown-menu {
        margin-top: 15px;
      }
      .sidebar .nav .nav-item .nav-link {
        display: flex;
        align-items: center;
        padding: 0.8rem 1.5rem;
        font-weight: 500;
        color: #475569;
      }
      .sidebar .nav .nav-item .menu-icon {
        margin-right: 1.25rem;
        color: #64748b;
      }
      .sidebar .nav .nav-item.active > .nav-link {
        color: #4b49ac !important;
        background-color: #f1f5f9;
      }
      .sidebar .nav .nav-item.active > .nav-link .menu-icon {
        color: #4b49ac !important;
      }
      /* Custom Premium Enhancements */
      .card {
        border-radius: 12px !important;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.02) !important;
        border: 1px solid #e2e8f0 !important;
        background-color: #ffffff;
        margin-bottom: 1.5rem;
      }
      .card-body {
        padding: 1.75rem !important;
      }
      /* Buttons UI */
      .btn {
        border-radius: 6px !important;
        font-weight: 600 !important;
        padding: 0.5rem 1rem !important;
        transition: all 0.2s ease-in-out !important;
      }
      .btn-lg {
        padding: 0.75rem 1.5rem !important;
      }
      .btn-sm {
        padding: 0.35rem 0.7rem !important;
        font-size: 0.8125rem !important;
      }
      .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08) !important;
      }
      .btn-primary {
        background-color: #4B49AC !important;
        border-color: #4B49AC !important;
      }
      .btn-primary:hover {
        background-color: #3d3b95 !important;
        border-color: #3d3b95 !important;
      }
      .btn-warning {
        background-color: #ff9f43 !important;
        border-color: #ff9f43 !important;
        color: #ffffff !important;
      }
      .btn-warning:hover {
        background-color: #f88f26 !important;
        border-color: #f88f26 !important;
        color: #ffffff !important;
      }
      .btn-danger {
        background-color: #ea5455 !important;
        border-color: #ea5455 !important;
      }
      .btn-danger:hover {
        background-color: #d93d3e !important;
        border-color: #d93d3e !important;
      }
      /* Table Custom Design */
      .table-responsive {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        overflow-x: auto;
      }
      .table {
        margin-bottom: 0 !important;
      }
      .table th {
        background-color: #f8fafc !important;
        color: #475569 !important;
        font-weight: 700 !important;
        font-size: 0.78rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px;
        padding: 1rem 0.75rem !important;
        border-bottom: 2px solid #e2e8f0 !important;
      }
      .table td {
        padding: 1rem 0.75rem !important;
        vertical-align: middle !important;
        color: #334155 !important;
        font-size: 0.875rem !important;
        border-bottom: 1px solid #f1f5f9 !important;
      }
      .table tr:hover td {
        background-color: #f8fafc !important;
      }
      /* Forms sample */
      .form-control, .form-select {
        border-radius: 6px !important;
        border: 1px solid #cbd5e1 !important;
        color: #334155 !important;
        padding: 0.625rem 1rem !important;
        font-size: 0.875rem !important;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
      }
      .form-control:focus, .form-select:focus {
        border-color: #4B49AC !important;
        box-shadow: 0 0 0 3px rgba(75, 73, 172, 0.15) !important;
      }
      /* Badges & Alerts */
      .badge {
        font-weight: 600 !important;
        padding: 0.35em 0.65em !important;
        border-radius: 4px !important;
      }
      .table-warning {
        background-color: #fffbeb !important;
      }
      .table-warning td {
        background-color: #fffbeb !important;
      }
      /* Statistics Details */
      .statistics-details .card {
        border: 1px solid #e2e8f0 !important;
        transition: all 0.2s ease-in-out;
      }
      .statistics-details .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05) !important;
        border-color: #cbd5e1 !important;
      }
    </style>
    @yield('styles')
  </head>
  <body class="with-welcome-text">
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
          <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
              <span class="icon-menu"></span>
            </button>
          </div>
          <div>
            <a class="navbar-brand brand-logo" href="{{ route('dashboard') }}">
              <h4 class="mb-0 fw-bold text-primary">INVENTARIS</h4>
            </a>
            <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard') }}">
              <h4 class="mb-0 fw-bold text-primary">INV</h4>
            </a>
          </div>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-top">
          <ul class="navbar-nav">
            <li class="nav-item fw-semibold d-none d-lg-block ms-0">
              <h1 class="welcome-text">Selamat Datang, <span class="text-black fw-bold">{{ auth()->user()->name }}</span></h1>
              <h3 class="welcome-sub-text">Sistem Manajemen Inventaris - Hak Akses: <span class="badge {{ auth()->user()->role == 'admin' ? 'bg-success' : 'bg-info' }}">{{ strtoupper(auth()->user()->role) }}</span></h3>
            </li>
          </ul>
          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
              <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="d-flex align-items-center">
                  <div class="me-2 text-end">
                    <p class="mb-0 fw-semibold">{{ auth()->user()->name }}</p>
                    <p class="mb-0 text-muted small">{{ auth()->user()->email }}</p>
                  </div>
                  <i class="mdi mdi-account-circle text-primary" style="font-size: 2rem;"></i>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <p class="mb-1 mt-3 fw-semibold">{{ auth()->user()->name }}</p>
                  <p class="fw-light text-muted mb-0">{{ auth()->user()->email }}</p>
                </div>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Keluar (Sign Out)
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item nav-category">Data Master</li>
            <li class="nav-item {{ Route::is('kategori.*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('kategori.index') }}">
                <i class="mdi mdi-folder-outline menu-icon"></i>
                <span class="menu-title">Kategori Barang</span>
              </a>
            </li>
            <li class="nav-item {{ Route::is('supplier.*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('supplier.index') }}">
                <i class="mdi mdi-account-group-outline menu-icon"></i>
                <span class="menu-title">Data Supplier</span>
              </a>
            </li>
            <li class="nav-item {{ Route::is('barang.*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('barang.index') }}">
                <i class="mdi mdi-package-variant-closed menu-icon"></i>
                <span class="menu-title">Data Barang</span>
              </a>
            </li>
            <li class="nav-item nav-category">Transaksi & Log</li>
            <li class="nav-item {{ Route::is('pembelian.*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('pembelian.index') }}">
                <i class="mdi mdi-cart-arrow-down menu-icon"></i>
                <span class="menu-title">Pembelian (Stok Masuk)</span>
              </a>
            </li>
            <li class="nav-item {{ Route::is('penjualan.*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('penjualan.index') }}">
                <i class="mdi mdi-cash-register menu-icon"></i>
                <span class="menu-title">Penjualan (Stok Keluar)</span>
              </a>
            </li>
          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            @yield('content')
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Sistem Manajemen Inventaris - Production Ready</span>
              <span class="float-none float-sm-end d-block mt-1 mt-sm-0 text-center">Copyright © {{ date('Y') }}. All rights reserved.</span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    
    <!-- plugins:js -->
    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
    <!-- endinject -->

    <!-- SweetAlert Global Sessions -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
          });
        @endif

        @if(session('error'))
          Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
            confirmButtonText: 'Tutup'
          });
        @endif

        // SweetAlert Delete Confirmation
        window.confirmDelete = function(formId) {
          Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
          }).then((result) => {
            if (result.isConfirmed) {
              document.getElementById(formId).submit();
            }
          });
        }
      });
    </script>

    @yield('scripts')
  </body>
</html>
