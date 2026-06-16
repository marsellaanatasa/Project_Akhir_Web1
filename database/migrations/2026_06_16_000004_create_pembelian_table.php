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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_faktur')->unique();
            $table->foreignId('supplier_id')->constrained('supplier');
            $table->foreignId('user_id')->constrained('users');
            $table->date('tanggal_pembelian');
            $table->decimal('total_harga', 15, 2);
            $table->string('status')->default('selesai'); // selesai, tertunda, dibatalkan
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
        Schema::dropIfExists('pembelian');
    }
};
