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
    /**
     * ✅ Get latest notifications dengan format lengkap
     */
    public function getLatest()
    {
        if (!Auth::check()) {
            return response()->json([], 401);
        }

        $notifications = Notifikasi::where('user_id', Auth::id())
            ->orderBy('tanggal_notifikasi', 'desc')
            ->take(10)
            ->get()
            ->map(function($notif) {
                return [
                    'id' => $notif->notifikasi_id,
                    'jenis' => $notif->judul_notif ?? $notif->jenis_notifikasi,
                    'isi' => $notif->pesan_notif,
                    'waktu' => $this->getRelativeTime($notif->tanggal_notifikasi),
                    'dibaca' => (bool) $notif->status_baca,
                    'icon_type' => $this->getIconType($notif->jenis_notifikasi),
                    'url' => $this->getNotificationUrl($notif->jenis_notifikasi)
                ];
            });

        return response()->json($notifications);
    }

    /**
     * ✅ Get unread count
     */
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

    /**
     * ✅ Mark single notification as read
     */
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

    /**
     * ✅ Mark all notifications as read
     */
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
     * ✅ Kirim notifikasi kegiatan dimulai ke SEMUA USER (admin, staf, pendonor)
     */
    public static function sendActivityStarted($kegiatan)
    {
        // ✅ Kirim ke SEMUA USER (admin, staf, pendonor)
        $allUsers = User::whereIn('role', ['admin', 'staf', 'pendonor'])->get();

        foreach ($allUsers as $user) {
            Notifikasi::create([
                'user_id' => $user->user_id,
                'judul_notif' => 'Kegiatan Dimulai',
                'jenis_notifikasi' => 'Kegiatan Dimulai',
                'pesan_notif' => "Kegiatan '{$kegiatan->nama_kegiatan}' telah dimulai di {$kegiatan->lokasi}.",
                'status_baca' => false,
                'tanggal_notifikasi' => now(),
            ]);
        }
    }

    /**
     * ✅ Kirim notifikasi kegiatan selesai ke SEMUA USER (admin, staf, pendonor)
     */
    public static function sendActivityFinished($kegiatan)
    {
        // ✅ Kirim ke SEMUA USER (admin, staf, pendonor)
        $allUsers = User::whereIn('role', ['admin', 'staf', 'pendonor'])->get();

        foreach ($allUsers as $user) {
            Notifikasi::create([
                'user_id' => $user->user_id,
                'judul_notif' => 'Kegiatan Selesai',
                'jenis_notifikasi' => 'Kegiatan Selesai',
                'pesan_notif' => "Kegiatan '{$kegiatan->nama_kegiatan}' telah selesai. Terima kasih atas partisipasinya!",
                'status_baca' => false,
                'tanggal_notifikasi' => now(),
            ]);
        }
    }

    /**
     * ✅ Kirim notifikasi ke pendonor saat permintaan jadi "Requesting"
     */
    public static function sendRequestingToDonor($permintaan)
    {
        // Hitung total permintaan "Requesting" yang mendesak
        $totalRequesting = PermintaanDonor::whereIn('tingkat_urgensi', ['Mendesak', 'Sangat Mendesak'])
            ->where('status_permintaan', 'Requesting')
            ->count();

        // ✅ Kirim ke SEMUA PENDONOR
        $pendonors = User::where('role', 'pendonor')
            ->whereHas('pendonor')
            ->get();

        foreach ($pendonors as $pendonor) {
            // ✅ Cari notifikasi BELUM DIBACA yang sudah ada
            $existingNotif = Notifikasi::where('user_id', $pendonor->user_id)
                ->where('jenis_notifikasi', 'Permintaan Darurat')
                ->where('status_baca', false)
                ->first();
            
            if ($existingNotif) {
                // ✅ UPDATE notifikasi yang ada
                $existingNotif->update([
                    'pesan_notif' => "🩸 Terdapat {$totalRequesting} permintaan donor mendesak yang membutuhkan bantuan Anda!",
                    'tanggal_notifikasi' => now(),
                ]);
            } else {
                // ✅ BUAT notifikasi baru
                Notifikasi::create([
                    'user_id' => $pendonor->user_id,
                    'judul_notif' => 'Butuh Donor Darah!',
                    'jenis_notifikasi' => 'Permintaan Darurat',
                    'pesan_notif' => "🩸 Terdapat {$totalRequesting} permintaan donor mendesak yang membutuhkan bantuan Anda!",
                    'status_baca' => false,
                    'tanggal_notifikasi' => now(),
                ]);
            }
        }
    }

    /**
     * ✅ Check status kegiatan dan kirim notifikasi otomatis
     * Bisa dipanggil manual atau via cron job
     */
    public function checkActivityStatus()
    {
        $now = Carbon::now();

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

    /**
     * ✅ Get relative time (1 menit yang lalu, 1 jam yang lalu, dll)
     */
    private function getRelativeTime($date)
    {
        $now = now();
        $notifDate = Carbon::parse($date);
        
        // ✅ FIX: Hitung dari sekarang ke notifikasi (bukan sebaliknya)
        $diffInSeconds = $now->diffInSeconds($notifDate, false);
        
        // Jika negatif, berarti notifikasi di masa lalu
        if ($diffInSeconds < 0) {
            $diffInSeconds = abs($diffInSeconds);
        }
        
        // Format waktu
        if ($diffInSeconds < 60) {
            return 'Baru saja'; // Ganti "X detik yang lalu" jadi "Baru saja"
        } elseif ($diffInSeconds < 3600) {
            $minutes = floor($diffInSeconds / 60);
            return $minutes . ' menit yang lalu';
        } elseif ($diffInSeconds < 86400) {
            $hours = floor($diffInSeconds / 3600);
            return $hours . ' jam yang lalu';
        } elseif ($diffInSeconds < 604800) { // 7 hari
            $days = floor($diffInSeconds / 86400);
            return $days . ' hari yang lalu';
        } else {
            // Lebih dari 7 hari → tampilkan tanggal
            return $notifDate->locale('id')->isoFormat('D MMM Y');
        }
    }

    /**
     * ✅ Get notification URL berdasarkan jenis dan role user
     */
    private function getNotificationUrl($jenis)
    {
        $user = Auth::user();
    
        return match($jenis) {
            'Kegiatan Baru' => in_array($user->role, ['admin', 'staf']) 
                ? route('admin.kegiatan.index')
                : route('kegiatan.index'),
            'Permintaan Darurat', 'Permintaan Sangat Mendesak' => $user->role === 'pendonor'
                ? route('pendonor.permintaan-darah')
                : route('admin.permintaan-darurat.index'),
            'Kegiatan Dimulai', 'Kegiatan Selesai' => in_array($user->role, ['admin', 'staf'])
                ? route('admin.kegiatan.index')
                : route('kegiatan.index'),
            'Donasi Berhasil' => route('pendonor.riwayat-donor'),
            'Pengingat' => route('pendonor.dashboard'),
            default => route('home'),
        };
    }

    /**
     * ✅ Get icon type berdasarkan jenis notifikasi
     */
    private function getIconType($jenis)
    {
        return match($jenis) {
            'Kegiatan Baru', 'Kegiatan Dimulai' => 'blue',
            'Kegiatan Selesai', 'Donasi Berhasil' => 'green',
            'Pengingat' => 'yellow',
            'Permintaan Darurat', 'Permintaan Sangat Mendesak' => 'red',
            default => 'blue',
        };
    }
}