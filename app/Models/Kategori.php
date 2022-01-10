<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    // inisialisasi bahwa model kategori menggunakan table kategori
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $guarded = [];
}
