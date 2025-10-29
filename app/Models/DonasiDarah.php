<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Models\DonasiDarah.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonasiDarah extends Model
{
    use HasFactory;

    protected $table = 'donasi_darah';
    protected $primaryKey = 'id_donasi';

    protected $fillable = [
        'id_pendonor',
        'tgl_donasi',
        'jenis_donor',
        'id_kegiatan',
        'id_permintaan',
        'lokasi_donor',
        'status_donasi',
    ];

    protected $casts = [
        'tgl_donasi' => 'date',
    ];

    // Relationships
    public function pendonor()
    {
        return $this->belongsTo(Pendonor::class, 'id_pendonor', 'id_pendonor');
    }

    public function kegiatan()
    {
        return $this->belongsTo(KegiatanDonor::class, 'id_kegiatan', 'id_kegiatan');
    }

    public function permintaan()
    {
        return $this->belongsTo(PermintaanDonor::class, 'id_permintaan', 'id_permintaan');
    }
}