<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    // inisialisasi bahwa model kategori menggunakan table kategori
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $guarded = [];
}
