<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mutasi_stok', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barang');
            $table->foreignId('user_id')->constrained('users');
            $table->string('jenis_transaksi'); // pembelian, penjualan, penyesuaian_masuk, penyesuaian_keluar
            $table->integer('jumlah');
            $table->integer('stok_akhir');
            $table->string('referensi_tipe')->nullable(); // Pembelian, Penjualan
            $table->unsignedBigInteger('referensi_id')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_stok');
    }
};
