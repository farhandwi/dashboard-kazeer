<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'price', 
        'duration_days', 
        'is_active', 
        'features'
    ];

    // Cast fitur ke tipe JSON
    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean'
    ];

    // Relasi ke merchant subscriptions
    public function merchantSubscriptions()
    {
        return $this->hasMany(MerchantSubscription::class);
    }

    // Scope untuk rencana aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Method untuk mengecek apakah fitur tersedia
    public function hasFeature($featureName)
    {
        $features = $this->features ?? [];
        return in_array($featureName, $features);
    }
}

