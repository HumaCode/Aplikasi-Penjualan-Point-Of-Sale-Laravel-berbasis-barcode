<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;

    protected $table = 'pembelian_detail';
    protected $primaryKey = 'id_pembelian_detail';
    protected $guarded = [];

    // relasi cardinalitas antar tabel
    public function produk()
    {
        // 1 pembelian boleh memiliki banyak produk
        return $this->hasOne(Produk::class, 'id_produk', 'id_produk');
    } 
}
