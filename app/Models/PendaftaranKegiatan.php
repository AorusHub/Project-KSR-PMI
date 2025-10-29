<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Models\PendaftaranKegiatan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranKegiatan extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_kegiatan';
    protected $primaryKey = 'id_pendaftaran';

    protected $fillable = [
        'id_pendonor',
        'id_kegiatan',
        'tgl_daftar',
        'status_pendaftaran',
        'tgl_acc',
    ];

    protected $casts = [
        'tgl_daftar' => 'date',
        'tgl_acc' => 'date',
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
}