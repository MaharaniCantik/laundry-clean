<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Ambil data user yang baru saja login
        $user = Auth::user();

        // 🔀 ALUR PENGALIRAN LOGIN SESUAI 4 ROLE
        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user && $user->role === 'owner') {
            // 🔥 MASUKKAN DI SINI: Otomatis nembak ke rute owner
            return redirect()->route('owner.dashboard'); 
        } elseif ($user && $user->role === 'kurir') {
            // 🔥 MASUKKAN DI SINI: Otomatis nembak ke rute kurir
            return redirect()->route('kurir.dashboard');
        }

        // 🌟 JALUR USER BIASA (Pelanggan)
        // Jika bukan admin, owner, atau kurir, otomatis lempar ke halaman utama ('/')
        return redirect('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Kamu berhasil keluar. Sampai jumpa lagi!');
    }
}
