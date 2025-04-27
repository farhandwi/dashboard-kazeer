<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_subscription_id', 
        'payment_gateway', 
        'external_payment_id', 
        'amount', 
        'status', 
        'payment_details'
    ];

    protected $casts = [
        'payment_details' => 'array'
    ];

    // Relasi ke merchant subscription
    public function merchantSubscription()
    {
        return $this->belongsTo(MerchantSubscription::class);
    }

    // Scope untuk pembayaran berhasil
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'success');
    }

    // Method untuk mencatat pembayaran
    public static function recordPayment(
        MerchantSubscription $subscription, 
        $gateway, 
        $externalPaymentId, 
        $amount, 
        $status = 'pending', 
        $details = null
    ) {
        return self::create([
            'merchant_subscription_id' => $subscription->id,
            'payment_gateway' => $gateway,
            'external_payment_id' => $externalPaymentId,
            'amount' => $amount,
            'status' => $status,
            'payment_details' => $details
        ]);
    }
}