<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Models\PendaftaranKegiatan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranKegiatan extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_kegiatan';
    protected $primaryKey = 'pendaftaran_id';

    protected $fillable = [
        'pendonor_id',
        'kegiatan_id',
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
        return $this->belongsTo(Pendonor::class, 'pendonor_id', 'pendonor_id');
    }

    public function kegiatan()
    {
        return $this->belongsTo(KegiatanDonor::class, 'kegiatan_id', 'kegiatan_id');
    }
}