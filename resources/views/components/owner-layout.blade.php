<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $title ?? 'CleanFlow Owner' }}</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght=300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#031635",
                        "on-primary": "#ffffff",
                        "on-primary-container": "#8293b8",
                        "surface": "#f9f9ff",
                        "on-surface": "#111c2d",
                        "on-surface-variant": "#44474e",
                        "outline-variant": "#c5c6cf",
                        "surface-container-low": "#f0f3ff",
                        "error": "#ba1a1a",
                        "primary-fixed": "#d8e2ff",
                        "on-primary-fixed-variant": "#364768"
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f9f9ff; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .chart-gradient { background: linear-gradient(180deg, rgba(3, 22, 53, 0.1) 0%, rgba(3, 22, 53, 0) 100%); }
    </style>
</head>
<body class="text-on-surface">

    <aside class="fixed left-0 top-0 h-full w-[260px] bg-primary shadow-sm flex flex-col p-4 z-50">
        <div class="mb-10 px-4">
            <h1 class="text-xl font-bold text-on-primary">CleanFlow Owner</h1>
            <p class="text-xs text-on-primary-container opacity-80">Monitoring Bisnis</p>
        </div>
        <nav class="flex-1 space-y-2 overflow-y-auto">
            <a class="flex items-center gap-3 px-4 py-3 {{ Request::is('owner/dashboard*') ? 'bg-on-primary/10 text-on-primary' : 'text-on-primary-container hover:text-on-primary hover:bg-on-primary/5' }} rounded-lg transition-all" href="{{ route('owner.dashboard') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="text-sm">Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 {{ Route::is('owner.laporan-keuangan') ? 'bg-on-primary/10 text-on-primary' : 'text-on-primary-container hover:text-on-primary hover:bg-on-primary/5' }} rounded-lg transition-all" href="{{ route('owner.laporan-keuangan') }}">
                <span class="material-symbols-outlined">payments</span>
                <span class="text-sm">Laporan Keuangan</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 {{ Route::is('owner.pengaturan-harga') ? 'bg-on-primary/10 text-on-primary' : 'text-on-primary-container hover:text-on-primary hover:bg-on-primary/5' }} rounded-lg transition-all" href="{{ route('owner.pengaturan-harga') }}">
                <span class="material-symbols-outlined">analytics</span>
                <span class="text-sm">Pengaturan Harga</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 {{ Request::is('owner/order-history*') ? 'bg-on-primary/10 text-on-primary' : 'text-on-primary-container hover:text-on-primary hover:bg-on-primary/5' }} rounded-lg transition-all" href="{{ route('owner.order-history')}}">
                <span class="material-symbols-outlined">receipt_long</span>
                <span class="text-sm">Riwayat Order</span>
            </a>
        </nav>

                {{-- Tombol Keluar --}}
        <button onclick="event.preventDefault(); document.getElementById('owner-logout-form').submit();" 
                class="flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span>Keluar</span>
        </button>

        {{-- Form POST Tersembunyi --}}
        <form id="owner-logout-form" action="{{ route('owner.logout') }}" method="POST" class="hidden">
            @csrf
        </form>
        <div class="mt-auto pt-6 border-t border-on-primary/10">
            <div class="flex items-center gap-3 px-4">
                <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-300">
                    <img class="w-full h-full object-cover" src="https://via.placeholder.com/150" alt="Profile"/>
                </div>
                <div>
                    <p class="text-sm font-semibold text-on-primary">{{ auth()->user()->name ?? 'Owner Toko' }}</p>
                    <p class="text-[10px] text-on-primary-container uppercase">Owner Role</p>
                </div>
            </div>
        </div>
    </aside>

    <div class="ml-[260px] min-h-screen flex flex-col">
        <header class="flex justify-between items-center h-16 px-6 bg-surface border-b border-outline-variant sticky top-0 z-40">
            <div class="flex items-center gap-4 flex-1">
                <div class="relative w-full max-w-md">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm">search</span>
                    <input class="w-full pl-10 pr-4 py-2 bg-surface-container-low border-none rounded-xl text-xs" placeholder="Cari data owner..." type="text"/>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <span class="font-semibold text-on-surface">CleanFlow System</span>
            </div>
        </header>

        <main class="p-8 flex-1">
            {{ $slot }}
        </main>
    </div>

</body>
</html>