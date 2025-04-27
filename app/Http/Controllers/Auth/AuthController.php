<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            return match(Auth::user()->role) {
                'admin' => redirect()->route('dashboard'),
                'merchant' => redirect()->route('merchants.index'),
                default => redirect()->route('user.dashboard')
            };
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // Redirect ke Google OAuth
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback dari Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari atau buat user
            $user = User::firstOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => bcrypt(Str::random(20)),
                    'role' => 'user'
                ]
            );

            // Login user
            Auth::login($user);

            // Redirect berdasarkan role
            return match($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                default => redirect()->route('admin.dashboard')
            };
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login dengan Google');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}