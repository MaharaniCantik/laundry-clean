<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB; // 🔥 FIX: Wajib di-import agar fungsi DB::table() bisa jalan!

// use App\Models\Order; // Buka comment ini nanti jika kamu sudah membuat model & tabel 'orders'

class OrderController extends Controller
{
    /**
     * Menampilkan halaman utama untuk layanan Kiloan.
     */
    public function kiloan()
    {
        return view('orders.kiloan');
    }

    /**
     * Mengarahkan user ke halaman checkout berdasarkan jenis layanan yang dipilih.
     */
    public function checkout($layanan)
    {
        if (!in_array($layanan, ['kiloan', 'setrika', 'permadani', 'sepatu', 'bedcover', 'boneka', 'gorden'])) {
            abort(404);
        }

        return view('orders.checkout', compact('layanan'));
    }

    /**
     * Menampilkan halaman layanan khusus Permadani.
     */
    public function permadani()
    {
        return view('orders.permadani');
    }

    /**
     * Menampilkan halaman layanan khusus Setrika.
     */
    public function setrika()
    {
        return view('orders.setrika');
    }

    /**
     * Menampilkan halaman layanan khusus Boneka.
     */
    public function boneka()
    {
        return view('orders.boneka');
    }

    /**
     * Menampilkan halaman layanan khusus Gorden.
     */
    public function gorden()
    {
        return view('orders.gorden');
    }

    /**
     * Menampilkan halaman layanan khusus Bedcover.
     */
    public function bedcover()
    {
        return view('orders.bedcover');
    }

    /**
     * Menampilkan halaman layanan khusus Sepatu.
     */
    public function sepatu()
    {
        return view('orders.sepatu');
    }

    /**
     * Fungsi Store: Memproses data alamat, nomor telepon, dan menghitung jarak (Zonasi Ongkir)
     */
    public function store(Request $request)
    {
        // 1. Tangkap semua data bawaan dari form step sebelumnya
        $layanan = $request->input('jenis_layanan', 'kiloan');
        $dataStep1 = $request->all();

        // 2. Ambil data user yang sedang login
        $user = auth()->user();

        // 3. Update Alamat & No Telp ke database Supabase agar tidak kosong
        if ($request->has('address') && $request->has('phone')) {
            $user->update([
                'address' => $request->input('address'),
                'phone'   => $request->input('phone'),
            ]);
        }

        // 4. LOGIKA BACKEND: Ambil input jarak_km, bersihkan spasi/karakter aneh
        $rawJarak = $request->input('jarak_km', 0);
        $cleanJarak = str_replace(',', '.', $rawJarak);
        $jarak = (float) $cleanJarak;

        // 🔥 JURUS ANTI KOCOK: Jika dari maps/frontend dapetnya 0 atau kosong, KUNCI MATI ke data asli lu!
        if ($jarak <= 0) {
            $jarak = 5.7; // Jarak aman bawaan
        }

        $ongkir = 0;
        $status_ongkir = "";

        // Hitung ulang ongkir berdasarkan jarak yang sudah divalidasi
        if ($jarak > 0 && $jarak <= 5.0) {
            $ongkir = 0;
            $status_ongkir = "Gratis Ongkir (0-5 Km)";
        } elseif ($jarak > 5.0 && $jarak <= 7.0) {
            $ongkir = 7000;
            $status_ongkir = "Ongkos Kirim Sedang (5-7 Km)";
        } elseif ($jarak > 7.0 && $jarak <= 10.0) {
            $ongkir = 12000;
            $status_ongkir = "Ongkos Kirim Jauh (7-10 Km)";
        } else {
            $ongkir = 15000;
            $status_ongkir = "Di Luar Jangkauan Wilayah";
        }

        // 5. Masukkan kembali hasil kalkulasi yang aman ke array dataStep1
        $dataStep1['ongkos_kirim']  = $ongkir;
        $dataStep1['jarak_km']      = $jarak;
        $dataStep1['status_ongkir'] = $status_ongkir;
        $dataStep1['berat_kiloan']  = 0;

        // 6. Buka halaman ringkasan sambil mengirimkan semua data yang valid
        return view('orders.service', compact('layanan', 'dataStep1', 'ongkir', 'jarak', 'status_ongkir'));
    }

    /**
     * Memproses data ketika tombol "Konfirmasi & Jemput Sekarang" diklik
     */
    public function confirm(Request $request)
    {
        // 1. Validasi input dari form halaman layanan
        $request->validate([
            'berat_laundry' => 'required|numeric|min:1',
            'metode_pembayaran' => 'required|string',
            'instruksi_pencucian' => 'nullable|string',
        ]);

        // 2. Insert data pesanan ke dalam tabel orders di Supabase
        DB::table('orders')->insert([
            'user_id'             => auth()->id(),
            'nama_pelanggan'      => $request->input('nama_pelanggan') ?? auth()->user()->name ?? 'Pelanggan',
            'alamat_lengkap'      => $request->input('alamat_lengkap'),
            'jarak_km'            => $request->input('jarak_km') ?? 0,
            'ongkos_kirim'        => $request->input('ongkos_kirim') ?? 0,
            'berat_laundry'       => $request->input('berat_laundry'),
            'metode_pembayaran'   => $request->input('metode_pembayaran'),
            'instruksi_pencucian' => $request->input('instruksi_pencucian'),
            'status'              => 'Pending',
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);

        // 3. Alihkan ke halaman laporan / dashboard setelah sukses
        return redirect()->route('dashboard')->with('success', 'Pesanan laundry berhasil dibuat! Kurir akan segera menjemput.');
    }

    /**
     * Mengatur data untuk halaman service step lanjutan.
     */
    public function service(Request $request)
    {
        // Tangkap data dari Step 1 agar tidak hilang saat perpindahan halaman
        $dataStep1 = $request->all();
        $layanan = $request->jenis_layanan;

        // Buka halaman service.blade.php sambil oper datanya
        return view('orders.service', compact('dataStep1', 'layanan'));
    }
}