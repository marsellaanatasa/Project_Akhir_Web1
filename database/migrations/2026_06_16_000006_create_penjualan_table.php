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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_faktur')->unique();
            $table->string('nama_pelanggan')->nullable();
            $table->string('telepon_pelanggan')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->date('tanggal_penjualan');
            $table->decimal('total_harga', 15, 2);
            $table->string('metode_pembayaran')->default('tunai'); // tunai, transfer
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
