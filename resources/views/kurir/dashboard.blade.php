<x-kurir-layout>
    <div class="h-[calc(100vh-140px)] overflow-y-auto px-6 py-8 space-y-8 pb-32">
        
        <div class="max-w-[1200px] mx-auto space-y-8 ">
            
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
                    <p class="text-3xl font-bold text-red-500">{{ $totalDelivery }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-500 flex items-center justify-center">
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

        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-bold text-slate-800 tracking-tight">Tugas Aktif ({{ $activeTasks->count() }})</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                @forelse($activeTasks as $task)
                    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm flex flex-col justify-between space-y-6 hover:shadow-sm transition-all {{ $task->status == 'pickup' ? 'hover:border-blue-200' : 'hover:border-red-200' }}">
                        <div class="space-y-3">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-slate-800 text-base">{{ $task->nama_pelanggan }}</h3>
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $task->package_type }} • ~{{ $task->weight }} kg</p>
                                </div>
                                
                                @if($task->status == 'pickup')
                                    <span class="px-2.5 py-1 text-xs font-semibold bg-blue-50 text-blue-600 rounded-full">Perlu Pick-up</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-semibold bg-red-50 text-red-600 rounded-full">Proses Antar</span>
                                @endif
                            </div>
                            
                            <p class="text-sm text-slate-500 line-clamp-2 flex items-start gap-1.5">
                                <span class="material-symbols-outlined text-slate-400 text-[18px] shrink-0">location_on</span>
                                {{ $task->address }}
                            </p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($task->address) }}" target="_blank" class="flex items-center justify-center gap-2 py-2.5 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                                <span class="material-symbols-outlined text-[16px]">map</span> Maps
                            </a>
                            
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $task->customer_phone) }}" target="_blank" class="flex items-center justify-center gap-2 py-2.5 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                                <span class="material-symbols-outlined text-[16px]">chat</span> WhatsApp
                            </a>
                            
                            <form action="{{ route('updateStatus', $task->id) }}" method="POST" class="col-span-2">
                                @csrf
                                {{-- Menggunakan POST sesuai definisiroute Anda --}}
                                @method('POST') 
                                
                                @if($task->status == 'pickup')
                                    <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-xl text-sm font-bold shadow-md shadow-blue-100 hover:bg-blue-700 transition-colors">
                                        Selesai Pick-up
                                    </button>
                                @else
                                    <button type="submit" class="w-full py-3 bg-red-500 text-white rounded-xl text-sm font-bold shadow-md shadow-red-100 hover:bg-red-600 transition-colors">
                                        Selesai Antar
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-3 bg-slate-50 rounded-2xl p-12 text-center border-2 border-dashed border-slate-200">
                        <span class="material-symbols-outlined text-slate-300 text-[48px]">auto_stories</span>
                        <p class="text-sm font-medium text-slate-500 mt-2">Mantap! Tidak ada tugas aktif untuk saat ini.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-kurir-layout>