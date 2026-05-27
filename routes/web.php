<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\OrderController;

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

    Route::get('/order/checkout/{layanan}', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
    Route::post('/order/confirm', [OrderController::class, 'confirm'])->name('order.confirm');
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

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ==========================================
// 4. GRUP MULTI-ROLE (KENDALI DASHBOARD)
// ==========================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboard');
    })->name('admin.dashboard');
});

Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/owner/dashboard', function () {
        return view('dashboard');
    })->name('owner.dashboard');
});

Route::middleware(['auth', 'role:kurir'])->group(function () {
    Route::get('/kurir/dashboard', function () {
        return view('dashboard');
    })->name('kurir.dashboard');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/customer/dashboard', function () {
        return view('dashboard');
    })->name('customer.dashboard');
});

// ==========================================
// 5. PROFILE & AUTHENTICATION (BREEZE)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
