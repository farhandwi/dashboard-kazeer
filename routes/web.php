<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\MerchantOutletController;
use App\Http\Controllers\MerchantSubscriptionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SubscriptionPaymentController;
use App\Http\Controllers\SubscriptionPlanController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/home', function () {
    return view('home');
})->name(name: 'user.dashboard');

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/admin/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin.access'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('admin.dashboard');

    // Merchant Routes
    Route::resource('admin/merchants', MerchantController::class);
    Route::resource('admin/subscription-plans', SubscriptionPlanController::class);
    Route::resource('admin/merchant-subscriptions', MerchantSubscriptionController::class)
        ->only(['index', 'show']);
    Route::resource('admin/subscription-payments', SubscriptionPaymentController::class)
        ->only(['index', 'show']);

    // Merchant Outlet Routes
    Route::get('/admin/merchants/{merchant}/outlets', [MerchantOutletController::class, 'index'])
        ->name('merchants.outlets.index');
    Route::get('/admin/merchants/{merchant}/outlets/create', [MerchantOutletController::class, 'create'])
        ->name('merchants.outlets.create');
    Route::post('/admin/merchants/{merchant}/outlets', [MerchantOutletController::class, 'store'])
        ->name('merchants.outlets.store');
    Route::get('/admin/merchants/{merchant}/outlets/{outlet}/edit', [MerchantOutletController::class, 'edit'])
        ->name('merchants.outlets.edit');
    Route::put('/admin/merchants/{merchant}/outlets/{outlet}', [MerchantOutletController::class, 'update'])
        ->name('merchants.outlets.update');
    Route::delete('/admin/merchants/{merchant}/outlets/{outlet}', [MerchantOutletController::class, 'destroy'])
        ->name('merchants.outlets.destroy');
});

// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
//     ->name('logout');

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])
    ->name('google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])
    ->name('google.callback');

Route::middleware(['auth'])->group(function () {
    Route::get('/subscription/choose-plan', [SubscriptionController::class, 'choosePlan'])
        ->name('subscription.choose-plan');
    
    Route::get('/subscription/create-merchant', [SubscriptionController::class, 'showCreateMerchantForm'])
        ->name('subscription.create-merchant');
    
    Route::post('/subscription/create-merchant', [SubscriptionController::class, 'createMerchant'])
        ->name('subscription.store-merchant');
    
    Route::post('/subscription/process', [SubscriptionController::class, 'processSubscription'])
        ->name('subscription.process');
    
    Route::get('/subscription/success', [SubscriptionController::class, 'subscriptionSuccess'])
        ->name('subscription.success');
    
    Route::get('/subscription/failed', [SubscriptionController::class, 'subscriptionFailed'])
        ->name('subscription.failed');
});

// Xendit Callback (Outside auth middleware)
Route::post('/xendit/callback', [SubscriptionController::class, 'handleXenditCallback'])
    ->name('xendit.callback');

require __DIR__.'/auth.php';
