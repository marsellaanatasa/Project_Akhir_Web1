-+@extends('layouts.admin')

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="home-tab">
      
      <!-- Summary Cards -->
      <div class="row mb-4">
        <div class="col-sm-12">
          <div class="statistics-details d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="card p-3 shadow-sm flex-fill border-0 bg-white" style="min-width: 200px;">
              <div class="d-flex align-items-center justify-content-between">
                <div>
                  <p class="statistics-title mb-1 text-muted" style="font-size: 13px;">Total Barang</p>
                  <h3 class="rate-percentage fw-bold text-primary mb-0" style="font-size: 24px;">{{ $totalBarang }}</h3>
                  <small class="text-muted" style="font-size: 11px;">Master Item</small>
                </div>
                <i class="mdi mdi-package-variant-closed text-primary" style="font-size: 2.5rem;"></i>
              </div>
            </div>
            <div class="card p-3 shadow-sm flex-fill border-0 bg-white" style="min-width: 200px;">
              <div class="d-flex align-items-center justify-content-between">
                <div>
                  <p class="statistics-title mb-1 text-muted" style="font-size: 13px;">Total Stok</p>
                  <h3 class="rate-percentage fw-bold text-success mb-0" style="font-size: 24px;">{{ $totalStok ?? 0 }}</h3>
                  <small class="text-muted" style="font-size: 11px;">Item Tersedia</small>
                </div>
                <i class="mdi mdi-buffer text-success" style="font-size: 2.5rem;"></i>
              </div>
            </div>
            <div class="card p-3 shadow-sm flex-fill border-0 bg-white" style="min-width: 200px;">
              <div class="d-flex align-items-center justify-content-between">
                <div>
                  <p class="statistics-title mb-1 text-muted" style="font-size: 13px;">Stok Kritis</p>
                  <h3 class="rate-percentage fw-bold text-danger mb-0" style="font-size: 24px;">{{ $stokKritis }}</h3>
                  <small class="text-muted" style="font-size: 11px;">Perlu Restock</small>
                </div>
                <i class="mdi mdi-alert-circle-outline text-danger" style="font-size: 2.5rem;"></i>
              </div>
            </div>
            <div class="card p-3 shadow-sm flex-fill border-0 bg-white" style="min-width: 200px;">
              <div class="d-flex align-items-center justify-content-between">
                <div>
                  <p class="statistics-title mb-1 text-muted" style="font-size: 13px;">Total Transaksi</p>
                  <h3 class="rate-percentage fw-bold text-info mb-0" style="font-size: 24px;">{{ $totalTransaksi }}</h3>
                  <small class="text-muted" style="font-size: 11px;">Beli & Jual</small>
                </div>
                <i class="mdi mdi-swap-horizontal text-info" style="font-size: 2.5rem;"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Charts Section -->
      <div class="row">
        <!-- Chart 1: Pembelian vs Penjualan -->
        <div class="col-lg-8 grid-margin stretch-card mb-4">
          <div class="card card-rounded shadow-sm">
            <div class="card-body">
              <h4 class="card-title card-title-dash fw-bold">Overview Transaksi (6 Bulan Terakhir)</h4>
              <p class="card-subtitle card-subtitle-dash text-muted">Statistik nilai transaksi pembelian (stok masuk) vs penjualan (stok keluar)</p>
              <div class="chartjs-wrapper mt-3" style="height: 300px; position: relative;">
                <canvas id="transactionChart"></canvas>
              </div>
            </div>
          </div>
        </div>

        <!-- Chart 2: Komposisi Kategori -->
        <div class="col-lg-4 grid-margin stretch-card mb-4">
          <div class="card card-rounded shadow-sm">
            <div class="card-body">
              <h4 class="card-title card-title-dash fw-bold">Komposisi Kategori</h4>
              <p class="card-subtitle card-subtitle-dash text-muted">Jumlah varian barang per kategori</p>
              <div class="chartjs-wrapper mt-3" style="height: 300px; position: relative;">
                <canvas id="categoryChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-2">
        <!-- Chart 3: Top Selling -->
        <div class="col-lg-4 grid-margin stretch-card mb-4">
          <div class="card card-rounded shadow-sm">
            <div class="card-body">
              <h4 class="card-title card-title-dash fw-bold">Top 5 Barang Terlaris</h4>
              <p class="card-subtitle card-subtitle-dash text-muted">Berdasarkan total kuantitas penjualan</p>
              <div class="chartjs-wrapper mt-3" style="height: 300px; position: relative;">
                <canvas id="topBarangChart"></canvas>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Activities & Low Stock lists -->
        <div class="col-lg-8 grid-margin stretch-card mb-4">
          <div class="card card-rounded shadow-sm">
            <div class="card-body">
              <h4 class="card-title card-title-dash fw-bold">Aktivitas Mutasi Stok Terbaru</h4>
              <p class="card-subtitle card-subtitle-dash text-muted">Log keluar masuk barang secara real-time</p>
              <div class="table-responsive mt-3">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Waktu</th>
                      <th>Barang</th>
                      <th>Tipe</th>
                      <th class="text-center">Jumlah</th>
                      <th class="text-center">Stok Akhir</th>
                      <th>Pencatat</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($recentMutasi as $mutasi)
                    <tr>
                      <td>{{ $mutasi->created_at->format('d/m/Y H:i') }}</td>
                      <td>
                        <div class="d-flex flex-column">
                          <strong class="text-black">{{ $mutasi->barang->nama_barang }}</strong>
                          <small class="text-muted">{{ $mutasi->barang->kode_barang }}</small>
                        </div>
                      </td>
                      <td>
                        @if($mutasi->jenis_transaksi == 'pembelian')
                          <span class="badge bg-success">Stok Masuk (Beli)</span>
                        @elseif($mutasi->jenis_transaksi == 'penjualan')
                          <span class="badge bg-danger">Stok Keluar (Jual)</span>
                        @else
                          <span class="badge bg-warning">{{ ucfirst($mutasi->jenis_transaksi) }}</span>
                        @endif
                      </td>
                      <td class="text-center">
                        <span class="fw-bold {{ $mutasi->jenis_transaksi == 'pembelian' ? 'text-success' : 'text-danger' }}">
                          {{ $mutasi->jenis_transaksi == 'pembelian' ? '+' : '-' }}{{ $mutasi->jumlah }}
                        </span>
                      </td>
                      <td class="text-center fw-bold">{{ $mutasi->stok_akhir }}</td>
                      <td>{{ $mutasi->user->name }}</td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="6" class="text-center text-muted">Belum ada aktivitas mutasi barang.</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>
