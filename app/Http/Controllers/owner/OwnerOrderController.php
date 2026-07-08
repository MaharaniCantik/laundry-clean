<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Barryvdh\Dompdf\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class OwnerOrderController extends Controller
{
    // Halaman Dashboard Utama Owner
    public function dashboard()
    {
        // 1. Statistik Utama (All-Time)
        $totalPendapatan = Order::where('status', 'Selesai')->sum('total_harga');
        $totalTransaksi = Order::count();
        $jumlahPelanggan = Order::distinct('nama_pelanggan')->count('nama_pelanggan');
        $orderHariIni = Order::whereDate('created_at', Carbon::today())->count();
        $orderBekerja = Order::whereNotIn('status', ['Selesai', 'Dibatalkan'])->count();
        $latestOrders = Order::latest()->take(5)->get();

        // ================= KODE TAMBAHAN UNTUK GRAFIK =================
        $chartLabels = [];
        $chartData = [];

        // Loop 7 hari terakhir
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            // Simpan label tanggal (Format contoh: "06 Jul")
            $chartLabels[] = $date->translatedFormat('d M');

            // Hitung total harga orderan yang 'Selesai' di tanggal tersebut
            $income = Order::where('status', 'Selesai')
                ->whereDate('updated_at', $date)
                ->sum('total_harga');

            $chartData[] = $income;
        }
        // ==============================================================

        return view('owner.dashboard', compact(
            'totalPendapatan',
            'totalTransaksi',
            'jumlahPelanggan',
            'orderHariIni',
            'orderBekerja',
            'latestOrders',
            'chartLabels', // Kirim ke blade
            'chartData'    // Kirim ke blade
        ));
    }

    // Halaman Index Tabel Riwayat
    public function index()
    {
        return view('owner.order-history');
    }
    public function laporanKeuangan(Request $request)
    {
        // 1. Ambil filter tanggal dari form request (jika kosong, default bulan ini)
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // 2. Query dasar: Mengambil orderan yang sudah 'Selesai' di rentang tanggal tersebut
        $query = Order::where('status', 'Selesai')
            ->whereBetween('updated_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        // 3. Hitung data Bento Grid Utama
        $totalPendapatan = $query->sum('total_harga');
        $totalTransaksi  = $query->count();

        // 4. Pisah Pendapatan per Metode Pembayaran (Gunakan clone)
        $pembayaranCash  = (clone $query)->where('metode_pembayaran', 'COD')->sum('total_harga');
        $pembayaranQris  = (clone $query)->where('metode_pembayaran', 'QRIS')->sum('total_harga');

        // TAMBAHAN: Hitung pembayaran menggunakan Debit Card
        // Catatan: Sesuaikan string 'DEBIT' di bawah ini dengan teks yang biasa masuk ke database lu (misal 'DEBIT' atau 'DEBIT_CARD')
        $pembayaranDebit = (clone $query)->where('metode_pembayaran', 'CARD')->sum('total_harga');

        // 5. Ambil list transaksi untuk tabel riwayat
        $transactions = $query->orderBy('updated_at', 'desc')->get();

        // 6. Lempar semua variabel ke view, termasuk $pembayaranDebit
        return view('owner.laporan-keuangan', compact(
            'totalPendapatan',
            'totalTransaksi',
            'pembayaranCash',
            'pembayaranQris',
            'pembayaranDebit',
            'transactions',
            'startDate',
            'endDate'
        ));
    }

    // Tambahkan API ini jika lu mau tabelnya nge-polling/update via JavaScript secara realtime
    public function getLaporanKeuanganApi(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $query = Order::where('status', 'Selesai')
            ->whereBetween('updated_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        return response()->json([
            'total_pendapatan' => $query->sum('total_harga'),
            'total_transaksi' => $query->count(),
            'pembayaran_cash' => (clone $query)->where('metode_pembayaran', 'CASH')->sum('total_harga'),
            'pembayaran_qris' => (clone $query)->where('metode_pembayaran', 'QRIS')->sum('total_harga'),
            'transactions' => $query->orderBy('updated_at', 'desc')->get()
        ]);
    }

    // API Real-time Data untuk Polling JS
    public function getOrdersApi()
    {
        // Mengambil 6 orderan terbaru dengan kolom asli database lo
        $orders = Order::latest()->take(6)->get();

        $totalHariIni = Order::whereDate('created_at', Carbon::today())->count();
        $orderSelesai = Order::where('status', 'Selesai')->count();

        return response()->json([
            'orders' => $orders,
            'kpi' => [
                'total_hari_ini' => $totalHariIni,
                'total_selesai' => $orderSelesai
            ]
        ]);
    }
    public function updateHarga(Request $request)
    {
        // 1. Ambil data config lama yang saat ini tersimpan
        $currentConfig = config('laundry');

        // 2. Cek apakah ini aksi klik tombol AKTIF / NONAKTIF
        if ($request->has('toggle_key')) {
            $key = $request->input('toggle_key');
            if (isset($currentConfig[$key])) {
                // Balik status is_active nya (true jadi false, vice versa)
                $currentConfig[$key]['is_active'] = !$currentConfig[$key]['is_active'];
            }
        }
        // 3. Jika ini aksi simpan nominal harga dari form input
        else {
            foreach ($request->except(['_token', '_method']) as $key => $hargaBaru) {
                if (isset($currentConfig[$key])) {
                    $currentConfig[$key]['harga'] = (int) $hargaBaru;
                }
            }
        }

        // 4. Tulis ulang perubahannya langsung ke file config/laundry.php
        $configPath = config_path('laundry.php');
        $content = "<?php\n\nreturn " . var_export($currentConfig, true) . ";\n";
        file_put_contents($configPath, $content);

        return redirect()->back()->with('success', 'Pengaturan master harga berhasil diperbarui!');
    }
    public function pengaturanHarga()
    {
        // Mengambil semua isi array dari file config/laundry.php
        $allLayanan = config('laundry');
        return view('owner.pengaturan-harga', compact('allLayanan'));
    }
    public function exportPdf(Request $request)
    {
        // Tangkap input dari form filter berdasarkan name yang baru
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Mulai query model database lu
        $query = Order::orderBy('created_at', 'desc'); // Ganti 'Order' dengan nama Model lu (misal Transaksi)

        // Jika filter tanggal diisi, lakukan penyaringan data
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]);
        }

        $laporan = $query->get();

        // Lempar data ke view PDF
        $pdf = \Barryvdh\Dompdf\Facades\Pdf::loadView('owner.laporan-pdf', compact('laporan', 'startDate', 'endDate'));

        return $pdf->setPaper('a4', 'portrait')->download('Laporan-Keuangan.pdf');
    }

    public function logout(Request $request)
    {
        // 1. Ambil nama Owner yang sedang login sebelum session dihancurkan
        $namaOwner = auth()->user()->name ?? 'Owner';

        // 2. Proses keluar session resmi Laravel
        Auth::logout();

        // 3. Hapus dan amankan session token dari celah pembajakan session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 4. Balikin ke halaman utama dengan pesan sukses yang ramah
        return redirect('/')
            ->with('success', "Sampai jumpa kembali, {$namaOwner}! Terima kasih atas kerja kerasnya hari ini.");
    }
}
