<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    // inisialisasi bahwa model member menggunakan table member
    protected $table = 'member';
    protected $primaryKey = 'id_member';
    protected $guarded = [];
}
