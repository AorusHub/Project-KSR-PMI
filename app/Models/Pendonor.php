<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendonor extends Model
{
    protected $table = 'pendonor';
    protected $primaryKey = 'pendonor_id';

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'no_hp',
        'NIK',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'alamat',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Relasi ke Donasi Darah
    public function donasiDarah()
    {
        return $this->hasMany(DonasiDarah::class, 'pendonor_id', 'pendonor_id');
    }
}