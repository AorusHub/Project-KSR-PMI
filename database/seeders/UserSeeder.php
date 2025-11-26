<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\database\seeders\UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'nama' => 'Admin PMI',
                'email' => 'admin@pmi.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'otp_code' => null,
                'otp_expires_at' => null,
                'is_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Staf PMI',
                'email' => 'staf@pmi.com',
                'password' => Hash::make('staf123'),
                'role' => 'staf',
                'otp_code' => null,
                'otp_expires_at' => null,
                'is_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Staf PMI 2',
                'email' => 'staf2@pmi.com',
                'password' => Hash::make('staf123'),
                'role' => 'staf',
                'otp_code' => null,
                'otp_expires_at' => null,
                'is_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Generate 50 pendonor
        $namaDepan = ['Ahmad', 'Budi', 'Citra', 'Dewi', 'Eko', 'Fajar', 'Gita', 'Hadi', 'Indah', 'Joko', 
                      'Kartika', 'Lina', 'Made', 'Nurul', 'Omar', 'Putri', 'Qory', 'Rina', 'Sari', 'Tono',
                      'Udin', 'Vina', 'Wahyu', 'Yanti', 'Zaki', 'Andi', 'Bella', 'Chandra', 'Diana', 'Edi'];
        
        $namaBelakang = ['Pratama', 'Wijaya', 'Kusuma', 'Santoso', 'Permana', 'Hidayat', 'Rahmawati', 
                         'Setiawan', 'Lestari', 'Putra', 'Putri', 'Firmansyah', 'Wulandari', 'Hakim', 
                         'Suharto', 'Mahendra', 'Utami', 'Saputra', 'Dewi', 'Rahman'];

        for ($i = 1; $i <= 50; $i++) {
            $nama = $namaDepan[array_rand($namaDepan)] . ' ' . $namaBelakang[array_rand($namaBelakang)];
            $email = 'pendonor' . $i . '@unhas.ac.id';
            
            $users[] = [
                'nama' => $nama,
                'email' => $email,
                'password' => Hash::make('pendonor123'),
                'role' => 'pendonor',
                'otp_code' => null,
                'otp_expires_at' => null,
                'is_verified' => true,
                'created_at' => now()->subDays(rand(30, 365)),
                'updated_at' => now()->subDays(rand(1, 30)),
            ];
        }

        DB::table('users')->insert($users);
    }
}