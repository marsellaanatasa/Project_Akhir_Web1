@extends('layouts.admin')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card card-rounded shadow-sm">
      <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start mb-4">
          <div>
            <h4 class="card-title card-title-dash">Kategori Barang</h4>
            <p class="card-subtitle card-subtitle-dash">Kelola kategori barang inventaris Anda</p>
          </div>
          @if(auth()->user()->role === 'admin')
          <div>
            <a href="{{ route('kategori.create') }}" class="btn btn-primary text-white btn-lg"><i class="mdi mdi-plus"></i> Tambah Kategori</a>
          </div>
          @endif
        </div>
        
        <div class="d-flex justify-content-between align-items-center mb-3">
          <form action="{{ route('kategori.index') }}" method="GET" class="d-flex align-items-center w-50">
            <input type="text" name="search" class="form-control" placeholder="Cari kategori..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary ms-2 text-white" style="height: 38px;">Cari</button>
            @if(request('search'))
              <a href="{{ route('kategori.index') }}" class="btn btn-light ms-1" style="height: 38px; display: flex; align-items: center;">Reset</a>
            @endif
          </form>
        </div>

        <div class="table-responsive">
          <table class="table table-hover select-table">
            <thead>
              <tr>
                <th width="80px">No</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                @if(auth()->user()->role === 'admin')
                <th width="150px">Aksi</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @forelse($kategori as $index => $item)
              <tr>
                <td>{{ $kategori->firstItem() + $index }}</td>
                <td>
                  <div class="d-flex">
                    <div>
                      <h6>{{ $item->nama_kategori }}</h6>
                    </div>
                  </div>
                </td>
                <td>{{ $item->deskripsi ?? '-' }}</td>
                @if(auth()->user()->role === 'admin')
                <td>
                  <a href="{{ route('kategori.edit', $item->id) }}" class="btn btn-warning btn-sm text-white" title="Edit"><i class="mdi mdi-pencil"></i></a>
                  <button type="button" class="btn btn-danger btn-sm text-white" onclick="confirmDelete('delete-form-{{ $item->id }}')" title="Hapus"><i class="mdi mdi-delete"></i></button>
                  <form id="delete-form-{{ $item->id }}" action="{{ route('kategori.destroy', $item->id) }}" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                  </form>
                </td>
                @endif
              </tr>
              @empty
              <tr>
                <td colspan="{{ auth()->user()->role === 'admin' ? 4 : 3 }}" class="text-center text-muted">Data Kategori Kosong</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="mt-3">
          {{ $kategori->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
