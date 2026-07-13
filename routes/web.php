<?php

use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\KurirController;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Kurir\KurirDashboardController;
use App\Http\Controllers\Owner\OwnerOrderController;

// ==========================================
// 1. RUTE HALAMAN UTAMA (LANDING PAGE)
// ==========================================
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/lacak', [TrackingController::class, 'index'])->name('tracking.index');
Route::post('/lacak/cari', [TrackingController::class, 'search'])->name('tracking.search');

// ==========================================
// 2. RUTE UNTUK ORDERAN (WAJIB LOGIN)
// ==========================================
Route::middleware(['auth'])->group(function () {
    Route::get('/orders/kiloan', [OrderController::class, 'kiloan'])->name('order.kiloan');
    Route::get('/orders/permadani', [OrderController::class, 'permadani'])->name('order.permadani');
    Route::get('/orders/setrika', [OrderController::class, 'setrika'])->name('order.setrika');
    Route::get('/orders/boneka', [OrderController::class, 'boneka'])->name('order.boneka');
    Route::get('/orders/gorden', [OrderController::class, 'gorden'])->name('order.gorden');
    Route::get('/orders/bedcover', [OrderController::class, 'bedcover'])->name('order.bedcover');
    Route::get('/orders/sepatu', [OrderController::class, 'sepatu'])->name('order.sepatu');
    Route::any('/order/service', [OrderController::class, 'showService'])->name('order.service'); 

    Route::get('/order/checkout/{layanan}', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
    Route::post('/order/confirm', [OrderController::class, 'confirm'])->name('order.confirm');
    Route::get('/order/history', [OrderController::class, 'history'])->name('order.history');
});

// ==========================================
// 3. ROUTE DASHBOARD (PENGALIRAN ROLE)
// ==========================================
Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'owner') {
        return redirect()->route('owner.dashboard');
    } elseif ($role === 'kurir') {
        return redirect()->route('kurir.dashboard');
    }

    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

// =====================================================================
// 4. GRUP MULTI-ROLE (KENDALI DASHBOARD ADMIN)
// =====================================================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    // 1. Ini route dashboard admin
    Route::get('/admin/dashboard', [OrderAdminController::class, 'index'])->name('admin.dashboard');

    // 2. Ini route orders admin
    Route::get('/admin/orders',[OrderAdminController::class, 'ordersPage'])->name('admin.orders');

    // Route update status versi admin
    Route::post('/admin/orders/{id}/update-status', [OrderAdminController::class, 'updateStatus'])->name('admin.orders.update-status');

    Route::post('/admin/order/konfirmasi/{id}', [OrderAdminController::class, 'konfirmasiOrder'])->name('admin.konfirmasiOrder');

    // Manajemen Armada Kurir oleh Admin
    Route::get('/admin/armada_kurir', [KurirController::class, 'index'])->name('admin.armada_kurir');
    Route::get('/admin/armada_kurir/create', [KurirController::class, 'create'])->name('admin.armada_kurir.create');
    Route::post('/admin/armada_kurir/store', [KurirController::class, 'store'])->name('admin.armada_kurir.store');

    Route::post('/admin/armada-kurir/tes-tembak', [OrderAdminController::class, 'tesKurirManual'])->name('admin.tes_kurir_manual');
    
    // ❌ NOTE: Route updateStatus kurir yang tadinya di sini SUDAH DIHAPUS & DIPINDAHKAN ke grup kurir di bawah!
});

Route::middleware(['auth', 'role:owner'])->group(function () {
    // 1. Halaman Dashboard Utama Owner
    Route::get('/owner/dashboard', [OwnerOrderController::class, 'dashboard'])->name('owner.dashboard');
    
    // 2. Halaman Index Arsip Riwayat Order (Real-time View)
    Route::get('/owner/order-history', [OwnerOrderController::class, 'index'])->name('owner.order-history');
    
    // 3. Halaman Monitoring Keuangan
    Route::get('/owner/laporan-keuangan', [OwnerOrderController::class, 'laporanKeuangan'])->name('owner.laporan-keuangan');
    Route::get('/owner/laporan-keuangan/laporan-pdf', [OwnerOrderController::class, 'exportPdf'])->name('owner.laporan-pdf');
    Route::get('/api/laporan-keuangan', [OwnerOrderController::class, 'getLaporanKeuanganApi']);

   // 1. Route untuk MEMBUKA halaman pengaturan harga
    Route::get('/owner/pengaturan-harga', [OwnerOrderController::class, 'pengaturanHarga'])->name('owner.pengaturan-harga');
    Route::put('/owner/update-harga', [OwnerOrderController::class, 'updateHarga'])->name('owner.update-harga');
    Route::post('/owner/logout', [OwnerOrderController::class, 'logout'])->name('owner.logout');

    
    // 4. Endpoint API Rahasia untuk Fetch JS Polling (Wajib di dalam middleware agar aman)
    Route::get('/owner/api/orders', [\App\Http\Controllers\Owner\OwnerOrderController::class, 'getOrdersApi'])->name('owner.api.orders');
});

// Group Route khusus untuk Kurir
// Pastikan nama class Controller-nya sesuai dengan file lu (KurirDashboardController)

// =====================================================================
// 5. GRUP KHUSUS ARMARDA KURIR (SINKRON & AMAN)
// =====================================================================
Route::middleware(['auth'])->prefix('kurir')->name('kurir.')->group(function () {
    
    // Dashboard Utama Kurir (Menampilkan Orderan Masuk & Tugas Aktif)
    Route::get('/dashboard', [KurirDashboardController::class, 'index'])->name('dashboard');

    Route::post('/toggle-kehadiran', [KurirDashboardController::class, 'toggleKehadiran'])->name('toggleKehadiran');
    
    // 🌟 FITUR BARU: Ambil/Klaim Orderan dari Dashboard (URL: kurir/ambil/{id})
    Route::post('/ambil/{id}', [KurirDashboardController::class, 'ambilPesanan'])->name('ambil');
    
    // Update Status Proses Kerja Kurir (URL: kurir/order/{id}/update-status)
    Route::post('/order/{id}/update-status', [KurirDashboardController::class, 'updateStatus'])->name('updateStatus');
    
    // Riwayat Tugas Selesai Kurir (URL: kurir/history)
    Route::get('/history', [KurirDashboardController::class, 'history'])->name('history');
    
    // Profil Fleet Kurir (URL: kurir/profile)
    Route::get('/profile', [KurirDashboardController::class, 'profile'])->name('profile');
});


Route::get('/', function () {
    return view('welcome'); // Langsung buka halaman user/customer biasa
})->name('welcome');

// ==========================================
// 5. PROFILE & AUTHENTICATION (BREEZE)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
