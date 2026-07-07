<x-kurir-layout>
    <div class="h-[calc(100vh-140px)] overflow-y-auto px-6 py-8 pb-32 bg-slate-50/50">
        <div class="max-w-[1200px] mx-auto font-['Poppins',sans-serif] grid grid-cols-1 md:grid-cols-12 gap-6">

            <div class="md:col-span-4 space-y-6">
                <div class="bg-white border border-slate-100 rounded-2xl p-6 flex flex-col items-center text-center shadow-sm">

                    <div class="relative group">
                        <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-emerald-500/20 shadow-inner">
                            <img class="w-full h-full object-cover"
                                alt="Foto profil {{ $profile->name }}"
                                src="{{ $profile->avatar_url ?? 'https://via.placeholder.com/150' }}" />
                        </div>
                    </div>

                    <h1 class="text-xl font-bold text-slate-800 mt-4 leading-tight">
                        {{ $profile->name }}
                    </h1>
                    <p class="text-xs font-semibold text-slate-400 mt-1 uppercase tracking-wider bg-slate-100 px-3 py-1 rounded-full">
                        ID Kurir: #{{ $profile->id }}
                    </p>

                    <div class="w-full grid grid-cols-2 gap-3 mt-6 border-t border-slate-50 pt-4">
                        <div class="bg-slate-50/80 rounded-xl p-3 border border-slate-100">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">Total Tugas</p>
                            <p class="text-xl font-extrabold text-slate-800 mt-0.5">
                                {{ $totalSelesai ?? number_format($profile->total_tasks ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="bg-slate-50/80 rounded-xl p-3 border border-slate-100">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">Rating Kerja</p>
                            <div class="flex items-center justify-center gap-1 mt-0.5">
                                <p class="text-xl font-extrabold text-amber-500">
                                    {{ number_format($profile->rating ?? 5.0, 1) }}
                                </p>
                                <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-8 space-y-6">
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Menu Navigasi Akun
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <a href="{{ route('kurir.profile') }}" class="group p-4 bg-slate-50 hover:bg-slate-100 border border-slate-200/60 rounded-xl transition-all flex items-center justify-between active:scale-95">
                            <div class="flex items-center gap-3">
                                <div class="bg-white p-2.5 rounded-lg border border-slate-200/50 text-slate-700 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-700">Data Pribadi</h3>
                                    <p class="text-[11px] text-slate-400 mt-0.5">KTP, Email, & No. HP</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <div class="group p-4 bg-slate-50 hover:bg-slate-100 border border-slate-200/60 rounded-xl transition-all flex items-center justify-between cursor-pointer active:scale-95">
                            <div class="flex items-center gap-3">
                                <div class="bg-white p-2.5 rounded-lg border border-slate-200/50 text-slate-700 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-700">Info Kendaraan</h3>
                                    <p class="text-[11px] text-slate-400 mt-0.5">SIM, STNK, & Plat Motor</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                        <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                            @csrf
                            <button type="submit" class="w-full sm:w-auto flex items-center justify-center gap-2 px-5 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl font-bold text-xs transition-all active:scale-95 border border-rose-100">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Keluar Aplikasi
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-kurir-layout>