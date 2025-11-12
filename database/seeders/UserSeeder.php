<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\database\seeders\UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nama' => 'Admin KSR PMI',
                'email' => 'admin@ksrpmi.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Staf KSR PMI',
                'email' => 'staf@ksrpmi.com',
                'password' => Hash::make('12345678'),
                'role' => 'staf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ahmad Pendonor',
                'email' => 'ahmad@example.com',
                'password' => Hash::make('12345678'),
                'role' => 'pendonor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Jeki Pendonor',
                'email' => 'jeki@example.com',
                'password' => Hash::make('12345678'),
                'role' => 'pendonor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}