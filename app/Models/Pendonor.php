<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Models\Pendonor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendonor extends Model
{
    protected $table = 'pendonor';
    protected $primaryKey = 'pendonor_id';
    
    protected $fillable = [
        'user_id',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'alamat',
        'no_hp',
        'berat_badan',
        'riwayat_penyakit',
        'status_kesehatan'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'berat_badan' => 'decimal:2'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Relasi ke DonasiDarah
    public function donasiDarah()
    {
        return $this->hasMany(DonasiDarah::class, 'pendonor_id', 'pendonor_id');
    }

    // Helper: Hitung usia
    public function getUsiaAttribute()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : null;
    }
}