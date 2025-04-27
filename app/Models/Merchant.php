<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Merchant extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'name', 
        'business_name', 
        'email', 
        'phone_number', 
        'address', 
        'city', 
        'province', 
        'postal_code', 
        'status', 
        'logo', 
        'description', 
        'website', 
        'social_media'
    ];

    protected $hidden = [
        'password', 
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'social_media' => 'array',
        'status' => 'string'
    ];

    // Relasi ke outlet
    public function outlets()
    {
        return $this->hasMany(MerchantOutlet::class);
    }

    // Relasi ke subscription
    public function subscriptions()
    {
        return $this->hasMany(MerchantSubscription::class);
    }

    // Scope untuk merchant aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Cek apakah merchant memiliki outlet aktif
    public function hasActiveOutlets()
    {
        return $this->outlets()->where('status', 'active')->exists();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Mendapatkan subscription aktif terakhir
    public function getCurrentSubscription()
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->latest('end_date')
            ->first();
    }

    // Method untuk mengupdate profil
    public function updateProfile(array $data)
    {
        $updateFields = [
            'name', 'business_name', 'address', 
            'city', 'province', 'postal_code', 
            'logo', 'description', 'website', 
            'social_media'
        ];

        foreach ($updateFields as $field) {
            if (isset($data[$field])) {
                $this->$field = $data[$field];
            }
        }

        $this->save();
        return $this;
    }
}
