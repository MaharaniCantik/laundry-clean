<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<x-app-layout>
    <form action="{{ route('order.store') }}" method="POST">
        @csrf

        {{-- 🌟 FIX KONSISTEN: Amankan semua input hidden menggunakan kombinasi old() dan fallback variabel --}}
        <input type="hidden" name="nama_pelanggan" value="{{ old('nama_pelanggan', $namaUser) }}">
        <input type="hidden" name="alamat_lengkap" value="{{ old('alamat_lengkap', $alamatUser ?? session('alamat_lengkap_backup')) }}">
        <input type="hidden" name="jarak_km" value="{{ old('jarak_km', $jarakTampil) }}">
        <input type="hidden" name="ongkos_kirim" value="{{ old('ongkos_kirim', $ongkir) }}">
        <input type="hidden" name="phone" value="{{ old('phone', $phoneUser ?? request('phone')) }}">

        {{-- JADWAL PICKUP (AMBIL) --}}
        <input type="hidden" name="hari_pickup" value="{{ old('hari_pickup', $hariPickup) }}">
        <input type="hidden" name="jam_pickup" value="{{ old('jam_pickup', $jamPickup) }}">

        {{-- 🌟 TAMBAHKAN 2 BARIS INI BIAR JADWAL DELIVERY (ANTAR KEMBALI) GA BANDEL LAGI --}}
        <input type="hidden" name="hari_delivery" value="{{ old('hari_delivery', $hariDelivery) }}">
        <input type="hidden" name="jam_delivery" value="{{ old('jam_delivery', $jamDelivery) }}">

        {{-- 🌟 KITA PISAH INPUT HIDDEN UNTUK KEDUA JENIS CATATAN DARI STEP 1 --}}
        <input type="hidden" name="instruksi_alamat" value="{{ old('instruksi_alamat', $instruksiAlamat ?? request('instruksi_alamat')) }}">
        <input type="hidden" name="instruksi_driver" value="{{ old('instruksi_driver', $instruksiDriver ?? request('instruksi_driver')) }}">

        @php
        $urlSebelumnya = url()->previous();
        if (str_contains($urlSebelumnya, 'setrika') || (isset($jenisLayanan) && $jenisLayanan == 'setrika')) {
        $currentLayanan = 'setrika';
        } elseif (str_contains($urlSebelumnya, 'permadani') || (isset($jenisLayanan) && $jenisLayanan == 'permadani')) {
        $currentLayanan = 'permadani';
        } elseif (str_contains($urlSebelumnya, 'boneka') || (isset($jenisLayanan) && $jenisLayanan == 'boneka')) {
        $currentLayanan = 'boneka';
        } elseif (str_contains($urlSebelumnya, 'gorden') || (isset($jenisLayanan) && $jenisLayanan == 'gorden')) {
        $currentLayanan = 'gorden';
        } else {
        $currentLayanan = 'kiloan';
        }
        @endphp

        {{-- Kolom jenis_layanan pembawa dari checkout.blade --}}
        <input type="hidden" id="js-jenis-layanan" name="jenis_layanan" value="{{ old('jenis_layanan', $currentLayanan) }}">
        <input type="hidden" id="js-ongkir" value="{{ old('ongkos_kirim', $ongkir) }}">

        <div class="min-h-screen bg-gradient-to-br from-[#7ec8ea] to-[#d4effa] py-8 px-4 md:px-8 font-sans">
            <div class="max-w-5xl mx-auto">

                {{-- STEPPER --}}
                @include('partials.step-bar')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start mt-6">

                    {{-- ====================================================
                     KOLOM SEBELAH KIRI (Penjemputan & Pembayaran)
                     ==================================================== --}}
                    <div class="space-y-6">

                        {{-- DETAIL PENJEMPUTAN --}}
                        <div class="bg-white rounded-[20px] shadow-lg p-6">
                            <h3 class="text-[#0085C9] font-bold text-lg mb-4">Detail Penjemputan</h3>
                            <div class="space-y-3">
                                <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                    <span class="block text-xs text-gray-400">Nama Pelanggan</span>
                                    <span class="text-sm font-semibold text-gray-700">{{ $namaUser }}</span>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                    <span class="block text-xs text-gray-400">Alamat Lengkap</span>
                                    {{-- 🌟 FIX SINKRONISASI: Teks di layar disamakan dengan value dari input hidden di atas --}}
                                    <span class="text-sm font-semibold text-gray-700">
                                        {{ old('alamat_lengkap', $alamatUser ?? session('alamat_lengkap_backup') ?? '') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- DROPDOWN DURASI (DINAMIS SINKRON) --}}
                        <div class="bg-white rounded-[20px] shadow-lg p-6">
                            @if($currentLayanan == 'permadani')
                            <label class="text-[#0085C9] font-bold text-lg block mb-2">Pilih Jenis Karpet:</label>
                            <select id="select_durasi_layanan" name="tipe_durasi" class="w-full p-2 border rounded focus:ring-2 focus:ring-[#0085C9] outline-none text-gray-700" required>
                                <option value="tipis" {{ old('tipe_durasi') == 'tipis' ? 'selected' : '' }}>Tipis (Rp 45.000 / m²)</option>
                                <option value="tebal" {{ old('tipe_durasi') == 'tebal' ? 'selected' : '' }}>Tebal (Rp 70.000 / m²)</option>
                            </select>
                            <p class="text-xs text-amber-600 font-medium mt-2 bg-amber-50 p-2 rounded-lg border border-amber-100">
                                ℹ️ Cuci permadani membutuhkan waktu proses minimal 14 hari kerja.
                            </p>

                            @elseif($currentLayanan == 'gorden')
                            {{-- 🧺 BLOK UPDATE: PILIHAN JENIS KAIN GORDEN PREMIUM --}}
                            <label class="text-[#0085C9] font-bold text-lg block mb-2">Pilih Jenis Gorden:</label>
                            <select id="select_durasi_layanan" name="tipe_durasi" class="w-full p-2 border rounded focus:ring-2 focus:ring-[#0085C9] outline-none text-gray-700" required>
                                <option value="vitrase" {{ old('tipe_durasi') == 'vitrase' ? 'selected' : '' }}>Vitrase (Rp 25.000 / m²)</option>
                                <option value="tipis" {{ old('tipe_durasi') == 'tipis' ? 'selected' : '' }}>Tipis (Rp 30.000 / m²)</option>
                                <option value="tebal" {{ old('tipe_durasi') == 'tebal' ? 'selected' : '' }}>Tebal (Rp 35.000 / m²)</option>
                            </select>
                            <div id="info_durasi_edukasi" class="text-xs font-medium mt-2 p-2 rounded-lg border transition-all duration-200"></div>

                            @elseif($currentLayanan == 'setrika')
                            <label class="text-[#0085C9] font-bold text-lg block mb-2">Pilih Durasi Setrika:</label>
                            <select id="select_durasi_layanan" name="tipe_durasi" class="w-full p-2 border rounded focus:ring-2 focus:ring-[#0085C9] outline-none text-gray-700" required>
                                <option value="reguler" {{ old('tipe_durasi') == 'reguler' ? 'selected' : '' }}>Reguler (2 Hari - Rp 5.000 / Kg)</option>
                                <option value="express" {{ old('tipe_durasi') == 'express' ? 'selected' : '' }}>Express (1 Hari - Rp 8.000 / Kg)</option>
                                <option value="kilat" {{ old('tipe_durasi') == 'kilat' ? 'selected' : '' }}>Kilat (2 Jam Beres - Rp 12.000 / Kg)</option>
                            </select>
                            <div id="info_durasi_edukasi" class="text-xs font-medium mt-2 p-2 rounded-lg border transition-all duration-200"></div>

                            @elseif($currentLayanan == 'boneka')
                            <label class="text-[#0085C9] font-bold text-lg block mb-2">Pilih Ukuran Boneka:</label>
                            <select id="select_durasi_layanan" name="tipe_durasi" class="w-full p-2 border rounded focus:ring-2 focus:ring-[#0085C9] outline-none text-gray-700" required>
                                <option value="s" {{ old('tipe_durasi') == 's' ? 'selected' : '' }}>Kecil (S) - Rp 20.000 / Pcs</option>
                                <option value="m" {{ old('tipe_durasi') == 'm' ? 'selected' : '' }}>Sedang (M) - Rp 30.000 / Pcs</option>
                                <option value="l" {{ old('tipe_durasi') == 'l' ? 'selected' : '' }}>Besar (L) - Rp 60.000 / Pcs</option>
                                <option value="xl" {{ old('tipe_durasi') == 'xl' ? 'selected' : '' }}>Sangat Besar (XL) - Rp 75.000 / Pcs</option>
                            </select>
                            <div id="info_durasi_edukasi" class="text-xs font-medium mt-2 p-2 rounded-lg border transition-all duration-200"></div>

                            @else
                            <label class="text-[#0085C9] font-bold text-lg block mb-2">Pilih Durasi Laundry Kiloan:</label>
                            <select id="select_durasi_layanan" name="tipe_durasi" class="w-full p-2 border rounded focus:ring-2 focus:ring-[#0085C9] outline-none text-gray-700" required>
                                <option value="reguler" {{ old('tipe_durasi') == 'reguler' ? 'selected' : '' }}>Reguler (Rp 5.000 / Kg)</option>
                                <option value="express" {{ old('tipe_durasi') == 'express' ? 'selected' : '' }}>Express (Rp 9.000 / Kg)</option>
                            </select>
                            <div id="info_durasi_edukasi" class="text-xs font-medium mt-2 p-2 rounded-lg border transition-all duration-200"></div>
                            @endif
                        </div>

                        {{-- METODE PEMBAYARAN --}}
                        <div class="bg-white rounded-[20px] shadow-lg p-6">
                            <h3 class="text-[#0085C9] font-bold text-lg mb-4">Metode Pembayaran</h3>

                            <div class="space-y-3">
                                <label class="block cursor-pointer relative">
                                    <input type="radio" name="metode_pembayaran" value="COD" class="peer absolute opacity-0 w-full h-full cursor-pointer z-10" {{ old('metode_pembayaran', 'COD') == 'COD' ? 'checked' : '' }}>
                                    <div class="flex items-center gap-4 p-4 rounded-xl border border-gray-200 bg-gray-50/50 peer-checked:border-[#F6921E] peer-checked:bg-orange-50/60 peer-checked:ring-2 peer-checked:ring-[#F6921E]/30 transition-all">
                                        <div class="w-10 h-10 bg-amber-100 rounded-lg text-amber-600 flex items-center justify-center text-lg">
                                            <i class="fa-solid fa-money-bill-wave"></i>
                                        </div>
                                        <span class="font-bold text-gray-700 text-sm tracking-wide">COD (Bayar di Tempat)</span>
                                    </div>
                                </label>

                                <label class="block cursor-pointer relative">
                                    <input type="radio" name="metode_pembayaran" value="QRIS" class="peer absolute opacity-0 w-full h-full cursor-pointer z-10" {{ old('metode_pembayaran') == 'QRIS' ? 'checked' : '' }}>
                                    <div class="flex items-center gap-4 p-4 rounded-xl border border-gray-200 bg-gray-50/50 peer-checked:border-[#F6921E] peer-checked:bg-orange-50/60 peer-checked:ring-2 peer-checked:ring-[#F6921E]/30 transition-all">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg text-blue-600 flex items-center justify-center text-lg">
                                            <i class="fa-solid fa-qrcode"></i>
                                        </div>
                                        <span class="font-bold text-gray-700 text-sm tracking-wide">QRIS (E-Wallet)</span>
                                    </div>
                                </label>

                                <label class="block cursor-pointer relative">
                                    <input type="radio" name="metode_pembayaran" value="CARD" class="peer absolute opacity-0 w-full h-full cursor-pointer z-10" {{ old('metode_pembayaran') == 'CARD' ? 'checked' : '' }}>
                                    <div class="flex items-center gap-4 p-4 rounded-xl border border-gray-200 bg-gray-50/50 peer-checked:border-[#F6921E] peer-checked:bg-orange-50/60 peer-checked:ring-2 peer-checked:ring-[#F6921E]/30 transition-all">
                                        <div class="w-10 h-10 bg-purple-100 rounded-lg text-purple-600 flex items-center justify-center text-lg">
                                            <i class="fa-solid fa-credit-card"></i>
                                        </div>
                                        <span class="font-bold text-gray-700 text-sm tracking-wide">DEBIT / TRANSFER BANK</span>
                                    </div>
                                </label>
                            </div>

                            <div class="mt-4">
                                <div id="info-cod" class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-medium space-y-2 transition-all">
                                    <p class="font-bold flex items-center gap-2"><i class="fa-solid fa-lightbulb text-amber-600"></i> Petunjuk COD:</p>
                                    <p class="pl-5">Silakan siapkan uang tunai pas saat kurir datang menjemput.</p>
                                </div>
                                <div id="info-qris" class="hidden p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 text-xs font-medium space-y-3 transition-all">
                                    <p class="font-bold flex items-center gap-2"><i class="fa-solid fa-mobile-screen-button text-blue-600"></i> Petunjuk Pembayaran QRIS:</p>
                                    <div class="pl-5 space-y-2">
                                        <p>Silakan scan kode QRIS di bawah ini:</p>
                                        <div class="w-32 h-32 bg-white border border-gray-300 rounded-lg p-2 mx-auto flex items-center justify-center shadow-sm">
                                            <i class="fa-solid fa-qrcode text-6xl text-gray-800"></i>
                                        </div>
                                    </div>
                                </div>
                                <div id="info-card" class="hidden p-4 rounded-xl bg-purple-50 border border-purple-200 text-purple-800 text-xs font-medium space-y-2 transition-all">
                                    <p class="font-bold flex items-center gap-2"><i class="fa-solid fa-landmark text-purple-600"></i> Petunjuk Transfer Bank:</p>
                                    <div class="pl-5 space-y-2">
                                        <div class="w-full bg-white border border-purple-100 rounded-xl p-3 flex justify-between items-center">
                                            <div>
                                                <span class="block text-[10px] text-gray-400">Bank BCA</span>
                                                <span class="text-sm font-bold text-purple-900 tracking-wider">123-4567-890</span>
                                            </div>
                                            <button type="button" onclick="alert('Disalin!')" class="bg-purple-100 text-purple-700 font-bold py-1 px-3 rounded-lg text-[10px]">Salin</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ====================================================
                     KOLOM SEBELAH KANAN (Penimbangan & Instruksi)
                     ==================================================== --}}
                    <div class="space-y-6">

                        {{-- INFORMASI LOGISTIK --}}
                        <div class="bg-white rounded-[20px] shadow-lg p-5 border border-blue-50">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Informasi Logistik Penjemputan</h4>
                            <div class="p-4 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Jarak ke Lokasi</p>
                                    <p class="text-lg font-black text-gray-800">{{ old('jarak_km', $jarakTampil) }} Km</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 font-medium">Status Ongkos Kirim</p>
                                    <span class="inline-block text-xs font-bold px-2.5 py-1 rounded-full border mt-0.5 {{ $badgeClass }}">
                                        {{ $statusOngkirText }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- FORM PENIMBANGAN / INPUT LUAS (DINAMIS) --}}
                        <div class="bg-white rounded-[20px] shadow-lg p-6">
                            <h3 class="text-[#0085C9] font-bold text-lg mb-4">Form Penimbangan</h3>
                            <div class="bg-[#e4f3fa] rounded-2xl p-5 border border-blue-100">

                                @if($currentLayanan == 'permadani')
                                <label class="block text-gray-700 font-semibold text-sm mb-3">Masukan Luas Karpet (m²)</label>
                                @elseif($currentLayanan == 'gorden')
                                <label class="block text-gray-700 font-semibold text-sm mb-3">Masukan Luas Gorden (m²)</label>
                                @elseif($currentLayanan == 'boneka')
                                <label class="block text-gray-700 font-semibold text-sm mb-3">Masukan Jumlah Boneka (Pcs)</label>
                                @else
                                <label class="block text-gray-700 font-semibold text-sm mb-3">Masukan berat (Kg)</label>
                                @endif

                                <div class="flex items-center gap-5 mb-5">
                                    <button type="button" id="btn-minus" class="w-8 h-8 rounded-full bg-[#F6921E] text-white flex items-center justify-center shadow hover:bg-orange-600 transition-all select-none">
                                        <span class="font-bold text-base">-</span>
                                    </button>
                                    <input type="number" id="input-berat" name="berat_laundry" value="{{ old('berat_laundry', 1) }}" min="1" class="w-12 text-center bg-transparent font-bold text-xl text-gray-800 border-none focus:ring-0 p-0 outline-none no-spinners" readonly>
                                    <button type="button" id="btn-plus" class="w-8 h-8 rounded-full bg-[#F6921E] text-white flex items-center justify-center shadow hover:bg-orange-600 transition-all select-none">
                                        <span class="font-bold text-base">+</span>
                                    </button>
                                    @if($currentLayanan == 'permadani' || $currentLayanan == 'gorden')
                                    {{-- 🧺 Gorden disamakan satuannya m² dengan permadani --}}
                                    <span class="text-gray-600 font-bold text-sm">m²</span>
                                    @elseif($currentLayanan == 'boneka')
                                    <span class="text-gray-600 font-bold text-sm">Pcs</span>
                                    @else
                                    <span class="text-gray-600 font-bold text-sm">Kg</span>
                                    @endif
                                </div>

                                <label class="block text-gray-700 font-semibold text-sm mb-1.5">Harga <span class="text-[9px] text-gray-400 font-normal italic">*termasuk ongkir jarak</span></label>
                                <div class="w-full bg-white rounded-xl py-3 px-4 border border-gray-100 shadow-inner">
                                    <span id="text-harga" class="text-gray-700 font-bold text-base">
                                        Rp --
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- INSTRUKSI PENCUCIAN --}}
                        <div class="bg-white rounded-[20px] shadow-lg p-6">
                            <h3 class="text-[#0085C9] font-bold text-lg mb-3">Instruksi Pencucian</h3>
                            <div class="bg-[#e4f3fa] rounded-2xl p-2 border border-blue-100">
                                <textarea name="instruksi_pencucian" rows="3" placeholder="contoh: jangan pakai pemutih, setrika lipat rapi" class="w-full bg-transparent border-none placeholder-gray-400/80 text-gray-700 text-sm focus:ring-0 resize-none outline-none p-3">{{ old('instruksi_pencucian') }}</textarea>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-[#F6921E] text-white font-bold py-4 rounded-xl shadow-lg hover:bg-orange-600 transition-all">
                            Konfirmasi & Jemput Sekarang
                        </button>

                    </div>
                </div>

            </div>
        </div>
    </form>
</x-app-layout>

<style>
    .no-spinners::-webkit-outer-spin-button,
    .no-spinners::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .no-spinners {
        -moz-appearance: textfield;
    }
</style>

{{-- ====================================================
 SCRIPT SINKRONISASI LOGIK (KILOAN, PERMADANI, BONEKA & GORDEN)
 ==================================================== --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnMinus = document.getElementById('btn-minus');
        const btnPlus = document.getElementById('btn-plus');
        const inputBerat = document.getElementById('input-berat');
        const textHarga = document.getElementById('text-harga');
        const jsJenisLayanan = document.getElementById('js-jenis-layanan');
        const selectDurasiElement = document.getElementById('select_durasi_layanan');
        const infoDurasiEd = document.getElementById('info_durasi_edukasi');

        function dapatkanHargaPerUnit() {
            const jenisLayanan = jsJenisLayanan ? jsJenisLayanan.value : 'kiloan';
            const durasiValue = selectDurasiElement ? selectDurasiElement.value : 'reguler';

            // 🧸 1. LOGIKA TARIF KHUSUS LAUNDRY BONEKA
            if (jenisLayanan === 'boneka') {
                if (durasiValue === 's') return 20000;
                if (durasiValue === 'm') return 30000;
                if (durasiValue === 'l') return 60000;
                if (durasiValue === 'xl') return 75000;
                return 20000;
            }

            // 🎪 2. LOGIKA TARIF LAUNDRY PERMADANI
            if (jenisLayanan === 'permadani') {
                return (durasiValue === 'tebal') ? 70000 : 45000;
            }

            // 🧺 3. LOGIKA UPDATE: TARIF PREMIUM GORDEN (PER METER PERSEGI)
            if (jenisLayanan === 'gorden') {
                if (durasiValue === 'vitrase') return 25000;
                if (durasiValue === 'tipis') return 30000;
                if (durasiValue === 'tebal') return 35000;
                return 30000; // fallback jika kosong
            }

            // 👔 4. LOGIKA TARIF LAUNDRY SETRIKA
            if (jenisLayanan === 'setrika') {
                if (durasiValue === 'kilat') return 12000;
                if (durasiValue === 'express') return 8000;
                return 5000;
            }

            // 👕 5. FALLBACK LAUNDRY KILOAN BIASA
            return (durasiValue === 'express') ? 9000 : 5000;
        }

        function dapatkanOngkirDariLayar() {
            const inputOngkir = document.getElementById('js-ongkir');
            return inputOngkir ? (parseInt(inputOngkir.value) || 0) : 0;
        }

        function updateHarga() {
            if (!inputBerat || !textHarga) return;

            let qty = parseInt(inputBerat.value) || 1;
            if (qty < 1) {
                qty = 1;
                inputBerat.value = 1;
            }
            const hargaPerUnit = dapatkanHargaPerUnit();
            const ongkirJarak = dapatkanOngkirDariLayar();
            let totalHarga = (qty * hargaPerUnit) + ongkirJarak;
            textHarga.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalHarga);
        }

        function updateInfoTeksEdukasi() {
            if (!selectDurasiElement || !infoDurasiEd) return;
            const jenisLayanan = jsJenisLayanan ? jsJenisLayanan.value : 'kiloan';
            const durasiValue = selectDurasiElement.value;

            // 🧸 1. LOGIKA TEKS EDUKASI REAL-TIME UNTUK LAUNDRY BONEKA
            if (jenisLayanan === 'boneka') {
                infoDurasiEd.className = "text-xs font-medium mt-2 p-2 rounded-lg border bg-blue-50 text-blue-700 border-blue-100";

                if (durasiValue === 's') {
                    infoDurasiEd.innerHTML = "🧸 <b>Boneka Kecil (S):</b> Estimasi proses cuci & pengeringan membutuhkan waktu <b>2 Hari</b>.";
                } else if (durasiValue === 'm') {
                    infoDurasiEd.innerHTML = "🧸 <b>Boneka Sedang (M):</b> Estimasi proses cuci & pengeringan membutuhkan waktu <b>4 Hari</b>.";
                } else if (durasiValue === 'l') {
                    infoDurasiEd.innerHTML = "🧸 <b>Boneka Besar (L):</b> Estimasi proses cuci & pengeringan membutuhkan waktu <b>4 Hari</b>.";
                } else if (durasiValue === 'xl') {
                    infoDurasiEd.innerHTML = "🧸 <b>Boneka Sangat Besar (XL):</b> Estimasi proses cuci & pengeringan membutuhkan waktu <b>7 Hari</b> (Seminggu) agar bagian dalam benar-benar kering maksimal.";
                } else {
                    infoDurasiEd.innerHTML = "🧸 <b>Laundry Boneka Satuan:</b> Estimasi pengerjaan disesuaikan dengan ukuran boneka demi menjaga kebersihan & kering maksimal.";
                }
            }
            // 🧺 2. LOGIKA UPDATE: TEKS EDUKASI REAL-TIME UNTUK GORDEN PREMIUM
            else if (jenisLayanan === 'gorden') {
                if (durasiValue === 'tebal') {
                    infoDurasiEd.className = "text-xs font-medium mt-2 p-2 rounded-lg border bg-amber-50 text-amber-700 border-amber-100";
                    infoDurasiEd.innerHTML = "📦 <b>Gorden Tebal / Blackout:</b> Bahan kain tebal & berat membutuhkan waktu pengeringan ekstra. Estimasi selesai dalam <b>4 Hari</b>.";
                } else if (durasiValue === 'vitrase') {
                    infoDurasiEd.className = "text-xs font-medium mt-2 p-2 rounded-lg border bg-blue-50 text-blue-700 border-blue-100";
                    infoDurasiEd.innerHTML = "⚡ <b>Gorden Vitrase:</b> Bahan kain kelambu ringan transparan diproses cepat. Estimasi selesai dalam <b>3 Hari</b>.";
                } else {
                    infoDurasiEd.className = "text-xs font-medium mt-2 p-2 rounded-lg border bg-blue-50 text-blue-700 border-blue-100";
                    infoDurasiEd.innerHTML = "⚡ <b>Gorden Tipis / Standard:</b> Bahan katun atau kain harian standar rumah. Estimasi selesai dalam <b>3 Hari</b>.";
                }
            }
            // 🧺 3. LOGIKA UNTUK LAUNDRY SETRIKA
            else if (jenisLayanan === 'setrika') {
                if (durasiValue === 'kilat') {
                    infoDurasiEd.className = "text-xs font-medium mt-2 p-3 rounded-xl border bg-blue-50 text-blue-700 border-blue-100";
                    infoDurasiEd.innerHTML = "🚀 <b>Setrika Kilat (2 Jam Beres):</b> Pakaian Anda akan selesai super cepat! Jadwal pengantaran kembali otomatis disesuaikan menjadi 2 jam (1 slot jam) setelah kurir menjemput pakaian Anda hari ini, mengabaikan opsi pengantaran di halaman awal.";
                } else if (durasiValue === 'express') {
                    infoDurasiEd.className = "text-xs font-medium mt-2 p-2 rounded-lg border bg-blue-50 text-blue-700 border-blue-100";
                    infoDurasiEd.innerHTML = "⚡ <b>Setrika Express:</b> Rapi dalam 24 jam. Pengantaran dipercepat sesuai request tanggal checkout.";
                } else {
                    infoDurasiEd.className = "text-xs font-medium mt-2 p-2 rounded-lg border bg-amber-50 text-amber-700 border-amber-100";
                    infoDurasiEd.innerHTML = "📦 <b>Setrika Reguler:</b> Pakaian disetrika rapi dengan estimasi proses selesai dalam 2 Hari.";
                }
            }
            // 🧺 4. LOGIKA UNTUK LAUNDRY KILOAN
            else if (jenisLayanan === 'kiloan') {
                if (durasiValue === 'express') {
                    infoDurasiEd.className = "text-xs font-medium mt-2 p-2 rounded-lg border bg-blue-50 text-blue-700 border-blue-100";
                    infoDurasiEd.innerHTML = "⚡ <b>Paket Express:</b> Pakaian selesai dalam 24 jam. Pengantaran sesuai request tanggal checkout.";
                } else {
                    infoDurasiEd.className = "text-xs font-medium mt-2 p-2 rounded-lg border bg-amber-50 text-amber-700 border-amber-100";
                    infoDurasiEd.innerHTML = "📦 <b>Paket Reguler:</b> Proses cuci butuh 3 hari. Jadwal pengantaran otomatis disesuaikan minimal H+3 dari tanggal pickup.";
                }
            }
            // 📦 5. LOGIKA UNTUK PERMADANI
            else if (jenisLayanan === 'permadani') {
                infoDurasiEd.className = "text-xs font-medium mt-2 p-2 rounded-lg border bg-amber-50 text-amber-700 border-amber-100";
                infoDurasiEd.innerHTML = "ℹ️ Cuci permadani membutuhkan waktu proses minimal 14 hari kerja.";
            }
        }

        if (selectDurasiElement) {
            selectDurasiElement.addEventListener('change', function() {
                updateHarga();
                updateInfoTeksEdukasi();
            });
        }

        if (btnPlus && inputBerat) {
            btnPlus.addEventListener('click', function(e) {
                e.preventDefault();
                let currentVal = parseInt(inputBerat.value) || 0;
                inputBerat.value = currentVal + 1;
                updateHarga();
            });
        }

        if (btnMinus && inputBerat) {
            btnMinus.addEventListener('click', function(e) {
                e.preventDefault();
                let currentVal = parseInt(inputBerat.value) || 1;
                if (currentVal > 1) {
                    inputBerat.value = currentVal - 1;
                    updateHarga();
                }
            });
        }

        const radioMetode = document.querySelectorAll('input[name="metode_pembayaran"]');
        const infoCod = document.getElementById('info-cod');
        const infoQris = document.getElementById('info-qris');
        const infoCard = document.getElementById('info-card');

        if (radioMetode.length > 0) {
            const checkedRadio = document.querySelector('input[name="metode_pembayaran"]:checked');
            if (checkedRadio) checkedRadio.dispatchEvent(new Event('change'));

            radioMetode.forEach(radio => {
                radio.addEventListener('change', function() {
                    const pilihan = this.value;
                    if (infoCod) infoCod.classList.add('hidden');
                    if (infoQris) infoQris.classList.add('hidden');
                    if (infoCard) infoCard.classList.add('hidden');

                    if (pilihan === 'COD' && infoCod) infoCod.classList.remove('hidden');
                    else if (pilihan === 'QRIS' && infoQris) infoQris.classList.remove('hidden');
                    else if (pilihan === 'CARD' && infoCard) infoCard.classList.remove('hidden');
                });
            });
        }

        updateInfoTeksEdukasi();
        updateHarga();
    });
</script>