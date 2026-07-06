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
                            ->whereIn('status', ['Sedang Dijemput', 'Siap Diantar', 'Kurir Menuju Lokasi'])
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('kurir.dashboard', compact('totalPickup', 'totalDelivery', 'totalCompletedToday', 'activeTasks', 'orderanMasuk'));
    }

    /**
     * 🌟 FITUR BARU: Kurir mengambil orderan secara mandiri dari dashboard
     */
    /**
     * FITUR: Kurir mengambil orderan secara mandiri dari dashboard
     */
    public function ambilPesanan(Request $request, $id)
    {
        try {
            $userId = auth()->id(); // Ini ID User yang login
            
            // 🔥 CARI ID JURAGAN KURIRNYA (id di tabel kurirs)
            $kurir = Kurir::where('user_id', $userId)->first();

            if (!$kurir) {
                return back()->with('error', 'Anda bukan armada kurir resmi.');
            }

            // Kunci orderan menggunakan ID dari tabel kurirs ($kurir->id)
            $updated = Order::where('id', $id)
                ->where('status', 'Pending Penjemputan')
                ->whereNull('kurir_id')
                ->update([
                    'kurir_id'   => $kurir->id, // 👈 SEKARANG FIX MASUKIN ID TABEL KURIRS!
                    'status'     => 'Sedang Dijemput', 
                    'updated_at' => now(),
                ]);

            if ($updated) {
                $kurir->status_kerja = 'busy';
                $kurir->save();

                return redirect()->route('kurir.dashboard')->with('success', 'Pesanan berhasil diambil! Silakan cek di daftar Tugas Aktif Anda.');
            }

            return back()->with('error', 'Waduh, pesanan ini sudah keduluan diambil kurir lain!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengambil pesanan: ' . $e->getMessage());
        }
    }

    public function history(Request $request)
    {
        $userId = auth()->id();

        // 🌟 FIX LOGIKA: Arahkan filter history ke 'kurir_id', bukan 'user_id' pelanggan
        $query = Order::where('kurir_id', $userId)->where('status', 'Selesai');

        // Fitur pencarian nama pelanggan jika diinput
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_pelanggan', 'like', '%' . $request->search . '%'); // fix target nama_pelanggan
        }

        $riwayatOrders = $query->latest('updated_at')->paginate(6);

        return view('kurir.history', compact('riwayatOrders'));
    }

    public function updateStatus($id)
    {
        $order = Order::findOrFail($id);
        $userId = auth()->id();
        
        // 🔥 LOGIKA BAWAAN LU TETAP DIJAGA SINKRONITASNYA
        if ($order->status == 'Sedang Dijemput' || $order->status == 'Kurir Menuju Lokasi') {
            $order->status = 'Sedang Diproses'; 
        } else if ($order->status == 'Siap Diantar') {
            $order->status = 'Selesai';
            
            // 🔥 SINKRONISASI PENTING LU: Kembalikan status_kerja kurir ke available
            $kurir = Kurir::where('user_id', $userId)->first();
            if ($kurir) {
                $kurir->status_kerja = 'available';
                $kurir->save();
            }
        }
        
        $order->save();
        
        return redirect()->back()->with('success', 'Status order berhasil diperbarui!');
    }

    public function profile()
    {
        $userId = auth()->id();
        $profile = auth()->user(); 

        $kurirInfo = Kurir::where('user_id', $userId)->first();
        
        if ($kurirInfo) {
            $profile->id = $kurirInfo->id; 
            // 🌟 FIX LOGIKA: Hitung performa selesai berdasarkan 'kurir_id'
            $profile->total_tasks = Order::where('kurir_id', $userId)->where('status', 'Selesai')->count();
            $profile->rating = $kurirInfo->rating ?? 5.0; 
        }

        return view('kurir.profile', compact('profile'));
    }
}