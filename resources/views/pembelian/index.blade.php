@extends('layouts.admin')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card card-rounded shadow-sm">
      <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start mb-4">
          <div>
            <h4 class="card-title card-title-dash">Transaksi Pembelian (Stok Masuk)</h4>
            <p class="card-subtitle card-subtitle-dash">Histori pembelian barang dari supplier</p>
          </div>
          <div>
            <a href="{{ route('pembelian.create') }}" class="btn btn-primary text-white btn-lg"><i class="mdi mdi-plus"></i> Transaksi Baru</a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between align-items-center mb-3">
          <form action="{{ route('pembelian.index') }}" method="GET" class="d-flex align-items-center w-50">
            <input type="text" name="search" class="form-control" placeholder="Cari nomor faktur..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary ms-2 text-white" style="height: 38px;">Cari</button>
            @if(request('search'))
              <a href="{{ route('pembelian.index') }}" class="btn btn-light ms-1" style="height: 38px; display: flex; align-items: center;">Reset</a>
            @endif
          </form>
        </div>

        <div class="table-responsive">
          <table class="table table-hover select-table">
            <thead>
              <tr>
                <th width="80px">No</th>
                <th>Nomor Faktur</th>
                <th>Supplier</th>
                <th>Tanggal Pembelian</th>
                <th>Total Harga</th>
                <th>Pencatat</th>
                <th>Status</th>
                <th width="100px">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($pembelian as $index => $item)
              <tr>
                <td>{{ $pembelian->firstItem() + $index }}</td>
                <td><span class="badge bg-primary">{{ $item->nomor_faktur }}</span></td>
                <td>{{ $item->supplier->nama_supplier }}</td>
                <td>{{ $item->tanggal_pembelian->format('d/m/Y') }}</td>
                <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                <td>{{ $item->user->name }}</td>
                <td><span class="badge bg-success">Selesai</span></td>
                <td>
                  <a href="{{ route('pembelian.show', $item->id) }}" class="btn btn-info btn-sm text-white" title="Detail"><i class="mdi mdi-eye"></i></a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="8" class="text-center text-muted">Data Pembelian Kosong</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="mt-3">
          {{ $pembelian->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
