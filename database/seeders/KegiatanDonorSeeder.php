<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KegiatanDonorSeeder extends Seeder
{
    public function run(): void
    {
        $adminStaf = DB::table('users')
            ->whereIn('role', ['admin', 'staf'])
            ->pluck('user_id')
            ->toArray();

        $locations = [
            'Gedung Rektorat UNHAS' => [
                'lat' => -5.1348, 
                'lng' => 119.4891,
                'rincian' => 'Ruangan 101, Lantai 3B'
            ],
            'Lapangan Rektorat UNHAS' => [
                'lat' => -5.1345, 
                'lng' => 119.4888,
                'rincian' => 'Area Terbuka, Samping Parkir Utama'
            ],
            'Auditorium UNHAS' => [
                'lat' => -5.1352, 
                'lng' => 119.4895,
                'rincian' => 'Auditorium Utama, Lantai 1'
            ],
            'Hall FK UNHAS' => [
                'lat' => -5.1360, 
                'lng' => 119.4900,
                'rincian' => 'Hall Serbaguna, Gedung A'
            ],
            'UPT Perpustakaan UNHAS' => [
                'lat' => -5.1355, 
                'lng' => 119.4893,
                'rincian' => 'Ruang Seminar, Lantai 2'
            ],
            'Gedung Pusat UNHAS' => [
                'lat' => -5.1350, 
                'lng' => 119.4892,
                'rincian' => 'Aula Utama, Lantai 1'
            ],
            'Lapangan Parkir Rektorat UNHAS' => [
                'lat' => -5.1346, 
                'lng' => 119.4889,
                'rincian' => 'Area Parkir Timur, Dekat Gerbang Utama'
            ],
            'Gedung Student Center UNHAS' => [
                'lat' => -5.1358, 
                'lng' => 119.4897,
                'rincian' => 'Student Center, Lantai 2'
            ],
        ];

        DB::table('kegiatan_donor')->insert([
            // Juli 2024
            [
                'nama_kegiatan' => 'Donor Darah HUT RI ke-79',
                'tanggal' => '2024-07-15',
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '14:00',
                'lokasi' => 'Gedung Rektorat UNHAS',
                'rincian_lokasi' => $locations['Gedung Rektorat UNHAS']['rincian'],
                'latitude' => $locations['Gedung Rektorat UNHAS']['lat'],
                'longitude' => $locations['Gedung Rektorat UNHAS']['lng'],
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
                'rincian_lokasi' => $locations['Lapangan Rektorat UNHAS']['rincian'],
                'latitude' => $locations['Lapangan Rektorat UNHAS']['lat'],
                'longitude' => $locations['Lapangan Rektorat UNHAS']['lng'],
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
                'rincian_lokasi' => $locations['Auditorium UNHAS']['rincian'],
                'latitude' => $locations['Auditorium UNHAS']['lat'],
                'longitude' => $locations['Auditorium UNHAS']['lng'],
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
                'rincian_lokasi' => $locations['Hall FK UNHAS']['rincian'],
                'latitude' => $locations['Hall FK UNHAS']['lat'],
                'longitude' => $locations['Hall FK UNHAS']['lng'],
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
                'lokasi' => 'Hall FK UNHAS',
                'rincian_lokasi' => $locations['Hall FK UNHAS']['rincian'],
                'latitude' => $locations['Hall FK UNHAS']['lat'],
                'longitude' => $locations['Hall FK UNHAS']['lng'],
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
                'rincian_lokasi' => $locations['UPT Perpustakaan UNHAS']['rincian'],
                'latitude' => $locations['UPT Perpustakaan UNHAS']['lat'],
                'longitude' => $locations['UPT Perpustakaan UNHAS']['lng'],
                'deskripsi' => 'Kegiatan donor darah rutin bulanan',
                'target_donor' => 100,
                'status' => 'Completed',
                'created_by' => $adminStaf[array_rand($adminStaf)],
                'created_at' => Carbon::parse('2024-10-01'),
                'updated_at' => Carbon::parse('2024-10-16'),
            ],
            // November 2024
            [
                'nama_kegiatan' => 'Donor Darah Hari Pahlawan',
                'tanggal' => '2024-11-10',
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '14:00',
                'lokasi' => 'Gedung Pusat UNHAS',
                'rincian_lokasi' => $locations['Gedung Pusat UNHAS']['rincian'],
                'latitude' => $locations['Gedung Pusat UNHAS']['lat'],
                'longitude' => $locations['Gedung Pusat UNHAS']['lng'],
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
                'rincian_lokasi' => $locations['Lapangan Parkir Rektorat UNHAS']['rincian'],
                'latitude' => $locations['Lapangan Parkir Rektorat UNHAS']['lat'],
                'longitude' => $locations['Lapangan Parkir Rektorat UNHAS']['lng'],
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
                'rincian_lokasi' => $locations['Gedung Student Center UNHAS']['rincian'],
                'latitude' => $locations['Gedung Student Center UNHAS']['lat'],
                'longitude' => $locations['Gedung Student Center UNHAS']['lng'],
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
                'rincian_lokasi' => $locations['Gedung Rektorat UNHAS']['rincian'],
                'latitude' => $locations['Gedung Rektorat UNHAS']['lat'],
                'longitude' => $locations['Gedung Rektorat UNHAS']['lng'],
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
                'rincian_lokasi' => $locations['Gedung Rektorat UNHAS']['rincian'],
                'latitude' => $locations['Gedung Rektorat UNHAS']['lat'],
                'longitude' => $locations['Gedung Rektorat UNHAS']['lng'],
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