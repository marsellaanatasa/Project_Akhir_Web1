<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'supplier';

    protected $fillable = [
        'nama_supplier',
        'kontak_person',
        'email',
        'telepon',
        'alamat'
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'supplier_id');
    }

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'supplier_id');
    }
}
