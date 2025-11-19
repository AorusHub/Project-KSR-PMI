<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'otp_code',           // ✅ Tambahkan
        'otp_expires_at',     // ✅ Tambahkan
        'is_verified',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    public function pendonor()
    {
        return $this->hasOne(Pendonor::class, 'user_id', 'user_id');
    }

    public function isAdmin()
    {
        return strtolower($this->role) === 'admin';
    }

    public function isStaf()
    {
        return strtolower($this->role) === 'staf';
    }

    public function isPendonor()
    {
        return strtolower($this->role) === 'pendonor';
    }
}