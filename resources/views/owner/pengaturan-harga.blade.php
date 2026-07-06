 <x-owner-layout>
 <main class="max-w-[1440px] mx-auto">
        {{-- 1. BUNGKUS DENGAN SATU FORM BESAR UNTUK UPDATE MASSAL --}}
        <form action="{{ route('owner.update-harga') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="max-w-[1440px] mx-auto p-margin-page">
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <h2 class="font-display-lg text-display-lg text-primary mb-2">Pengaturan Harga Layanan</h2>
                        <p class="font-body-md text-body-md text-on-surface-variant">Kelola dan perbarui tarif layanan laundry Anda untuk menjaga profitabilitas bisnis.</p>
                    </div>
                    <div class="flex gap-4">
                        {{-- Ganti type ke submit --}}
                        <button type="submit" class="flex items-center gap-2 px-6 py-2.5 bg-primary text-on-primary font-body-md rounded-lg hover:opacity-90 shadow-sm transition-all">
                            <span class="material-symbols-outlined" data-icon="save">save</span> Simpan Perubahan
                        </button>
                    </div>
                </div>

                @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-xl flex items-center gap-2 text-sm">
                    <span class="material-symbols-outlined text-md">check_circle</span>
                    {{ session('success') }}
                </div>
                @endif

                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 lg:col-span-3 flex flex-col gap-6">
                        <div class="glass-card p-6 rounded-xl shadow-sm">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="p-3 bg-primary-fixed text-primary rounded-lg">
                                    <span class="material-symbols-outlined" data-icon="info">info</span>
                                </div>
                                <h3 class="font-label-bold text-label-bold uppercase tracking-wider text-on-surface-variant">Info Update</h3>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mb-4">Update terakhir harga dilakukan secara dinamis melalui sistem dashboard Owner.</p>
                            <div class="p-4 bg-surface-container-low rounded-lg border border-outline-variant/30">
                                <p class="font-label-bold text-[11px] text-on-secondary-container mb-1">STATUS AKTIF</p>
                                <p class="font-title-sm text-title-sm text-primary font-bold">5 Layanan Utama</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 lg:col-span-9">
                        <div class="glass-card rounded-xl shadow-sm overflow-hidden">
                            <div class="p-6 border-b border-outline-variant flex justify-between items-center bg-surface-container-low/50">
                                <h3 class="font-title-sm text-title-sm font-semibold text-primary">Daftar Harga Layanan</h3>
                            </div>
                            <div class="overflow-x-auto custom-scrollbar">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="border-b border-outline-variant bg-surface-container-low text-on-surface-variant font-label-md text-label-md">
                                            <th class="px-6 py-4">NAMA LAYANAN</th>
                                            <th class="px-6 py-4">TARIF SAAT INI</th>
                                            <th class="px-6 py-4 text-center">STATUS</th>
                                            <th class="px-6 py-4 text-right">AKSI UBAH</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($allLayanan as $key => $item)
                                        <tr class="border-b border-outline-variant hover:bg-surface-container-lowest/50 transition-colors">
                                            
                                            {{-- 1. Nama Layanan --}}
                                            <td class="px-6 py-5 font-body-md text-on-surface">
                                                {{ $item['nama'] }}
                                            </td>
                                            
                                            {{-- 2. Tarif Saat Ini --}}
                                            <td class="px-6 py-5 font-data-tabular text-data-tabular">
                                                Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                            </td>
                                            
                                            {{-- 3. Tombol Toggle Aktif / Nonaktif --}}
                                            <td class="px-6 py-5 text-center">
                                                <form action="{{ route('owner.update-harga') }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="toggle_key" value="{{ $key }}">
                                                    
                                                    @if($item['is_active'])
                                                        <button type="submit" class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full hover:bg-green-200 transition-colors">
                                                            ● AKTIF
                                                        </button>
                                                    @else
                                                        <button type="submit" class="px-3 py-1 bg-gray-100 text-gray-500 text-xs font-bold rounded-full hover:bg-gray-200 transition-colors">
                                                            ○ NONAKTIF
                                                        </button>
                                                    @endif
                                                </form>
                                            </td>
                                            
                                            {{-- 4. Form Ubah Nominal Harga --}}
                                            <td class="px-6 py-5 text-right">
                                                <form action="{{ route('owner.update-harga') }}" method="POST" class="inline-flex items-center gap-2">
                                                    @csrf
                                                    @method('PUT')
                                                    
                                                    <div class="inline-flex items-center gap-2 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-1.5 focus-within:ring-2 focus-within:ring-primary transition-all">
                                                        <span class="text-on-surface-variant text-body-sm">Rp</span>
                                                        <input class="w-20 border-none bg-transparent p-0 font-data-tabular text-data-tabular focus:ring-0 text-right text-on-surface" 
                                                            type="number" 
                                                            name="{{ $key }}" 
                                                            value="{{ $item['harga'] }}"/>
                                                    </div>
                                                    
                                                    <button type="submit" class="bg-primary/10 text-primary hover:bg-primary hover:text-on-primary p-1.5 rounded-lg transition-all flex items-center">
                                                        <span class="material-symbols-outlined text-sm">save</span>
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="flex items-center gap-3 px-8 py-4 bg-primary text-on-primary font-body-md font-bold rounded-xl hover:opacity-90 shadow-lg transform active:scale-95 transition-all">
                                <span class="material-symbols-outlined" data-icon="published_with_changes">published_with_changes</span> Terapkan & Simpan Perubahan Harga
                            </button>
                        </div>
                    </div>
                </div>
                
                <footer class="mt-12 py-6 border-t border-outline-variant flex justify-between items-center opacity-60">
                    <p class="font-body-sm text-body-sm">© 2026 CleanFlow Enterprise. All rights reserved.</p>
                </footer>
            </div>
        </form>
    </main>
</x-owner-layout>