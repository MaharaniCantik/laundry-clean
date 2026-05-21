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

        // --- MULAI LOGIKA REDIRECT CUSTOM ---
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->role === 'owner') {
            return redirect()->intended(route('owner.dashboard'));
        } elseif ($user->role === 'kurir') {
            return redirect()->intended(route('kurir.dashboard'));
        }

        // Jalur cadangan jika tidak masuk ke role mana pun
        return redirect()->intended('/');
        // Default jika role tidak dikenali
        return redirect()->intended('/');    
        // --- AKHIR LOGIKA REDIRECT CUSTOM ---
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
