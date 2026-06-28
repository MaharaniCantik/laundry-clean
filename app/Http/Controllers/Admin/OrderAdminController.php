<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Kurir;

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
    
    public function store(Request $request)
    {
        // 1. Validasi inputan admin/customer seperti biasa
        $request->validate([
            'customer_name' => 'required',
            'layanan' => 'required',
            'alamat' => 'required',
        ]);

        // 2. LOGIKA RANDOM PICK KURIR YANG MENGGUNAKAN KOLOM 'status_kerja'
        $kurirTerpilih = Kurir::where('status_kerja', 'available') // 🔥 DISINKRONKAN KE status_kerja
                            ->whereNotNull('user_id')
                            ->inRandomOrder()
                            ->first();

        // 3. Simpan data orderan baru
        $order = new Order();
        $order->customer_name = $request->customer_name;
        $order->layanan = $request->layanan;
        $order->alamat = $request->alamat;

        if ($kurirTerpilih) {
            $order->user_id = $kurirTerpilih->user_id;
            $order->status = 'Sedang Dijemput';
            
            // 🔥 KUNCI STATUS KERJA KURIR TERPILIH JADI on-delivery
            $kurirTerpilih->status_kerja = 'on-delivery'; 
            $kurirTerpilih->save();

            $pesanFlash = 'Pesanan berhasil dibuat dan otomatis ditugaskan ke Kurir: ' . $kurirTerpilih->nama_lengkap;
        } else {
            $order->user_id = null;
            $order->status = 'Pending Penjemputan';
            
            $pesanFlash = 'Pesanan dibuat, tapi tidak ada kurir yang tersedia (Available) saat ini.';
        }

        $order->save();

        return redirect()->back()->with('success', $pesanFlash);
    }
public function konfirmasiOrder(Request $request, $id)
{
    $request->validate([
        'kurir_id' => 'required|exists:kurirs,user_id'
    ]);

    $order = Order::findOrFail($id);
    $kurirTerpilih = Kurir::where('user_id', $request->kurir_id)->first();

    if (!$kurirTerpilih) {
        return redirect()->back()->with('error', 'Kurir tidak ditemukan.');
    }

    // Tetap konsisten simpan ke instruksi_driver sesuai skema lo
    $order->instruksi_driver = $kurirTerpilih->user_id; 
    $order->status           = 'Sedang Dijemput'; 
    $order->save();
    
    $kurirTerpilih->status_kerja = 'on-delivery'; 
    $kurirTerpilih->save();

    return redirect()->back()->with('success', 'Berhasil menugaskan kurir!');
}
public function tesKurirManual(\Illuminate\Http\Request $request)
{
    // 1. Ambil ID baris kurir yang diklik dari Blade
    $idKurirRow = $request->input('id_kurir_row');

    // 2. Cari data murni dari tabel kurirs berdasarkan ID tersebut
    $kurir = \DB::table('kurirs')->where('id', $idKurirRow)->first();

    if (!$kurir) {
        return "Gagal: Kurir dengan ID Row tersebut tidak ditemukan di database.";
    }

    // 3. AMBIL USER_ID NYA (Sesuai jembatan relasi yang lo maksud!)
    $jembatanUserId = $kurir->user_id; 

    if (empty($jembatanUserId)) {
        return "Gagal: Kolom user_id untuk kurir " . $kurir->nama_lengkap . " kosong di database Supabase lo.";
    }

    // 4. Cari data orderan target (Ubah angka 23 ini sesuai id orderan rani kusuma yang mau lo tes)
    $order = \App\Models\Order::find(35);

    if (!$order) {
        return "Gagal: Data Order ID 23 tidak ditemukan di tabel orders.";
    }

    // 5. Masukkan user_id kurir ke dalam kolom instruksi_driver tabel orders
    $order->instruksi_driver = $jembatanUserId;
    $order->status           = 'Sedang Dijemput';
    $order->save();

    return "Sukses Masuk, Bro! Kurir " . $kurir->nama_lengkap . " dengan jembatan USER_ID: " . $jembatanUserId . " berhasil direkam ke kolom instruksi_driver pada Order ID 23!";
}
}