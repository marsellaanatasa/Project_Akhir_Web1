<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\MutasiStok;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users (Admin & Staff)
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@inventaris.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $staff = User::create([
            'name' => 'Staff Gudang',
            'email' => 'staff@inventaris.com',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
        ]);

        $users = [$admin, $staff];

        // 2. Seed Kategori
        $kategoriList = [
            'Elektronik' => 'Perangkat komputer, laptop, dan periferal',
            'Alat Tulis Kantor' => 'Kertas, pena, map, dan perlengkapan meja',
            'Furnitur Kantor' => 'Meja, kursi, lemari arsip',
            'Sanitasi' => 'Cairan pembersih, masker, hand sanitizer',
            'Packing & Logistik' => 'Kardus, lakban, bubble wrap',
        ];

        $kategoriModels = [];
        foreach ($kategoriList as $nama => $deskripsi) {
            $kategoriModels[] = Kategori::create([
                'nama_kategori' => $nama,
                'deskripsi' => $deskripsi,
            ]);
        }

        // 3. Seed Supplier
        $supplierList = [
            [
                'nama_supplier' => 'PT. Indotech Global Perdana',
                'kontak_person' => 'Rian Hidayat',
                'email' => 'sales@indotechglobal.com',
                'telepon' => '081234567890',
                'alamat' => 'Sudirman Central Business District, Jakarta',
            ],
            [
                'nama_supplier' => 'CV. ATK Mandiri Sentosa',
                'kontak_person' => 'Susi Astuti',
                'email' => 'sales@atkmandiri.co.id',
                'telepon' => '089876543210',
                'alamat' => 'Jl. Merdeka No. 45, Bandung',
            ],
            [
                'nama_supplier' => 'PT. Office Design Furnitur',
                'kontak_person' => 'Budi Prasetyo',
                'email' => 'info@officedesign.com',
                'telepon' => '081122334455',
                'alamat' => 'Kawasan Industri Rungkut, Surabaya',
            ],
            [
                'nama_supplier' => 'CV. Hygiene & Safety Supplies',
                'kontak_person' => 'Dewi Lestari',
                'email' => 'support@hygieneindonesia.com',
                'telepon' => '082233445566',
                'alamat' => 'Jl. Diponegoro No. 12, Semarang',
            ],
        ];

        $supplierModels = [];
        foreach ($supplierList as $sup) {
            $supplierModels[] = Supplier::create($sup);
        }

        // 4. Seed Barang (Start with stock = 0, stock will be built by purchases seed)
        $barangData = [
            [
                'kode_barang' => 'BRG-ELK-001',
                'nama_barang' => 'Laptop Asus ExpertBook B1',
                'deskripsi' => 'Laptop Intel Core i5, RAM 8GB, SSD 512GB',
                'harga_beli' => 8500000.00,
                'harga_jual' => 10500000.00,
                'stok_minimum' => 3,
                'satuan' => 'unit',
                'kategori_index' => 0, // Elektronik
                'supplier_index' => 0, // Indotech
            ],
            [
                'kode_barang' => 'BRG-ELK-002',
                'nama_barang' => 'Mouse Wireless Logitech Silent M331',
                'deskripsi' => 'Mouse silent click dengan jangkauan 10 meter',
                'harga_beli' => 160000.00,
                'harga_jual' => 240000.00,
                'stok_minimum' => 5,
                'satuan' => 'pcs',
                'kategori_index' => 0,
                'supplier_index' => 0,
            ],
            [
                'kode_barang' => 'BRG-ELK-003',
                'nama_barang' => 'Monitor LED Dell 24 Inch',
                'deskripsi' => 'Monitor IPS Full HD 60Hz',
                'harga_beli' => 1800000.00,
                'harga_jual' => 220000.00,
                'stok_minimum' => 2,
                'satuan' => 'unit',
                'kategori_index' => 0,
                'supplier_index' => 0,
            ],
            [
                'kode_barang' => 'BRG-ATK-001',
                'nama_barang' => 'Kertas HVS PaperOne A4 80gr',
                'deskripsi' => 'Kertas A4 putih untuk print laporan',
                'harga_beli' => 45000.00,
                'harga_jual' => 55000.00,
                'stok_minimum' => 10,
                'satuan' => 'rim',
                'kategori_index' => 1, // ATK
                'supplier_index' => 1, // ATK Mandiri
            ],
            [
                'kode_barang' => 'BRG-ATK-002',
                'nama_barang' => 'Pulpen Gel Zebra Sarasa 0.5 Black',
                'deskripsi' => 'Pulpen gel hitam lancar berkualitas',
                'harga_beli' => 12000.00,
                'harga_jual' => 17000.00,
                'stok_minimum' => 20,
                'satuan' => 'pcs',
                'kategori_index' => 1,
                'supplier_index' => 1,
            ],
            [
                'kode_barang' => 'BRG-FUR-001',
                'nama_barang' => 'Kursi Jaring Hidrolik Ergonomis',
                'deskripsi' => 'Kursi kantor hidrolik sandaran jaring',
                'harga_beli' => 750000.00,
                'harga_jual' => 1100000.00,
                'stok_minimum' => 2,
                'satuan' => 'unit',
                'kategori_index' => 2, // Furnitur
                'supplier_index' => 2, // Office Design
            ],
            [
                'kode_barang' => 'BRG-FUR-002',
                'nama_barang' => 'Meja Kantor Kayu Jati Lapis',
                'deskripsi' => 'Meja kerja 120x60 cm dengan laci kunci',
                'harga_beli' => 950000.00,
                'harga_jual' => 1350000.00,
                'stok_minimum' => 2,
                'satuan' => 'unit',
                'kategori_index' => 2,
                'supplier_index' => 2,
            ],
            [
                'kode_barang' => 'BRG-SAN-001',
                'nama_barang' => 'Hand Sanitizer Gel Antis 5 Liter',
                'deskripsi' => 'Hand sanitizer jerigen untuk isi ulang',
                'harga_beli' => 135000.00,
                'harga_jual' => 175000.00,
                'stok_minimum' => 3,
                'satuan' => 'jerigen',
                'kategori_index' => 3, // Sanitasi
                'supplier_index' => 3, // Hygiene Supplies
            ],
            [
                'kode_barang' => 'BRG-SAN-002',
                'nama_barang' => 'Masker Medis Sensi 3-Ply (Box)',
                'deskripsi' => 'Masker bedah 3 ply isi 50 pcs',
                'harga_beli' => 22000.00,
                'harga_jual' => 32000.00,
                'stok_minimum' => 15,
                'satuan' => 'box',
                'kategori_index' => 3,
                'supplier_index' => 3,
            ],
            [
                'kode_barang' => 'BRG-LOG-001',
                'nama_barang' => 'Kardus Box Polos 30x20x20 cm',
                'deskripsi' => 'Kardus pengemasan double wall tebal',
                'harga_beli' => 4500.00,
                'harga_jual' => 7000.00,
                'stok_minimum' => 50,
                'satuan' => 'pcs',
                'kategori_index' => 4, // Packing
                'supplier_index' => 1, // ATK Mandiri
            ],
            [
                'kode_barang' => 'BRG-LOG-002',
                'nama_barang' => 'Lakban Daimaru Cokelat 2 Inch',
                'deskripsi' => 'Lakban packing cokelat 90 yard',
                'harga_beli' => 9000.00,
                'harga_jual' => 13000.00,
                'stok_minimum' => 12,
                'satuan' => 'roll',
                'kategori_index' => 4,
                'supplier_index' => 1,
            ],
        ];

        $barangModels = [];
        foreach ($barangData as $data) {
            $barangModels[] = Barang::create([
                'kode_barang' => $data['kode_barang'],
                'nama_barang' => $data['nama_barang'],
                'deskripsi' => $data['deskripsi'],
                'harga_beli' => $data['harga_beli'],
                'harga_jual' => $data['harga_jual'],
                'stok' => 0, // Start empty, increment via purchases
                'stok_minimum' => $data['stok_minimum'],
                'satuan' => $data['satuan'],
                'kategori_id' => $kategoriModels[$data['kategori_index']]->id,
                'supplier_id' => $supplierModels[$data['supplier_index']]->id,
            ]);
        }

        // 5. Seed Transactions (Simulated over the last 6 months)
        // We will seed purchases first so there is stock to sell.
        // We loop from month -5 (5 months ago) to 0 (current month).
        for ($m = 5; $m >= 0; $m--) {
            $baseDate = now()->subMonths($m)->startOfMonth();
            $user = $users[array_rand($users)];

            // A. Seed Pembelian (Stok Masuk) - 2 Pembelian per bulan
            for ($p = 1; $p <= 2; $p++) {
                $supplier = $supplierModels[array_rand($supplierModels)];
                $tglBeli = (clone $baseDate)->addDays(rand(1, 12))->format('Y-m-d');
                $invoiceBeli = 'INV-IN-' . date('Ymd', strtotime($tglBeli)) . '-' . rand(100, 999);
                
                DB::transaction(function() use ($invoiceBeli, $supplier, $user, $tglBeli, $barangModels) {
                    $pembelian = Pembelian::create([
                        'nomor_faktur' => $invoiceBeli,
                        'supplier_id' => $supplier->id,
                        'user_id' => $user->id,
                        'tanggal_pembelian' => $tglBeli,
                        'total_harga' => 0,
                        'status' => 'selesai',
                        'catatan' => 'Pembelian rutin bulanan stok barang.',
                    ]);

                    $totalHarga = 0;
                    // Select 3 to 5 random items to buy
                    $purchasedItems = (array) array_rand($barangModels, rand(3, 5));
                    
                    foreach ($purchasedItems as $index) {
                        $barang = $barangModels[$index];
                        $jumlah = rand(15, 40); // Quantity purchased
                        $subtotal = $jumlah * $barang->harga_beli;
                        $totalHarga += $subtotal;

                        DetailPembelian::create([
                            'pembelian_id' => $pembelian->id,
                            'barang_id' => $barang->id,
                            'jumlah' => $jumlah,
                            'harga_beli' => $barang->harga_beli,
                            'subtotal' => $subtotal,
                        ]);

                        // Update stock in DB
                        $barang->increment('stok', $jumlah);

                        // Log stock movement
                        MutasiStok::create([
                            'barang_id' => $barang->id,
                            'user_id' => $user->id,
                            'jenis_transaksi' => 'pembelian',
                            'jumlah' => $jumlah,
                            'stok_akhir' => $barang->fresh()->stok,
                            'referensi_tipe' => 'Pembelian',
                            'referensi_id' => $pembelian->id,
                            'keterangan' => "Penerimaan stok dari Faktur {$invoiceBeli}",
                            'created_at' => $tglBeli . ' 09:00:00',
                            'updated_at' => $tglBeli . ' 09:00:00',
                        ]);
                    }

                    $pembelian->update(['total_harga' => $totalHarga]);
                });
            }

            // B. Seed Penjualan (Stok Keluar) - 3 Penjualan per bulan
            for ($s = 1; $s <= 3; $s++) {
                $tglJual = (clone $baseDate)->addDays(rand(14, 28))->format('Y-m-d');
                $invoiceJual = 'INV-OUT-' . date('Ymd', strtotime($tglJual)) . '-' . rand(100, 999);
                $customerName = ['PT. Citra Abadi', 'Toko Berkah Utama', 'CV. Karya Indah', 'Pelanggan Umum'][rand(0, 3)];
                $paymentMethod = ['tunai', 'transfer'][rand(0, 1)];

                DB::transaction(function() use ($invoiceJual, $customerName, $paymentMethod, $user, $tglJual, $barangModels) {
                    $penjualan = Penjualan::create([
                        'nomor_faktur' => $invoiceJual,
                        'nama_pelanggan' => $customerName,
                        'telepon_pelanggan' => '08' . rand(10000000, 99999999),
                        'user_id' => $user->id,
                        'tanggal_penjualan' => $tglJual,
                        'total_harga' => 0,
                        'metode_pembayaran' => $paymentMethod,
                        'catatan' => 'Penjualan ke pelanggan.',
                    ]);

                    $totalHarga = 0;
                    // Select 2 to 4 items to sell
                    $soldItems = (array) array_rand($barangModels, rand(2, 4));

                    foreach ($soldItems as $index) {
                        $barang = $barangModels[$index]->fresh();
                        // Verify we have stock available to sell
                        if ($barang->stok > 5) {
                            $jumlah = rand(2, 5); // Selling quantity
                            $subtotal = $jumlah * $barang->harga_jual;
                            $totalHarga += $subtotal;

                            DetailPenjualan::create([
                                'penjualan_id' => $penjualan->id,
                                'barang_id' => $barang->id,
                                'jumlah' => $jumlah,
                                'harga_jual' => $barang->harga_jual,
                                'subtotal' => $subtotal,
                            ]);

                            // Update stock in DB
                            $barang->decrement('stok', $jumlah);

                            // Log stock movement
                            MutasiStok::create([
                                'barang_id' => $barang->id,
                                'user_id' => $user->id,
                                'jenis_transaksi' => 'penjualan',
                                'jumlah' => $jumlah,
                                'stok_akhir' => $barang->fresh()->stok,
                                'referensi_tipe' => 'Penjualan',
                                'referensi_id' => $penjualan->id,
                                'keterangan' => "Pengeluaran stok untuk Faktur {$invoiceJual}",
                                'created_at' => $tglJual . ' 14:30:00',
                                'updated_at' => $tglJual . ' 14:30:00',
                            ]);
                        }
                    }

                    $penjualan->update(['total_harga' => $totalHarga]);
                });
            }
        }
    }
}
