<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PastikanPenugasanLengkap
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        // Admin tidak wajib mengisi penugasan.
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Halaman penugasan tetap boleh dibuka agar tidak terjadi redirect loop.
        if ($request->routeIs('penugasan.*')) {
            return $next($request);
        }

        // User biasa yang belum memilih program wajib melengkapi penugasan.
        if (!$user->programs()->exists()) {
            return redirect()
                ->route('penugasan.edit')
                ->with('info', 'Silakan lengkapi penugasan Anda terlebih dahulu.');
        }

        return $next($request);
    }
}