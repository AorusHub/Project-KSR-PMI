<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Models\KegiatanDonor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory;

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
        'rincian_lokasi', // ✅ TAMBAH
        'latitude',       // ✅ TAMBAH
        'longitude',      // ✅ TAMBAH
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

    /**
     * Get badge color based on status
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'Planned' => 'bg-blue-100 text-blue-800',
            'Ongoing' => 'bg-green-100 text-green-800',
            'Completed' => 'bg-gray-100 text-gray-800',
            'Cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'Planned' => 'Akan Datang',
            'Ongoing' => 'Berlangsung',
            'Completed' => 'Selesai',
            'Cancelled' => 'Dibatalkan',
            default => 'Unknown',
        };
    }
}