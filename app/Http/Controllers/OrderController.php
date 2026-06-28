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
     * Step 2: Menerima data dari Checkout, Hitung Ongkir Berdasarkan Jarak, & Tampilkan Halaman Timbangan/Layanan
     */
    public function showService(Request $request)
    {
        $namaUser = auth()->user()->name;
        $alamatUser = $request->input('alamat_lengkap');
        $layanan = $request->input('layanan_utama', 'kiloan');

        // 🌟 TANGKAP DATA JADWAL BARU DARI STEP 1
        $hariPickup = $request->input('hari_pickup');
        $jamPickup  = $request->input('jam_pickup');

        // Menangkap input jarak dari maps javascript (default 1.2 Km)
        $jarakTampil = (float) $request->input('jarak_km', 1.2);

        // LOGIKA HITUNG ONGKIR OTOMATIS
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

        // 🌟 LEMPAR $hariPickup DAN $jamPickup KE VIEW SERVICE
        return view('orders.service', compact(
            'namaUser',
            'alamatUser',
            'layanan',
            'jarakTampil',
            'ongkir',
            'statusOngkirText',
            'badgeClass',
            'hariPickup',
            'jamPickup'
        ));
    }

    /**
     * Step 3: Eksekutor Final - Simpan Data Orderan Awal Berdasarkan Estimasi Pelanggan
     */
    public function store(Request $request)
    {
        $request->validate([
            'alamat_lengkap'    => 'required',
            'berat_laundry'     => 'required|numeric|min:1',
            'tipe_durasi'       => 'required',
            'metode_pembayaran' => 'required',
        ]);

        try {
            $qtyInput     = (float) $request->input('berat_laundry', 1);
            $ongkir       = (float) $request->input('ongkos_kirim', 0);
            $jarak        = (float) $request->input('jarak_km', 0);
            $jenisLayanan = $request->input('jenis_layanan', 'kiloan');
            $tipeDurasi   = $request->input('tipe_durasi', 'reguler');

            // 🌟 1. LOGIKA HITUNG HARGA DINAMIS & AMANKAN TEKS PAKET
            if ($jenisLayanan == 'permadani') {
                $hargaPerUnit = ($tipeDurasi == 'tebal') ? 70000 : 45000;
                $estimasiHarga = ($qtyInput * $hargaPerUnit) + $ongkir;

                // Format teks untuk disimpan ke kolom tipe_durasi di DB
                $namaPaketTeks = "Permadani - " . ucfirst($tipeDurasi);
            } else {
                // Jaga-jaga kalau frontend ngirim data 'tebal'/'tipis' ke kiloan karena bug, kita paksa ke reguler/express
                if ($tipeDurasi !== 'express' && $tipeDurasi !== 'reguler') {
                    $tipeDurasi = 'reguler';
                }

                $hargaPerKg = ($tipeDurasi == 'express') ? 9000 : 5000;
                $estimasiHarga = ($qtyInput * $hargaPerKg) + $ongkir;

                $namaPaketTeks = "Kiloan - " . ucfirst($tipeDurasi);
            }

            // ====================================================
            // 🌟 2. LOGIKA OTOMATISASI TANGGAL & JAM KEMBALI
            // ====================================================
            $hariPickup = $request->input('hari_pickup');
            $hariDeliveryUser = $request->input('hari_delivery');
            $jamDelivery = $request->input('jam_delivery') ?? 'Siang (11:00 - 13:00)';

            // Tentukan durasi wajib di backend biar gak bisa diakalin frontend/javascript bug
            if ($jenisLayanan == 'permadani') {
                $durasiProses = 14; // Paksa 14 hari kalau permadani
            } elseif ($tipeDurasi == 'express') {
                $durasiProses = 1;  // Paksa 1 hari kalau kiloan express
            } else {
                $durasiProses = 3;  // Paksa 3 hari kalau kiloan reguler
            }

            // Hitung tanggal minimal yang sah
            $tanggalSeharusnya = date('Y-m-d', strtotime($hariPickup . ' + ' . $durasiProses . ' days'));

            // VALIDASI KETAT: Mau jenis layanan apapun, kalau tanggal yang dikirim user ternyata 
            // lebih cepat dari durasi standar laundry, langsung OVERWRITE/PAKSA pakai tanggal seharusnya!
            if (!$hariDeliveryUser || $hariDeliveryUser < $tanggalSeharusnya) {
                $tglFinal = $tanggalSeharusnya;
            } else {
                $tglFinal = $hariDeliveryUser;
            }

            // Gabungkan tanggal dengan jam pengiriman kembali
            $jadwalPengiriman = $tglFinal . ' @ ' . $jamDelivery;
            // ====================================================

            $tanggal = date('ymd');
            $karakterAcak = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
            $nomorResi = 'CY-' . $tanggal . '-' . $karakterAcak;

            // 🌟 3. INSERT DATA KE SUPABASE
            $orderId = DB::table('orders')->insertGetId([
                'nomor_resi'          => $nomorResi,
                'user_id'             => auth()->id(),
                'nama_pelanggan'      => auth()->user()->name,
                'alamat_lengkap'      => $request->input('alamat_lengkap'),
                'nomor_telepon_order' => $request->input('phone'),
                'instruksi_driver'    => $request->input('instruksi_driver'),
                'jarak_km'            => $jarak,
                'ongkos_kirim'        => $ongkir,
                'tipe_durasi'         => $namaPaketTeks, // Menyimpan teks rapi: "Kiloan - Express" atau "Permadani - Tebal"
                'berat_laundry'       => $qtyInput,
                'total_harga'         => $estimasiHarga, // Fix sesuai hitungan backend di atas
                'jenis_layanan'       => $jenisLayanan,
                'metode_pembayaran'   => $request->input('metode_pembayaran'),
                'instruksi_pencucian' => $request->input('instruksi_pencucian'),
                'status'              => 'Pending Penjemputan',
                'jadwal_pickup'       => $request->input('hari_pickup') . ' @ ' . $request->input('jam_pickup'),
                'jadwal_pengiriman'   => $jadwalPengiriman,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);

            // 🌟 4. REDIRECT DAN KIRIM DATA FLASH SESSION DALAM BENTUK ARRAY
            return redirect()->route('order.history')->with([
                'success' => 'Pesanan laundry Anda berhasil dibuat! Kurir kami akan segera menjemput.',
                'order_data' => [
                    'id'                => $orderId,
                    'nomor_resi'        => $nomorResi,
                    'nama_pelanggan'    => auth()->user()->name,
                    'metode_pembayaran' => $request->input('metode_pembayaran'),
                    'status'            => 'Pending Penjemputan',
                    'tipe_durasi'       => $namaPaketTeks,
                    'berat_laundry'     => $qtyInput,
                    'ongkos_kirim'      => $ongkir,
                    'jarak_km'          => $jarak,
                    'alamat_lengkap'    => $request->input('alamat_lengkap'),
                    'total_harga'       => $estimasiHarga,
                    'jadwal_pickup'     => $request->input('hari_pickup') . ' @ ' . $request->input('jam_pickup'),
                    'jadwal_pengiriman' => $jadwalPengiriman,
                    'instruksi_driver'  => $request->input('instruksi_driver'),
                    'created_at'        => now()
                ]
            ]);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan pesanan. Silakan coba lagi.');
        }
    }

    /**
     * Step 4: [FITUR DASHBOARD ADMIN] - Update Berat Asli & Hitung Otomatis Harga Final
     */
    public function updateTimbangan(Request $request, $id)
    {
        $request->validate([
            'berat_asli' => 'required|numeric|min:0.1',
        ]);

        try {
            $order = DB::table('orders')->where('id', $id)->first();

            if (!$order) {
                return back()->with('error', 'Orderan tidak ditemukan.');
            }

            $hargaPerKg = ($order->tipe_durasi == 'express') ? 9000 : 5000;
            $beratReal = (float) $request->input('berat_asli');

            $totalHargaFix = ($beratReal * $hargaPerKg) + $order->ongkos_kirim;

            DB::table('orders')->where('id', $id)->update([
                'berat_laundry' => $beratReal,
                'total_harga'   => $totalHargaFix,
                'status'        => 'Sedang Diproses',
                'updated_at'    => now(),
            ]);

            return back()->with('success', 'Berat asli berhasil diperbarui! Harga dihitung otomatis oleh sistem.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupdate data timbangan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan Halaman Riwayat / Laporan Pencucian
     */
public function history()
{
    $customerId = auth()->id();

    // 1. Ambil orderan terbaru milik customer yang sedang login
    $orderModel = \App\Models\Order::where('user_id', $customerId)
                    ->latest()
                    ->first();

    if (!$orderModel) {
        return redirect()->route('dashboard');
    }

    // Convert ke array biasa
    $order = $orderModel->toArray();

    // Default status jika kurir belum ada
    $namaKurirDitemukan = 'Mencari Kurir...';

    // 2. Gunakan kurir_id asli untuk mencari siapa kurir yang ditugaskan
    if (!empty($orderModel->kurir_id)) {
        
        // Cari ke tabel kurirs berdasarkan user_id yang sesuai dengan kurir_id di orderan
        $kurir = \DB::table('kurirs')->where('user_id', $orderModel->kurir_id)->first();
        
        if ($kurir) {
            $namaKurirDitemukan = $kurir->nama_lengkap;
        }
    }

    // Masukkan nama kurir murni ke dalam array order agar dibaca oleh blade
    $order['nama_kurir_siap'] = $namaKurirDitemukan;

    return view('orders.history', compact('order'));
}
    // View Informasi Singkat Layanan
    public function kiloan()
    {
        return view('orders.kiloan');
    }
    public function permadani()
    {
        return view('orders.permadani');
    }
    public function setrika()
    {
        return view('orders.setrika');
    }
    public function boneka()
    {
        return view('orders.boneka');
    }
    public function gorden()
    {
        return view('orders.gorden');
    }
    public function bedcover()
    {
        return view('orders.bedcover');
    }
    public function sepatu()
    {
        return view('orders.sepatu');
    }
}
