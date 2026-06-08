<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kurir;
// use App\Models\Order; // Di-comment dulu karena tabel/model belum siap
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
            // Sesuai migration baru kita, nama kolomnya adalah 'status_kerja'
            $query->where('status_kerja', $request->status);
        }

        // 3. Ambil data dengan Pagination
        $kurirs = $query->paginate(5);

        // 4. Set angka 0 dulu sementara biar gak error "Class Order Not Found"
        foreach ($kurirs as $kurir) {
            $kurir->total_orderan_hari_ini = 0; 
        }

        // 5. Lempar data ke view admin armada kurir
        // Pastikan nama file di folder resources/views/admin/ adalah 'armada_kurir.blade.php'
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
    // 1. Tambahkan validasi email di sini
    $request->validate([
        'nik' => 'required|string|max:16',
        'nama_lengkap' => 'required|string|max:255',
        'email' => 'required|email|max:255', // <--- Tambahkan baris ini
        'no_hp' => 'required|string|max:15',
        'kendaraan' => 'required|in:Motor,Mobil',
        'plat_nomor' => 'required|string|max:15',
        'area_tugas' => 'nullable|string|max:255',
    ]);

    // 2. Tambahkan 'email' ke dalam query create
    Kurir::create([
        'nik' => $request->nik,
        'nama_lengkap' => $request->nama_lengkap,
        'email' => $request->email, // <--- Tambahkan baris ini
        'no_hp' => $request->no_hp,
        'kendaraan' => $request->kendaraan,
        'plat_nomor' => $request->plat_nomor,
        'area_tugas' => $request->area_tugas ?? 'Semua Area',
        'status_kerja' => 'available',
    ]);

    return redirect()->route('admin.armada_kurir')->with('success', 'Data kurir berhasil ditambahkan!');
}
    // Redirect kembali ke halaman utama dengan pesan sukses
   
}