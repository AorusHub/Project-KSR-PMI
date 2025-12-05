<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendonor extends Model
{
    protected $table = 'pendonor';
    protected $primaryKey = 'pendonor_id';

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'no_hp',
        'NIK',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'alamat',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Relasi ke Donasi Darah
    public function donasiDarah()
    {
        return $this->hasMany(DonasiDarah::class, 'pendonor_id', 'pendonor_id');
    }

    // ✅ RELASI KE VERIFIKASI KELAYAKAN
    public function verifikasiKelayakan()
    {
        return $this->hasMany(VerifikasiKelayakan::class, 'pendonor_id', 'pendonor_id');
    }

    // ✅ GET VERIFIKASI TERBARU
    public function verifikasiTerbaru()
    {
        return $this->hasOne(VerifikasiKelayakan::class, 'pendonor_id', 'pendonor_id')
            ->latest('created_at');
    }

    // ✅ HELPER METHOD CEK KELAYAKAN
    public function isLayakDonor()
    {
        $verifikasiTerbaru = $this->verifikasiTerbaru;
        
        if (!$verifikasiTerbaru) {
            return false; // Belum pernah verifikasi
        }

        // Cek apakah verifikasi terakhir statusnya "Layak"
        if ($verifikasiTerbaru->status_kelayakan !== 'Layak') {
            return false;
        }

        // Cek apakah verifikasi masih berlaku (misalnya 3 bulan)
        $expiredDate = $verifikasiTerbaru->verified_at?->addMonths(3);
        
        if (!$expiredDate || now()->gt($expiredDate)) {
            return false; // Verifikasi sudah expired
        }

        return true;
    }

    // ✅ GET STATUS KELAYAKAN TERKINI
    public function getStatusKelayakan()
    {
        $verifikasiTerbaru = $this->verifikasiTerbaru;
        
        if (!$verifikasiTerbaru) {
            return 'Belum Verifikasi';
        }

        return $verifikasiTerbaru->status_kelayakan;
    }
}