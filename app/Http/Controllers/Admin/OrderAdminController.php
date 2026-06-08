<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    public function index()
    {
        // 1. Hitung orderan berdasarkan kolom 'status' di database Anda
        // Catatan: Sesuaikan string status ('Baru', 'Proses', 'Selesai') dengan isi data asli Anda
        $newOrdersCount = Order::where('status', 'Baru')->count();
        $inProcessCount = Order::where('status', 'Proses')->count();
        $readyCount     = Order::where('status', 'Selesai')->count();

        // 2. Hitung total pendapatan hari ini menggunakan kolom 'total_harga'
        $todayRevenue   = Order::whereDate('created_at', Carbon::today())
                               ->sum('total_harga');

        // 3. Ambil 5 orderan terbaru menggunakan kolom 'nama_pelanggan' dan 'total_harga'
        $recentActivities = Order::latest()->take(5)->get();

        // Kirim variabel ke view dashboard
        return view('admin.dashboard', compact(
            'newOrdersCount', 
            'inProcessCount', 
            'readyCount', 
            'todayRevenue',
            'recentActivities'
        ));
    }
}

