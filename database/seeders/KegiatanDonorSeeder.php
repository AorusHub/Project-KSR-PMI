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
                'nama_kegiatan' => 'Donor Darah Kampus UNHAS',
                'tanggal' => now()->addDays(7),
                'waktu_mulai' => '08:00',        // ✅ TAMBAHKAN
                'waktu_selesai' => '14:00',      // ✅ TAMBAHKAN
                'lokasi' => 'Gedung Rektorat UNHAS',
                'deskripsi' => 'Kegiatan donor darah rutin di kampus',
                'target_donor' => 100,
                'status' => 'Planned',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kegiatan' => 'Donor Darah Sukarela - Pekan KSR',
                'tanggal' => '2024-11-05',
                'waktu_mulai' => '09:00',        // ✅ TAMBAHKAN
                'waktu_selesai' => '15:00',      // ✅ TAMBAHKAN
                'lokasi' => 'Lapangan Rektorat UNHAS',
                'deskripsi' => 'Kegiatan donor darah sukarela',
                'target_donor' => 100,
                'status' => 'Planned',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kegiatan' => 'Donor Darah Sukarela - Bulan Ramadhan',
                'tanggal' => '2025-03-20',
                'waktu_mulai' => '09:00',
                'waktu_selesai' => '13:00',
                'lokasi' => 'Masjid Kampus UNHAS',
                'deskripsi' => 'Donor darah di bulan Ramadhan untuk membantu sesama',
                'target_donor' => 50,
                'status' => 'Planned',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}