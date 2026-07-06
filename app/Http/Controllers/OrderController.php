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
        $alamatUser = $request->input('alamat_lengkap') ?? old('alamat_lengkap');

        $layanan = $request->input('layanan_utama')
            ?? $request->input('jenis_layanan')
            ?? $request->input('layanan')
            ?? old('jenis_layanan', 'kiloan');

        $jenisLayanan = $layanan;
        $hariPickup = $request->input('hari_pickup') ?? old('hari_pickup');
        $jamPickup  = $request->input('jam_pickup') ?? old('jam_pickup');

        // 🌟 TAMBAHKAN 3 BARIS INI BIAR TANGGAL/JAM DELIVERY & INSTRUKSI ALAMAT GA HILANG
        $hariDelivery = $request->input('hari_delivery') ?? old('hari_delivery');
        $jamDelivery  = $request->input('jam_delivery') ?? old('jam_delivery');
        $instruksiAlamat = $request->input('instruksi_alamat') ?? old('instruksi_alamat');

        $jarakTampil = (float) ($request->input('jarak_km') ?? old('jarak_km', 1.2));

        // Logika hitung ongkir default
        $ongkir = 0;
        $statusOngkirText = 'Gratis Ongkir (0-5 Km)';
        $badgeClass = 'bg-green-100 text-green-700 border-green-200';

        // Logika pengecekan jarak yang lama
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
        } elseif ($jarakTampil > 10.0) {
            $ongkir = 15000;
            $statusOngkirText = 'Di Luar Jangkauan (+ Rp 15.000)';
            $badgeClass = 'bg-red-100 text-red-700 border-red-200';
        }

        return view('orders.service', compact(
            'namaUser',
            'alamatUser',
            'layanan',
            'jenisLayanan',
            'jarakTampil',
            'ongkir',
            'statusOngkirText',
            'badgeClass',
            'hariPickup',
            'jamPickup',
            'hariDelivery',
            'jamDelivery',
            'instruksiAlamat' // 🔥 Tambahkan ini ke compact
        ));
    }
    /**
     * Step 3: Eksekutor Final - Simpan Data Orderan Awal
     */
