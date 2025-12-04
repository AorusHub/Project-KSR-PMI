<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\database\seeders\DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PendonorSeeder::class,
            AnggotaSeeder::class,
            KegiatanDonorSeeder::class,
            PermintaanDonorSeeder::class,
            InfoUtdSeeder::class,
            DonasiDarahSeeder::class,
            StokDarahSeeder::class,
        ]);
    }
}