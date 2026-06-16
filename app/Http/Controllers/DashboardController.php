<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\MutasiStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the inventory dashboard.
     */
    public function index()
    {
        $totalBarang = Barang::count();
        $totalStok = Barang::sum('stok');
        $stokKritis = Barang::whereColumn('stok', '<=', 'stok_minimum')->count();
        $totalTransaksi = Pembelian::count() + Penjualan::count();

        $barangKritis = Barang::with('kategori')
            ->whereColumn('stok', '<=', 'stok_minimum')
            ->limit(5)
            ->get();

        $recentMutasi = MutasiStok::with(['barang', 'user'])
            ->latest()
            ->limit(5)
            ->get();

        // 1. Chart.js Data: Pembelian vs Penjualan Bulanan (6 bulan terakhir)
        $monthlyData = DB::table(DB::raw('(SELECT DATE_FORMAT(tanggal_pembelian, "%Y-%m") as month, SUM(total_harga) as total, "pembelian" as type FROM pembelian WHERE deleted_at IS NULL GROUP BY month
            UNION ALL
            SELECT DATE_FORMAT(tanggal_penjualan, "%Y-%m") as month, SUM(total_harga) as total, "penjualan" as type FROM penjualan WHERE deleted_at IS NULL GROUP BY month) as combined'))
            ->select('month', 
                DB::raw('SUM(CASE WHEN type = "pembelian" THEN total ELSE 0 END) as total_beli'),
                DB::raw('SUM(CASE WHEN type = "penjualan" THEN total ELSE 0 END) as total_jual')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->limit(6)
            ->get();

        $chartBulan = [];
        $chartBeli = [];
        $chartJual = [];

        // Prepopulate past 6 months
        for ($i = 5; $i >= 0; $i--) {
            $monthStr = date('Y-m', strtotime("-$i months"));
            $chartBulan[$monthStr] = date('M Y', strtotime("-$i months"));
            $chartBeli[$monthStr] = 0;
            $chartJual[$monthStr] = 0;
        }

        foreach ($monthlyData as $row) {
            if (isset($chartBulan[$row->month])) {
                $chartBeli[$row->month] = (float)$row->total_beli;
                $chartJual[$row->month] = (float)$row->total_jual;
            }
        }

        // 2. Chart.js Data: Komposisi Kategori (Pie Chart)
        $kategoriComposition = Kategori::withCount('barang')
            ->get()
            ->map(function ($kategori) {
                return [
                    'label' => $kategori->nama_kategori,
                    'value' => $kategori->barang_count,
                ];
            });

        // 3. Chart.js Data: Top 5 Barang Terlaris (Bar Chart)
        $topBarang = DB::table('detail_penjualan')
            ->join('barang', 'detail_penjualan.barang_id', '=', 'barang.id')
            ->select('barang.nama_barang', DB::raw('SUM(detail_penjualan.jumlah) as total_terjual'))
            ->groupBy('barang.nama_barang')
            ->orderBy('total_terjual', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'totalBarang' => $totalBarang,
            'totalStok' => $totalStok,
            'stokKritis' => $stokKritis,
            'totalTransaksi' => $totalTransaksi,
            'barangKritis' => $barangKritis,
            'recentMutasi' => $recentMutasi,
            'chartLabels' => array_values($chartBulan),
            'chartBeli' => array_values($chartBeli),
            'chartJual' => array_values($chartJual),
            'kategoriLabels' => $kategoriComposition->pluck('label')->toArray(),
            'kategoriValues' => $kategoriComposition->pluck('value')->toArray(),
            'topBarangLabels' => $topBarang->pluck('nama_barang')->toArray(),
            'topBarangValues' => $topBarang->pluck('total_terjual')->toArray(),
        ]);
    }
}
