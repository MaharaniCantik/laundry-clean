<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - CuciYuk</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans antialiased">

    <div class="flex min-h-screen">
        
        {{-- 1. SIDEBAR KIRI (MENU ADMIN) --}}
        <aside class="w-64 bg-slate-900 text-white flex flex-col shrink-0">
            <div class="p-5 text-xl font-bold tracking-wider border-b border-slate-800 text-sky-400 flex items-center gap-2">
                <i class="fa-solid fa-soap"></i> CuciYuk Admin
            </div>
            
            <nav class="flex-1 p-4 space-y-2">
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg bg-slate-800 text-white font-medium">
                    <i class="fa-solid fa-chart-simple w-5 text-center"></i> Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    <i class="fa-solid fa-boxes-stacked w-5 text-center"></i> Daftar Orderan
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    <i class="fa-solid fa-truck w-5 text-center"></i> Armada & Kurir
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    <i class="fa-solid fa-tags w-5 text-center"></i> Pengaturan Harga
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800 text-sm text-slate-400 flex items-center gap-2">
                <i class="fa-solid fa-user-shield"></i>
                <div>
                    Logged in: <span class="text-white font-semibold block">Admin Utama</span>
                </div>
            </div>
        </aside>

        {{-- 2. KONTEN SEBELAH KANAN --}}
        <div class="flex-1 flex flex-col">
            
            {{-- NAVBAR ATAS (HEADER) --}}
            <header class="bg-white h-16 shadow-sm flex items-center justify-between px-6 border-b border-slate-200">
                <div class="text-sm text-slate-500 font-medium flex items-center gap-2">
                    <i class="fa-brands fa-whatsapp text-green-500 text-lg"></i> Sistem Otomatisasi WhatsApp CuciYuk
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-green-500 font-semibold flex items-center gap-2 text-sm">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        Connected
                    </span>
                </div>
            </header>

            {{-- TEMPAT KONTEN HALAMAN UTAMA LU BERUBAH-UBAH --}}
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>

        </div>
    </div>

</body>
</html>