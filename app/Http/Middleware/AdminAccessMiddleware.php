<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Cek apakah URL dimulai dengan /admin
        if (str_starts_with($request->path(), 'admin')) {
            // Jika bukan admin, tolak akses
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('user.dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman admin.');
            }
        }

        return $next($request);
    }
}