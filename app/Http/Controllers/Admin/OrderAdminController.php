<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    public function index()
    {
        // 1. Ambil hitungan dari 5 alur status Anda yang baru
        $pendingCount   = \App\Models\Order::where('status', 'Pending Penjemputan')->count();
        $dijemputCount  = \App\Models\Order::where('status', 'Sedang Dijemput')->count();
        $diprosesCount  = \App\Models\Order::where('status', 'Sedang Diproses')->count();
        $diantarCount   = \App\Models\Order::where('status', 'Siap Diantar')->count();
        $selesaiCount   = \App\Models\Order::where('status', 'Selesai')->count();

        // 2. Hitung total pendapatan hari ini (untuk pesanan yang sudah 'Selesai')
        $todayRevenue   = \App\Models\Order::where('status', 'Selesai')
                            ->whereDate('created_at', \Carbon\Carbon::today())
                            ->sum('total_harga');

        // 3. Ambil 5 orderan terbaru
        $recentActivities = \App\Models\Order::latest()->take(5)->get();

        // Kirim semua variabel ke view
        return view('admin.dashboard', compact(
            'pendingCount', 
            'dijemputCount', 
            'diprosesCount', 
            'diantarCount', 
            'selesaiCount',
            'todayRevenue',
            'recentActivities'
        ));
    }
    // Tambahkan fungsi baru ini di bawah fungsi index() Anda:
    public function ordersPage(\Illuminate\Http\Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Mulai query untuk menarik data dari model Order
        $orders = \App\Models\Order::query();

        // Jika admin mengisi filter tanggal, saring data tabelnya
        if ($startDate && $endDate) {
            $orders->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }

        // Ambil data terbaru dari Supabase
        $allOrders = $orders->latest()->get();

        // Lempar variabel data ke file view admin/orders.blade.php
        return view('admin.orders', compact('allOrders'));
    }

     public function updateStatus(\Illuminate\Http\Request $request, $id)
    {
        // 1. Validasi input agar status yang masuk sesuai pilihan resmi
        $request->validate([
            'status' => 'required|string'
        ]);

        // 2. Cari data order berdasarkan ID-nya
        $order = \App\Models\Order::findOrFail($id);

        // 3. Ubah statusnya sesuai pilihan admin di web
        $order->status = $request->input('status');
        $order->save(); // Otomatis tersinkronisasi ke Supabase!

        // 4. Kembalikan ke halaman tadi dengan pesan sukses modal pop-up ringan
        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}