<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Models\Pendonor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendonor extends Model
{
    use HasFactory;

    protected $table = 'pendonor';
    protected $primaryKey = 'id_pendonor';

    protected $fillable = [
        'id_user',
        'NIK',
        'alamat',
        'tgl_lahir',
        'golongan_darah',
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function pendaftaranKegiatan()
    {
        return $this->hasMany(PendaftaranKegiatan::class, 'id_pendonor', 'id_pendonor');
    }

    public function partisipanKegiatan()
    {
        return $this->hasMany(PartisipanKegiatan::class, 'id_pendonor', 'id_pendonor');
    }

    public function riwayatMedis()
    {
        return $this->hasMany(RiwayatMedis::class, 'id_pendonor', 'id_pendonor');
    }

    public function donasiDarah()
    {
        return $this->hasMany(DonasiDarah::class, 'id_pendonor', 'id_pendonor');
    }
}