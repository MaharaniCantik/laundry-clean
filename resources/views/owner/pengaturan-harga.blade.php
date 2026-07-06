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
                                        <tr class="bg-surface-container-low border-b border-outline-variant">
                                            <th class="px-6 py-4 font-label-bold text-label-bold text-on-surface-variant">NAMA LAYANAN</th>
                                            <th class="px-6 py-4 font-label-bold text-label-bold text-on-surface-variant">KATEGORI</th>
                                            <th class="px-6 py-4 font-label-bold text-label-bold text-on-surface-variant">HARGA SAAT INI (RP)</th>
                                            <th class="px-6 py-4 font-label-bold text-label-bold text-on-surface-variant text-right">UBAH HARGA</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-outline-variant">
                                        
                                        <tr class="hover:bg-primary/5 transition-colors group">
                                            <td class="px-6 py-5">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                                                        <span class="material-symbols-outlined" data-icon="local_laundry_service">local_laundry_service</span>
                                                    </div>
                                                    <span class="font-body-md text-body-md font-medium text-on-surface">Laundry Kiloan</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5">
                                                <span class="px-3 py-1 bg-secondary-container text-on-secondary-container rounded-full font-label-bold text-[11px]">KILOAN</span>
                                            </td>
                                            <td class="px-6 py-5 font-data-tabular text-data-tabular">Rp {{ number_format(config('laundry.HARGA_LAUNDRY_KILOAN', 5000), 0, ',', '.') }} / kg</td>
                                            <td class="px-6 py-5 text-right">
                                                <div class="inline-flex items-center gap-2 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-1.5 focus-within:ring-2 focus-within:ring-primary transition-all">
                                                    <span class="text-on-surface-variant text-body-sm">Rp</span>
                                                    <input class="w-20 border-none bg-transparent p-0 font-data-tabular text-data-tabular focus:ring-0 text-right" type="number" name="HARGA_LAUNDRY_KILOAN" value="{{ config('laundry.HARGA_LAUNDRY_KILOAN', 5000) }}"/>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-primary/5 transition-colors group">
                                            <td class="px-6 py-5">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                                                        <span class="material-symbols-outlined" data-icon="layers">layers</span>
                                                    </div>
                                                    <span class="font-body-md text-body-md font-medium text-on-surface">Laundry Permadani</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5">
                                                <span class="px-3 py-1 bg-secondary-container text-on-secondary-container rounded-full font-label-bold text-[11px]">KILOAN</span>
                                            </td>
                                            <td class="px-6 py-5 font-data-tabular text-data-tabular">Rp {{ number_format(config('laundry.HARGA_PERMADANI', 45000), 0, ',', '.') }} / kg</td>
                                            <td class="px-6 py-5 text-right">
                                                <div class="inline-flex items-center gap-2 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-1.5 focus-within:ring-2 focus-within:ring-primary transition-all">
                                                    <span class="text-on-surface-variant text-body-sm">Rp</span>
                                                    <input class="w-20 border-none bg-transparent p-0 font-data-tabular text-data-tabular focus:ring-0 text-right" type="number" name="HARGA_PERMADANI" value="{{ config('laundry.HARGA_PERMADANI', 45000) }}"/>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr class="hover:bg-primary/5 transition-colors group">
                                            <td class="px-6 py-5">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                                                        <span class="material-symbols-outlined" data-icon="iron">iron</span>
                                                    </div>
                                                    <span class="font-body-md text-body-md font-medium text-on-surface">Setrika</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5">
                                                <span class="px-3 py-1 bg-secondary-container text-on-secondary-container rounded-full font-label-bold text-[11px]">KILOAN</span>
                                            </td>
                                            <td class="px-6 py-5 font-data-tabular text-data-tabular">Rp {{ number_format(env('HARGA_SETRIKA', 5000), 0, ',', '.') }} / kg</td>
                                            <td class="px-6 py-5 text-right">
                                                <div class="inline-flex items-center gap-2 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-1.5 focus-within:ring-2 focus-within:ring-primary transition-all">
                                                    <span class="text-on-surface-variant text-body-sm">Rp</span>
                                                    <input class="w-20 border-none bg-transparent p-0 font-data-tabular text-data-tabular focus:ring-0 text-right" type="number" name="HARGA_SETRIKA" value="{{ env('HARGA_SETRIKA', 5000) }}"/>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-primary/5 transition-colors group">
                                            <td class="px-6 py-5">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                                                        <span class="material-symbols-outlined" data-icon="toys">toys</span>
                                                    </div>
                                                    <span class="font-body-md text-body-md font-medium text-on-surface">Boneka</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5">
                                                <span class="px-3 py-1 bg-secondary-container text-on-secondary-container rounded-full font-label-bold text-[11px]">KILOAN</span>
                                            </td>
                                            <td class="px-6 py-5 font-data-tabular text-data-tabular">Rp {{ number_format(env('HARGA_BONEKA', 20000), 0, ',', '.') }} / kg</td>
                                            <td class="px-6 py-5 text-right">
                                                <div class="inline-flex items-center gap-2 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-1.5 focus-within:ring-2 focus-within:ring-primary transition-all">
                                                    <span class="text-on-surface-variant text-body-sm">Rp</span>
                                                    <input class="w-20 border-none bg-transparent p-0 font-data-tabular text-data-tabular focus:ring-0 text-right" type="number" name="HARGA_BONEKA" value="{{ env('HARGA_BONEKA', 20000) }}"/>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr class="hover:bg-primary/5 transition-colors group">
                                            <td class="px-6 py-5">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                                                        <span class="material-symbols-outlined" data-icon="steps">steps</span>
                                                    </div>
                                                    <span class="font-body-md text-body-md font-medium text-on-surface">Laundry Sepatu</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5">
                                                <span class="px-3 py-1 bg-surface-variant text-on-surface-variant rounded-full font-label-bold text-[11px]">SATUAN</span>
                                            </td>
                                            <td class="px-6 py-5 font-data-tabular text-data-tabular">Rp {{ number_format(env('HARGA_SEPATU', 20000), 0, ',', '.') }} / psg</td>
                                            <td class="px-6 py-5 text-right">
                                                <div class="inline-flex items-center gap-2 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-1.5 focus-within:ring-2 focus-within:ring-primary transition-all">
                                                    <span class="text-on-surface-variant text-body-sm">Rp</span>
                                                    <input class="w-20 border-none bg-transparent p-0 font-data-tabular text-data-tabular focus:ring-0 text-right" type="number" name="HARGA_SEPATU" value="{{ env('HARGA_SEPATU', 20000) }}"/>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr class="hover:bg-primary/5 transition-colors group">
                                            <td class="px-6 py-5">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                                                        <span class="material-symbols-outlined" data-icon="curtains">curtains</span>
                                                    </div>
                                                    <span class="font-body-md text-body-md font-medium text-on-surface">Gorden</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5">
                                                <span class="px-3 py-1 bg-surface-variant text-on-surface-variant rounded-full font-label-bold text-[11px]">SATUAN</span>
                                            </td>
                                            <td class="px-6 py-5 font-data-tabular text-data-tabular">Rp {{ number_format(env('HARGA_GORDEN', 25000), 0, ',', '.') }} / pcs</td>
                                            <td class="px-6 py-5 text-right">
                                                <div class="inline-flex items-center gap-2 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-1.5 focus-within:ring-2 focus-within:ring-primary transition-all">
                                                    <span class="text-on-surface-variant text-body-sm">Rp</span>
                                                    <input class="w-20 border-none bg-transparent p-0 font-data-tabular text-data-tabular focus:ring-0 text-right" type="number" name="HARGA_GORDEN" value="{{ env('HARGA_GORDEN', 25000) }}"/>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr class="hover:bg-primary/5 transition-colors group">
                                            <td class="px-6 py-5">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                                                        <span class="material-symbols-outlined" data-icon="bed">bed</span>
                                                    </div>
                                                    <span class="font-body-md text-body-md font-medium text-on-surface">Cuci Bedcover </span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5">
                                                <span class="px-3 py-1 bg-surface-variant text-on-surface-variant rounded-full font-label-bold text-[11px]">SATUAN</span>
                                            </td>
                                            <td class="px-6 py-5 font-data-tabular text-data-tabular">Rp {{ number_format(env('HARGA_BEDCOVER', 25000), 0, ',', '.') }} / pcs</td>
                                            <td class="px-6 py-5 text-right">
                                                <div class="inline-flex items-center gap-2 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-1.5 focus-within:ring-2 focus-within:ring-primary transition-all">
                                                    <span class="text-on-surface-variant text-body-sm">Rp</span>
                                                    <input class="w-20 border-none bg-transparent p-0 font-data-tabular text-data-tabular focus:ring-0 text-right" type="number" name="HARGA_BEDCOVER" value="{{ env('HARGA_BEDCOVER', 25000) }}"/>
                                                </div>
                                            </td>
                                        </tr>

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