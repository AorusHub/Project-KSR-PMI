<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\database\seeders\PendonorSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendonorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pendonor')->insert([
            [
                'user_id' => 3, // Ahmad Pendonor
                'NIK' => '7371012345678901',
                'alamat' => 'Jl. Perintis Kemerdekaan No. 10, Makassar',
                'tgl_lahir' => '1995-05-15',
                'golongan_darah' => 'O+',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4, // Siti Pendonor
                'NIK' => '7371012345678902',
                'alamat' => 'Jl. Sultan Alauddin No. 25, Makassar',
                'tgl_lahir' => '1998-08-20',
                'golongan_darah' => 'A+',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}