@extends('layouts.admin')

@section('content')
<div class="row">
  <div class="col-md-8 grid-margin stretch-card mx-auto">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="card-title">Ubah Data Barang</h4>
        <p class="card-description">Ubah data barang inventaris</p>
        
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form class="forms-sample row" method="POST" action="{{ route('barang.update', $barang->id) }}">
          @csrf
          @method('PUT')
          <div class="form-group col-md-6 mb-3">
            <label for="kode_barang" class="mb-1 fw-bold">Kode Barang (SKU)</label>
            <input type="text" name="kode_barang" class="form-control" id="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}" required>
          </div>
          <div class="form-group col-md-6 mb-3">
            <label for="nama_barang" class="mb-1 fw-bold">Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" id="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
          </div>
          <div class="form-group col-md-6 mb-3">
            <label for="kategori_id" class="mb-1 fw-bold">Kategori</label>
            <select name="kategori_id" id="kategori_id" class="form-select" style="height: 2.875rem;" required>
              @foreach($kategori as $kat)
                <option value="{{ $kat->id }}" {{ old('kategori_id', $barang->kategori_id) == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-6 mb-3">
            <label for="supplier_id" class="mb-1 fw-bold">Supplier Utama</label>
            <select name="supplier_id" id="supplier_id" class="form-select" style="height: 2.875rem;">
              <option value="">Pilih Supplier (Opsional)</option>
              @foreach($supplier as $sup)
                <option value="{{ $sup->id }}" {{ old('supplier_id', $barang->supplier_id) == $sup->id ? 'selected' : '' }}>{{ $sup->nama_supplier }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-6 mb-3">
            <label for="harga_beli" class="mb-1 fw-bold">Harga Beli</label>
            <div class="input-group">
              <span class="input-group-text">Rp</span>
              <input type="number" name="harga_beli" class="form-control" id="harga_beli" min="0" value="{{ old('harga_beli', (int)$barang->harga_beli) }}" required>
            </div>
          </div>
          <div class="form-group col-md-6 mb-3">
            <label for="harga_jual" class="mb-1 fw-bold">Harga Jual</label>
            <div class="input-group">
              <span class="input-group-text">Rp</span>
              <input type="number" name="harga_jual" class="form-control" id="harga_jual" min="0" value="{{ old('harga_jual', (int)$barang->harga_jual) }}" required>
            </div>
          </div>
          <div class="form-group col-md-6 mb-3">
            <label for="stok_minimum" class="mb-1 fw-bold">Stok Minimum (Alert)</label>
            <input type="number" name="stok_minimum" class="form-control" id="stok_minimum" min="0" value="{{ old('stok_minimum', $barang->stok_minimum) }}" required>
          </div>
          <div class="form-group col-md-6 mb-3">
            <label for="satuan" class="mb-1 fw-bold">Satuan</label>
            <input type="text" name="satuan" class="form-control" id="satuan" value="{{ old('satuan', $barang->satuan) }}" required>
          </div>
          <div class="form-group col-12 mb-3">
            <label for="deskripsi" class="mb-1 fw-bold">Deskripsi Barang</label>
            <textarea name="deskripsi" class="form-control" id="deskripsi" rows="3">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
          </div>
          <div class="col-12 mt-2">
            <button type="submit" class="btn btn-primary text-white me-2">Perbarui</button>
            <a href="{{ route('barang.index') }}" class="btn btn-light">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
