<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    // inisialisasi bahwa model supplier menggunakan table supplier
    protected $table = 'supplier';
    protected $primaryKey = 'id_supplier';
    protected $guarded = [];
}
