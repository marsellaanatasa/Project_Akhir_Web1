<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barang';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'deskripsi',
        'harga_jual',
        'harga_beli',
        'stok',
        'stok_minimum',
        'satuan',
        'kategori_id',
        'supplier_id'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function detailPembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'barang_id');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'barang_id');
    }

    public function mutasiStok()
    {
        return $this->hasMany(MutasiStok::class, 'barang_id');
    }
}
