<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\MutasiStok;
use App\Http\Requests\PembelianRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pembelian::with(['supplier', 'user']);
        if ($request->filled('search')) {
            $query->where('nomor_faktur', 'like', '%' . $request->search . '%');
        }
        $pembelian = $query->latest()->paginate(10);

        return view('pembelian.index', compact('pembelian'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $supplier = Supplier::all();
        $barang = Barang::all();
        $nomorFaktur = 'INV-IN-' . date('YmdHis');

        return view('pembelian.create', compact('supplier', 'barang', 'nomorFaktur'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PembelianRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::transaction(function () use ($validated) {
                $totalHarga = 0;

                // 1. Buat Transaksi Pembelian
                $pembelian = Pembelian::create([
                    'nomor_faktur' => $validated['nomor_faktur'],
                    'supplier_id' => $validated['supplier_id'],
                    'user_id' => Auth::id(),
                    'tanggal_pembelian' => $validated['tanggal_pembelian'],
                    'total_harga' => 0,
                    'status' => 'selesai',
                    'catatan' => $validated['catatan'] ?? null,
                ]);

                // 2. Simpan Detail & Update Stok
                foreach ($validated['barang_id'] as $index => $barangId) {
                    $jumlah = $validated['jumlah'][$index];
                    $hargaBeli = $validated['harga_beli'][$index];
                    $subtotal = $jumlah * $hargaBeli;
                    $totalHarga += $subtotal;

                    DetailPembelian::create([
                        'pembelian_id' => $pembelian->id,
                        'barang_id' => $barangId,
                        'jumlah' => $jumlah,
                        'harga_beli' => $hargaBeli,
                        'subtotal' => $subtotal,
                    ]);

                    // Update stok barang
                    $barang = Barang::findOrFail($barangId);
                    $barang->increment('stok', $jumlah);

                    // Catat mutasi stok
                    MutasiStok::create([
                        'barang_id' => $barangId,
                        'user_id' => Auth::id(),
                        'jenis_transaksi' => 'pembelian',
                        'jumlah' => $jumlah,
                        'stok_akhir' => $barang->stok,
                        'referensi_tipe' => 'Pembelian',
                        'referensi_id' => $pembelian->id,
                        'keterangan' => 'Pembelian barang masuk dengan Faktur: ' . $pembelian->nomor_faktur,
                    ]);
                }

                // 3. Update total harga final
                $pembelian->update(['total_harga' => $totalHarga]);
            });

            return redirect()->route('pembelian.index')->with('success', 'Transaksi pembelian berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembelian $pembelian)
    {
        $pembelian->load(['supplier', 'user', 'detailPembelian.barang']);

        return view('pembelian.show', compact('pembelian'));
    }
}
