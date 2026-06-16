@extends('layouts.admin')

@section('content')
<div class="row">
  <div class="col-md-6 grid-margin stretch-card mx-auto">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="card-title">Ubah Kategori</h4>
        <p class="card-description">Ubah data kategori barang</p>
        
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form class="forms-sample" method="POST" action="{{ route('kategori.update', $kategori->id) }}">
          @csrf
          @method('PUT')
          <div class="form-group mb-3">
            <label for="nama_kategori" class="mb-1 fw-bold">Nama Kategori</label>
            <input type="text" name="nama_kategori" class="form-control" id="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
          </div>
          <div class="form-group mb-3">
            <label for="deskripsi" class="mb-1 fw-bold">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" id="deskripsi" rows="4">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
          </div>
          <button type="submit" class="btn btn-primary text-white me-2">Perbarui</button>
          <a href="{{ route('kategori.index') }}" class="btn btn-light">Batal</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
