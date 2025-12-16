<?php

// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\database\seeders\DonasiDarahSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DonasiDarahSeeder extends Seeder
{
    public function run(): void
    {
        $pendonor = DB::table('pendonor')->get();
        $kegiatan = DB::table('kegiatan_donor')
            ->where('status', 'Completed')
            ->get();
        
        if ($pendonor->isEmpty() || $kegiatan->isEmpty()) {
            $this->command->warn('Tidak ada data pendonor atau kegiatan.');
            return;
        }

        $targetPerBulan = [
            '2024-07' => 142,
            '2024-08' => 156,
            '2024-09' => 168,
            '2024-10' => 174,
            '2024-11' => 238,
            '2024-12' => 142,
        ];

        $donasi = [];
        $pendonorUsed = [];

        foreach ($targetPerBulan as $bulan => $target) {
            $pendonorUsed[$bulan] = [];
            
            $kegiatanBulanIni = $kegiatan->filter(function($k) use ($bulan) {
                return Carbon::parse($k->tanggal)->format('Y-m') === $bulan;
            });

            if ($kegiatanBulanIni->isEmpty()) {
                continue;
            }

            $jumlahDonasi = 0;

            foreach ($kegiatanBulanIni as $keg) {
                $donasiPerKegiatan = rand(40, 80);
                
                if ($jumlahDonasi + $donasiPerKegiatan > $target) {
                    $donasiPerKegiatan = $target - $jumlahDonasi;
                }

                $availablePendonor = $pendonor->filter(function($p) use ($pendonorUsed, $bulan) {
                    return !in_array($p->pendonor_id, $pendonorUsed[$bulan] ?? []);
                })->shuffle();

                for ($i = 0; $i < $donasiPerKegiatan && $i < $availablePendonor->count(); $i++) {
                    $selectedPendonor = $availablePendonor[$i];
                    
                    $pendonorUsed[$bulan][] = $selectedPendonor->pendonor_id;
                    
                    // Status donasi (95% berhasil, 5% gagal)
                    $statusDonasi = rand(1, 100) <= 95 ? 'Berhasil' : 'Dibatalkan';
                    
                    // Tanggal donasi = tanggal kegiatan
                    $tanggalDonasi = Carbon::parse($keg->tanggal);
                    
                    // Jenis donor (90% sukarela, 10% pengganti)
                    $jenisDonor = rand(1, 100) <= 90 ? 'Sukarela' : 'Pengganti';
                    
                    // ✅ Jumlah kantong (1-2 kantong, mayoritas 1 kantong)
                    $jumlahKantongOptions = [1, 1, 1, 1, 2]; // 80% = 1 kantong, 20% = 2 kantong
                    $jumlahKantong = $jumlahKantongOptions[array_rand($jumlahKantongOptions)];
                    
                    $donasi[] = [
                        'pendonor_id' => $selectedPendonor->pendonor_id,
                        'tanggal_donasi' => $tanggalDonasi->format('Y-m-d'),
                        'jenis_donor' => $jenisDonor,
                        'kegiatan_id' => $keg->kegiatan_id,
                        'permintaan_id' => null,
                        'lokasi_donor' => $keg->lokasi,
                        'jumlah_kantong' => $jumlahKantong,
                        'status_donasi' => $statusDonasi,
                        'created_at' => $tanggalDonasi->setTime(rand(8, 14), rand(0, 59)),
                        'updated_at' => $tanggalDonasi->copy()->addMinutes(rand(30, 120)),
                    ];
                    
                    $jumlahDonasi++;
                }

                if ($jumlahDonasi >= $target) {
                    break;
                }
            }
        }

        // Insert dalam batch untuk performa
        foreach (array_chunk($donasi, 100) as $chunk) {
            DB::table('donasi_darah')->insert($chunk);
        }

        $this->command->info('Berhasil menambahkan ' . count($donasi) . ' data donasi darah!');
    }
}