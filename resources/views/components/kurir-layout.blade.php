<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $title ?? 'CleanControl Kurir Hub' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght=400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    {{-- Paste tailwind.config bawaan lu di sini --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "surface-container-low": "#f2f3ff",
                        "on-surface": "#131b2e",
                        "on-primary-container": "#eeefff",
                        "secondary": "#006e2f",
                        "primary": "#004ac6",
                        "surface-container": "#eaedff",
                        "outline-variant": "#c3c6d7",
                        "background": "#faf8ff",
                        "tertiary": "#ab0b1c",
                        "error": "#ba1a1a",
                        "secondary-container": "#6bff8f",
                        "on-secondary-container": "#007432",
                        "surface-low": "#f2f3ff"
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; display: inline-block; vertical-align: middle; }
        body { background-color: #faf8ff; color: #131b2e; font-family: 'Poppins', sans-serif; }
        .card-shadow { box-shadow: 0px 4px 12px rgba(15, 23, 42, 0.08); }
        .status-toggle-transition { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="min-h-screen font-body-md text-body-md flex flex-col pb-24 overflow-hidden">

    <header class="w-full top-0 sticky bg-white border-b border-outline-variant z-50 h-16 flex items-center justify-between px-4">
        <div class="flex items-center gap-4">
            <span class="text-xl text-primary font-extrabold tracking-tight">Kurir Hub</span>
        </div>
        <div class="flex items-center gap-3 ml-2 pl-4 border-l border-outline-variant">
            <div class="text-right hidden sm:block">
                {{-- 🌟 MENAMPILKAN NAMA KURIR YANG SEDANG LOGIN --}}
                <p class="text-xs font-semibold text-on-surface">{{ Auth::user()->name }}</p>
                
                {{-- Menampilkan ID unik dari database user --}}
                <p class="text-[10px] text-gray-400 uppercase tracking-wider">ID: #CC-00{{ Auth::user()->id }}</p>
            </div>
            <div class="w-10 h-10 rounded-full overflow-hidden border border-outline-variant">
                {{-- Menggunakan inisial nama atau placeholder jika tidak ada foto profil --}}
                <img alt="Profile" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=004ac6&color=fff"/>
            </div>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto h-full min-h-screen pb-24">
        {{ $slot }}
    </main>

    <nav class="fixed bottom-0 left-0 w-full flex justify-center items-center h-20 bg-white border-t border-outline-variant z-50">
        <div class="max-w-4xl w-full flex justify-around px-4">
            <a class="flex flex-col items-center justify-center rounded-full px-8 py-1.5 transition-all {{ Request::is('kurir/dashboard') ? 'bg-secondary-container text-on-secondary-container font-bold' : 'text-gray-500' }}" href="{{ route('kurir.dashboard') }}">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ Request::is('kurir/dashboard') ? 1 : 0 }};">dashboard</span>
                <span class="text-xs">Dashboard</span>
            </a>
            <a class="flex flex-col items-center justify-center px-8 py-1.5 transition-all {{ Request::is('kurir/history') ? 'bg-secondary-container text-on-secondary-container font-bold' : 'text-gray-500' }}" href="{{ route('kurir.history') }}">
                <span class="material-symbols-outlined">history</span>
                <span class="text-xs">Riwayat</span>
            </a>
            <a class="flex flex-col items-center justify-center px-8 py-1.5 transition-all {{ Request::is('kurir/profile') ? 'bg-secondary-container text-on-secondary-container font-bold' : 'text-gray-500' }}" href="{{ route('kurir.profile') }}">
                <span class="material-symbols-outlined">person</span>
                <span class="text-xs">Profil</span>
            </a>
        </div>
    </nav>

    {{-- Script interaksi toggle ditaruh di sini --}}
    <script>
        const toggleBtn = document.getElementById('toggle-availability');
        const toggleThumb = document.getElementById('toggle-thumb');
        const statusText = document.getElementById('status-text');
        if(toggleBtn) {
            let isAvailable = true;
            toggleBtn.addEventListener('click', () => {
                isAvailable = !isAvailable;
                if (isAvailable) {
                    toggleBtn.classList.replace('bg-error', 'bg-secondary-container');
                    toggleThumb.classList.replace('translate-x-1', 'translate-x-11');
                    statusText.innerText = "Siap Kerja (Available)";
                } else {
                    toggleBtn.classList.replace('bg-secondary-container', 'bg-error');
                    toggleThumb.classList.replace('translate-x-11', 'translate-x-1');
                    statusText.innerText = "Istirahat (Unavailable)";
                }
            });
        }
    </script>
</body>
</html>