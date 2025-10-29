<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\database\seeders\PermintaanDonorSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermintaanDonorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('permintaan_donor')->insert([
            [
                'tanggal_hari' => now(),
                'nama_pasien' => 'Budi Santoso',
                'gol_darah' => 'O+',
                'jumlah_kantong' => 2,
                'kontak_keluarga' => '081234567890',
                'status_permintaan' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal_hari' => now()->subDays(2),
                'nama_pasien' => 'Ani Wijaya',
                'gol_darah' => 'A+',
                'jumlah_kantong' => 3,
                'kontak_keluarga' => '081234567891',
                'status_permintaan' => 'Completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}