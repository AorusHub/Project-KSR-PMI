<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\database\seeders\AnggotaSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('anggota')->insert([
            [
                'id_user' => 2, // Staf KSR PMI
                'nama_staf' => 'Staf KSR PMI UNHAS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}