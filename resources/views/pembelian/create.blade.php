@extends('layouts.admin')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="card-title">Transaksi Pembelian Baru (Stok Masuk)</h4>
        <p class="card-description">Penerimaan barang masuk dari supplier</p>
        
        @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0 ps-3">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('pembelian.store') }}" id="transaction-form">
          @csrf
          
          <div class="row mb-4">
            <div class="col-md-4 mb-3">
              <label for="nomor_faktur" class="fw-bold mb-1">Nomor Faktur</label>
              <input type="text" name="nomor_faktur" class="form-control" id="nomor_faktur" value="{{ old('nomor_faktur', $nomorFaktur) }}" required readonly>
            </div>
            <div class="col-md-4 mb-3">
              <label for="supplier_id" class="fw-bold mb-1">Supplier</label>
              <select name="supplier_id" id="supplier_id" class="form-select" style="height: 2.875rem;" required>
                <option value="">Pilih Supplier</option>
                @foreach($supplier as $sup)
                  <option value="{{ $sup->id }}" {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>{{ $sup->nama_supplier }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="tanggal_pembelian" class="fw-bold mb-1">Tanggal Pembelian</label>
              <input type="date" name="tanggal_pembelian" class="form-control" id="tanggal_pembelian" value="{{ old('tanggal_pembelian', date('Y-m-d')) }}" required>
            </div>
            <div class="col-12 mb-3">
              <label for="catatan" class="fw-bold mb-1">Catatan</label>
              <textarea name="catatan" class="form-control" id="catatan" rows="3" placeholder="Catatan transaksi (opsional)">{{ old('catatan') }}</textarea>
            </div>
          </div>

          <h5 class="card-subtitle mb-3 fw-bold text-primary">Detail Barang Pembelian</h5>
          
          <div class="table-responsive mb-4">
            <table class="table table-bordered align-middle" id="items-table">
              <thead class="table-light">
                <tr>
                  <th>Nama Barang</th>
                  <th width="180px">Harga Beli (Rp)</th>
                  <th width="120px">Jumlah</th>
                  <th width="180px" class="text-end">Subtotal (Rp)</th>
                  <th width="80px" class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody id="items-container">
                <!-- Dynamic rows will be inserted here -->
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="3" class="text-end">Total Pembelian</th>
                  <th id="grand-total" class="fw-bold fs-5 text-primary text-end">Rp 0</th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>

          <div class="mb-4">
            <button type="button" class="btn btn-outline-primary btn-sm text-black" id="add-row-btn"><i class="mdi mdi-plus"></i> Tambah Baris Barang</button>
          </div>

          <div class="mt-4">
            <button type="submit" class="btn btn-primary text-white me-2 btn-lg">Simpan Transaksi</button>
            <a href="{{ route('pembelian.index') }}" class="btn btn-light btn-lg">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Hidden template for duplication -->
<table class="d-none">
  <tbody id="row-template">
    <tr>
      <td>
        <select name="barang_id[]" class="form-select barang-select" required>
          <option value="">Pilih Barang</option>
          @foreach($barang as $item)
            <option value="{{ $item->id }}" data-price="{{ (int)$item->harga_beli }}">{{ $item->kode_barang }} - {{ $item->nama_barang }}</option>
          @endforeach
        </select>
      </td>
      <td>
        <input type="number" name="harga_beli[]" class="form-control price-input" placeholder="0" min="0" required>
      </td>
      <td>
        <input type="number" name="jumlah[]" class="form-control qty-input" placeholder="1" min="1" value="1" required>
      </td>
      <td class="subtotal-val fw-bold text-end">0</td>
      <td class="text-center">
        <button type="button" class="btn btn-danger btn-sm text-white remove-row-btn"><i class="mdi mdi-close"></i></button>
      </td>
    </tr>
  </tbody>
</table>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('items-container');
    const template = document.getElementById('row-template').querySelector('tr');
    const addRowBtn = document.getElementById('add-row-btn');
    const grandTotalEl = document.getElementById('grand-total');

    function calculateRowSubtotal(row) {
      const price = parseFloat(row.querySelector('.price-input').value) || 0;
      const qty = parseInt(row.querySelector('.qty-input').value) || 0;
      const subtotal = price * qty;
      row.querySelector('.subtotal-val').innerText = new Intl.NumberFormat('id-ID').format(subtotal);
      return subtotal;
    }

    function calculateGrandTotal() {
      let total = 0;
      container.querySelectorAll('tr').forEach(row => {
        total += calculateRowSubtotal(row);
      });
      grandTotalEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }

    function addRow() {
      const clone = template.cloneNode(true);
      
      // Select change event
      const select = clone.querySelector('.barang-select');
      select.addEventListener('change', function() {
        const selectedOption = select.options[select.selectedIndex];
        const price = selectedOption.getAttribute('data-price') || 0;
        clone.querySelector('.price-input').value = price;
        calculateGrandTotal();
      });

      // Price/Qty change event
      clone.querySelector('.price-input').addEventListener('input', calculateGrandTotal);
      clone.querySelector('.qty-input').addEventListener('input', calculateGrandTotal);

      // Remove row event
      clone.querySelector('.remove-row-btn').addEventListener('click', function() {
        clone.remove();
        calculateGrandTotal();
      });

      container.appendChild(clone);
      calculateGrandTotal();
    }

    addRowBtn.addEventListener('click', addRow);

    // Form submit validation
    document.getElementById('transaction-form').addEventListener('submit', function(e) {
      if (container.children.length === 0) {
        e.preventDefault();
        Swal.fire({
          icon: 'warning',
          title: 'Perhatian!',
          text: 'Harap tambahkan minimal 1 barang dalam daftar transaksi!',
          confirmButtonText: 'Tutup'
        });
      }
    });

    // Add first row automatically
    addRow();
  });
</script>
@endsection
