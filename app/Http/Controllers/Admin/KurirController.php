<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kurir;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class KurirController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data kurir dasar
        $query = Kurir::query();

        // 2. Logika Filter Dropdown Status Kerja
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status_kerja', $request->status);
        }

        // 3. Ambil data dengan Pagination
        $kurirs = $query->paginate(5);

        // 4. FIX LOGIKA: Hitung total orderan selesai riil hari ini per kurir (jaring pengaman data lama + baru)
        foreach ($kurirs as $kurir) {
            $kurir->total_orderan_hari_ini = Order::where('kurir_id', $kurir->id)
                ->whereIn('status', ['Selesai', 'To Complete'])
                ->whereDate('updated_at', Carbon::today())
                ->count();
        }

        // 5. Lempar data ke view admin armada kurir
        return view('admin.armada_kurir', compact('kurirs'));
    }

    // 1. Fungsi untuk menampilkan halaman form tambah
    public function create()
    {
        return view('admin.create_kurir');
    }

    // 2. Fungsi untuk memproses data dari form ke database
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|max:16',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'no_hp' => 'required|string|max:15',
            'kendaraan' => 'required|in:Motor,Mobil',
            'plat_nomor' => 'required|string|max:15',
            'area_tugas' => 'nullable|string|max:255',
        ]);

        // Menggunakan alamat lengkap model agar tidak tersesat di namespace Admin
        $user = \App\Models\User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'kurir',
        ]);

        // Begitu juga dengan Model Kurir
        \App\Models\Kurir::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'kendaraan' => $request->kendaraan,
            'plat_nomor' => $request->plat_nomor,
            'area_tugas' => $request->area_tugas ?? 'Semua Area',
            'status_kerja' => 'available',
        ]);

        return redirect()->route('admin.armada_kurir')->with('success', 'Data kurir berhasil ditambahkan!');
    }
}