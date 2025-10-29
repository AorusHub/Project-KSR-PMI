<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\database\seeders\InfoUtdSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InfoUtdSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('info_utd')->insert([
            [
                'nama_utd' => 'UTD PMI Kota Makassar',
                'alamat' => 'Jl. Andi Pangeran Pettarani No. 1, Makassar',
                'no_telp' => '0411-452952',
                'jam_buka' => 'Senin - Sabtu: 08:00 - 16:00 WIB',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_utd' => 'UTD PMI Provinsi Sulawesi Selatan',
                'alamat' => 'Jl. Jenderal Sudirman No. 1, Makassar',
                'no_telp' => '0411-3620112',
                'jam_buka' => 'Senin - Jumat: 08:00 - 15:00 WIB',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}