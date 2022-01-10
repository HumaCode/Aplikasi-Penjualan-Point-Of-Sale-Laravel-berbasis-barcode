<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;

    // inisialisasi bahwa model penjualan_detail menggunakan table penjualan_detail
    protected $table = 'penjualan_detail';
    protected $primaryKey = 'id_penjualan_detail';
    protected $guarded = [];

    // relasi cardinalitas antar tabel
    public function produk()
    {
        // 1 pembelian boleh memiliki banyak produk
        return $this->hasOne(Produk::class, 'id_produk', 'id_produk');
    } 
}
