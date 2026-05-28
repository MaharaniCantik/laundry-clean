<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// 1. Wajib panggil Controller yang udah kamu buat tadi di sini
use App\Http\Controllers\API\OrderController; 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// 2. Tambahkan Route baru kamu di bawah ini (masih di dalam pengaman Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    
    // Route untuk membuat pesanan, hitung jarak otomatis, dan update alamat
    Route::post('/buat-pesanan', [OrderController::class, 'buatPesanan']);
    
});