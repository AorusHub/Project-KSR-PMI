<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\database\seeders\PendonorSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PendonorSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua user dengan role pendonor
        $userPendonor = DB::table('users')
            ->where('role', 'pendonor')
            ->get();

        $jenisKelamin = ['Laki-laki', 'Perempuan'];
        $golonganDarah = ['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'];
        
        // Distribusi golongan darah realistis
        $distribusiGoldar = [
            'O+' => 35,
            'A+' => 25,
            'B+' => 20,
            'AB+' => 4,
            'O-' => 5,
            'A-' => 5,
            'B-' => 5,
            'AB-' => 1,
        ];
        
        $pendonorData = [];
        
        foreach ($userPendonor as $index => $user) {
            // Tentukan golongan darah berdasarkan distribusi
            $rand = rand(1, 100);
            if ($rand <= 35) {
                $goldar = 'O+';
            } elseif ($rand <= 60) {
                $goldar = 'A+';
            } elseif ($rand <= 80) {
                $goldar = 'B+';
            } elseif ($rand <= 84) {
                $goldar = 'AB+';
            } elseif ($rand <= 89) {
                $goldar = 'O-';
            } elseif ($rand <= 94) {
                $goldar = 'A-';
            } elseif ($rand <= 99) {
                $goldar = 'B-';
            } else {
                $goldar = 'AB-';
            }
            
            $umur = rand(18, 60);
            $tanggalLahir = Carbon::now()->subYears($umur)->subDays(rand(1, 365));
            
            // Generate NIK (16 digit, dimulai dengan kode Makassar 7371)
            $nik = '7371' . str_pad(rand(1, 999999999999), 12, '0', STR_PAD_LEFT);
            
            $pendonorData[] = [
                'user_id' => $user->user_id,
                'nama' => $user->nama,
                'email' => $user->email,
                'no_hp' => '08' . rand(1000000000, 9999999999),
                'NIK' => $nik,
                'tanggal_lahir' => $tanggalLahir->format('Y-m-d'),
                'jenis_kelamin' => $jenisKelamin[array_rand($jenisKelamin)],
                'golongan_darah' => $goldar,
                'alamat' => 'Jl. ' . ['Perintis Kemerdekaan', 'Tamalanrea', 'Urip Sumoharjo', 'AP Pettarani', 'Sultan Alauddin', 'Veteran Selatan'][array_rand(['Perintis Kemerdekaan', 'Tamalanrea', 'Urip Sumoharjo', 'AP Pettarani', 'Sultan Alauddin', 'Veteran Selatan'])] . ' No. ' . rand(1, 150) . ', Makassar, Sulawesi Selatan',
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ];
        }

        DB::table('pendonor')->insert($pendonorData);
    }
}