<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; //  Sudah diperbaiki (backslash tunggal)

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 🔥 Memaksa aset menggunakan HTTPS jika berjalan di server live Railway
        if (config('app.env') === 'production' || env('RAILWAY_STATIC_URL')) {
            URL::forceScheme('https');
        }
    }
}