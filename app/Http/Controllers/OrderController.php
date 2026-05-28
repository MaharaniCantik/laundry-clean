<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Step 1: Menampilkan halaman checkout berdasarkan jenis layanan
     */
    public function checkout($layanan)
    {
        if (!in_array($layanan, ['kiloan', 'setrika', 'permadani', 'sepatu', 'bedcover', 'boneka', 'gorden'])) {
            abort(404);
        }

        return view('orders.checkout', compact('layanan'));
    }

    /**
     * Step 2: Menerima data dari Checkout, Hitung Ongkir, & Tampilkan Halaman Timbangan
     */
   public function showService(Request $request)
    {
        // 1. Tangkap data dari Step 1 dengan nama input yang BENAR
        $namaUser = $request->input('nama_pelanggan'); 
        $alamatUser = $request->input('alamat_lengkap');
        
        // Ambil jarak (pastikan nama inputnya sesuai dengan yang ada di select kecamatan lo, misal 'jarak_km')
        $jarakTampil = (float) $request->input('jarak_km', 1.2); 

        // 2. Logika Hitung Ongkir Otomatis (Pindahan dari Blade lo)
        if ($jarakTampil > 0 && $jarakTampil <= 5.0) {
            $ongkir = 0;
            $statusOngkirText = 'Gratis Ongkir (0-5 Km)';
            $badgeClass = 'bg-green-100 text-green-700 border-green-200';
        } elseif ($jarakTampil > 5.0 && $jarakTampil <= 7.0) {
            $ongkir = 7000;
            $statusOngkirText = '+ Rp 7.000 (5-7 Km)';
            $badgeClass = 'bg-orange-100 text-orange-700 border-orange-200';
        } elseif ($jarakTampil > 7.0 && $jarakTampil <= 10.0) {
            $ongkir = 12000;
            $statusOngkirText = '+ Rp 12.000 (7-10 Km)';
            $badgeClass = 'bg-orange-100 text-orange-700 border-orange-200';
        } else {
            $ongkir = 15000;
            $statusOngkirText = 'Di Luar Jangkauan (+ Rp 15.000)';
            $badgeClass = 'bg-red-100 text-red-700 border-red-200';
        }

        // 3. Lempar semua variabel ini ke view biar tinggal dipake bersih
        return view('orders.service', compact(
            'namaUser', 
            'alamatUser', 
            'jarakTampil', 
            'ongkir', 
            'statusOngkirText', 
            'badgeClass'
        ));
    }       

    /**
     * Step 3: Eksekutor Final - Simpan Data ke Tabel Orders Supabase
     */
    public function store(Request $request)
    {
        // 1. Validasi input wajib dari halaman service/timbangan
        $request->validate([
            'nama_pelanggan'    => 'required',
            'alamat_lengkap'    => 'required',
            'berat_laundry'     => 'required|numeric|min:1',
            'metode_pembayaran' => 'required',
        ]);

        try {
            $hargaPerKg = 8000;
            $berat      = (float) $request->input('berat_laundry', 1);
            $ongkir     = (float) $request->input('ongkos_kirim', 0);

            // 2. Tembak data langsung ke tabel orders Supabase sesuai skema valid asli lo
            $orderId = DB::table('orders')->insertGetId([
                'user_id'           => auth()->check() ? auth()->id() : null,
                'nama_pelanggan'    => $request->input('nama_pelanggan'),
                'alamat_lengkap'      => $request->input('alamat_lengkap'),
                'jarak_km'            => (float) $request->input('jarak_km', 0),
                'ongkos_kirim'        => $ongkir,
                'berat_laundry'       => $berat,
                'metode_pembayaran'   => $request->input('metode_pembayaran'),
                'instruksi_pencucian' => $request->input('instruksi_pencucian'),
                'status'              => 'Pending Penjemputan', // Default status non-null
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);

            // 3. Alihkan ke halaman riwayat/laporan pencucian dengan flash message sukses
            return redirect()->route('order.history')->with([
                'success' => 'Orderan berhasil disimpan ke Supabase!',
                'order_data' => (object) [
                    'id'                => $orderId,
                    'nama_pelanggan'    => $request->input('nama_pelanggan'),
                    'metode_pembayaran' => $request->input('metode_pembayaran'),
                    'status'            => 'Pending Penjemputan',
                    'berat_laundry'     => $berat,
                    'ongkos_kirim'      => $ongkir,
                    'jarak_km'          => (float) $request->input('jarak_km', 0),
                    'alamat_lengkap'    => $request->input('alamat_lengkap'),
                    'created_at'        => now()
                ]
            ]);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal simpan data ke Supabase: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan Halaman Riwayat / Laporan Pencucian
     */
    public function history()
    {
        // Ambil data kiriman dari session flash store tadi
        $order = session('order_data');

        // Kalau user akses langsung tanpa order baru, kita ambilin data terakhir dari DB
        if (!$order) {
            $order = \DB::table('orders')
                        ->where('user_id', auth()->id())
                        ->orderBy('created_at', 'desc')
                        ->first();
        }

        // Kalau bener-bener kosong, baru balikin ke dashboard
        if (!$order) {
            return redirect()->route('dashboard');
        }

        return view('orders.history', compact('order'));
    }

    // =========================================================================
    // Sisa layanan di bawah ini dipertahankan jika view-nya memang mandiri
    // =========================================================================
    public function kiloan() { return view('orders.kiloan'); }
    public function permadani() { return view('orders.permadani'); }
    public function setrika() { return view('orders.setrika'); }
    public function boneka() { return view('orders.boneka'); }
    public function gorden() { return view('orders.gorden'); }
    public function bedcover() { return view('orders.bedcover'); }
    public function sepatu() { return view('orders.sepatu'); }
}