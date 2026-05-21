<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function kiloan()
    {
        return view('orders.kiloan'); 
    }
    public function checkout($layanan)
    {
        if (!in_array($layanan, ['kiloan', 'setrika', 'permadani', 'sepatu','bedcover','boneka','gorden'])) {
        abort(404);
    }

    return view('orders.checkout', compact('layanan'));
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
    public function store(Request $request)
    {
        // Ini buat ngetes doang apakah datanya beneran masuk pas di-klik nanti
       $layanan = $request->input('jenis_layanan', 'kiloan');
       $dataStep1 = $request->all();
       return view('orders.service', compact('layanan', 'dataStep1'));
    }

    public function service(Request $request)
    {
        // Frontend Note: Kita tangkap data dari Step 1 biar gak hilang
        $dataStep1 = $request->all();
        $layanan = $request->jenis_layanan;

        // Buka halaman service.blade.php sambil oper datanya
        return view('orders.service', compact('dataStep1', 'layanan'));
    }
}
