<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\SubscriptionPlan;
use App\Models\MerchantSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Xendit\Xendit;

class SubscriptionController extends Controller
{
    public function choosePlan()
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Cek apakah user sudah memiliki merchant
        $merchant = Merchant::where('user_id', Auth::id())->first();

        $plans = SubscriptionPlan::active()->get();

        return Inertia::render('Subscription/ChoosePlan', [
            'plans' => $plans,
            'hasMerchant' => $merchant !== null
        ]);
    }

    public function createMerchant(Request $request)
    {
        // Debugging: Tambahkan log untuk melihat semua data
        Log::info('Request Data:', $request->all());

        $userId = Auth::id();
        Log::info('User ID: ' . $userId);

        // Cek apakah user sudah memiliki merchant
        $existingMerchant = Merchant::where('user_id', Auth::id())->first();
        
        if ($existingMerchant) {
            return redirect()->route('subscription.choose-plan')
                ->with('error', 'Anda sudah memiliki profil merchant');
        }
    
        $request->validate([
            'name' => 'required|string|max:255',
            'business_name' => 'required|string|max:255',
            'email' => 'required|email|unique:merchants,email',
            'phone_number' => 'required|string|unique:merchants,phone_number',
            'address' => 'required|string',
            'city' => 'required|string',
            'province' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'description' => 'nullable|string'
        ]);
    
        $merchant = Merchant::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'business_name' => $request->business_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'description' => $request->description,
        ]);
    
        return redirect()->route('subscription.choose-plan')->with('success', 'Profil merchant berhasil dibuat');
    }

    public function processSubscription(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id'
        ]);

        // Pastikan user sudah memiliki merchant
        $merchant = Merchant::where('user_id', Auth::id())->firstOrFail();

        $plan = SubscriptionPlan::findOrFail($request->plan_id);

        // Inisialisasi Xendit
        Xendit::setApiKey(config('services.xendit.secret_key'));

        try {
            // Buat invoice di Xendit
            $invoice = \Xendit\Invoice::create([
                'external_id' => 'subscription_' . uniqid(),
                'amount' => $plan->price,
                'payer_email' => $merchant->email,
                'description' => "Langganan {$plan->name} untuk {$merchant->business_name}",
                'success_redirect_url' => route('subscription.success'),
                'failure_redirect_url' => route('subscription.failed')
            ]);

            // Simpan invoice di database
            $merchantSubscription = MerchantSubscription::create([
                'merchant_id' => $merchant->id,
                'subscription_plan_id' => $plan->id,
                'start_date' => now(),
                'end_date' => now()->addDays($plan->duration_days),
                'status' => 'pending',
                'payment_status' => 'pending',
                'transaction_id' => $invoice['id'],
                'paid_amount' => $plan->price
            ]);

            // Redirect ke halaman pembayaran Xendit
            return redirect($invoice['invoice_url']);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat invoice: ' . $e->getMessage());
        }
    }

    public function handleXenditCallback(Request $request)
    {
        // Validasi callback dari Xendit
        $status = $request->input('status');
        $externalId = $request->input('external_id');

        $merchantSubscription = MerchantSubscription::where('transaction_id', $request->input('id'))->first();

        if ($merchantSubscription) {
            if ($status === 'PAID') {
                $merchantSubscription->update([
                    'status' => 'active',
                    'payment_status' => 'success'
                ]);
            } else {
                $merchantSubscription->update([
                    'status' => 'failed',
                    'payment_status' => 'failed'
                ]);
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function showCreateMerchantForm()
    {
        return Inertia::render('Subscription/CreateMerchant', [
            'auth' => [
                'user' => Auth::user()
            ]
        ]);
    }
}