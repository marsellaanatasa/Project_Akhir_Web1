<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard or login
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    
    // Dashboard Route (Dynamic)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes (Breeze Default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ----------------------------------------------------
    // Read-only routes for Staff, Full CRUD for Admin
    // ----------------------------------------------------
    Route::middleware('role:admin,staff')->group(function () {
        // Master Data Lists (Read)
        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
        Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
        Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');

        // Transactions (Both admin and staff can create & view)
        Route::resource('pembelian', PembelianController::class)->only(['index', 'create', 'store', 'show']);
        Route::resource('penjualan', PenjualanController::class)->only(['index', 'create', 'store', 'show']);
    });

    // Write-only routes for Admin on Master Data
    Route::middleware('role:admin')->group(function () {
        // Kategori
        Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
        Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
        Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

        // Supplier
        Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
        Route::get('/supplier/{supplier}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

        // Barang
        Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
        Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
        Route::get('/barang/{barang}/edit', [BarangController::class, 'edit'])->name('barang.edit');
        Route::put('/barang/{barang}', [BarangController::class, 'update'])->name('barang.update');
        Route::delete('/barang/{barang}', [BarangController::class, 'destroy'])->name('barang.destroy');
    });
});

require __DIR__.'/auth.php';
