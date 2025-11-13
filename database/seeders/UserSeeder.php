<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'user_id' => 1,
                'nama' => 'Admin PMI',
                'email' => 'admin@pmi.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'nama' => 'Staf PMI',
                'email' => 'staf@pmi.com',
                'password' => Hash::make('staf123'),
                'role' => 'staf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'nama' => 'Ahmad Hidayat',
                'email' => 'ahmad.pendonor@demo.com',
                'password' => Hash::make('pendonor123'),
                'role' => 'pendonor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'nama' => 'Siti Aisyah',
                'email' => 'siti.pendonor@demo.com',
                'password' => Hash::make('pendonor123'),
                'role' => 'pendonor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5,
                'nama' => 'Budi Santoso',
                'email' => 'budi@demo.com',
                'password' => Hash::make('pendonor123'),
                'role' => 'pendonor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}