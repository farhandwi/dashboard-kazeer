<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'google_id', 
        'role', 
        'avatar', 
        'is_active'
    ];

    protected $hidden = [
        'password', 
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    // Cek role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isMerchant()
    {
        return $this->role === 'merchant';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function merchant()
    {
        return $this->hasOne(Merchant::class);
    }

    public function getAvatarAttribute()
    {
        // Jika tidak ada avatar, gunakan default
        return $this->attributes['avatar'] ?? 'path/to/default/avatar.png';
    }
}