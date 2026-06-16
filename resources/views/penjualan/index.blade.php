@extends('layouts.admin')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card card-rounded shadow-sm">
      <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start mb-4">
          <div>
            <h4 class="card-title card-title-dash">Transaksi Penjualan (Stok Keluar)</h4>
            <p class="card-subtitle card-subtitle-dash">Histori penjualan barang ke pelanggan</p>
          </div>
          <div>
            <a href="{{ route('penjualan.create') }}" class="btn btn-primary text-white btn-lg"><i class="mdi mdi-plus"></i> Transaksi Baru</a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between align-items-center mb-3">
          <form action="{{ route('penjualan.index') }}" method="GET" class="d-flex align-items-center w-50">
            <input type="text" name="search" class="form-control" placeholder="Cari faktur atau pelanggan..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary ms-2 text-white" style="height: 38px;">Cari</button>
            @if(request('search'))
              <a href="{{ route('penjualan.index') }}" class="btn btn-light ms-1" style="height: 38px; display: flex; align-items: center;">Reset</a>
            @endif
          </form>
        </div>

        <div class="table-responsive">
          <table class="table table-hover select-table">
            <thead>
              <tr>
                <th width="80px">No</th>
                <th>Nomor Faktur</th>
                <th>Nama Pelanggan</th>
                <th>Telepon</th>
                <th>Tanggal Penjualan</th>
                <th>Total Pendapatan</th>
                <th>Pencatat</th>
                <th>Metode</th>
                <th width="100px">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($penjualan as $index => $item)
              <tr>
                <td>{{ $penjualan->firstItem() + $index }}</td>
                <td><span class="badge bg-danger">{{ $item->nomor_faktur }}</span></td>
                <td>{{ $item->nama_pelanggan ?? 'Pelanggan Umum' }}</td>
                <td>{{ $item->telepon_pelanggan ?? '-' }}</td>
                <td>{{ $item->tanggal_penjualan->format('d/m/Y') }}</td>
                <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                <td>{{ $item->user->name }}</td>
                <td><span class="badge bg-info text-white">{{ strtoupper($item->metode_pembayaran) }}</span></td>
                <td>
                  <a href="{{ route('penjualan.show', $item->id) }}" class="btn btn-info btn-sm text-white" title="Detail"><i class="mdi mdi-eye"></i></a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="9" class="text-center text-muted">Data Penjualan Kosong</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="mt-3">
          {{ $penjualan->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
