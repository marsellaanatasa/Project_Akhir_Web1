<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembelian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pembelian';

    protected $fillable = [
        'nomor_faktur',
        'supplier_id',
        'user_id',
        'tanggal_pembelian',
        'total_harga',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_pembelian' => 'date'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detailPembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'pembelian_id');
    }
}
