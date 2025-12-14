<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';
    protected $primaryKey = 'notifikasi_id';
    
    protected $fillable = [
        'user_id',
        'judul_notif',
        'jenis_notifikasi',
        'pesan_notif',
        'status_baca',
        'tanggal_notifikasi',
    ];

    protected $casts = [
        'status_baca' => 'boolean',
        'tanggal_notifikasi' => 'datetime',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}