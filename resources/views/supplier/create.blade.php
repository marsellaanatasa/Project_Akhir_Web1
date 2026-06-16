@extends('layouts.admin')

@section('content')
<div class="row">
  <div class="col-md-6 grid-margin stretch-card mx-auto">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="card-title">Tambah Supplier Baru</h4>
        <p class="card-description">Tambahkan supplier baru untuk pengadaan barang</p>
        
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form class="forms-sample" method="POST" action="{{ route('supplier.store') }}">
          @csrf
          <div class="form-group mb-3">
            <label for="nama_supplier" class="mb-1 fw-bold">Nama Supplier</label>
            <input type="text" name="nama_supplier" class="form-control" id="nama_supplier" placeholder="PT. Nama Supplier" value="{{ old('nama_supplier') }}" required>
          </div>
          <div class="form-group mb-3">
            <label for="kontak_person" class="mb-1 fw-bold">Kontak Person</label>
            <input type="text" name="kontak_person" class="form-control" id="kontak_person" placeholder="Nama Kontak" value="{{ old('kontak_person') }}">
          </div>
          <div class="form-group mb-3">
            <label for="email" class="mb-1 fw-bold">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="contoh@email.com" value="{{ old('email') }}">
          </div>
          <div class="form-group mb-3">
            <label for="telepon" class="mb-1 fw-bold">Telepon</label>
            <input type="text" name="telepon" class="form-control" id="telepon" placeholder="08xxxxxxxx" value="{{ old('telepon') }}">
          </div>
          <div class="form-group mb-3">
            <label for="alamat" class="mb-1 fw-bold">Alamat</label>
            <textarea name="alamat" class="form-control" id="alamat" rows="4" placeholder="Alamat supplier">{{ old('alamat') }}</textarea>
          </div>
          <button type="submit" class="btn btn-primary text-white me-2">Simpan</button>
          <a href="{{ route('supplier.index') }}" class="btn btn-light">Batal</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
