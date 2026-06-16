<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiStok extends Model
{
    use HasFactory;

    protected $table = 'mutasi_stok';

    protected $fillable = [
        'barang_id',
        'user_id',
        'jenis_transaksi',
        'jumlah',
        'stok_akhir',
        'referensi_tipe',
        'referensi_id',
        'keterangan'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
