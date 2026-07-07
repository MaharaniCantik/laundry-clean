<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Kurir;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 

class KurirDashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id(); 
        $kurir = Kurir::where('user_id', $userId)->first();

        if (!$kurir) {
            return "Akun Anda belum terdaftar sebagai armada kurir.";
        }

        $orderanMasuk = Order::where('status', 'Pending Penjemputan')
                            ->whereNull('kurir_id')
                            ->orderBy('created_at', 'desc')
                            ->get();

        // 🔥 HITUNG TUGAS BERDASARKAN ID TABEL KURIRS
        $totalPickup = Order::where('kurir_id', $kurir->id)->where('status', 'Sedang Dijemput')->count();
        $totalDelivery = Order::where('kurir_id', $kurir->id)->where('status', 'Siap Diantar')->count();
        $totalCompletedToday = Order::where('kurir_id', $kurir->id)
                                    ->where('status', 'Selesai')
                                    ->whereDate('updated_at', today())
                                    ->count();

        $activeTasks = Order::where('kurir_id', $kurir->id)
                            ->whereIn('status', ['Sedang Dijemput', 'Siap Diantar', 'Kurir Menuju Lokasi', 'Dibawa ke Toko'])
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('kurir.dashboard', compact('totalPickup', 'totalDelivery', 'totalCompletedToday', 'activeTasks', 'orderanMasuk'));
    }

    /**
     * FITUR: Kurir mengambil orderan secara mandiri dari dashboard
     */
    public function ambilPesanan(Request $request, $id)
    {
        try {
            $userId = auth()->id(); 
            $kurir = Kurir::where('user_id', $userId)->first();

            if (!$kurir) {
                return back()->with('error', 'Anda bukan armada kurir resmi.');
            }

            // 🛠️ FIX: Tambahkan nama_kurir_siap agar muncul di tracking halaman user
            $updated = Order::where('id', $id)
                ->where('status', 'Pending Penjemputan')
                ->whereNull('kurir_id')
                ->update([
                    'kurir_id'         => $kurir->id, 
                    'nama_kurir_siap'  => auth()->user()->name, // 👈 PENTING: Mengisi nama kurir
                    'status'           => 'Sedang Dijemput', 
                    'updated_at'       => now(),
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

        // 🛠️ FIX: Mengubah flash message UX menjadi lebih ramah dan status bertahap
        if ($order->status == 'Sedang Dijemput' || $order->status == 'Kurir Menuju Lokasi') {
            $order->status = 'Dibawa ke Toko'; // 👈 Mengubah status ke toko, bukan langsung diproses cuci
            $order->save();
            return redirect()->back()->with('success', '🚚 Laundry berhasil di-pickup dan sedang dibawa menuju toko!');
        } else if ($order->status == 'Siap Diantar') {
            $order->status = 'Selesai';
            $order->save();
            
            // Kembalikan status_kerja kurir ke available
            $kurir->status_kerja = 'available';
            $kurir->save();
            
            return redirect()->back()->with('success', '✅ Laundry telah sukses diantarkan ke tangan pelanggan!');
        }
        
        $order->save();
        return redirect()->back()->with('success', 'Status order berhasil diperbarui!');
    }

    public function history(Request $request)
    {
        $userId = auth()->id();
        $kurir = Kurir::where('user_id', $userId)->first();

        if (!$kurir) {
            return redirect()->route('dashboard')->with('error', 'Akses armada ditolak.');
        }

        // 🛠️ FIX: Menggunakan $kurir->id bukan $userId
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
            // 🛠️ FIX: Menghitung total_tasks menggunakan $kurirInfo->id
            $profile->total_tasks = Order::where('kurir_id', $kurirInfo->id)->where('status', 'Selesai')->count();
            $profile->rating = $kurirInfo->rating ?? 5.0; 
        }

        return view('kurir.profile', compact('profile'));
    }
}