public function store(Request $request)
    {
        // 1. VALIDASI INPUT FORM
        $request->validate([
            'alamat_lengkap'    => 'required|string',
            'berat_laundry'     => 'required|numeric|min:1',
            'tipe_durasi'       => 'required|string',
            'metode_pembayaran' => 'required|string',
            'jarak_km'          => 'required',
            'ongkos_kirim'      => 'required',
        ], [
            'alamat_lengkap.required' => 'Alamat pengiriman wajib diisi melalui maps.',
            'berat_laundry.min'       => 'Minimal berat laundry adalah 1 unit/kg.',
        ]);

        try {
            $qtyInput     = (float) $request->input('berat_laundry', 1);
            $ongkir       = (float) $request->input('ongkos_kirim', 0);
            $jarak        = (float) $request->input('jarak_km', 0);
            $jenisLayanan = $request->input('jenis_layanan') ?? $request->input('layanan_utama', 'kiloan');
            $tipeDurasi   = $request->input('tipe_durasi', 'reguler');

            // =====================================================================
            // 🌟 GABUNGKAN INSTRUKSI ALAMAT & DRIVER (BIAR GA USAH TAMBAH KOLOM DB)
            // =====================================================================
            $instruksiAlamat = $request->input('instruksi_alamat');
            $instruksiDriver = $request->input('instruksi_driver');

            $catatanDriverFinal = "";
            if ($instruksiAlamat) {
                $catatanDriverFinal .= "[Petunjuk Alamat]: " . $instruksiAlamat . " | ";
            }
            $catatanDriverFinal .= "[Pesan ke Driver]: " . ($instruksiDriver ?? '-');

            // =====================================================================
            // LOGIKA HITUNG HARGA DINAMIS & AMANKAN TEKS PAKET
            // =====================================================================
            if ($jenisLayanan == 'boneka') {
                // 🧸 DETEKSI HARGA BERDASARKAN UKURAN BONEKA
                $ukuranLower = strtolower($tipeDurasi);
                if ($ukuranLower == 's') {
                    $hargaPerUnit = 20000;
                    $namaPaketTeks = "Boneka - Kecil (S)";
                } elseif ($ukuranLower == 'm') {
                    $hargaPerUnit = 30000;
                    $namaPaketTeks = "Boneka - Sedang (M)";
                } elseif ($ukuranLower == 'l') {
                    $hargaPerUnit = 60000;
                    $namaPaketTeks = "Boneka - Besar (L)";
                } elseif ($ukuranLower == 'xl') {
                    $hargaPerUnit = 75000;
                    $namaPaketTeks = "Boneka - Sangat Besar (XL)";
                } else {
                    $hargaPerUnit = 20000;
                    $namaPaketTeks = "Boneka - Kecil (S)";
                }
                $estimasiHarga = ($qtyInput * $hargaPerUnit) + $ongkir;
            } elseif ($jenisLayanan == 'permadani') {
                $hargaPerUnit = ($tipeDurasi == 'tebal') ? 70000 : 45000;
                $estimasiHarga = ($qtyInput * $hargaPerUnit) + $ongkir;
                $namaPaketTeks = "Permadani - " . ucfirst($tipeDurasi);
            } elseif ($jenisLayanan == 'gorden') {
                // 🧺 LOGIKA UPDATE: HITUNG HARGA PREMIUM GORDEN
                $tipeGordenLower = strtolower($tipeDurasi);
                if ($tipeGordenLower == 'vitrase') {
                    $hargaPerUnit = 25000;
                    $namaPaketTeks = "Gorden - Vitrase";
                } elseif ($tipeGordenLower == 'tipis') {
                    $hargaPerUnit = 30000;
                    $namaPaketTeks = "Gorden - Tipis";
                } elseif ($tipeGordenLower == 'tebal') {
                    $hargaPerUnit = 35000;
                    $namaPaketTeks = "Gorden - Tebal";
                } else {
                    $hargaPerUnit = 30000; // Fallback ke tipis jika tidak terdeteksi
                    $namaPaketTeks = "Gorden - Tipis";
                }
                $estimasiHarga = ($qtyInput * $hargaPerUnit) + $ongkir;
            } elseif ($jenisLayanan == 'setrika') {
                if ($tipeDurasi == 'kilat') {
                    $hargaPerKg = 12000;
                } elseif ($tipeDurasi == 'express') {
                    $hargaPerKg = 8000;
                } else {
                    $tipeDurasi = 'reguler';
                    $hargaPerKg = 5000;
                }
                $estimasiHarga = ($qtyInput * $hargaPerKg) + $ongkir;
                $namaPaketTeks = "Setrika - " . ucfirst($tipeDurasi);
            } else {
                if ($tipeDurasi !== 'express' && $tipeDurasi !== 'reguler') {
                    $tipeDurasi = 'reguler';
                }
                $hargaPerKg = ($tipeDurasi == 'express') ? 9000 : 5000;
                $estimasiHarga = ($qtyInput * $hargaPerKg) + $ongkir;
                $namaPaketTeks = "Kiloan - " . ucfirst($tipeDurasi);
            }

            // =====================================================================
            // LOGIKA OTOMATISASI TANGGAL & JAM DELIVERY
            // =====================================================================
            $hariPickup       = $request->input('hari_pickup');
            $hariDeliveryUser = $request->input('hari_delivery');
            $rawJamPickup     = $request->input('jam_pickup');
            $rawJamDelivery   = $request->input('jam_delivery');

            $mapJam = [
                '09:00 - 11:00' => 'Pagi (09:00 - 11:00)',
                '11:00 - 13:00' => 'Siang (11:00 - 13:00)',
                '13:00 - 15:00' => 'Siang (13:00 - 15:00)',
                '15:00 - 17:00' => 'Sore (15:00 - 17:00)',
                '17:00 - 19:00' => 'Sore/Malam (17:00 - 19:00)',
                '19:00 - 21:00' => 'Malam (19:00 - 21:00)',
                '21:00 - 22:00' => 'Malam Khusus Weekend (21:00 - 22:00)',
            ];

            $jamPickupFinal = $mapJam[$rawJamPickup] ?? $rawJamPickup ?? 'Siang (11:00 - 13:00)';
            $isKilat        = ($jenisLayanan == 'setrika' && $tipeDurasi == 'kilat');

            if ($isKilat) {
                $tglFinal = $hariPickup;
                if ($rawJamPickup == '09:00 - 11:00') {
                    $jamDeliveryFinal = $mapJam['11:00 - 13:00'];
                } elseif ($rawJamPickup == '11:00 - 13:00') {
                    $jamDeliveryFinal = $mapJam['13:00 - 15:00'];
                } elseif ($rawJamPickup == '13:00 - 15:00') {
                    $jamDeliveryFinal = $mapJam['15:00 - 17:00'];
                } elseif ($rawJamPickup == '15:00 - 17:00') {
                    $jamDeliveryFinal = $mapJam['17:00 - 19:00'];
                } else {
                    $jamDeliveryFinal = $mapJam['19:00 - 21:00'];
                }
            } else {
                // 🧸 SINKRONISASI HARI ESTIMASI SECARA SILENT (CARA 1)
                if ($jenisLayanan == 'boneka') {
                    $ukuranLower = strtolower($tipeDurasi);
                    if ($ukuranLower == 's') {
                        $durasiMinimal = 2;
                    } elseif ($ukuranLower == 'm' || $ukuranLower == 'l') {
                        $durasiMinimal = 4;
                    } elseif ($ukuranLower == 'xl') {
                        $durasiMinimal = 7;
                    } else {
                        $durasiMinimal = 3;
                    }
                } elseif ($jenisLayanan == 'permadani') {
                    $durasiMinimal = 14;
                } elseif ($jenisLayanan == 'gorden') {
                    // 🧺 LOGIKA UPDATE: SINKRONISASI DURASI MINIMAL GORDEN
                    $durasiMinimal = (strtolower($tipeDurasi) == 'tebal') ? 4 : 3;
                } elseif ($tipeDurasi == 'express') {
                    $durasiMinimal = 1;
                } else {
                    $durasiMinimal = ($jenisLayanan == 'setrika') ? 2 : 3;
                }

                $tanggalMinimalSelesai = date('Y-m-d', strtotime($hariPickup . ' + ' . $durasiMinimal . ' days'));
                $tglFinal = (!$hariDeliveryUser || $hariDeliveryUser < $tanggalMinimalSelesai) ? $tanggalMinimalSelesai : $hariDeliveryUser;
                $jamDeliveryFinal = $mapJam[$rawJamDelivery] ?? $rawJamDelivery ?? $jamPickupFinal;
            }

            $jadwalPengiriman = $tglFinal . ' @ ' . $jamDeliveryFinal;

            // Generate nomor resi unik
            $nomorResi = 'CY-' . date('ymd') . '-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));

            // =====================================================================
            // 🌟 INSERT DATA KE DATABASE
            // =====================================================================
            $orderId = \DB::table('orders')->insertGetId([
                'nomor_resi'          => $nomorResi,
                'user_id'             => auth()->id(),
                'nama_pelanggan'      => auth()->user()->name,
                'alamat_lengkap'      => $request->input('alamat_lengkap'),
                'nomor_telepon_order' => $request->input('phone'),
                'instruksi_driver'    => $catatanDriverFinal,
                'jarak_km'            => $jarak,
                'ongkos_kirim'        => $ongkir,
                'tipe_durasi'         => $namaPaketTeks,
                'berat_laundry'       => $qtyInput,
                'total_harga'         => $estimasiHarga,
                'jenis_layanan'       => $jenisLayanan,
                'metode_pembayaran'   => $request->input('metode_pembayaran'),
                'instruksi_pencucian' => $request->input('instruksi_pencucian'),
                'status'              => 'Pending Penjemputan',
                'jadwal_pickup'       => $hariPickup . ' @ ' . $jamPickupFinal,
                'jadwal_pengiriman'   => $jadwalPengiriman,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);

            // REDIRECT BERHASIL KE HALAMAN HISTORY
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
                    'jadwal_pickup'     => $hariPickup . ' @ ' . $jamPickupFinal,
                    'jadwal_pengiriman' => $jadwalPengiriman,
                    'instruksi_driver'  => $catatanDriverFinal,
                    'created_at'        => now()
                ]
            ]);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan pesanan: ' . $e->getMessage());
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

            $tipeDurasiLower = strtolower($order->tipe_durasi);

            // =====================================================================
            // 🌟 LOGIKA HITUNG HARGA REAL ADMIN (DIPERBAIKI UNTUK GORDEN)
            // =====================================================================
            if ($order->jenis_layanan == 'boneka') {
                if (str_contains($tipeDurasiLower, 'kecil') || str_contains($tipeDurasiLower, '(s)')) {
                    $hargaPerUnit = 20000;
                } elseif (str_contains($tipeDurasiLower, 'sedang') || str_contains($tipeDurasiLower, '(m)')) {
                    $hargaPerUnit = 30000;
                } elseif (str_contains($tipeDurasiLower, 'besar') || str_contains($tipeDurasiLower, '(l)')) {
                    $hargaPerUnit = 60000;
                } elseif (str_contains($tipeDurasiLower, 'sangat besar') || str_contains($tipeDurasiLower, '(xl)')) {
                    $hargaPerUnit = 75000;
                } else {
                    $hargaPerUnit = 20000;
                }
                $hargaFinalPerItem = $hargaPerUnit;
            } elseif ($order->jenis_layanan == 'gorden') {
                // 🧺 AMANKAN HARGA REAL KHUSUS LAYANAN GORDEN PREMIUM
                if (str_contains($tipeDurasiLower, 'vitrase')) {
                    $hargaFinalPerItem = 25000;
                } elseif (str_contains($tipeDurasiLower, 'tipis')) {
                    $hargaFinalPerItem = 30000;
                } elseif (str_contains($tipeDurasiLower, 'tebal')) {
                    $hargaFinalPerItem = 35000;
                } else {
                    $hargaFinalPerItem = 30000; // Fallback gorden tipis
                }
            } elseif ($order->jenis_layanan == 'permadani') {
                // 🎪 Pisahkan permadani dari kiloan karena harganya beda jauh
                $hargaFinalPerItem = (str_contains($tipeDurasiLower, 'tebal')) ? 70000 : 45000;
            } elseif ($order->jenis_layanan == 'setrika') {
                if (str_contains($tipeDurasiLower, 'kilat')) {
                    $hargaFinalPerItem = 12000;
                } elseif (str_contains($tipeDurasiLower, 'express')) {
                    $hargaFinalPerItem = 8000;
                } else {
                    $hargaFinalPerItem = 5000;
                }
            } else {
                // Khusus laundry kiloan biasa
                $hargaFinalPerItem = (str_contains($tipeDurasiLower, 'express')) ? 9000 : 5000;
            }

            $beratReal = (float) $request->input('berat_asli');
            $totalHargaFix = ($beratReal * $hargaFinalPerItem) + $order->ongkos_kirim;

            DB::table('orders')->where('id', $id)->update([
                'berat_laundry' => $beratReal,
                'total_harga'   => $totalHargaFix,
                'status'        => 'Sedang Diproses',
                'updated_at'    => now(),
            ]);

            return back()->with('success', 'Berat/Jumlah asli berhasil diperbarui! Harga dihitung otomatis oleh sistem.');
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
