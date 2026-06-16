<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penjualan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penjualan';

    protected $fillable = [
        'nomor_faktur',
        'nama_pelanggan',
        'telepon_pelanggan',
        'user_id',
        'tanggal_penjualan',
        'total_harga',
        'metode_pembayaran',
        'catatan'
    ];

    protected $casts = [
        'tanggal_penjualan' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'penjualan_id');
    }
}
