@extends('layouts.admin')

@section('content')
<div class="row">
  <div class="col-lg-8 mx-auto grid-margin stretch-card">
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
          <div>
            <h4 class="card-title">Detail Pembelian</h4>
            <p class="card-description">Faktur: <span class="badge bg-primary fs-6">{{ $pembelian->nomor_faktur }}</span></p>
          </div>
          <div>
            <a href="{{ route('pembelian.index') }}" class="btn btn-light"><i class="mdi mdi-arrow-left"></i> Kembali</a>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-md-6 mb-3">
            <h6 class="fw-bold mb-1">Informasi Supplier:</h6>
            <p class="mb-0 fw-semibold">{{ $pembelian->supplier->nama_supplier }}</p>
            <p class="mb-0 text-muted small">PIC: {{ $pembelian->supplier->kontak_person ?? '-' }}</p>
            <p class="mb-0 text-muted small">Telp: {{ $pembelian->supplier->telepon ?? '-' }}</p>
            <p class="mb-0 text-muted small">Alamat: {{ $pembelian->supplier->alamat ?? '-' }}</p>
          </div>
          <div class="col-md-6 mb-3 text-md-end">
            <h6 class="fw-bold mb-1">Detail Transaksi:</h6>
            <p class="mb-0"><strong>Tanggal:</strong> {{ $pembelian->tanggal_pembelian->format('d F Y') }}</p>
            <p class="mb-0"><strong>Pencatat:</strong> {{ $pembelian->user->name }}</p>
            <p class="mb-0"><strong>Status:</strong> <span class="badge bg-success">Selesai</span></p>
          </div>
        </div>

        <h6 class="fw-bold mb-3">Daftar Barang Masuk</h6>
        <div class="table-responsive mb-4">
          <table class="table table-bordered">
            <thead class="table-light">
              <tr>
                <th>Nama Barang</th>
                <th width="150px" class="text-end">Harga Beli</th>
                <th width="100px" class="text-center">Jumlah</th>
                <th width="180px" class="text-end">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pembelian->detailPembelian as $detail)
              <tr>
                <td>
                  <strong>{{ $detail->barang->nama_barang }}</strong><br>
                  <small class="text-muted">{{ $detail->barang->kode_barang }}</small>
                </td>
                <td class="text-end">Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                <td class="text-center">{{ $detail->jumlah }} {{ $detail->barang->satuan }}</td>
                <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th colspan="3" class="text-end">Total Pembelian</th>
                <th class="text-end text-primary fs-5">Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}</th>
              </tr>
            </tfoot>
          </table>
        </div>

        @if($pembelian->catatan)
        <div class="bg-light p-3 rounded mb-4">
          <h6 class="fw-bold">Catatan:</h6>
          <p class="mb-0">{{ $pembelian->catatan }}</p>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
