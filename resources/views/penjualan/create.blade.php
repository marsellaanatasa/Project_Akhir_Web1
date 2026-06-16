@extends('layouts.admin')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="card-title">Transaksi Penjualan Baru (Stok Keluar)</h4>
        <p class="card-description">Pencatatan barang keluar ke pelanggan</p>
        
        @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0 ps-3">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('penjualan.store') }}" id="transaction-form">
          @csrf
          
          <div class="row mb-4">
            <div class="col-md-3 mb-3">
              <label for="nomor_faktur" class="fw-bold mb-1">Nomor Faktur</label>
              <input type="text" name="nomor_faktur" class="form-control" id="nomor_faktur" value="{{ old('nomor_faktur', $nomorFaktur) }}" required readonly>
            </div>
            <div class="col-md-3 mb-3">
              <label for="nama_pelanggan" class="fw-bold mb-1">Nama Pelanggan</label>
              <input type="text" name="nama_pelanggan" class="form-control" id="nama_pelanggan" placeholder="Nama Pelanggan / Umum" value="{{ old('nama_pelanggan') }}">
            </div>
            <div class="col-md-3 mb-3">
              <label for="telepon_pelanggan" class="fw-bold mb-1">Telepon Pelanggan</label>
              <input type="text" name="telepon_pelanggan" class="form-control" id="telepon_pelanggan" placeholder="08xxxxxxxx" value="{{ old('telepon_pelanggan') }}">
            </div>
            <div class="col-md-3 mb-3">
              <label for="tanggal_penjualan" class="fw-bold mb-1">Tanggal Penjualan</label>
              <input type="date" name="tanggal_penjualan" class="form-control" id="tanggal_penjualan" value="{{ old('tanggal_penjualan', date('Y-m-d')) }}" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="metode_pembayaran" class="fw-bold mb-1">Metode Pembayaran</label>
              <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" style="height: 2.875rem;" required>
                <option value="tunai" {{ old('metode_pembayaran') == 'tunai' ? 'selected' : '' }}>Tunai / Cash</option>
                <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
              </select>
            </div>
            <div class="col-md-8 mb-3">
              <label for="catatan" class="fw-bold mb-1">Catatan</label>
              <input type="text" name="catatan" class="form-control" id="catatan" placeholder="Keterangan tambahan (opsional)" value="{{ old('catatan') }}">
            </div>
          </div>

          <h5 class="card-subtitle mb-3 fw-bold text-danger">Detail Barang Penjualan</h5>
          
          <div class="table-responsive mb-4">
            <table class="table table-bordered align-middle" id="items-table">
              <thead class="table-light">
                <tr>
                  <th>Nama Barang</th>
                  <th width="150px" class="text-center">Stok Tersedia</th>
                  <th width="180px" class="text-end">Harga Jual (Rp)</th>
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
                  <th colspan="4" class="text-end">Total Penjualan</th>
                  <th id="grand-total" class="fw-bold fs-5 text-danger text-end">Rp 0</th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>

          <div class="mb-4">
            <button type="button" class="btn btn-outline-danger btn-sm text-black" id="add-row-btn"><i class="mdi mdi-plus"></i> Tambah Baris Barang</button>
          </div>

          <div class="mt-4">
            <button type="submit" class="btn btn-danger text-white me-2 btn-lg">Simpan Transaksi</button>
            <a href="{{ route('penjualan.index') }}" class="btn btn-light btn-lg">Batal</a>
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
            <option value="{{ $item->id }}" data-price="{{ (int)$item->harga_jual }}" data-stock="{{ $item->stok }}">{{ $item->kode_barang }} - {{ $item->nama_barang }} (Stok: {{ $item->stok }})</option>
          @endforeach
        </select>
      </td>
      <td class="stock-val text-center fw-bold text-muted">-</td>
      <td class="price-val text-end">-</td>
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
      const select = row.querySelector('.barang-select');
      const selectedOption = select.options[select.selectedIndex];
      const price = selectedOption ? parseFloat(selectedOption.getAttribute('data-price')) || 0 : 0;
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
        if (selectedOption && selectedOption.value) {
          const price = selectedOption.getAttribute('data-price') || 0;
          const stock = selectedOption.getAttribute('data-stock') || 0;
          
          clone.querySelector('.price-val').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
          clone.querySelector('.stock-val').innerText = stock;
          clone.querySelector('.stock-val').className = parseInt(stock) <= 0 ? 'stock-val text-center fw-bold text-danger' : 'stock-val text-center fw-bold text-success';
          
          // Max limit qty based on stock
          clone.querySelector('.qty-input').setAttribute('max', stock);
        } else {
          clone.querySelector('.price-val').innerText = '-';
          clone.querySelector('.stock-val').innerText = '-';
          clone.querySelector('.stock-val').className = 'stock-val text-center fw-bold text-muted';
        }
        calculateGrandTotal();
      });

      // Qty change event
      clone.querySelector('.qty-input').addEventListener('input', function() {
        const select = clone.querySelector('.barang-select');
        const selectedOption = select.options[select.selectedIndex];
        if (selectedOption) {
          const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
          const qty = parseInt(clone.querySelector('.qty-input').value) || 0;
          if (qty > stock) {
            Swal.fire({
              icon: 'warning',
              title: 'Stok Kurang!',
              text: 'Stok tersedia hanya ' + stock + ' pcs. Anda menginput ' + qty + ' pcs.',
              confirmButtonText: 'OK'
            });
            clone.querySelector('.qty-input').value = stock;
          }
        }
        calculateGrandTotal();
      });

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
        return;
      }

      // Check stock client side
      let stockIssue = false;
      container.querySelectorAll('tr').forEach(row => {
        const select = row.querySelector('.barang-select');
        const selectedOption = select.options[select.selectedIndex];
        if (selectedOption) {
          const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
          const qty = parseInt(row.querySelector('.qty-input').value) || 0;
          if (qty > stock) {
            stockIssue = true;
          }
        }
      });

      if (stockIssue) {
        e.preventDefault();
        Swal.fire({
          icon: 'error',
          title: 'Transaksi Batal!',
          text: 'Terdapat barang dengan jumlah melebihi stok yang tersedia!',
          confirmButtonText: 'Tutup'
        });
      }
    });

    // Add first row automatically
    addRow();
  });
</script>
@endsection
