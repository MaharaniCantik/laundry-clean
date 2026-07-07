<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // 👈 1. WAJIB IMPORT MODEL ORDER DI SINI
use Illuminate\Support\Facades\DB;

class TrackingController extends Controller
{
    // Fungsi untuk menampilkan halaman awal /lacak
    public function index()
    {
        $order = null; 
        $ordersHistory = null;

        // Jika user sudah login, siapkan data riwayat transaksinya
        if (auth()->check()) {
            // Kita biarkan pakai DB::table untuk history list bawah karena cuma butuh data mentah
            $ordersHistory = DB::table('orders')
                ->where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Return view mengarah ke 'lacak' sesuai file asli lu
        return view('lacak', compact('order', 'ordersHistory'));
    }

    // Fungsi untuk memproses pencarian saat tombol Lacak ditekan
    public function search(Request $request)
    {
        $request->validate([
            'nomor_resi' => 'required|string',
        ]);

        $resi = trim($request->input('nomor_resi'));
        
        // 🛠️ FIX SINKRONISASI: Mengubah DB::table menjadi Model Order + Eager Loading relasi kurir
        $order = Order::with(['kurir.user'])->where('nomor_resi', $resi)->first();

        if (!$order) {
            return back()->withInput()->with('error', 'Nomor nota/resi tidak ditemukan!');
        }

        $ordersHistory = null;
        if (auth()->check()) {
            $ordersHistory = DB::table('orders')
                ->where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('lacak', compact('order', 'ordersHistory'));
    }
}