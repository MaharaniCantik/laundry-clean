<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 🌟 LOGIKA OTOMATIS MENENTUKAN 4 ROLE BERDASARKAN EMAIL
        $email = strtolower($request->email);
        $roleOtomatis = 'user'; // Defaultnya adalah pelanggan biasa

        if (str_contains($email, 'admin')) {
            $roleOtomatis = 'admin';
        } elseif (str_contains($email, 'owner')) {
            $roleOtomatis = 'owner';
        } elseif (str_contains($email, 'kurir')) {
            $roleOtomatis = 'kurir';
        }

        // Simpan ke Supabase
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $roleOtomatis, // 🔥 Otomatis terisi sesuai deteksi di atas!
        ]);

        event(new Registered($user));

        Auth::login($user);

        // 🔀 REDIRECT SESUAI ROLE MASING-MASING SETELAH DAFTAR SUKSES
        if ($roleOtomatis === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($roleOtomatis === 'owner') {
            return redirect()->route('owner.dashboard');
        } elseif ($roleOtomatis === 'kurir') {
            return redirect()->route('kurir.dashboard');
        }

        // Kalau user biasa, langsung ke halaman utama
        return redirect('/');
    }
}