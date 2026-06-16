@extends('layouts.admin')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card card-rounded shadow-sm">
      <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start mb-4">
          <div>
            <h4 class="card-title card-title-dash">Data Barang (Stok & Inventaris)</h4>
            <p class="card-subtitle card-subtitle-dash">Kelola data barang dan pantau stok minimum</p>
          </div>
          @if(auth()->user()->role === 'admin')
          <div>
            <a href="{{ route('barang.create') }}" class="btn btn-primary text-white btn-lg"><i class="mdi mdi-plus"></i> Tambah Barang</a>
          </div>
          @endif
        </div>
        
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
          <form action="{{ route('barang.index') }}" method="GET" class="d-flex align-items-center w-50 flex-grow-1" style="max-width: 600px;">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari Kode atau Nama Barang..." value="{{ request('search') }}">
            <select name="kategori_id" class="form-select me-2" style="height: 38px; width: 200px;">
              <option value="">Semua Kategori</option>
              @foreach($kategori as $kat)
                <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
              @endforeach
            </select>
            <button type="submit" class="btn btn-primary text-white" style="height: 38px;">Filter</button>
            @if(request('search') || request('kategori_id'))
              <a href="{{ route('barang.index') }}" class="btn btn-light ms-1" style="height: 38px; display: flex; align-items: center;">Reset</a>
            @endif
          </form>
        </div>

        <div class="table-responsive">
          <table class="table table-hover select-table">
            <thead>
              <tr>
                <th width="80px">No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Supplier</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
                <th>Stok</th>
                <th>Stok Minimum</th>
                <th>Satuan</th>
                @if(auth()->user()->role === 'admin')
                <th width="120px">Aksi</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @forelse($barang as $index => $item)
              <tr class="{{ $item->stok <= $item->stok_minimum ? 'table-warning' : '' }}">
                <td>{{ $barang->firstItem() + $index }}</td>
                <td><span class="badge bg-secondary">{{ $item->kode_barang }}</span></td>
                <td>
                  <div class="d-flex flex-column">
                    <h6 class="mb-0">{{ $item->nama_barang }}</h6>
                    @if($item->stok <= $item->stok_minimum)
                      <span class="text-danger small fw-bold" style="font-size: 11px;"><i class="mdi mdi-alert-circle"></i> Stok Kritis!</span>
                    @endif
                  </div>
                </td>
                <td>{{ $item->kategori->nama_kategori }}</td>
                <td>{{ $item->supplier->nama_supplier ?? '-' }}</td>
                <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                <td>
                  <span class="fw-bold {{ $item->stok <= $item->stok_minimum ? 'text-danger' : 'text-success' }}">
                    {{ $item->stok }}
                  </span>
                </td>
                <td>{{ $item->stok_minimum }}</td>
                <td><span class="badge badge-opacity-info">{{ $item->satuan }}</span></td>
                @if(auth()->user()->role === 'admin')
                <td>
                  <a href="{{ route('barang.edit', $item->id) }}" class="btn btn-warning btn-sm text-white" title="Edit"><i class="mdi mdi-pencil"></i></a>
                  <button type="button" class="btn btn-danger btn-sm text-white" onclick="confirmDelete('delete-form-{{ $item->id }}')" title="Hapus"><i class="mdi mdi-delete"></i></button>
                  <form id="delete-form-{{ $item->id }}" action="{{ route('barang.destroy', $item->id) }}" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                  </form>
                </td>
                @endif
              </tr>
              @empty
              <tr>
                <td colspan="{{ auth()->user()->role === 'admin' ? 11 : 10 }}" class="text-center text-muted">Data Barang Kosong</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="mt-3">
          {{ $barang->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
