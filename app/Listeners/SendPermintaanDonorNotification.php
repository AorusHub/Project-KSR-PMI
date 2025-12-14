<?php

namespace App\Listeners;

use App\Events\PermintaanDonorCreated;
use App\Models\Notifikasi;
use App\Models\User;
use App\Models\PermintaanDonor;

class SendPermintaanDonorNotification
{
    public function handle(PermintaanDonorCreated $event)
    {
        // ✅ HANYA kirim notif jika permintaan Mendesak atau Sangat Mendesak
        if (!in_array($event->permintaan->tingkat_urgensi, ['Mendesak', 'Sangat Mendesak'])) {
            return; // Skip jika tidak mendesak
        }

        // ✅ Hitung total permintaan mendesak yang masih Pending/Requesting
        $totalMendesak = PermintaanDonor::whereIn('tingkat_urgensi', ['Mendesak', 'Sangat Mendesak'])
            ->whereIn('status_permintaan', ['Pending', 'Requesting'])
            ->count();

        // ✅ Kirim notifikasi ke SEMUA PENDONOR
        $pendonors = User::where('role', 'pendonor')->get();

        foreach ($pendonors as $pendonor) {
            Notifikasi::create([
                'user_id' => $pendonor->user_id,
                'judul_notif' => 'Permintaan Donor Mendesak!',
                'jenis_notifikasi' => 'Permintaan Darurat',
                'pesan_notif' => "Ada {$totalMendesak} permintaan donor mendesak yang membutuhkan bantuan Anda. Klik untuk lihat detail.",
                'status_baca' => false,
                'tanggal_notifikasi' => now(),
            ]);
        }
    }
}