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
        // 1. Ambil hitungan berdasarkan variasi alur status (Jaring pengaman data lama + data baru tetap sinkron)
        $pendingCount   = Order::whereIn('status', ['Pending Penjemputan', 'To Pending'])->count();
        $dijemputCount  = Order::whereIn('status', ['Sedang Dijemput', 'To Pickup'])->count();
        $diprosesCount  = Order::whereIn('status', ['Sedang Diproses', 'To Washing'])->count();
        $diantarCount   = Order::whereIn('status', ['Siap Diantar', 'Sedang Diantar', 'Deliver', 'To Deliver', 'Proses Antar'])->count();
        $selesaiCount   = Order::whereIn('status', ['Selesai', 'To Complete', 'selesal'])->count();

        // 2. Hitung total pendapatan hari ini
        $todayRevenue   = Order::whereIn('status', ['Selesai', 'To Complete'])
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
        $newStatus = $request->input('status'); // Menerima teks seperti "To Washing", "To Deliver", dll dari dropdown gambar image_01b6da.png

        // Simpan status baru ke database sesuai opsi dropdown terpilih
        $order->status = $newStatus;
        $order->save();

        $kurir = null;
        if ($order->kurir_id) {
            $kurir = Kurir::find($order->kurir_id);
        }

        if ($kurir) {
            $statusCheck = strtolower($newStatus);

            // JIKA ADMIN MENGUBAH KE STATUS ANTAR
            if (in_array($statusCheck, ['siap diantar', 'sedang diantar', 'deliver', 'to deliver'])) {
                $kurir->status_kerja = 'busy';
                $kurir->save();
            }
            // JIKA SELESAI ATAU KEMBALI DIPROSES DI WORKSHOP
            elseif (in_array($statusCheck, ['sedang diproses', 'to washing', 'selesai', 'to complete', 'selesal'])) {

                // Cek sisa tugas aktif lain sebelum membebaskan kurir menjadi available
                $sisaTugas = Order::where('kurir_id', $kurir->id)
                    ->whereIn('status', ['Sedang Dijemput', 'To Pickup', 'Siap Diantar', 'Sedang Diantar', 'Deliver', 'To Deliver'])
                    ->count();

                if ($sisaTugas == 0) {
                    $kurir->status_kerja = 'available';
                    $kurir->save();
                }
            }
        }

        // 🔥 INTEGRASI WHATSAPP OTOMATIS SEBELUM REDIRECT
        if (!empty($order->nomor_telepon_order)) {
            $nama = $order->nama_pelanggan;
            $idOrder = $order->id;
            $pesan = "";

            switch (strtolower($newStatus)) {
                case 'pending penjemputan':
                case 'to pending':
                    $pesan = "Halo {$nama},\n\nPesanan laundry Anda #{$idOrder} telah kami terima. Kurir kami akan segera menjemput pesanan Anda sesuai jadwal. Terima kasih! 🙏";
                    break;

                case 'sedang dijemput':
                case 'to pickup':
                    $pesan = "Halo {$nama},\n\nKabar baik! Kurir kami saat ini sedang dalam perjalanan menuju ke lokasi Anda untuk menjemput pesanan. 🛵💨";
                    break;

                case 'sedang diproses':
                case 'to washing':
                    $pesan = "Halo {$nama},\n\nPesanan Anda sudah tiba di laundry kami dan saat ini *Sedang Diproses (Dicuci)*. Kami akan memastikan pakaian Anda bersih maksimal! 🧼👕";
                    break;

                case 'siap diantar':
                case 'sedang diantar':
                case 'to deliver':
                case 'deliver':
                    $pesan = "Halo {$nama},\n\nHore! Laundry Anda sudah bersih, dan wangi. Saat ini pesanan Anda sedang dalam proses diantar kembali ke rumah oleh kurir kami. 📦✨";
                    break;

                case 'selesal':
                case 'selesai':
                case 'to complete':
                    $pesan = "Halo {$nama},\n\nTransaksi laundry #{$idOrder} telah dinyatakan *Selesai*. Terima kasih banyak telah memercayakan laundry Anda kepada kami. Sampai jumpa di orderan berikutnya! 🙏✨";
                    break;
            }

            if ($pesan != "") {
                $nomor_wa = $order->nomor_telepon_order;
                $nomor_wa = preg_replace('/[^0-9]/', '', $nomor_wa);

                if (substr($nomor_wa, 0, 1) === '0') {
                    $nomor_wa = '62' . substr($nomor_wa, 1);
                }

                WhatsappService::send($nomor_wa, $pesan);
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
            'nomor_telepon_order' => 'required'
        ]);

        $kurirTerpilih = Kurir::where('status_kerja', 'available')
            ->whereNotNull('user_id')
            ->inRandomOrder()
            ->first();

        $order = new Order();
        // Sesuai field database kamu (perhatikan nama property modelnya ya, sesuaikan nama kolom DB)
        $order->customer_name = $request->customer_name;
        $order->nama_pelanggan = $request->customer_name; // Mengisi nama_pelanggan sesuai kode updateStatus kamu
        $order->layanan = $request->layanan;
        $order->alamat = $request->alamat;
        $order->nomor_telepon_order = $request->nomor_telepon_order; // Menangkap nomor telepon dari form

        if ($kurirTerpilih) {
            $order->kurir_id = $kurirTerpilih->id;
            $order->status = 'To Pickup'; // Langsung set status siap jemput

            $kurirTerpilih->status_kerja = 'busy';
            $kurirTerpilih->save();

            $pesanFlash = 'Pesanan berhasil dibuat dan otomatis ditugaskan ke Kurir: ' . $kurirTerpilih->nama_lengkap;
        } else {
            $order->kurir_id = null;
            $order->status = 'To Pending'; // Antrean pending kalau kurir sibuk semua

            $pesanFlash = 'Pesanan dibuat, tapi tidak ada kurir yang tersedia (Available) saat ini.';
        }

        $order->save();

        // 🔥 TAMBAHAN: OTOMATIS KIRIM WA SESAAT SETELAH PESANAN DISIMPAN
        if (!empty($order->nomor_telepon_order)) {
            $nama = $order->nama_pelanggan;
            $idOrder = $order->id;

            // Format isi template pesan pembuka
            $pesan = "Halo {$nama},\n\nPesanan laundry Anda #{$idOrder} telah kami terima di sistem. ";
            if ($order->kurir_id) {
                $pesan .= "Kurir kami ({$kurirTerpilih->nama_lengkap}) akan segera menuju ke lokasi Anda untuk menjemput pesanan. Mohon ditunggu ya! 🛵✨";
            } else {
                $pesan .= "Saat ini pesanan Anda sedang dalam antrean penjadwalan kurir kami. Terima kasih! 🙏";
            }

            // Bersihkan nomor HP dan ubah ke format 62
            $nomor_wa = preg_replace('/[^0-9]/', '', $order->nomor_telepon_order);
            if (substr($nomor_wa, 0, 1) === '0') {
                $nomor_wa = '62' . substr($nomor_wa, 1);
            }

            // Tembak service Fonnte
            \App\Services\WhatsappService::send($nomor_wa, $pesan);
        }

        return redirect()->back()->with('success', $pesanFlash . ' Serta notifikasi WhatsApp berhasil dikirim ke pelanggan!');
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
        $order->status   = 'To Pickup'; 
        $order->save();

        $kurirTerpilih->status_kerja = 'busy';
        $kurirTerpilih->save();

        // 🔥 KODE TAMBAHAN BIAR WA KAMU BUNYI PAS KLIK TOMBOL:
        if (!empty($order->nomor_telepon_order)) {
            $pesan = "Halo {$order->nama_pelanggan},\n\nPesanan laundry Anda #{$order->id} telah dikonfirmasi oleh Admin! ✨\n\nKurir kami, *{$kurirTerpilih->nama_lengkap}*, telah ditugaskan dan sedang bersiap menuju lokasi Anda untuk menjemput pesanan. Mohon disiapkan pesanan kotornya ya! 🛵🧺";

            $nomor_wa = preg_replace('/[^0-9]/', '', $order->nomor_telepon_order);
            if (substr($nomor_wa, 0, 1) === '0') {
                $nomor_wa = '62' . substr($nomor_wa, 1);
            }

            try {
                \App\Services\WhatsappService::send($nomor_wa, $pesan);
            } catch (\Exception $e) {
                \Log::error('Gagal mengirim WA Konfirmasi Order: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Berhasil menugaskan kurir dan mengirim notifikasi WhatsApp!');
    }

    public function tesKurirManual(Request $request)
    {
        $idKurirRow = $request->input('id_kurir_row');
        $kurir = \DB::table('kurirs')->where('id', $idKurirRow)->first();

        if (!$kurir) {
            return "Gagal: Kurir dengan ID Row tersebut tidak ditemukan di database.";
        }

        $order = Order::find(35);

        if (!$order) {
            return "Gagal: Data Order ID 35 tidak ditemukan di tabel orders.";
        }

        $order->kurir_id = $kurir->id;
        $order->status   = 'To Pickup'; // Ganti dari 'Sedang Dijemput' ke 'To Pickup'
        $order->save();

        return redirect()->back()->with('success', 'Sukses Masuk, Kurir berhasil ditugaskan ke dalam orderan secara manual!');
    }
}
