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

        // 1. Mengambil orderan baru yang masuk & siap diklaim kurir (Mendukung data lama & data baru 'To Pending')
        $orderanMasuk = Order::whereIn('status', ['Pending Penjemputan', 'To Pending'])
            ->whereNull('kurir_id')
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Menghitung statistik untuk Card Dashboard Kurir
        $totalPickup = Order::where('kurir_id', $kurir->id)
            ->whereIn('status', ['Sedang Dijemput', 'To Pickup'])
            ->count();

        $totalDelivery = Order::where('kurir_id', $kurir->id)
            ->whereIn('status', ['Siap Diantar', 'Proses Antar', 'Sedang Diantar', 'Deliver', 'To Deliver', 'On Delivery'])
            ->count();

        $totalCompletedToday = Order::where('kurir_id', $kurir->id)
            ->whereIn('status', ['Selesai', 'To Complete', 'selesal'])
            ->whereDate('updated_at', today())
            ->count();

        // 3. Menggabungkan semua status pelacakan tugas aktif kurir menjadi satu query bersih
        $activeTasks = Order::where('kurir_id', $kurir->id)
            ->whereIn('status', [
                'Sedang Dijemput', 'Kurir Menuju Lokasi', 'Dibawa ke Toko', 'To Pickup',
                'Siap Diantar', 'Proses Antar', 'Sedang Diantar', 'Deliver', 'To Deliver', 'On Delivery'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kurir.dashboard', compact('totalPickup', 'totalDelivery', 'totalCompletedToday', 'activeTasks', 'orderanMasuk', 'kurir'));
    }

    public function ambilPesanan(Request $request, $id)
    {
        try {
            $userId = auth()->id();
            $kurir = Kurir::where('user_id', $userId)->first();

            if (!$kurir) {
                return back()->with('error', 'Anda bukan armada kurir resmi.');
            }

            // Validasi status pengaman ganda agar data lama/baru bisa diambil
            $order = Order::where('id', $id)->whereNull('kurir_id')->first();
            if (!$order || !in_array($order->status, ['Pending Penjemputan', 'To Pending'])) {
                return back()->with('error', 'Waduh, pesanan ini sudah keduluan diambil kurir lain!');
            }

            // Alur Uji Langkah 2: Ubah status ke format baru 'To Pickup'
            $order->kurir_id = $kurir->id;
            $order->status = 'To Pickup';
            $order->updated_at = now();
            $order->save();

            // Kunci status kerja kurir menjadi sibuk
            $kurir->status_kerja = 'busy'; 
            $kurir->save();

            // 🔥 INI BAGIAN YANG TADI BELUM ADA, SEKARANG SUDAH SAYA TAMBAHKAN:
            if (!empty($order->nomor_telepon_order)) {
                $pesan = "Halo {$order->nama_pelanggan},\n\nPesanan laundry Anda #{$order->id} telah diambil oleh Kurir kami: *{$kurir->nama_lengkap}*.\n\nKurir akan segera menuju lokasi Anda untuk menjemput pakaian. Mohon disiapkan pakaian kotornya ya! 🛵✨";

                $nomor_wa = preg_replace('/[^0-9]/', '', $order->nomor_telepon_order);
                if (substr($nomor_wa, 0, 1) === '0') {
                    $nomor_wa = '62' . substr($nomor_wa, 1);
                }

                // Tembak Fonnte
                \App\Services\WhatsappService::send($nomor_wa, $pesan);
            }

            return redirect()->route('kurir.dashboard')->with('success', '🎉 Pesanan berhasil diambil! Silakan cek di daftar Tugas Aktif Anda.');
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

        $currentStatus = strtolower($order->status);

        // =========================================================================
        // 1. ALUR PENJEMPUTAN (Pakaian Kotor dari Konsumen -> Dibawa ke Workshop)
        // =========================================================================
        if (in_array($currentStatus, ['sedang dijemput', 'kurir menuju lokasi', 'to pickup'])) {
            
            // Ubah status ke 'To Washing' (Artinya pakaian kotor sudah sampai di toko & siap dicuci)
            $order->status = 'To Washing';
            $order->save();

            // 🔥 Kirim WA: Pakaian kotor sudah aman sampai di workshop
            if (!empty($order->nomor_telepon_order)) {
                $pesan = "Halo *{$order->nama_pelanggan}*,\n\nKurir kami (*{$kurir->nama_lengkap}*) telah selesai menjemput laundry Anda. Saat ini pakaian Anda sudah tiba di workshop kami dan masuk ke dalam antrean *Sedang Diproses (Dicuci)*. 🧼👕";

                $nomor_wa = preg_replace('/[^0-9]/', '', $order->nomor_telepon_order);
                if (substr($nomor_wa, 0, 1) === '0') {
                    $nomor_wa = '62' . substr($nomor_wa, 1);
                }

                \App\Services\WhatsappService::send($nomor_wa, $pesan);
            }

            // Atur status kerja kurir
            $sisaTugas = Order::where('kurir_id', $kurir->id)
                ->whereIn('status', ['Sedang Dijemput', 'Kurir Menuju Lokasi', 'To Pickup', 'Siap Diantar', 'Proses Antar', 'Sedang Diantar', 'Deliver', 'To Deliver', 'On Delivery'])
                ->count();

            if ($sisaTugas == 0) {
                $kurir->status_kerja = 'available';
                $kurir->save();
            }

            return redirect()->back()->with('success', '🚚 Laundry berhasil di-pickup dan diserahkan ke workshop untuk dicuci!');
        }

        // =========================================================================
        // 2. ALUR PENGANTARAN (Pakaian Bersih dari Workshop -> Tangan Konsumen)
        // =========================================================================
        else if (in_array($currentStatus, ['siap diantar', 'proses antar', 'sedang diantar', 'deliver', 'to deliver', 'on delivery'])) {
            
            // Hapus 'dibawa ke toko' dari sini agar tidak tabrakan lagi!
            $order->status = 'To Complete';
            $order->save();

            // 🔥 Kirim WA: Notifikasi Selesai Antar ke Konsumen
            if (!empty($order->nomor_telepon_order)) {
                $pesan = "Halo *{$order->nama_pelanggan}*,\n\nPakaian laundry Anda telah sukses diantarkan oleh kurir kami ke lokasi Anda. Transaksi #{$order->id} dinyatakan *Selesai*.\n\nTerima kasih banyak telah menggunakan layanan CuciYuk! 🙏✨";

                $nomor_wa = preg_replace('/[^0-9]/', '', $order->nomor_telepon_order);
                if (substr($nomor_wa, 0, 1) === '0') {
                    $nomor_wa = '62' . substr($nomor_wa, 1);
                }

                \App\Services\WhatsappService::send($nomor_wa, $pesan);
            }

            // Kembalikan status kurir menjadi siap sedia (available)
            $sisaTugas = Order::where('kurir_id', $kurir->id)
                ->whereIn('status', ['Sedang Dijemput', 'Kurir Menuju Lokasi', 'To Pickup', 'Siap Diantar', 'Proses Antar', 'Sedang Diantar', 'Deliver', 'To Deliver', 'On Delivery'])
                ->count();

            if ($sisaTugas == 0) {
                $kurir->status_kerja = 'available';
                $kurir->save();
            }

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

        // Mendukung riwayat pencarian data lama 'Selesai' maupun format baru 'To Complete'
        $query = Order::where('kurir_id', $kurir->id)->whereIn('status', ['Selesai', 'To Complete', 'selesal']);

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
            $profile->total_tasks = Order::where('kurir_id', $kurirInfo->id)->whereIn('status', ['Selesai', 'To Complete', 'selesal'])->count();
            $profile->rating = $kurirInfo->rating ?? 5.0;
        }

        return view('kurir.profile', compact('profile'));
    }

    public function toggleKehadiran()
    {
        $userId = auth()->id();
        $kurir = Kurir::where('user_id', $userId)->first();

        if (!$kurir) {
            return back()->with('error', 'Anda bukan armada kurir resmi.');
        }

        if ($kurir->status_kerja === 'busy' || $kurir->status_kerja === 'on-delivery') {
            return redirect()->back()->with('error', 'Selesaikan tugas aktif Anda terlebih dahulu!');
        }

        if ($kurir->status_kerja === 'available' || $kurir->status_kerja === 'idle' || empty($kurir->status_kerja)) {
            $kurir->status_kerja = 'inactive';
            $pesan = 'Status Anda sekarang Nonaktif (Izin/Libur).';
        } else {
            $kurir->status_kerja = 'available';
            $pesan = 'Status Anda sekarang Aktif (Siap Kerja).';
        }

        $kurir->save();

        return redirect()->back()->with('success', $pesan);
    }
}