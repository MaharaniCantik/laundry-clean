<x-admin-layout>
    <main class="flex-1 md:ml-sidebar-width mt-16 p-container-padding min-h-screen">
        
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
            <div>
                <h2 class="font-headline-lg text-headline-lg text-on-surface">
                    Armada Kurir
                </h2>
                <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                    Kelola data kurir, kendaraan, dan pantau status ketersediaan armada penjemputan/pengantaran.
                </p>
            </div>
            
            <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto justify-between lg:justify-end">
                <form action="{{ route('admin.armada_kurir') }}" method="GET" class="flex flex-wrap items-center gap-3">
                    <select
                        name="status"
                        onchange="this.form.submit()"
                        class="bg-surface-container-lowest border border-outline-variant text-on-surface font-body-sm text-body-sm rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none cursor-pointer"
                    >
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia (Idle)</option>
                        <option value="on-delivery" {{ request('status') == 'on-delivery' ? 'selected' : '' }}>Sedang Tugas</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </form>

                <a href="{{route('admin.armada_kurir.create')}}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-on-primary font-label-md text-label-md rounded-lg hover:bg-primary/90 transition-colors shadow-sm"
                >
                    <span class="material-symbols-outlined text-[20px]">person_add</span>
                    Tambah Kurir
                </a>
            </div>
        </div>

        <div class="bg-surface-container-lowest rounded-xl shadow-[0_4px_24px_rgba(0,0,0,0.04)] border border-surface-variant/40 overflow-hidden">
            <div class="w-full overflow-x-auto table-scrollbar">
                <table class="w-full min-w-[1000px] text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low border-b border-surface-variant">
                            <th class="py-3 px-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider w-20">ID Kurir</th>
                            <th class="py-3 px-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Nama Kurir</th>
                            <th class="py-3 px-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Kendaraan & Plat</th>
                            <th class="py-3 px-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Area Tugas</th>
                            <th class="py-3 px-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider text-center w-36">Total Orderan Hari Ini</th>
                            <th class="py-3 px-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Status Kerja</th>
                            <th class="py-3 px-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider text-right w-24">Aksi</th>
                        </tr>
                    </thead>
                    
                    <tbody class="divide-y divide-surface-variant/50">
                        @forelse($kurirs as $kurir)
                            <tr class="hover:bg-surface-container-low/50 transition-colors group {{ $kurir->status_kerja == 'on-delivery' ? 'bg-primary-fixed/5' : '' }} {{ $kurir->status_kerja == 'inactive' ? 'opacity-60' : '' }}">
                                
                                <td class="py-4 px-4 font-body-sm text-body-sm text-on-surface-variant">
                                    #CRR-{{ str_pad($kurir->id, 2, '0', STR_PAD_LEFT) }}
                                </td>
                                
                                <td class="py-4 px-4">
                                    <div class="font-body-md text-body-md font-semibold text-on-surface">
                                        {{ $kurir->nama_lengkap }}
                                    </div>
                                    <div class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-0.5">
                                        <span class="material-symbols-outlined text-[14px]">phone</span>
                                        {{ $kurir->no_hp }}
                                    </div>
                                </td>
                                
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-1.5 font-body-md text-body-md text-on-surface">
                                        <span class="material-symbols-outlined text-[18px] text-on-surface-variant">
                                            {{ $kurir->kendaraan == 'Mobil' ? 'directions_car' : 'motorcycle' }}
                                        </span>
                                        {{ $kurir->kendaraan ?? 'Belum Diatur' }}
                                    </div>
                                    <div class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                                        {{ $kurir->plat_nomor ?? '-' }}
                                    </div>
                                </td>
                                
                                <td class="py-4 px-4 font-body-sm text-body-sm text-on-surface-variant">
                                    {{ $kurir->area_tugas ?? 'Semua Area' }}
                                </td>
                                
                                <td class="py-4 px-4 font-body-sm text-body-sm text-on-surface text-center font-semibold">
                                    {{ $kurir->total_orderan_hari_ini ?? 0 }} Order
                                </td>
                                
                                <td class="py-4 px-4">
                                    @if($kurir->status_kerja == 'available')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#e6f4ea] text-[#1e8e3e] font-label-md text-label-md border border-[#1e8e3e]/10">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#1e8e3e]"></span>
                                            Tersedia (Idle)
                                        </span>
                                    @elseif($kurir->status_kerja == 'on-delivery')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-primary-container text-on-primary-container font-label-md text-label-md">
                                            <span class="material-symbols-outlined text-[14px] animate-pulse">local_shipping</span>
                                            Sedang Tugas
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-surface-container-highest text-on-surface-variant font-label-md text-label-md border border-outline-variant/30">
                                            <span class="w-1.5 h-1.5 rounded-full bg-outline"></span>
                                            Nonaktif (Izin/Libur)
                                        </span>
                                    @endif
                                </td>
                                
                               <td class="py-4 px-4 text-right">
                                <form action="{{ route('admin.tes_kurir_manual') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="id_kurir_row" value="{{ $kurir->id }}">

                                    <button type="submit" class="inline-flex items-center justify-center p-1.5 rounded-lg text-outline hover:text-primary transition-colors" title="Tugaskan Kurir Ini">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>
                                </form>
                            </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center font-body-md text-on-surface-variant">
                                    Belum ada data armada kurir terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-surface-variant flex items-center justify-between bg-surface-container-lowest">
                <span class="font-body-sm text-body-sm text-on-surface-variant">
                    Menampilkan {{ $kurirs->firstItem() ?? 0 }} sampai {{ $kurirs->lastItem() ?? 0 }} dari {{ $kurirs->total() ?? 0 }} kurir
                </span>
                <div class="flex gap-2">
                    {{ $kurirs->links() }}
                </div>
            </div>
        </div>

    </main>
</x-admin-layout>