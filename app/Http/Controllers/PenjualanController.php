<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Barang;
use App\Models\MutasiStok;
use App\Http\Requests\PenjualanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Penjualan::with('user');
        if ($request->filled('search')) {
            $query->where('nomor_faktur', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_pelanggan', 'like', '%' . $request->search . '%');
        }
        $penjualan = $query->latest()->paginate(10);

        return view('penjualan.index', compact('penjualan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barang = Barang::where('stok', '>', 0)->get();
        $nomorFaktur = 'INV-OUT-' . date('YmdHis');

        return view('penjualan.create', compact('barang', 'nomorFaktur'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PenjualanRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::transaction(function () use ($validated) {
                $totalHarga = 0;

                // 1. Validasi Stok Terlebih Dahulu (Pencegahan Stok Negatif)
                $barangList = [];
                foreach ($validated['barang_id'] as $index => $barangId) {
                    $jumlah = $validated['jumlah'][$index];
                    $barang = Barang::findOrFail($barangId);

                    if ($barang->stok < $jumlah) {
                        throw new \Exception("Stok untuk barang '{$barang->nama_barang}' tidak mencukupi! Stok saat ini: {$barang->stok}, permintaan: {$jumlah}.");
                    }

                    $barangList[] = [
                        'barang' => $barang,
                        'jumlah' => $jumlah,
                        'harga_jual' => $barang->harga_jual,
                    ];
                }

                // 2. Buat Transaksi Penjualan
                $penjualan = Penjualan::create([
                    'nomor_faktur' => $validated['nomor_faktur'],
                    'nama_pelanggan' => $validated['nama_pelanggan'] ?? 'Pelanggan Umum',
                    'telepon_pelanggan' => $validated['telepon_pelanggan'] ?? null,
                    'user_id' => Auth::id(),
                    'tanggal_penjualan' => $validated['tanggal_penjualan'],
                    'total_harga' => 0,
                    'metode_pembayaran' => $validated['metode_pembayaran'],
                    'catatan' => $validated['catatan'] ?? null,
                ]);

                // 3. Simpan Detail & Kurangi Stok & Log Mutasi
                foreach ($barangList as $itemData) {
                    $barang = $itemData['barang'];
                    $jumlah = $itemData['jumlah'];
                    $hargaJual = $itemData['harga_jual'];
                    $subtotal = $jumlah * $hargaJual;
                    $totalHarga += $subtotal;

                    DetailPenjualan::create([
                        'penjualan_id' => $penjualan->id,
                        'barang_id' => $barang->id,
                        'jumlah' => $jumlah,
                        'harga_jual' => $hargaJual,
                        'subtotal' => $subtotal,
                    ]);

                    // Kurangi stok barang
                    $barang->decrement('stok', $jumlah);

                    // Catat mutasi stok
                    MutasiStok::create([
                        'barang_id' => $barang->id,
                        'user_id' => Auth::id(),
                        'jenis_transaksi' => 'penjualan',
                        'jumlah' => $jumlah,
                        'stok_akhir' => $barang->stok,
                        'referensi_tipe' => 'Penjualan',
                        'referensi_id' => $penjualan->id,
                        'keterangan' => 'Penjualan barang keluar dengan Faktur: ' . $penjualan->nomor_faktur,
                    ]);
                }

                // 4. Update total harga final
                $penjualan->update(['total_harga' => $totalHarga]);
            });

            return redirect()->route('penjualan.index')->with('success', 'Transaksi penjualan berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Penjualan $penjualan)
    {
        $penjualan->load(['user', 'detailPenjualan.barang']);

        return view('penjualan.show', compact('penjualan'));
    }
}
