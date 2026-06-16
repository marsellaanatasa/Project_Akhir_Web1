<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login - Sistem Inventaris</title>
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
              <h4 class="fw-light text-center mb-4">Silakan masuk untuk melanjutkan.</h4>
              
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

              <form class="pt-3" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group mb-3">
                  <label for="email" class="mb-1 text-small">Email Address</label>
                  <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="form-group mb-3">
                  <label for="password" class="mb-1 text-small">Password</label>
                  <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="********" required>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" name="remember" class="form-check-input"> Ingat Saya </label>
                  </div>
                </div>
                <div class="mt-3 d-grid gap-2">
                  <button type="submit" class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn">MASUK</button>
                </div>
                <div class="text-center mt-4 fw-light"> Belum punya akun? <a href="{{ route('register') }}" class="text-primary">Daftar</a>
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
