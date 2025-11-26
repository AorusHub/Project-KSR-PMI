<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\database\seeders\KegiatanDonorSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KegiatanDonorSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID admin dan staf
        $adminStaf = DB::table('users')
            ->whereIn('role', ['admin', 'staf'])
            ->pluck('user_id')
            ->toArray();

        DB::table('kegiatan_donor')->insert([
            // Juli 2024
            [
                'nama_kegiatan' => 'Donor Darah HUT RI ke-79',
                'tanggal' => '2024-07-15',
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '14:00',
                'lokasi' => 'Gedung Rektorat UNHAS',
                'deskripsi' => 'Kegiatan donor darah dalam rangka HUT RI',
                'target_donor' => 150,
                'status' => 'Completed',
                'created_by' => $adminStaf[array_rand($adminStaf)],
                'created_at' => Carbon::parse('2024-07-01'),
                'updated_at' => Carbon::parse('2024-07-16'),
            ],
            // Agustus 2024
            [
                'nama_kegiatan' => 'Donor Darah Merdeka',
                'tanggal' => '2024-08-17',
                'waktu_mulai' => '07:00',
                'waktu_selesai' => '15:00',
                'lokasi' => 'Lapangan Rektorat UNHAS',
                'deskripsi' => 'Donor darah kemerdekaan Indonesia',
                'target_donor' => 200,
                'status' => 'Completed',
                'created_by' => $adminStaf[array_rand($adminStaf)],
                'created_at' => Carbon::parse('2024-08-01'),
                'updated_at' => Carbon::parse('2024-08-18'),
            ],
            // September 2024
            [
                'nama_kegiatan' => 'Donor Darah Mahasiswa Baru 2024',
                'tanggal' => '2024-09-10',
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '14:00',
                'lokasi' => 'Auditorium UNHAS',
                'deskripsi' => 'Kegiatan donor darah untuk mahasiswa baru',
                'target_donor' => 120,
                'status' => 'Completed',
                'created_by' => $adminStaf[array_rand($adminStaf)],
                'created_at' => Carbon::parse('2024-09-01'),
                'updated_at' => Carbon::parse('2024-09-11'),
            ],
            [
                'nama_kegiatan' => 'Donor Darah Fakultas Kedokteran',
                'tanggal' => '2024-09-25',
                'waktu_mulai' => '09:00',
                'waktu_selesai' => '13:00',
                'lokasi' => 'Hall FK UNHAS',
                'deskripsi' => 'Donor darah rutin Fakultas Kedokteran',
                'target_donor' => 80,
                'status' => 'Completed',
                'created_by' => $adminStaf[array_rand($adminStaf)],
                'created_at' => Carbon::parse('2024-09-15'),
                'updated_at' => Carbon::parse('2024-09-26'),
            ],
            // Oktober 2024
            [
                'nama_kegiatan' => 'Donor Darah Sumpah Pemuda',
                'tanggal' => '2024-10-28',
                'waktu_mulai' => '09:00',
                'waktu_selesai' => '15:00',
                'lokasi' => 'Hall Fakultas Kedokteran UNHAS',
                'deskripsi' => 'Donor darah peringatan Sumpah Pemuda',
                'target_donor' => 100,
                'status' => 'Completed',
                'created_by' => $adminStaf[array_rand($adminStaf)],
                'created_at' => Carbon::parse('2024-10-15'),
                'updated_at' => Carbon::parse('2024-10-29'),
            ],
            [
                'nama_kegiatan' => 'Donor Darah Rutin Oktober',
                'tanggal' => '2024-10-15',
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '12:00',
                'lokasi' => 'UPT Perpustakaan UNHAS',
                'deskripsi' => 'Kegiatan donor darah rutin bulanan',
                'target_donor' => 100,
                'status' => 'Completed',
                'created_by' => $adminStaf[array_rand($adminStaf)],
                'created_at' => Carbon::parse('2024-10-01'),
                'updated_at' => Carbon::parse('2024-10-16'),
            ],
            // November 2024 (Puncak)
            [
                'nama_kegiatan' => 'Donor Darah Hari Pahlawan',
                'tanggal' => '2024-11-10',
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '14:00',
                'lokasi' => 'Gedung Pusat UNHAS',
                'deskripsi' => 'Donor darah memperingati Hari Pahlawan',
                'target_donor' => 180,
                'status' => 'Completed',
                'created_by' => $adminStaf[array_rand($adminStaf)],
                'created_at' => Carbon::parse('2024-11-01'),
                'updated_at' => Carbon::parse('2024-11-11'),
            ],
            [
                'nama_kegiatan' => 'Donor Darah Dies Natalis UNHAS',
                'tanggal' => '2024-11-20',
                'waktu_mulai' => '07:00',
                'waktu_selesai' => '16:00',
                'lokasi' => 'Lapangan Parkir Rektorat UNHAS',
                'deskripsi' => 'Donor darah dalam rangka Dies Natalis UNHAS',
                'target_donor' => 250,
                'status' => 'Completed',
                'created_by' => $adminStaf[array_rand($adminStaf)],
                'created_at' => Carbon::parse('2024-11-05'),
                'updated_at' => Carbon::parse('2024-11-21'),
            ],
            [
                'nama_kegiatan' => 'Donor Darah Rutin November',
                'tanggal' => '2024-11-25',
                'waktu_mulai' => '09:00',
                'waktu_selesai' => '15:00',
                'lokasi' => 'Gedung Student Center UNHAS',
                'deskripsi' => 'Kegiatan donor darah rutin bulanan',
                'target_donor' => 150,
                'status' => 'Completed',
                'created_by' => $adminStaf[array_rand($adminStaf)],
                'created_at' => Carbon::parse('2024-11-10'),
                'updated_at' => Carbon::parse('2024-11-26'),
            ],
            // Desember 2024
            [
                'nama_kegiatan' => 'Donor Darah Akhir Tahun 2024',
                'tanggal' => '2024-12-15',
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '14:00',
                'lokasi' => 'Gedung Rektorat UNHAS',
                'deskripsi' => 'Kegiatan donor darah penutup tahun 2024',
                'target_donor' => 200,
                'status' => 'Ongoing',
                'created_by' => $adminStaf[array_rand($adminStaf)],
                'created_at' => Carbon::parse('2024-12-01'),
                'updated_at' => now(),
            ],
            // Future
            [
                'nama_kegiatan' => 'Donor Darah Kampus UNHAS',
                'tanggal' => now()->addDays(30),
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '14:00',
                'lokasi' => 'Gedung Rektorat UNHAS',
                'deskripsi' => 'Kegiatan donor darah rutin di kampus',
                'target_donor' => 100,
                'status' => 'Planned',
                'created_by' => $adminStaf[array_rand($adminStaf)],
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}