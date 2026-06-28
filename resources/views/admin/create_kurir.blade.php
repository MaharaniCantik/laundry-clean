<x-admin-layout>
    <main class="flex-1 md:ml-sidebar-width mt-16 p-container-padding min-h-screen">
        
        <div class="mb-6">
            <a href="{{ route('admin.armada_kurir') }}" class="inline-flex items-center gap-2 text-primary font-label-md text-label-md hover:underline mb-2">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali ke Armada Kurir
            </a>
            <h2 class="font-headline-lg text-headline-lg text-on-surface">Tambah Kurir Baru</h2>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">Daftarkan personel kurir baru ke dalam sistem armada.</p>
        </div>

        <div class="bg-surface-container-lowest rounded-xl shadow-[0_4px_24px_rgba(0,0,0,0.04)] border border-surface-variant/40 p-6 max-w-2xl">
            <form action="{{ route('admin.armada_kurir.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2">NIK (Nomor Induk Kependudukan)</label>
                    <input type="text" name="nik" required placeholder="Contoh: 3201xxxxxxxxxxxx" value="{{ old('nik') }}"
                        class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                    @error('nik') <p class="text-error font-body-sm text-body-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" required value="{{ old('nama_lengkap') }}"
                        class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                    @error('nama_lengkap') <p class="text-error font-body-sm text-body-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2">Alamat Email Kurir</label>
                    <input type="email" name="email" required placeholder="Contoh: kurir@laundry.com" value="{{ old('email') }}"
                        class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                    @error('email') <p class="text-error font-body-sm text-body-sm mt-1">{{ $message }}</p> @enderror
                </div>
                {{-- Letakkan ini tepat di bawah div Alamat Email Kurir dan di atas No. HP --}}
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2">Password Akun Kurir</label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter untuk login"
                        class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                    @error('password') <p class="text-error font-body-sm text-body-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2">No. HP / WhatsApp</label>
                    <input type="text" name="no_hp" required placeholder="Contoh: 08123456789" value="{{ old('no_hp') }}"
                        class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                    @error('no_hp') <p class="text-error font-body-sm text-body-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-2">Jenis Kendaraan</label>
                        <select name="kendaraan" required
                            class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none cursor-pointer">
                            <option value="Motor" {{ old('kendaraan') == 'Motor' ? 'selected' : '' }}>Motor (Sepeda Motor)</option>
                            <option value="Mobil" {{ old('kendaraan') == 'Mobil' ? 'selected' : '' }}>Mobil (Van/Pickup)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-2">Plat Nomor</label>
                        <input type="text" name="plat_nomor" required placeholder="Contoh: B 1234 ABC" value="{{ old('plat_nomor') }}"
                            class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                        @error('plat_nomor') <p class="text-error font-body-sm text-body-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2">Area Tugas (Opsional)</label>
                    <input type="text" name="area_tugas" placeholder="Contoh: Jakarta Barat / Semua Area" value="{{ old('area_tugas') }}"
                        class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                    @error('area_tugas') <p class="text-error font-body-sm text-body-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-3 pt-2 border-t border-surface-variant/40">
                    <a href="{{ route('admin.armada_kurir') }}" 
                        class="px-5 py-2.5 border border-outline-variant text-outline hover:bg-surface-container-low font-label-md text-label-md rounded-lg transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                        class="px-5 py-2.5 bg-primary text-on-primary font-label-md text-label-md rounded-lg hover:bg-primary/90 transition-colors shadow-sm">
                        Simpan Kurir
                    </button>
                </div>
            </form>
        </div>

    </main>
</x-admin-layout>