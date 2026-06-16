<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Daftar - Sistem Inventaris</title>
  <link rel="stylesheet" href="{{ asset('vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
  <style>
    .auth .brand-logo h3 {
      font-size: 2.2rem;
      letter-spacing: 1px;
    }
  </style>
</head>
<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5 card shadow-sm">
              <div class="brand-logo text-center">
                <h3 class="fw-bold text-primary mb-2">INVENTARIS</h3>
                <p class="text-muted small">Sistem Manajemen Inventaris</p>
              </div>
              <h4 class="fw-light text-center mb-4">Buat akun staf baru Anda.</h4>
              
              <!-- Validation Errors -->
              @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <form class="pt-3" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group mb-3">
                  <label for="name" class="mb-1 text-small">Nama Lengkap</label>
                  <input type="text" name="name" id="name" class="form-control form-control-lg" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus>
                </div>
                <div class="form-group mb-3">
                  <label for="email" class="mb-1 text-small">Email Address</label>
                  <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="nama@email.com" value="{{ old('email') }}" required>
                </div>
                <div class="form-group mb-3">
                  <label for="password" class="mb-1 text-small">Password</label>
                  <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="********" required>
                </div>
                <div class="form-group mb-3">
                  <label for="password_confirmation" class="mb-1 text-small">Konfirmasi Password</label>
                  <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg" placeholder="********" required>
                </div>
                <div class="form-group mb-4">
                  <label for="role" class="mb-1 text-small">Peran (Role)</label>
                  <select name="role" id="role" class="form-select form-control" style="height: 2.875rem;" required>
                    <option value="staff" selected>Staff Gudang</option>
                    <option value="admin">Administrator</option>
                  </select>
                </div>
                <div class="mt-3 d-grid gap-2">
                  <button type="submit" class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn">DAFTAR</button>
                </div>
                <div class="text-center mt-4 fw-light"> Sudah punya akun? <a href="{{ route('login') }}" class="text-primary">Masuk</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
</body>
</html>
