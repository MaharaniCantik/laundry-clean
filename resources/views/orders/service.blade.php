<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<x-app-layout>
    <form action="{{ route('order.store') }}" method="POST">
        @csrf

        <input type="hidden" name="nama_pelanggan" value="{{ old('nama_pelanggan', $namaUser) }}">
        <input type="hidden" name="alamat_lengkap" value="{{ old('alamat_lengkap', $alamatUser) }}">
        <input type="hidden" name="jarak_km" value="{{ old('jarak_km', $jarakTampil) }}">
        <input type="hidden" name="ongkos_kirim" value="{{ old('ongkos_kirim', $ongkir) }}">

        {{-- 🌟 GANTI DUA BARIS INI BIAR DATA TELEPON & INSTRUKSI VALID MASUK KE CONTROLLER 🌟 --}}
        <input type="hidden" name="phone" value="{{ old('phone', request('phone')) }}">
        <input type="hidden" name="instruksi_driver" value="{{ old('instruksi_driver', request('instruksi_driver')) }}">

        {{-- Kolom jenis_layanan pembawa dari checkout.blade --}}
        <input type="hidden" name="jenis_layanan" value="{{ old('jenis_layanan', request('jenis_layanan', 'kiloan')) }}">

        <input type="hidden" id="js-ongkir" value="{{ $ongkir }}">

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
                                    <span class="text-sm font-semibold text-gray-700">{{ $alamatUser }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-[20px] shadow-lg p-6 ">
                            <label class="text-[#0085C9] font-bold text-lg mb-4">Pilih Durasi Laundry:</label>
                            <select name="tipe_durasi" class="w-full p-2 border rounded" required>
                                <option value="reguler">Reguler (Rp 5.000 / Kg)</option>
                                <option value="express">Express (Rp 9.000 / Kg)</option>
                            </select>
                        </div>

                        {{-- METODE PEMBAYARAN --}}
                        <div class="bg-white rounded-[20px] shadow-lg p-6">
                            <h3 class="text-[#0085C9] font-bold text-lg mb-4">Metode Pembayaran</h3>

                            <div class="space-y-3">
                                <label class="block cursor-pointer relative">
                                    <input type="radio" name="metode_pembayaran" value="COD" class="peer absolute opacity-0 w-full h-full cursor-pointer z-10" checked>
                                    <div class="flex items-center gap-4 p-4 rounded-xl border border-gray-200 bg-gray-50/50 peer-checked:border-[#F6921E] peer-checked:bg-orange-50/60 peer-checked:ring-2 peer-checked:ring-[#F6921E]/30 transition-all">
                                        <div class="w-10 h-10 bg-amber-100 rounded-lg text-amber-600 flex items-center justify-center text-lg">
                                            <i class="fa-solid fa-money-bill-wave"></i>
                                        </div>
                                        <span class="font-bold text-gray-700 text-sm tracking-wide">COD (Bayar di Tempat)</span>
                                    </div>
                                </label>

                                <label class="block cursor-pointer relative">
                                    <input type="radio" name="metode_pembayaran" value="QRIS" class="peer absolute opacity-0 w-full h-full cursor-pointer z-10">
                                    <div class="flex items-center gap-4 p-4 rounded-xl border border-gray-200 bg-gray-50/50 peer-checked:border-[#F6921E] peer-checked:bg-orange-50/60 peer-checked:ring-2 peer-checked:ring-[#F6921E]/30 transition-all">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg text-blue-600 flex items-center justify-center text-lg">
                                            <i class="fa-solid fa-qrcode"></i>
                                        </div>
                                        <span class="font-bold text-gray-700 text-sm tracking-wide">QRIS (E-Wallet)</span>
                                    </div>
                                </label>

                                <label class="block cursor-pointer relative">
                                    <input type="radio" name="metode_pembayaran" value="CARD" class="peer absolute opacity-0 w-full h-full cursor-pointer z-10">
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
                                        <div class="bg-white border border-purple-100 rounded-xl p-3 flex justify-between items-center">
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
                                    <p class="text-lg font-black text-gray-800">{{ $jarakTampil }} Km</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 font-medium">Status Ongkos Kirim</p>
                                    <span class="inline-block text-xs font-bold px-2.5 py-1 rounded-full border mt-0.5 {{ $badgeClass }}">
                                        {{ $statusOngkirText }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- FORM PENIMBANGAN --}}
                        <div class="bg-white rounded-[20px] shadow-lg p-6">
                            <h3 class="text-[#0085C9] font-bold text-lg mb-4">Form Penimbangan</h3>
                            <div class="bg-[#e4f3fa] rounded-2xl p-5 border border-blue-100">
                                <input type="hidden" id="js-harga-per-kg" value="5000">
                                <label class="block text-gray-700 font-semibold text-sm mb-3">Masukan berat(Kg)</label>

                                <div class="flex items-center gap-5 mb-5">
                                    <button type="button" id="btn-minus" class="w-8 h-8 rounded-full bg-[#F6921E] text-white flex items-center justify-center shadow hover:bg-orange-600 transition-all select-none">
                                        <span class="font-bold text-base">-</span>
                                    </button>

                                    <input type="number" id="input-berat" name="berat_laundry" value="1" min="1" class="w-12 text-center bg-transparent font-bold text-xl text-gray-800 border-none focus:ring-0 p-0 outline-none no-spinners" readonly>

                                    <button type="button" id="btn-plus" class="w-8 h-8 rounded-full bg-[#F6921E] text-white flex items-center justify-center shadow hover:bg-orange-600 transition-all select-none">
                                        <span class="font-bold text-base">+</span>
                                    </button>
                                </div>

                                <label class="block text-gray-700 font-semibold text-sm mb-1.5">Harga <span class="text-[9px] text-gray-400 font-normal italic">*termasuk ongkir jarak</span></label>
                                <div class="w-full bg-white rounded-xl py-3 px-4 border border-gray-100 shadow-inner">
                                    <span id="text-harga" class="text-gray-700 font-bold text-base">
                                        Rp {{ number_format(5000 + $ongkir, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- INSTRUKSI PENCUCIAN --}}
                        <div class="bg-white rounded-[20px] shadow-lg p-6">
                            <h3 class="text-[#0085C9] font-bold text-lg mb-3">Instruksi Pencucian</h3>
                            <div class="bg-[#e4f3fa] rounded-2xl p-2 border border-blue-100">
                                <textarea name="instruksi_pencucian" rows="3" placeholder="contoh: jangan pakai pemutih" class="w-full bg-transparent border-none placeholder-gray-400/80 text-gray-700 text-sm focus:ring-0 resize-none outline-none p-3"></textarea>
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
 SCRIPT SINKRONISASI LOGIK (Sudah Diperbaiki)
 ==================================================== --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnMinus = document.getElementById('btn-minus');
        const btnPlus = document.getElementById('btn-plus');
        const inputBerat = document.getElementById('input-berat');
        const textHarga = document.getElementById('text-harga');

        function dapatkanHargaPerKg() {
            // Menggunakan selector yang lebih aman untuk mencari dropdown tipe_durasi
            const selectDurasi = document.querySelector('select[name="tipe_durasi"]');
            if (selectDurasi && selectDurasi.value === 'express') {
                return 9000;
            }
            return 5000;
        }

        function dapatkanOngkirDariLayar() {
            const inputOngkir = document.getElementById('js-ongkir');
            return inputOngkir ? (parseInt(inputOngkir.value) || 0) : 0;
        }

        function updateHarga() {
            // Pastikan inputBerat ada sebelum membaca nilainya
            if (!inputBerat || !textHarga) return;

            let berat = parseInt(inputBerat.value) || 1;
            if (berat < 1) {
                berat = 1;
                inputBerat.value = 1;
            }
            const hargaPerKg = dapatkanHargaPerKg();
            const ongkirJarak = dapatkanOngkirDariLayar();
            let totalHarga = (berat * hargaPerKg) + ongkirJarak;
            textHarga.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalHarga);
        }

        // Pasang event listener ke dropdown durasi jika elemennya ditemukan
        const selectDurasiElement = document.querySelector('select[name="tipe_durasi"]');
        if (selectDurasiElement) {
            selectDurasiElement.addEventListener('change', updateHarga);
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

        // Jalankan kalkulasi awal saat halaman selesai dimuat
        updateHarga();
    });
</script>