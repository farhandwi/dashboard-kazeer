<?php

namespace App\Http\Controllers;

use App\Models\MerchantSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class MerchantSubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $merchantSubscriptions = MerchantSubscription::query()
            ->with([
                'merchant', 
                'subscriptionPlan'
            ])
            ->when($request->input('search'), function ($query, $search) {
                $query->whereHas('merchant', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('business_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
    
        return Inertia::render('MerchantSubscriptions/Index', [
            'merchantSubscriptions' => $merchantSubscriptions,
            'filters' => $request->only(['search']),
            'auth' => [
                'user' => $request->user()
            ]
        ]);
    }
}