<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\database\seeders\StokDarahSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StokDarah;
use Carbon\Carbon;

class StokDarahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $golonganDarah = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $jenisDarah = [
            'Darah Lengkap (Whole Blood)',
            'Packed Red Cells (PRC)',
            'Trombosit (TC)',
            'Plasma'
        ];

        // Hapus data lama
        StokDarah::truncate();

        foreach ($golonganDarah as $golongan) {
            foreach ($jenisDarah as $jenis) {
                
                // ===== DATA 3 BULAN LALU =====
                StokDarah::create([
                    'golongan_darah' => $golongan,
                    'jenis_darah' => $jenis,
                    'jumlah_kantong' => rand(800, 1200),
                    'keterangan' => 'Stok awal ' . $jenis,
                    'created_at' => now()->subMonths(3),
                    'updated_at' => now()->subMonths(3),
                ]);

                // ===== DATA 2 BULAN LALU =====
                StokDarah::create([
                    'golongan_darah' => $golongan,
                    'jenis_darah' => $jenis,
                    'jumlah_kantong' => rand(100, 300),
                    'keterangan' => 'Penambahan donor rutin',
                    'created_at' => now()->subMonths(2),
                    'updated_at' => now()->subMonths(2),
                ]);

                // ===== DATA BULAN LALU =====
                StokDarah::create([
                    'golongan_darah' => $golongan,
                    'jenis_darah' => $jenis,
                    'jumlah_kantong' => rand(80, 250),
                    'keterangan' => 'Donor dari event kampus',
                    'created_at' => now()->subMonth(),
                    'updated_at' => now()->subMonth(),
                ]);

                // ===== DATA BULAN INI (Minggu 1) =====
                StokDarah::create([
                    'golongan_darah' => $golongan,
                    'jenis_darah' => $jenis,
                    'jumlah_kantong' => rand(30, 80),
                    'keterangan' => 'Donor minggu pertama',
                    'created_at' => now()->startOfMonth()->addDays(5),
                    'updated_at' => now()->startOfMonth()->addDays(5),
                ]);

                // ===== DATA BULAN INI (Minggu 2) =====
                StokDarah::create([
                    'golongan_darah' => $golongan,
                    'jenis_darah' => $jenis,
                    'jumlah_kantong' => rand(20, 60),
                    'keterangan' => 'Donor minggu kedua',
                    'created_at' => now()->startOfMonth()->addDays(12),
                    'updated_at' => now()->startOfMonth()->addDays(12),
                ]);

                // ===== DATA BULAN INI (Minggu 3) =====
                StokDarah::create([
                    'golongan_darah' => $golongan,
                    'jenis_darah' => $jenis,
                    'jumlah_kantong' => rand(25, 70),
                    'keterangan' => 'Donor minggu ketiga',
                    'created_at' => now()->startOfMonth()->addDays(18),
                    'updated_at' => now()->startOfMonth()->addDays(18),
                ]);

                // ===== DATA TERBARU (Hari ini) =====
                if (rand(1, 3) == 1) { // 33% chance ada donor hari ini
                    StokDarah::create([
                        'golongan_darah' => $golongan,
                        'jenis_darah' => $jenis,
                        'jumlah_kantong' => rand(10, 40),
                        'keterangan' => 'Donor hari ini',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        $this->command->info('✅ Stok Darah seeder berhasil dijalankan!');
        $this->command->info('📊 Total data: ' . StokDarah::count() . ' records');
    }
}