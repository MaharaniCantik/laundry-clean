<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Kurir;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\WhatsappService;

class KurirDashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $kurir = Kurir::where('user_id', $userId)->first();

        if (!$kurir) {
            return "Akun Anda belum terdaftar sebagai armada kurir.";
        }

        // 1. Mengambil orderan baru yang masuk & siap diklaim oleh kurir mana saja
        $orderanMasuk = Order::where('status', 'Pending Penjemputan')
            ->whereNull('kurir_id')
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Menghitung statistik untuk Card Dashboard
        $totalPickup = Order::where('kurir_id', $kurir->id)->where('status', 'Sedang Dijemput')->count();

        // Card antar hanya menghitung yang benar-benar siap diantar ke rumah konsumen
        $totalDelivery = Order::where('kurir_id', $kurir->id)->where('status', 'Siap Diantar')->count();

        $totalCompletedToday = Order::where('kurir_id', $kurir->id)
            ->where('status', 'Selesai')
            ->whereDate('updated_at', today())
            ->count();

        // 🛠️ FIX LOGIKA: Tugas aktif tetap memantau baju yang 'Dibawa ke Toko' agar kurir tau progress-nya,
        // atau jika baju sudah berstatus 'Siap Diantar' maka card pengantaran akan muncul di sini.
        $activeTasks = Order::where('kurir_id', $kurir->id)
            ->whereIn('status', ['Sedang Dijemput', 'Kurir Menuju Lokasi', 'Dibawa ke Toko', 'Siap Diantar'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kurir.dashboard', compact('totalPickup', 'totalDelivery', 'totalCompletedToday', 'activeTasks', 'orderanMasuk'));
    }

    public function ambilPesanan(Request $request, $id)
    {
        try {
            $userId = auth()->id();
            $kurir = Kurir::where('user_id', $userId)->first();

            if (!$kurir) {
                return back()->with('error', 'Anda bukan armada kurir resmi.');
            }

            $updated = Order::where('id', $id)
                ->where('status', 'Pending Penjemputan')
                ->whereNull('kurir_id')
                ->update([
                    'kurir_id'   => $kurir->id,
                    'status'     => 'Sedang Dijemput',
                    'updated_at' => now(),
                ]);

            if ($updated) {
                $kurir->status_kerja = 'busy';
                $kurir->save();

                return redirect()->route('kurir.dashboard')->with('success', '🎉 Pesanan berhasil diambil! Silakan cek di daftar Tugas Aktif Anda.');
            }

            return back()->with('error', 'Waduh, pesanan ini sudah keduluan diambil kurir lain!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengambil pesanan: ' . $e->getMessage());
        }
    }

    public function updateStatus($id)
    {
        $order = Order::findOrFail($id);
        $userId = auth()->id();
        $kurir = Kurir::where('user_id', $userId)->first();

        if (!$kurir) {
            return back()->with('error', 'Akses ditolak.');
        }

        // 1. KONDISI: KURIR SELESAI PICKUP & BAWA KE TOKO
        if ($order->status == 'Sedang Dijemput' || $order->status == 'Kurir Menuju Lokasi') {
            $order->status = 'Dibawa ke Toko';
            $order->save();

            // 🔥 Kirim WA: Pakaian sedang dibawa ke toko
            if (!empty($order->nomor_telepon_order)) { // 👈 Ganti jadi nomor_telepon_order
                $pesan = "Halo {$order->nama_pelanggan},\n\nKurir telah selesai menjemput laundry Anda. Saat ini pakaian sedang *Dibawa ke Toko/Workshop* untuk proses pencucian. 🧼👕";
                
                // Format nomor HP otomatis ke 628xx biar Fonnte lancar
                $nomor_wa = preg_replace('/[^0-9]/', '', $order->nomor_telepon_order);
                if (substr($nomor_wa, 0, 1) === '0') {
                    $nomor_wa = '62' . substr($nomor_wa, 1);
                }

                WhatsappService::send($nomor_wa, $pesan);
            }

            // Sinkronisasi status kerja kurir
            $kurir->status_kerja = 'available';
            $kurir->save();

            return redirect()->back()->with('success', '🚚 Laundry berhasil di-pickup dan diserahkan ke toko! Anda siap mengambil orderan lain.');
        }

        // 2. KONDISI: KURIR SELESAI MENGANTAR CUCIAN BERSIH KE PELANGGAN
        else if ($order->status == 'Siap Diantar') {
            $order->status = 'Selesai';
            $order->save();

            // 🔥 Kirim WA: Pakaian sudah sampai di tangan pelanggan (Selesai)
            if (!empty($order->nomor_telepon_order)) { // 👈 Ganti jadi nomor_telepon_order
                $pesan = "Halo {$order->nama_pelanggan},\n\nPakaian laundry Anda telah sukses diantarkan oleh kurir kami ke lokasi Anda. Transaksi #{$order->id} dinyatakan *Selesai*.\n\nTerima kasih banyak telah menggunakan layanan kami! 🙏✨";
                
                // Format nomor HP otomatis ke 628xx biar Fonnte lancar
                $nomor_wa = preg_replace('/[^0-9]/', '', $order->nomor_telepon_order);
                if (substr($nomor_wa, 0, 1) === '0') {
                    $nomor_wa = '62' . substr($nomor_wa, 1);
                }

                WhatsappService::send($nomor_wa, $pesan);
            }

            // Sinkronisasi status kerja kurir
            $kurir->status_kerja = 'available';
            $kurir->save();

            return redirect()->back()->with('success', '✅ Laundry telah sukses diantarkan ke tangan pelanggan!');
        }

        return redirect()->back()->with('success', 'Status order berhasil diperbarui!');
    }

    public function history(Request $request)
    {
        $userId = auth()->id();
        $kurir = Kurir::where('user_id', $userId)->first();

        if (!$kurir) {
            return redirect()->route('dashboard')->with('error', 'Akses armada ditolak.');
        }

        // 🛠️ FIX LOGIKA MUTLAK: Riwayat HANYA menampilkan orderan yang BENAR-BENAR sukses sampai ke tangan pelanggan ('Selesai')
        $query = Order::where('kurir_id', $kurir->id)->where('status', 'Selesai');

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_pelanggan', 'like', '%' . $request->search . '%');
        }

        $riwayatOrders = $query->latest('updated_at')->paginate(6);

        return view('kurir.history', compact('riwayatOrders'));
    }

    public function profile()
    {
        $userId = auth()->id();
        $profile = auth()->user();
        $kurirInfo = Kurir::where('user_id', $userId)->first();

        if ($kurirInfo) {
            $profile->id = $kurirInfo->id;
            $profile->total_tasks = Order::where('kurir_id', $kurirInfo->id)->where('status', 'Selesai')->count();
            $profile->rating = $kurirInfo->rating ?? 5.0;
        }

        return view('kurir.profile', compact('profile'));
    }
}
