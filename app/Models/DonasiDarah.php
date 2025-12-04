<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Models\DonasiDarah.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonasiDarah extends Model
{
    protected $table = 'donasi_darah';
    protected $primaryKey = 'donasi_id';

    protected $fillable = [
        'pendonor_id',
        'kegiatan_id',
        'permintaan_id',
        'tanggal_donasi',
        'jenis_donor',
        'lokasi_donor',      // ✅ HARUS ADA INI
        'volume_darah',
        'status_donasi',
    ];

    protected $casts = [
        'tanggal_donasi' => 'date',
        'verified_at' => 'datetime',
    ];

    // Relasi ke Pendonor
    public function pendonor()
    {
        return $this->belongsTo(Pendonor::class, 'pendonor_id', 'pendonor_id');
    }

    // Relasi ke Kegiatan Donor
    public function kegiatan()
    {
        return $this->belongsTo(KegiatanDonor::class, 'kegiatan_id', 'kegiatan_id');
    }

        public function permintaan()
    {
        return $this->belongsTo(PermintaanDonor::class, 'permintaan_id', 'permintaan_id');
    }
    
    // Relasi ke User yang verifikasi
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by', 'user_id');
    }

    
}