@endsection

@section('scripts')
<!-- ChartJS via CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // 1. Transaction Chart (Pembelian vs Penjualan)
    const ctxTx = document.getElementById('transactionChart').getContext('2d');
    new Chart(ctxTx, {
      type: 'bar',
      data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [
          {
            label: 'Pembelian (Stok Masuk)',
            data: {!! json_encode($chartBeli) !!},
            backgroundColor: '#4B49AC',
            borderColor: '#4B49AC',
            borderWidth: 1,
            borderRadius: 5
          },
          {
            label: 'Penjualan (Stok Keluar)',
            data: {!! json_encode($chartJual) !!},
            backgroundColor: '#FF4747',
            borderColor: '#FF4747',
            borderWidth: 1,
            borderRadius: 5
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
              }
            }
          }
        },
        plugins: {
          tooltip: {
            callbacks: {
              label: function(context) {
                let label = context.dataset.label || '';
                if (label) {
                  label += ': ';
                }
                if (context.parsed.y !== null) {
                  label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                }
                return label;
              }
            }
          }
        }
      }
    });

    // 2. Category Chart (Pie/Doughnut)
    const ctxCat = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctxCat, {
      type: 'doughnut',
      data: {
        labels: {!! json_encode($kategoriLabels) !!},
        datasets: [{
          data: {!! json_encode($kategoriValues) !!},
          backgroundColor: [
            '#FFC107',
            '#28A745',
            '#17A2B8',
            '#6F42C1',
            '#E83E8C',
            '#FD7E14'
          ]
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });

    // 3. Top Barang Chart
    const ctxTop = document.getElementById('topBarangChart').getContext('2d');
    new Chart(ctxTop, {
      type: 'bar',
      data: {
        labels: {!! json_encode($topBarangLabels) !!},
        datasets: [{
          label: 'Jumlah Terjual',
          data: {!! json_encode($topBarangValues) !!},
          backgroundColor: '#FF8A00',
          borderColor: '#FF8A00',
          borderWidth: 1,
          borderRadius: 5
        }]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            beginAtZero: true
          }
        }
      }
    });
  });
</script>
@endsection
