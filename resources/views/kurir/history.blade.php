<x-kurir-layout>
    <div class="h-[calc(100vh-140px)] overflow-y-auto px-6 py-8 pb-32 bg-slate-50/50">
        <div class="max-w-[1200px] mx-auto font-['Poppins',sans-serif] space-y-6">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                <div class="lg:col-span-7">
                    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">
                        Riwayat Tugas
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Pantau performa dan riwayat tugas yang telah Anda selesaikan.
                    </p>
                </div>
                <div class="lg:col-span-5 flex gap-4 w-full">
                    <div class="flex-1 bg-white border border-slate-100 p-4 rounded-2xl shadow-sm">
                        <span class="text-xs font-semibold text-slate-400 block mb-0.5 uppercase tracking-wider">Tugas Selesai</span>
                        <span class="text-2xl font-extrabold text-slate-800">
                            {{ $riwayatOrders->total() }}
                        </span>
                    </div>
                    <div class="flex-1 bg-white border border-slate-100 p-4 rounded-2xl shadow-sm">
                        <span class="text-xs font-semibold text-slate-400 block mb-0.5 uppercase tracking-wider">Total Estimasi</span>
                        <span class="text-2xl font-extrabold text-emerald-600">
                            {{ $riwayatOrders->total() * 50 }} <span class="text-sm font-semibold text-emerald-500">Poin</span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-center bg-white border border-slate-100 p-3 rounded-2xl shadow-sm gap-4">
                <div class="flex items-center gap-2 w-full sm:w-auto overflow-x-auto no-scrollbar">
                    <a href="{{ request()->fullUrlWithQuery(['filter' => 'all']) }}" 
                       class="px-5 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap active:scale-95 {{ request('filter', 'all') == 'all' ? 'bg-slate-800 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Semua Riwayat
                    </a>
                </div>
                
                <form action="{{ url()->current() }}" method="GET" class="relative w-full sm:w-72">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input name="search" value="{{ request('search') }}"
                        class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:ring-2 focus:ring-slate-800 focus:bg-white outline-none transition-all placeholder:text-slate-400 text-slate-700"
                        placeholder="Cari nama pelanggan..." type="text" onchange="this.form.submit()" />
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($riwayatOrders as $order)
                    <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between gap-4">
                        
                        <div class="flex justify-between items-start gap-2">
                            <div class="flex items-center gap-3">
                                <div class="h-11 w-11 rounded-full bg-slate-100 border border-slate-200/50 flex items-center justify-center text-slate-700 font-bold text-sm shadow-inner">
                                    {{ strtoupper(substr($order->user->name ?? $order->customer_name ?? 'C', 0, 2)) }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800 text-base leading-tight">
                                        {{ $order->user->name ?? $order->customer_name ?? 'Pelanggan' }}
                                    </h3>
                                    <span class="text-xs font-medium text-slate-400 block mt-0.5">
                                        {{ $order->layanan ?? 'Layanan Cuci' }}
                                    </span>
                                </div>
                            </div>
                            <span class="bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-wider">
                                Selesai
                            </span>
                        </div>
                        
                        <div class="space-y-2 border-y border-slate-50 py-3 text-slate-600 text-xs">
                            <div class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="font-medium">
                                    {{ $order->updated_at->translatedFormat('d F Y • H:i') }} WIB
                                </span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="leading-relaxed line-clamp-2" title="{{ $order->alamat_pengiriman ?? $order->alamat }}">
                                    {{ $order->alamat_pengiriman ?? $order->alamat ?? 'Alamat tidak tersedia' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-1">
                            <div class="text-emerald-600 font-extrabold text-base">
                                +50 Poin
                            </div>
                            <button class="text-xs font-bold text-slate-700 bg-slate-50 hover:bg-slate-100 border border-slate-200/60 px-4 py-2 rounded-xl transition-all active:scale-95">
                                Detail Tugas
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white border border-dashed border-slate-200 rounded-2xl p-8 flex flex-col items-center justify-center text-center py-16 shadow-sm">
                        <div class="h-16 w-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-slate-400">
                            Belum ada riwayat tugas yang diselesaikan.
                        </p>
                    </div>
                @endforelse
            </div>

            <div class="pt-4 flex justify-center items-center">
                {{ $riwayatOrders->links() }}
            </div>
        </div>
    </div>
</x-kurir-layout>