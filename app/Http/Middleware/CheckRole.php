<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login?
        if (!auth()->check()) {
            return redirect('/login');
        }

        // 2. Ambil role user yang sedang login
        $userRole = auth()->user()->role;

        // 3. Cek apakah role user ada di dalam daftar role yang diizinkan (yang dikirim dari route)
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // 4. Jika tidak punya akses, tendang ke halaman awal dengan pesan error
        return redirect('/')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}