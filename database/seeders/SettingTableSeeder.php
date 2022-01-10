<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert([
            'id_setting' => 1,
            'nama_perusahaan' => 'Toko Ku',
            'alamat' => 'Jl. Diponegoro',
            'telepon' => '082324118699',
            'tipe_nota' => 1, // kecil, 2 besar
            'diskon' => 5, 
            'path_logo' => '/img/logo.png',
            'path_kartu_member' => '/img/member.png'  
        ]); 
    }
}
