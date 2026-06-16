@extends('layouts.admin')

@section('content')
<div class="row">
  <div class="col-lg-8 mx-auto grid-margin stretch-card">
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
          <div>
            <h4 class="card-title">Detail Penjualan</h4>
            <p class="card-description">Faktur: <span class="badge bg-danger fs-6">{{ $penjualan->nomor_faktur }}</span></p>
          </div>
          <div>
            <a href="{{ route('penjualan.index') }}" class="btn btn-light"><i class="mdi mdi-arrow-left"></i> Kembali</a>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-md-6 mb-3">
            <h6 class="fw-bold mb-1">Informasi Pelanggan:</h6>
            <p class="mb-0 fw-semibold">{{ $penjualan->nama_pelanggan ?? 'Pelanggan Umum' }}</p>
            <p class="mb-0 text-muted small">Telp: {{ $penjualan->telepon_pelanggan ?? '-' }}</p>
          </div>
          <div class="col-md-6 mb-3 text-md-end">
            <h6 class="fw-bold mb-1">Detail Transaksi:</h6>
            <p class="mb-0"><strong>Tanggal:</strong> {{ $penjualan->tanggal_penjualan->format('d F Y') }}</p>
            <p class="mb-0"><strong>Pencatat:</strong> {{ $penjualan->user->name }}</p>
            <p class="mb-0"><strong>Metode Pembayaran:</strong> <span class="badge bg-info text-white">{{ strtoupper($penjualan->metode_pembayaran) }}</span></p>
          </div>
        </div>

        <h6 class="fw-bold mb-3">Daftar Barang Terjual</h6>
        <div class="table-responsive mb-4">
          <table class="table table-bordered">
            <thead class="table-light">
              <tr>
                <th>Nama Barang</th>
                <th width="150px" class="text-end">Harga Jual</th>
                <th width="100px" class="text-center">Jumlah</th>
                <th width="180px" class="text-end">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @foreach($penjualan->detailPenjualan as $detail)
              <tr>
                <td>
                  <strong>{{ $detail->barang->nama_barang }}</strong><br>
                  <small class="text-muted">{{ $detail->barang->kode_barang }}</small>
                </td>
                <td class="text-end">Rp {{ number_format($detail->harga_jual, 0, ',', '.') }}</td>
                <td class="text-center">{{ $detail->jumlah }} {{ $detail->barang->satuan }}</td>
                <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th colspan="3" class="text-end">Total Penjualan</th>
                <th class="text-end text-danger fs-5">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</th>
              </tr>
            </tfoot>
          </table>
        </div>

        @if($penjualan->catatan)
        <div class="bg-light p-3 rounded mb-4">
          <h6 class="fw-bold">Catatan:</h6>
          <p class="mb-0">{{ $penjualan->catatan }}</p>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
