<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\database\seeders\PermintaanDonorSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PermintaanDonorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('permintaan_donor')->insert([
            [
                'nomor_pelacakan' => 'REQ' . now()->format('ymd') . 'A1B2C',
                'tanggal_hari' => now(),
                'nama_pasien' => 'Budi Santoso',
                'gol_darah' => 'O+',
                'jumlah_kantong' => 2,
                'riwayat' => 'Pasien mengalami kecelakaan lalu lintas dan membutuhkan transfusi darah segera',
                'tempat_rawat' => 'RSUD Wahidin Sudirohusodo',
                'jenis_permintaan' => 'Packed Red Cells (PRC)',
                'tingkat_urgensi' => 'Sangat Mendesak',
                'nama_kontak' => 'Siti Nurhaliza',
                'no_hp' => '081234567890',
                'hubungan' => 'Istri',
                'kontak_keluarga' => '081234567890',
                'status_permintaan' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_pelacakan' => 'REQ' . now()->subDays(2)->format('ymd') . 'D3E4F',
                'tanggal_hari' => now()->subDays(2),
                'nama_pasien' => 'Ani Wijaya',
                'gol_darah' => 'A+',
                'jumlah_kantong' => 3,
                'riwayat' => 'Pasien penderita thalasemia yang memerlukan transfusi rutin',
                'tempat_rawat' => 'RS Universitas Hasanuddin',
                'jenis_permintaan' => 'Darah Lengkap (Whole Blood)',
                'tingkat_urgensi' => 'Normal',
                'nama_kontak' => 'Ahmad Wijaya',
                'no_hp' => '081234567891',
                'hubungan' => 'Suami',
                'kontak_keluarga' => '081234567891',
                'status_permintaan' => 'Completed',
                'created_at' => now()->subDays(2),
                'updated_at' => now(),
            ],
            [
                'nomor_pelacakan' => 'REQ' . now()->subDays(1)->format('ymd') . 'G5H6I',
                'tanggal_hari' => now()->subDays(1),
                'nama_pasien' => 'Dewi Lestari',
                'gol_darah' => 'B+',
                'jumlah_kantong' => 1,
                'riwayat' => 'Pasien post operasi caesar membutuhkan tambahan darah',
                'tempat_rawat' => 'RS Siloam Makassar',
                'jenis_permintaan' => 'Packed Red Cells (PRC)',
                'tingkat_urgensi' => 'Mendesak',
                'nama_kontak' => 'Andi Lestari',
                'no_hp' => '081234567892',
                'hubungan' => 'Kakak',
                'kontak_keluarga' => '081234567892',
                'status_permintaan' => 'Approved',
                'created_at' => now()->subDays(1),
                'updated_at' => now(),
            ],
            [
                'nomor_pelacakan' => 'REQ' . now()->subDays(3)->format('ymd') . 'J7K8L',
                'tanggal_hari' => now()->subDays(3),
                'nama_pasien' => 'Muhammad Rizki',
                'gol_darah' => 'AB+',
                'jumlah_kantong' => 4,
                'riwayat' => 'Pasien dengan anemia berat memerlukan transfusi darah',
                'tempat_rawat' => 'RS Stella Maris',
                'jenis_permintaan' => 'Darah Lengkap (Whole Blood)',
                'tingkat_urgensi' => 'Mendesak',
                'nama_kontak' => 'Nurhayati',
                'no_hp' => '081234567893',
                'hubungan' => 'Ibu',
                'kontak_keluarga' => '081234567893',
                'status_permintaan' => 'Approved',
                'created_at' => now()->subDays(3),
                'updated_at' => now(),
            ],
            [
                'nomor_pelacakan' => 'REQ' . now()->subDays(5)->format('ymd') . 'M9N0P',
                'tanggal_hari' => now()->subDays(5),
                'nama_pasien' => 'Siti Aisyah',
                'gol_darah' => 'O-',
                'jumlah_kantong' => 2,
                'riwayat' => 'Pasien demam berdarah dengan trombosit rendah',
                'tempat_rawat' => 'RSUP Dr. Wahidin Sudirohusodo',
                'jenis_permintaan' => 'Trombosit (TC)',
                'tingkat_urgensi' => 'Sangat Mendesak',
                'nama_kontak' => 'Abdul Rahman',
                'no_hp' => '081234567894',
                'hubungan' => 'Ayah',
                'kontak_keluarga' => '081234567894',
                'status_permintaan' => 'Completed',
                'created_at' => now()->subDays(5),
                'updated_at' => now(),
            ],
        ]);
    }
}