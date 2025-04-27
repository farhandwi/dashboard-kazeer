<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MerchantOutlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id', 
        'name', 
        'address', 
        'city', 
        'province', 
        'postal_code', 
        'phone_number', 
        'latitude', 
        'longitude', 
        'status'
    ];

    // Relasi ke merchant
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    // Scope untuk outlet aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Generate unique QR code untuk outlet
    public function generateQRCode()
    {
        // Implementasi generate QR code unik
        // Contoh sederhana:
        return hash('sha256', $this->id . $this->merchant_id . now());
    }
}