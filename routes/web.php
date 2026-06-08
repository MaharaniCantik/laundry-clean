<?php

use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\KurirController;
use Illuminate\Support\Facades\Redirect;

// ==========================================
// 1. RUTE HALAMAN UTAMA (LANDING PAGE)
// ==========================================
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/lacak', [TrackingController::class, 'index'])->name('lacak');

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

// ==========================================
// 4. GRUP MULTI-ROLE (KENDALI DASHBOARD)
// ==========================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    // 1. Ini route dashboard yang benar
    Route::get('/admin/dashboard', [OrderAdminController::class, 'index'])->name('admin.dashboard');

    // 2. Ini route orders Anda yang sudah benar
    Route::get('/admin/orders',[OrderAdminController::class, 'ordersPage'])->name('admin.orders');

    // Taruh ini di bawah rute admin.orders yang sudah ada kemarin:
    Route::post('/admin/orders/{id}/update-status', [OrderAdminController::class, 'updateStatus'])->name('admin.orders.update-status');

    // TARUH DI SINI (Gua sejajarin biar gak tumpang tindih middleware-nya, dan namanya disamain):
    Route::get('/admin/armada_kurir', [KurirController::class, 'index'])->name('admin.armada_kurir');
    // Route untuk menampilkan halaman form tambah kurir
    Route::get('/admin/armada_kurir/create', [KurirController::class, 'create'])->name('admin.armada_kurir.create');

    // Route untuk memproses penyimpanan data kurir baru
    Route::post('/admin/armada_kurir/store', [KurirController::class, 'store'])->name('admin.armada_kurir.store');
});



Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/owner/dashboard', function () {
        return view('owner.dashboard');
    })->name('owner.dashboard');
});

Route::middleware(['auth', 'role:kurir'])->group(function () {
    Route::get('/kurir/dashboard', function () {
       return view('kurir.dashboard');
    })->name('kurir.dashboard');
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
