<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        // Sementara kita tampilin view-nya aja dulu
        return view('lacak'); 
    }
}
