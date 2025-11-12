<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Models\User.php

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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi ke Pendonor
    public function pendonor()
    {
        return $this->hasOne(Pendonor::class, 'user_id', 'user_id');
    }

    // Helper methods untuk cek role (gunakan lowercase)
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