<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\User;
use App\Models\PermintaanDonor;
use App\Models\KegiatanDonor;
use App\Models\Pendonor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NotifikasiController extends Controller
{
    public function getLatest()
    {
        if (!Auth::check()) {
            return response()->json([], 401);
        }

        $notifications = Notifikasi::where('user_id', Auth::id())
            ->orderBy('tanggal_notifikasi', 'desc')
            ->take(5)
            ->get()
            ->map(function($notif) {
                return [
                    'id' => $notif->notifikasi_id,
                    'jenis' => $notif->jenis_notifikasi,
                    'isi' => $notif->pesan_notif,
                    'dibaca' => (bool)$notif->status_baca,
                    'waktu' => $notif->tanggal_notifikasi->diffForHumans(),
                    'icon_type' => $this->getIconType($notif->jenis_notifikasi),
                    'url' => $this->getNotificationUrl($notif->jenis_notifikasi),
                ];
            });

        return response()->json($notifications);
    }

    public function getUnreadCount()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0], 401);
        }

        $count = Notifikasi::where('user_id', Auth::id())
            ->where('status_baca', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    public function markAsRead($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false], 401);
        }

        $notif = Notifikasi::where('notifikasi_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($notif) {
            $notif->update(['status_baca' => true]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function markAllAsRead()
    {
        if (!Auth::check()) {
            return response()->json(['success' => false], 401);
        }

        Notifikasi::where('user_id', Auth::id())
            ->where('status_baca', false)
            ->update(['status_baca' => true]);

        return response()->json(['success' => true]);
    }

    // ========== STATIC METHODS UNTUK KIRIM NOTIFIKASI ==========

    /**
     * ✅ Kirim notifikasi kegiatan baru HANYA ke admin & staf
     */
    public static function sendNewActivityNotification($kegiatan)
    {
        $adminStaff = User::whereIn('role', ['admin', 'staf'])
        ->where('user_id', '!=', $kegiatan->created_by)
        ->whereDoesntHave('pendonor')
        ->get();
        
        foreach ($adminStaff as $user) {
            Notifikasi::create([
                'user_id' => $user->user_id,
                'jenis_notifikasi' => 'Kegiatan Baru',
                'pesan_notif' => "📢 Kegiatan baru '{$kegiatan->nama_kegiatan}' telah dibuat untuk tanggal " . \Carbon\Carbon::parse($kegiatan->tanggal)->format('d/m/Y'),
                'status_baca' => false,
                'tanggal_notifikasi' => now(),
            ]);
        }
    }

    /**
     * Kirim notifikasi permintaan sangat mendesak ke admin & staf
     */
    public static function sendUrgentRequestToAdminStaff($permintaanDarah)
    {
        $users = User::whereIn('role', ['admin', 'staf'])->get();
        
        foreach ($users as $user) {
            Notifikasi::create([
                'user_id' => $user->user_id,
                'jenis_notifikasi' => 'Permintaan Sangat Mendesak',
                'pesan_notif' => "🚨 SANGAT MENDESAK! Permintaan darah {$permintaanDarah->gol_darah} sebanyak {$permintaanDarah->jumlah_kantong} kantong untuk {$permintaanDarah->nama_pasien}",
                'status_baca' => false,
                'tanggal_notifikasi' => now(),
            ]);
        }
    }

    /**
     * Kirim notifikasi permintaan sangat mendesak ke pendonor yang sesuai
     */
    public static function sendUrgentRequestToDonor($permintaanDarah)
    {
        $pendonors = Pendonor::where('golongan_darah', $permintaanDarah->gol_darah)
            ->with('user')
            ->get();
        
        foreach ($pendonors as $pendonor) {
            // ✅ PERBAIKI: Gunakan $pendonor->user->user_id, bukan $pendonor->user_id
            if ($pendonor->user) {
                Notifikasi::create([
                    'user_id' => $pendonor->user->user_id,
                    'jenis_notifikasi' => 'Permintaan Sangat Mendesak',
                    'pesan_notif' => "🚨 SANGAT MENDESAK! Dibutuhkan donor {$permintaanDarah->gol_darah} sebanyak {$permintaanDarah->jumlah_kantong} kantong. Segera donor!",
                    'status_baca' => false,
                    'tanggal_notifikasi' => now(),
                ]);
            }
        }
    }

    /**
     * ✅ Kirim notifikasi kegiatan dimulai ke admin, staf, DAN pendonor yang terdaftar
     */
    public static function sendActivityStarted($kegiatan)
    {
        // 1. Notif ke admin & staf
        $adminStaff = User::whereIn('role', ['admin', 'staf'])->get();
        foreach ($adminStaff as $user) {
            Notifikasi::create([
                'user_id' => $user->user_id,
                'jenis_notifikasi' => 'Kegiatan Dimulai',
                'pesan_notif' => "📍 Kegiatan '{$kegiatan->nama_kegiatan}' telah dimulai di {$kegiatan->lokasi}",
                'status_baca' => false,
                'tanggal_notifikasi' => now(),
            ]);
        }

        // 2. ✅ Notif ke PENDONOR yang terdaftar di kegiatan (dari DonasiDarah)
        $donasiDarah = \App\Models\DonasiDarah::where('kegiatan_id', $kegiatan->kegiatan_id)
            ->whereHas('pendonor.user')
            ->with(['pendonor.user'])
            ->get();
        
        foreach ($donasiDarah as $donasi) {
            if ($donasi->pendonor && $donasi->pendonor->user) {
                Notifikasi::create([
                    'user_id' => $donasi->pendonor->user->user_id,
                    'jenis_notifikasi' => 'Kegiatan Dimulai',
                    'pesan_notif' => "📍 Kegiatan '{$kegiatan->nama_kegiatan}' yang Anda ikuti telah dimulai di {$kegiatan->lokasi}. Silakan datang!",
                    'status_baca' => false,
                    'tanggal_notifikasi' => now(),
                ]);
            }
        }
    }

    /**
     * ✅ Kirim notifikasi kegiatan selesai ke admin, staf, DAN pendonor yang terdaftar
     */
    public static function sendActivityFinished($kegiatan)
    {
        // 1. Notif ke admin & staf
        $adminStaff = User::whereIn('role', ['admin', 'staf'])->get();
        foreach ($adminStaff as $user) {
            Notifikasi::create([
                'user_id' => $user->user_id,
                'jenis_notifikasi' => 'Kegiatan Selesai',
                'pesan_notif' => "✅ Kegiatan '{$kegiatan->nama_kegiatan}' telah selesai. Terima kasih atas partisipasinya!",
                'status_baca' => false,
                'tanggal_notifikasi' => now(),
            ]);
        }

        // 2. ✅ Notif ke PENDONOR yang terdaftar di kegiatan (dari DonasiDarah)
        $donasiDarah = \App\Models\DonasiDarah::where('kegiatan_id', $kegiatan->kegiatan_id)
            ->whereHas('pendonor.user')
            ->with(['pendonor.user'])
            ->get();

        foreach ($donasiDarah as $donasi) {
            if ($donasi->pendonor && $donasi->pendonor->user) {
                Notifikasi::create([
                    'user_id' => $donasi->pendonor->user->user_id,
                    'jenis_notifikasi' => 'Kegiatan Selesai',
                    'pesan_notif' => "✅ Kegiatan '{$kegiatan->nama_kegiatan}' telah selesai. Terima kasih telah berpartisipasi sebagai pendonor!",
                    'status_baca' => false,
                    'tanggal_notifikasi' => now(),
                ]);
            }
        }
    }

    /**
     * Check status kegiatan dan kirim notifikasi otomatis
     * Bisa dipanggil manual atau via cron job
     */
    public function checkActivityStatus()
    {
        $now = Carbon::now();

        // ✅ PERBAIKI: Gunakan field 'tanggal' dan 'status', bukan 'tanggal_kegiatan' dan 'status_kegiatan'
        // Cek kegiatan yang baru dimulai (dalam 5 menit terakhir)
        $startedActivities = KegiatanDonor::where('tanggal', '<=', $now)
            ->where('tanggal', '>=', $now->copy()->subMinutes(5))
            ->where('status', 'Planned')
            ->get();

        foreach ($startedActivities as $activity) {
            $activity->update(['status' => 'Ongoing']);
            self::sendActivityStarted($activity);
        }

        // Cek kegiatan yang baru selesai (4 jam setelah dimulai)
        $finishedActivities = KegiatanDonor::where('tanggal', '<=', $now->copy()->subHours(4))
            ->whereIn('status', ['Planned', 'Ongoing'])
            ->get();

        foreach ($finishedActivities as $activity) {
            $activity->update(['status' => 'Completed']);
            self::sendActivityFinished($activity);
        }

        return response()->json([
            'success' => true,
            'started' => $startedActivities->count(),
            'finished' => $finishedActivities->count(),
        ]);
    }

    // ========== PRIVATE HELPER METHODS ==========

    private function getNotificationUrl($jenis)
    {
        $user = Auth::user();
    
        return match($jenis) {
            'Kegiatan Baru' => in_array($user->role, ['admin', 'staf']) 
                ? route('managemen.kegiatan.index')
                : route('kegiatan.index'),
            'Permintaan Darurat', 'Permintaan Sangat Mendesak' => $user->role === 'pendonor'
                ? route('pendonor.permintaan-darah')
                : route('managemen.permintaan-darurat.index'),
            'Kegiatan Dimulai', 'Kegiatan Selesai' => in_array($user->role, ['admin', 'staf'])
                ? route('managemen.kegiatan.index')
                : route('kegiatan.index'),
            'Donasi Berhasil' => route('pendonor.riwayat-donor'),
            'Pengingat' => route('pendonor.dashboard'),
            default => route('home'),
        };
    }

    private function getIconType($jenis)
    {
        return match($jenis) {
            'Kegiatan Baru', 'Kegiatan Dimulai' => 'blue',
            'Kegiatan Selesai', 'Donasi Berhasil' => 'green',
            'Pengingat' => 'yellow',
            'Permintaan Darurat', 'Permintaan Sangat Mendesak' => 'red',
            default => 'gray',
        };
    }
}