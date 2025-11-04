<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user'; // Fix: use correct primary key

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

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function pendonor()
    {
        return $this->hasOne(Pendonor::class, 'id_user', 'id_user'); // Fix: use correct keys
    }

    public function anggota()
    {
        return $this->hasOne(Anggota::class, 'id_user', 'id_user'); // Fix: use correct keys
    }

    // Helper methods for role checking
    public function isAdmin()
    {
        return $this->role === 'Admin';
    }

    public function isStaf()
    {
        return $this->role === 'Staf';
    }

    public function isPendonor()
    {
        return $this->role === 'Pendonor';
    }
}