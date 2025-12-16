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

        // ✅ Hitung total permintaan mendesak yang masih Pending
        $totalMendesak = PermintaanDonor::whereIn('tingkat_urgensi', ['Mendesak', 'Sangat Mendesak'])
            ->where('status_permintaan', 'Pending')
            ->count();

        // ✅ HANYA kirim ke ADMIN & STAF (bukan pendonor)
        $adminStaff = User::whereIn('role', ['admin', 'staf'])->get();

        foreach ($adminStaff as $user) {
            // ✅ Cari notifikasi BELUM DIBACA yang sudah ada
            $existingNotif = Notifikasi::where('user_id', $user->user_id)
                ->where('jenis_notifikasi', 'Permintaan Darurat')
                ->where('status_baca', false)
                ->first();
            
            if ($existingNotif) {
                // ✅ UPDATE notifikasi yang ada
                $existingNotif->update([
                    'pesan_notif' => "🚨 Terdapat {$totalMendesak} permintaan donor mendesak yang membutuhkan perhatian segera!",
                    'tanggal_notifikasi' => now(),
                ]);
            } else {
                // ✅ BUAT notifikasi baru
                Notifikasi::create([
                    'user_id' => $user->user_id,
                    'judul_notif' => 'Permintaan Donor Mendesak!',
                    'jenis_notifikasi' => 'Permintaan Darurat',
                    'pesan_notif' => "🚨 Terdapat {$totalMendesak} permintaan donor mendesak yang membutuhkan perhatian segera!",
                    'status_baca' => false,
                    'tanggal_notifikasi' => now(),
                ]);
            }
        }
    }
}