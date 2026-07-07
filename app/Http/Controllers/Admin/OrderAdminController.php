<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Kurir;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\WhatsappService;

class OrderAdminController extends Controller
{
    public function index()
    {
        // 1. Ambil hitungan berdasarkan 5 alur status ter-update
        $pendingCount   = Order::where('status', 'Pending Penjemputan')->count();
        $dijemputCount  = Order::where('status', 'Sedang Dijemput')->count();
        $diprosesCount  = Order::where('status', 'Sedang Diproses')->count();
        $diantarCount   = Order::where('status', 'Siap Diantar')->count();
        $selesaiCount   = Order::where('status', 'Selesai')->count();

        // 2. Hitung total pendapatan hari ini (Hanya pesanan yang sudah mutlak 'Selesai')
        $todayRevenue   = Order::where('status', 'Selesai')
            ->whereDate('updated_at', Carbon::today())
            ->sum('total_harga');

        // 3. Ambil 5 orderan terbaru untuk log aktivitas dashboard
        $recentActivities = Order::latest()->take(5)->get();

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

    public function ordersPage(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $orders = Order::query();

        if ($startDate && $endDate) {
            $orders->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }

        $allOrders = $orders->latest()->get();

        return view('admin.orders', compact('allOrders'));
    }

    /**
     * 🛠️ FIX LOGIKA MUTLAK: Sinkronisasi Status Kerja Kurir Otomatis saat Admin Mengubah Status Orderan
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->input('status');

        $order->status = $newStatus;
        $order->save();

        // Ambil data kurir yang memegang orderan ini (jika sudah ada kurir yang ditugaskan)
        $kurir = null;
        if ($order->kurir_id) {
            $kurir = Kurir::find($order->kurir_id);
        }

        if ($kurir) {
            // JIKA ADMIN MENGUBAH KE STATUS "Siap Diantar"
            if ($newStatus == 'Siap Diantar') {
                $kurir->status_kerja = 'busy';
                $kurir->save();
            }
            // JIKA ADMIN MENGUBAH KE STATUS "Sedang Diproses"
            elseif ($newStatus == 'Sedang Diproses') {
                $kurir->status_kerja = 'available';
                $kurir->save();
            }
            // JIKA ADMIN MENYELESAIKAN SECARA MANUAL KE STATUS "Selesai"
            elseif ($newStatus == 'Selesai') {
                $kurir->status_kerja = 'available';
                $kurir->save();
            }
        }

        // 🔥 INTEGRASI WHATSAPP OTOMATIS SEBELUM REDIRECT
        if (!empty($order->no_telp)) {
            $nama = $order->nama_pelanggan;
            $idOrder = $order->id;
            $pesan = "";

            switch ($newStatus) {
                case 'Pending Penjemputan':
                    $pesan = "Halo {$nama},\n\nPesanan laundry Anda #{$idOrder} telah kami terima. Kurir kami akan segera menjemput pakaian Anda sesuai jadwal. Terima kasih! 🙏";
                    break;

                case 'Sedang Dijemput':
                    $pesan = "Halo {$nama},\n\nKabar baik! Kurir kami saat ini sedang dalam perjalanan menuju ke lokasi Anda untuk menjemput pakaian. 🛵💨";
                    break;

                case 'Sedang Diproses':
                    $pesan = "Halo {$nama},\n\nPakaian Anda sudah tiba di workshop kami dan saat ini *Sedang Diproses (Dicuci)*. Kami akan memastikan pakaian Anda bersih maksimal! 🧼👕";
                    break;

                case 'Siap Diantar':
                    $pesan = "Halo {$nama},\n\nHore! Laundry Anda sudah bersih, wangi, dan rapi. Saat ini pakaian Anda *Siap Diantar* kembali ke rumah oleh kurir kami. 📦✨";
                    break;

                case 'Selesai':
                    $pesan = "Halo {$nama},\n\nTransaksi laundry #{$idOrder} telah dinyatakan *Selesai*. Terima kasih banyak telah memercayakan laundry Anda kepada kami. Sampai jumpa di orderan berikutnya! 🙏✨";
                    break;
            }

            // Jalankan pengiriman jika isi pesan ter-generate
            if ($pesan != "") {
                WhatsappService::send($order->no_telp, $pesan);
            }
        }

        return redirect()->back()->with('success', '🎉 Status pesanan berhasil diperbarui, disinkronkan ke armada kurir, dan notifikasi WA terkirim!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'layanan' => 'required',
            'alamat' => 'required',
        ]);

        // 🛠️ SINKRONISASI: Filter kurir menggunakan status 'available'
        $kurirTerpilih = Kurir::where('status_kerja', 'available')
            ->whereNotNull('user_id')
            ->inRandomOrder()
            ->first();

        $order = new Order();
        $order->customer_name = $request->customer_name;
        $order->layanan = $request->layanan;
        $order->alamat = $request->alamat;

        if ($kurirTerpilih) {
            $order->kurir_id = $kurirTerpilih->id; // Menggunakan jembatan kurir_id asli
            $order->status = 'Sedang Dijemput';

            // 🛠️ SINKRONISASI: Ubah ke 'busy', bukan 'on-delivery'
            $kurirTerpilih->status_kerja = 'busy';
            $kurirTerpilih->save();

            $pesanFlash = 'Pesanan berhasil dibuat dan otomatis ditugaskan ke Kurir: ' . $kurirTerpilih->nama_lengkap;
        } else {
            $order->kurir_id = null;
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

        $order->kurir_id = $kurirTerpilih->id;
        $order->status   = 'Sedang Dijemput';
        $order->save();

        // 🛠️ SINKRONISASI: Ubah ke 'busy', bukan 'on-delivery'
        $kurirTerpilih->status_kerja = 'busy';
        $kurirTerpilih->save();

        return redirect()->back()->with('success', 'Berhasil menugaskan kurir!');
    }

    public function tesKurirManual(Request $request)
    {
        $idKurirRow = $request->input('id_kurir_row');
        $kurir = \DB::table('kurirs')->where('id', $idKurirRow)->first();

        if (!$kurir) {
            return "Gagal: Kurir dengan ID Row tersebut tidak ditemukan di database.";
        }

        $order = Order::find(35); // Target Order pengetesan

        if (!$order) {
            return "Gagal: Data Order ID 35 tidak ditemukan di tabel orders.";
        }

        $order->kurir_id = $kurir->id;
        $order->status   = 'Sedang Dijemput';
        $order->save();

        return "Sukses Masuk, Kurir " . $kurir->nama_lengkap . " berhasil direkam ke dalam orderan!";
    }
}
