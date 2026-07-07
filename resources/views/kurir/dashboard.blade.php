<x-kurir-layout>
    <div class="h-[calc(100vh-140px)] overflow-y-auto px-6 py-8 space-y-8 pb-32">

        <div class="max-w-[1200px] mx-auto space-y-8">

            @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm shadow-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-sm shadow-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-rose-500">error</span>
                {{ session('error') }}
            </div>
            @endif

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status Kehadiran</span>
                    <h1 class="text-2xl font-bold text-emerald-600 flex items-center gap-2 mt-1">
                        Siap Kerja (Available)
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    </h1>
                </div>

                <label class="relative inline-flex items-center cursor-pointer group">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-14 h-8 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:start-[4px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-emerald-500"></div>
                </label>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-slate-500">Perlu Pick-up</p>
                        <p class="text-3xl font-bold text-slate-800">{{ $totalPickup }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[28px]">local_shipping</span>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-slate-500">Perlu Diantar</p>
                        <p class="text-3xl font-bold text-rose-500">{{ $totalDelivery }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[28px]">package_2</span>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-slate-500">Selesai Hari Ini</p>
                        <p class="text-3xl font-bold text-emerald-600">{{ $totalCompletedToday }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[28px]">task_alt</span>
                    </div>
                </div>
            </div>

            {{-- 1. SECTION ORDERAN BARU --}}
            <div class="space-y-4">
                <h2 class="text-lg font-bold text-slate-800 tracking-tight flex items-center gap-2">
                    📦 Orderan Baru Tersedia <span class="bg-amber-100 text-amber-700 text-xs px-2.5 py-0.5 rounded-full font-semibold">{{ $orderanMasuk->count() }}</span>
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($orderanMasuk as $order)
                    @php
                    $layananBaru = strtolower($order->jenis_layanan ?? '');
                    @endphp
                    <div class="bg-white rounded-2xl border border-amber-100 p-6 shadow-sm flex flex-col justify-between space-y-6 hover:shadow-md transition-all bg-gradient-to-br from-white to-amber-50/20">
                        <div class="space-y-3">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-slate-800 text-base">{{ $order->nama_pelanggan }}</h3>
                                    {{-- 🛠️ FIX: Ditambahkan $order->jenis_layanan --}}
                                    <p class="text-xs text-slate-500 mt-0.5">
                                        {{ $order->tipe_durasi }} • {{ number_format($order->berat_laundry, 0) }}
                                        {{-- Logika Satuan Dinamis --}}
                                        @if(str_contains($layananBaru, 'permadani') || str_contains($layananBaru, 'karpet') || str_contains($layananBaru, 'gorden'))
                                        m²
                                        @elseif(str_contains($layananBaru, 'boneka') || str_contains($layananBaru, 'bedcover'))
                                        Pcs
                                        @elseif(str_contains($layananBaru, 'sepatu'))
                                        Pasang
                                        @else
                                        Kg
                                        @endif
                                    </p>
                                </div>
                                <span class="px-2.5 py-1 text-xs font-semibold bg-amber-50 text-amber-600 rounded-full border border-amber-100 shadow-sm">Mencari Kurir</span>
                            </div>
                            <p class="text-sm text-slate-600 line-clamp-2 flex items-start gap-1.5">
                                <span class="material-symbols-outlined text-slate-400 text-[18px] shrink-0">location_on</span>
                                {{ $order->alamat_lengkap }}
                            </p>
                        </div>

                        <form action="{{ route('kurir.ambil', $order->id) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full py-3 bg-[#0085C9] text-white rounded-xl text-sm font-bold shadow-md shadow-blue-100 hover:bg-blue-600 transition-colors flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[18px]">pan_tool</span> Ambil Orderan Ini
                            </button>
                        </form>
                    </div>
                    @empty
                    <div class="col-span-1 md:col-span-3 bg-slate-50 rounded-2xl p-8 text-center border-2 border-dashed border-slate-200">
                        <p class="text-xs font-medium text-slate-400">📭 Belum ada orderan baru yang masuk ke sistem.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- 2. SECTION TUGAS AKTIF SAYA --}}
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold text-slate-800 tracking-tight flex items-center gap-2">
                        🏃 Tugas Aktif Saya <span class="bg-blue-100 text-blue-700 text-xs px-2.5 py-0.5 rounded-full font-semibold">{{ $activeTasks->count() }}</span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($activeTasks as $task)
                    @php
                    $isPickupStatus = in_array($task->status, ['Sedang Dijemput', 'Kurir Menuju Lokasi', 'Pending Penjemputan']);
                    $layananAktif = strtolower($task->jenis_layanan ?? '');
                    @endphp

                    <div class="bg-white rounded-2xl border p-6 shadow-sm flex flex-col justify-between space-y-6 hover:shadow-md transition-all {{ $isPickupStatus ? 'border-blue-100 hover:border-blue-200' : 'border-rose-100 hover:border-rose-200' }}">
                        <div class="space-y-3">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-slate-800 text-base">{{ $task->nama_pelanggan }}</h3>
                                    {{-- 🛠️ FIX: Ditambahkan $task->jenis_layanan --}}
                                    <p class="text-xs text-slate-400 mt-0.5">
                                        {{ $task->tipe_durasi }} • ~{{ number_format($task->berat_laundry, 0) }}
                                        {{-- Logika Satuan Dinamis --}}
                                        @if(str_contains($layananAktif, 'permadani') || str_contains($layananAktif, 'karpet') || str_contains($layananAktif, 'gorden'))
                                        m²
                                        @elseif(str_contains($layananAktif, 'boneka') || str_contains($layananAktif, 'bedcover'))
                                        Pcs
                                        @elseif(str_contains($layananAktif, 'sepatu'))
                                        Pasang
                                        @else
                                        Kg
                                        @endif
                                    </p>
                                </div>

                                @if($isPickupStatus)
                                <span class="px-2.5 py-1 text-xs font-semibold bg-blue-50 text-blue-600 rounded-full">Perlu Pick-up</span>
                                @else
                                <span class="px-2.5 py-1 text-xs font-semibold bg-rose-50 text-rose-600 rounded-full">Proses Antar</span>
                                @endif
                            </div>

                            <p class="text-sm text-slate-500 line-clamp-2 flex items-start gap-1.5">
                                <span class="material-symbols-outlined text-slate-400 text-[18px] shrink-0">location_on</span>
                                {{ $task->alamat_lengkap }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($task->alamat_lengkap) }}" target="_blank" class="flex items-center justify-center gap-2 py-2.5 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                                <span class="material-symbols-outlined text-[16px]">map</span> Maps
                            </a>

                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $task->no_hp_pelanggan ?? '') }}" target="_blank" class="flex items-center justify-center gap-2 py-2.5 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                                <span class="material-symbols-outlined text-[16px]">chat</span> WhatsApp
                            </a>

                            <form action="{{ route('kurir.updateStatus', $task->id) }}" method="POST" class="col-span-2">
                                @csrf
                                <button type="submit" class="w-full py-3 text-white rounded-xl text-sm font-bold shadow-md transition-colors {{ $isPickupStatus ? 'bg-blue-600 shadow-blue-100 hover:bg-blue-700' : 'bg-rose-500 shadow-rose-100 hover:bg-rose-600' }}">
                                    {{ $isPickupStatus ? 'Selesai Pick-up (Bawa ke Toko)' : 'Selesai Antar ke Konsumen' }}
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-1 md:col-span-3 bg-slate-50 rounded-2xl p-12 text-center border-2 border-dashed border-slate-200">
                        <span class="material-symbols-outlined text-slate-300 text-[48px]">auto_stories</span>
                        <p class="text-sm font-medium text-slate-500 mt-2">Mantap! Anda tidak memiliki tugas aktif berjalan.</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-kurir-layout>