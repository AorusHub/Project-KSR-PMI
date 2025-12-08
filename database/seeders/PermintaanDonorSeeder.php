<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PermintaanDonor;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PermintaanDonorSeeder extends Seeder
{
    public function run(): void
    {
        $permintaanData = [
            [
                'nomor_pelacakan' => 'REQ' . now()->format('ymd') . strtoupper(Str::random(5)),
                'tanggal_hari' => now()->format('Y-m-d'),
                'nama_pasien' => 'Ahmad Rizki',
                'gol_darah' => 'A+',
                'jumlah_kantong' => 2,
                'riwayat' => 'Pasien kecelakaan lalu lintas, membutuhkan transfusi darah segera',
                'tempat_rawat' => 'RS Wahidin Sudirohusodo - Ruang IGD',
                'jenis_permintaan' => 'Packed Red Cells (PRC)',
                'tingkat_urgensi' => 'Sangat Mendesak',
                'nama_kontak' => 'Siti Nurhaliza',
                'no_hp' => '081234567890',
                'hubungan' => 'Istri',
                'status_permintaan' => 'Requesting',
            ],
            [
                'nomor_pelacakan' => 'REQ' . now()->format('ymd') . strtoupper(Str::random(5)),
                'tanggal_hari' => now()->addDay()->format('Y-m-d'),
                'nama_pasien' => 'Dewi Sartika',
                'gol_darah' => 'O+',
                'jumlah_kantong' => 3,
                'riwayat' => 'Pasien DBD dengan trombosit rendah, butuh transfusi trombosit',
                'tempat_rawat' => 'RSUP Dr. Wahidin - Lantai 3 Kamar 301',
                'jenis_permintaan' => 'Trombosit (TC)',
                'tingkat_urgensi' => 'Mendesak',
                'nama_kontak' => 'Budi Santoso',
                'no_hp' => '082345678901',
                'hubungan' => 'Suami',
                'status_permintaan' => 'Requesting',
            ],
            [
                'nomor_pelacakan' => 'REQ' . now()->format('ymd') . strtoupper(Str::random(5)),
                'tanggal_hari' => now()->subDay()->format('Y-m-d'),
                'nama_pasien' => 'Muhammad Ridwan',
                'gol_darah' => 'B+',
                'jumlah_kantong' => 1,
                'riwayat' => 'Pasien operasi caesar, kehilangan banyak darah',
                'tempat_rawat' => 'RS Stella Maris - Ruang Bersalin',
                'jenis_permintaan' => 'Darah Lengkap (Whole Blood)',
                'tingkat_urgensi' => 'Mendesak',
                'nama_kontak' => 'Andi Wijaya',
                'no_hp' => '083456789012',
                'hubungan' => 'Ayah',
                'status_permintaan' => 'Requesting',
            ],
            [
                'nomor_pelacakan' => 'REQ' . now()->format('ymd') . strtoupper(Str::random(5)),
                'tanggal_hari' => now()->format('Y-m-d'),
                'nama_pasien' => 'Fatimah Azzahra',
                'gol_darah' => 'AB+',
                'jumlah_kantong' => 2,
                'riwayat' => 'Pasien thalassemia, rutin transfusi darah setiap bulan',
                'tempat_rawat' => 'RS Hermina - Ruang Rawat Inap Lt 2',
                'jenis_permintaan' => 'Packed Red Cells (PRC)',
                'tingkat_urgensi' => 'Normal',
                'nama_kontak' => 'Aminah',
                'no_hp' => '084567890123',
                'hubungan' => 'Ibu',
                'status_permintaan' => 'Requesting',
            ],
            [
                'nomor_pelacakan' => 'REQ' . now()->format('ymd') . strtoupper(Str::random(5)),
                'tanggal_hari' => now()->addDays(2)->format('Y-m-d'),
                'nama_pasien' => 'Yusuf Ibrahim',
                'gol_darah' => 'O-',
                'jumlah_kantong' => 4,
                'riwayat' => 'Pasien kanker darah (leukemia), perlu transfusi plasma',
                'tempat_rawat' => 'RSUP Dr. Wahidin - Ruang Onkologi',
                'jenis_permintaan' => 'Plasma',
                'tingkat_urgensi' => 'Sangat Mendesak',
                'nama_kontak' => 'Hasan Ali',
                'no_hp' => '085678901234',
                'hubungan' => 'Adik',
                'status_permintaan' => 'Requesting',
            ],
            [
                'nomor_pelacakan' => 'REQ' . now()->format('ymd') . strtoupper(Str::random(5)),
                'tanggal_hari' => now()->format('Y-m-d'),
                'nama_pasien' => 'Nurul Hidayah',
                'gol_darah' => 'A-',
                'jumlah_kantong' => 2,
                'riwayat' => 'Pasien anemia berat pasca operasi',
                'tempat_rawat' => 'RS Siloam - ICU',
                'jenis_permintaan' => 'Packed Red Cells (PRC)',
                'tingkat_urgensi' => 'Mendesak',
                'nama_kontak' => 'Ahmad Fauzi',
                'no_hp' => '086789012345',
                'hubungan' => 'Suami',
                'status_permintaan' => 'Requesting',
            ],
            [
                'nomor_pelacakan' => 'REQ' . now()->format('ymd') . strtoupper(Str::random(5)),
                'tanggal_hari' => now()->subDays(2)->format('Y-m-d'),
                'nama_pasien' => 'Siti Aminah',
                'gol_darah' => 'B-',
                'jumlah_kantong' => 1,
                'riwayat' => 'Pasien melahirkan dengan komplikasi pendarahan',
                'tempat_rawat' => 'RS Hermina - Ruang Bersalin',
                'jenis_permintaan' => 'Darah Lengkap (Whole Blood)',
                'tingkat_urgensi' => 'Normal',
                'nama_kontak' => 'Rudi Hartono',
                'no_hp' => '087890123456',
                'hubungan' => 'Suami',
                'status_permintaan' => 'Requesting',
            ],
            [
                'nomor_pelacakan' => 'REQ' . now()->format('ymd') . strtoupper(Str::random(5)),
                'tanggal_hari' => now()->addDay()->format('Y-m-d'),
                'nama_pasien' => 'Bambang Setiawan',
                'gol_darah' => 'AB-',
                'jumlah_kantong' => 3,
                'riwayat' => 'Pasien kecelakaan kerja, fraktur tulang dengan pendarahan internal',
                'tempat_rawat' => 'RSUP Dr. Wahidin - Ruang Bedah',
                'jenis_permintaan' => 'Darah Lengkap (Whole Blood)',
                'tingkat_urgensi' => 'Sangat Mendesak',
                'nama_kontak' => 'Wati Suryani',
                'no_hp' => '088901234567',
                'hubungan' => 'Istri',
                'status_permintaan' => 'Requesting',
            ],
        ];

        foreach ($permintaanData as $data) {
            PermintaanDonor::create($data);
        }
    }
}