<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackingController extends Controller
{
    // Fungsi untuk menampilkan halaman awal /lacak
    public function index()
    {
        // 1. Inisialisasi awal variabel $order sebagai null agar compact() tidak error
        $order = null; 
        $ordersHistory = null;

        // Jika user sudah login, siapkan data riwayat transaksinya
        if (auth()->check()) {
            $ordersHistory = DB::table('orders')
                ->where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Sekarang aman dikirim ke view 'lacak'
        return view('lacak', compact('order', 'ordersHistory'));
    }

    // Fungsi untuk memproses pencarian saat tombol Lacak ditekan
    public function search(Request $request)
    {
        $request->validate([
            'nomor_resi' => 'required|string',
        ]);

        $resi = trim($request->input('nomor_resi'));
        
        // Mencari data order berdasarkan nomor_resi di database
        $order = DB::table('orders')->where('nomor_resi', $resi)->first();

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