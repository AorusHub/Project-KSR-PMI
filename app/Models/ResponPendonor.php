<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponPendonor extends Model
{
    protected $table = 'respon_pendonor';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'permintaan_id',
        'user_id',
        'pendonor_id',
        'nama_pendonor',
        'tgl_lahir',
        'gol_darah',
        'no_telp',
        'status'
    ];

    // ✅ RELASI BALIK KE PERMINTAAN
    public function permintaan()
    {
        return $this->belongsTo(PermintaanDonor::class, 'permintaan_id', 'permintaan_id');
    }
    
    // ✅ RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}