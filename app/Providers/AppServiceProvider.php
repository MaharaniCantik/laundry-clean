<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // 🔥 Tambahkan baris ini agar semua aset CSS/JS dibaca lewat HTTPS di Railway
        if (config('app.env') === 'production' || env('RAILWAY_STATIC_URL')) {
            URL::forceScheme('https');
        }
    }
}
