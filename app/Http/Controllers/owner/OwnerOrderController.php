<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class OwnerOrderController extends Controller
{
    // Halaman Dashboard Utama Owner
    public function dashboard()
    {
        $totalPendapatan = Order::where('status', 'Selesai')->sum('total_harga');
        $totalTransaksi = Order::count();
        // Disesuaikan ke kolom 'nama_pelanggan' sesuai gambar database lo
        $jumlahPelanggan = Order::distinct('nama_pelanggan')->count('nama_pelanggan');

        return view('owner.dashboard', compact('totalPendapatan', 'totalTransaksi', 'jumlahPelanggan'));
    }

    // Halaman Index Tabel Riwayat
    public function index()
    {
        return view('owner.order-history');
    }
    public function laporanKeuangan()
    {
        // Menampilkan view keuangan lo (Data riwayat di dalamnya akan di-render otomatis oleh JS)
        return view('owner.laporan-keuangan');
    }

    // API Real-time Data untuk Polling JS
    public function getOrdersApi()
    {
        // Mengambil 6 orderan terbaru dengan kolom asli database lo
        $orders = Order::latest()->take(6)->get();
        
        $totalHariIni = Order::whereDate('created_at', Carbon::today())->count();
        $orderSelesai = Order::where('status', 'Selesai')->count();

        return response()->json([
            'orders' => $orders,
            'kpi' => [
                'total_hari_ini' => $totalHariIni,
                'total_selesai' => $orderSelesai
            ]
        ]);
    }
}