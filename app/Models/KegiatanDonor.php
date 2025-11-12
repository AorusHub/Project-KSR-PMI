<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Models\KegiatanDonor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanDonor extends Model
{
    protected $table = 'kegiatan_donor';
    protected $primaryKey = 'kegiatan_id';

    protected $fillable = [
        'nama_kegiatan',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'deskripsi',
        'target_donor',
        'status',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_mulai' => 'datetime:H:i',
        'waktu_selesai' => 'datetime:H:i',
    ];

    // Relasi ke User (pembuat kegiatan)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    // Relasi ke DonasiDarah
    public function donasiDarah()
    {
        return $this->hasMany(DonasiDarah::class, 'kegiatan_id', 'kegiatan_id');
    }
}