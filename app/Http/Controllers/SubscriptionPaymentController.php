<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class SubscriptionPaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = SubscriptionPayment::query()
            ->with(['merchantSubscription.subscriptionPlan', 'merchantSubscription.merchant'])
            ->when($request->input('search'), function ($query, $search) {
                $query->whereHas('merchantSubscription.merchant', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('business_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('SubscriptionPayments/Index', [
            'payments' => $payments,
            'filters' => $request->only(['search']),
            'auth' => [
                'user' => $request->user()
            ]
        ]);
    }
}