<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\database\seeders\KegiatanDonorSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KegiatanDonorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kegiatan_donor')->insert([
            [
                'nama_kegiatan' => 'Donor Darah Sukarela - Dies Natalis UNHAS',
                'tanggal' => '2024-10-15',
                'lokasi' => 'Gedung Andi Pangerang UNHAS',
                'status' => 'Completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kegiatan' => 'Donor Darah Sukarela - Pekan KSR',
                'tanggal' => '2024-11-05',
                'lokasi' => 'Lapangan Rektorat UNHAS',
                'status' => 'Planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kegiatan' => 'Donor Darah Sukarela - Bulan Ramadhan',
                'tanggal' => '2025-03-20',
                'lokasi' => 'Masjid Kampus UNHAS',
                'status' => 'Planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}