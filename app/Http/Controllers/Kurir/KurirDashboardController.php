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
        $userId = auth()->id(); // ID Kurir yang lagi login
        $kurir = Kurir::where('user_id', $userId)->first();

        if (!$kurir) {
            return "Akun Anda belum terdaftar sebagai armada kurir.";
        }

        // 🔥 KOREKSI SAKTI: Cari berdasarkan instruksi_driver!
        $totalPickup = Order::where('instruksi_driver', $userId)->where('status', 'Sedang Dijemput')->count();
        $totalDelivery = Order::where('instruksi_driver', $userId)->where('status', 'Siap Diantar')->count();
        $totalCompletedToday = Order::where('instruksi_driver', $userId)
                                    ->where('status', 'Selesai')
                                    ->whereDate('updated_at', today())
                                    ->count();

        $activeTasks = Order::where('instruksi_driver', $userId)
                            ->whereIn('status', ['Sedang Dijemput', 'Siap Diantar'])
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('kurir.dashboard', compact('totalPickup', 'totalDelivery', 'totalCompletedToday', 'activeTasks'));
    }

    public function history(Request $request)
    {
        $userId = auth()->id();

        // 🔥 KOREKSI: Sesuaikan target kolom ke 'status' dan nilainya ke 'Selesai'
        $query = Order::where('user_id', $userId)->where('status', 'Selesai');

        // Fitur pencarian nama pelanggan jika diinput
        if ($request->has('search') && $request->search != '') {
            $query->where('customer_name', 'like', '%' . $request->search . '%');
        }

        $riwayatOrders = $query->latest('updated_at')->paginate(6);

        return view('kurir.history', compact('riwayatOrders'));
    }

    public function updateStatus($id)
    {
        $order = Order::findOrFail($id);
        $userId = auth()->id();
        
        // 🔥 KOREKSI ALUR: Ubah status order berjenjang sesuai alur laundry teks Indonesia Anda
        if ($order->status == 'Sedang Dijemput') {
            $order->status = 'Sedang Diproses'; 
        } else if ($order->status == 'Siap Diantar') {
            $order->status = 'Selesai';
            
            // 🔥 SINKRONISASI PENTING: Pas order Selesai, kembalikan status_kerja kurir ini jadi available agar bisa di-random pick lagi!
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

        // OPTIMALISASI: Ambil data jumlah tugas real & rating dari tabel kurirs untuk halaman profile.blade
        $kurirInfo = Kurir::where('user_id', $userId)->first();
        
        if ($kurirInfo) {
            // Kita tempelkan datanya ke objek $profile secara dinamis agar dibaca oleh view profil Anda
            $profile->id = $kurirInfo->id; 
            $profile->total_tasks = Order::where('user_id', $userId)->where('status', 'Selesai')->count(); // 🔥 KOREKSI: status 'Selesai'
            $profile->rating = $kurirInfo->rating ?? 5.0; 
        }

        return view('kurir.profile', compact('profile'));
    }
}