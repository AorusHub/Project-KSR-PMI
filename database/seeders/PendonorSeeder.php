<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PendonorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pendonor')->insert([
            [
                'user_id' => 3,
                'nama' => 'Ahmad Hidayat',
                'email' => 'ahmad.pendonor@demo.com',
                'no_hp' => '081234567890',
                'NIK' => '7371012345678901',
                'tanggal_lahir' => '1995-05-15',
                'jenis_kelamin' => 'Laki-laki',
                'golongan_darah' => 'O+',
                'alamat' => 'Jl. Perintis Kemerdekaan No. 10, Makassar, Sulawesi Selatan',
                'created_at' => Carbon::now()->subMonths(6),
                'updated_at' => Carbon::now()->subMonths(6),
            ],
            [
                'user_id' => 4,
                'nama' => 'Siti Aisyah',
                'email' => 'siti.pendonor@demo.com',
                'no_hp' => '081234567891',
                'NIK' => '7371012345678902',
                'tanggal_lahir' => '1998-08-20',
                'jenis_kelamin' => 'Perempuan',
                'golongan_darah' => 'A+',
                'alamat' => 'Jl. Sultan Alauddin No. 25, Makassar, Sulawesi Selatan',
                'created_at' => Carbon::now()->subMonths(3),
                'updated_at' => Carbon::now()->subMonths(3),
            ],
            [
                'user_id' => 5,
                'nama' => 'Budi Santoso',
                'email' => 'budi@demo.com',
                'no_hp' => '081234567892',
                'NIK' => '7371012345678903',
                'tanggal_lahir' => '1992-03-10',
                'jenis_kelamin' => 'Laki-laki',
                'golongan_darah' => 'B+',
                'alamat' => 'Jl. Veteran Selatan No. 50, Makassar, Sulawesi Selatan',
                'created_at' => Carbon::now()->subYear(),
                'updated_at' => Carbon::now()->subYear(),
            ],
        ]);
    }
}