<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\OrderController;

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
    Route::post('/orders/service{layanan}', [OrderController::class, 'checkout'])->name('order.checkout');
});
Route::get('/', function () {
    return view('welcome');
});
Route::get('/lacak', [TrackingController::class, 'index'])->name('lacak');

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
