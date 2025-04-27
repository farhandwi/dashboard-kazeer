<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class MerchantSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id', 
        'subscription_plan_id', 
        'start_date', 
        'end_date', 
        'status', 
        'payment_status', 
        'transaction_id', 
        'paid_amount'
    ];

    protected $dates = [
        'start_date', 
        'end_date'
    ];

    protected $casts = [
        'paid_amount' => 'float',
    ];

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function payments()
    {
        return $this->hasMany(SubscriptionPayment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                     ->whereDate('end_date', '>=', now());
    }

    public function isExpired()
    {
        return Carbon::parse($this->end_date)->isPast();
    }

    public function isActive()
    {
        return $this->status === 'active' && !$this->isExpired();
    }

    public function getRemainingDays()
    {
        return now()->diffInDays(Carbon::parse($this->end_date), false);
    }

    public function extend(SubscriptionPlan $plan)
    {
        $this->subscription_plan_id = $plan->id;
        $this->start_date = now();
        $this->end_date = now()->addDays($plan->duration_days);
        $this->status = 'active';
        $this->save();

        return $this;
    }
}
