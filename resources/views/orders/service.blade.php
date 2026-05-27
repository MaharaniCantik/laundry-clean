<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-[#7ec8ea] to-[#d4effa] py-8 px-4 md:px-8 font-sans">
        <div class="max-w-5xl mx-auto">

            {{-- ==========================================
                 STEPPER (Step 2: Layanan Aktif)
                 ========================================== --}}
            <div class="relative flex justify-between items-center w-full max-w-3xl mx-auto mb-10 pt-6">
                <div class="absolute top-[52px] left-0 w-full h-[2px] bg-[#E27D18] -z-10"></div>

                <div class="flex flex-col items-center w-1/3">
                    <div class="w-14 h-14 rounded-full bg-[#F6921E] flex items-center justify-center shadow-md text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="mt-3 text-gray-600 font-semibold text-xs md:text-sm">Informasi Pemesanan</span>
                </div>

                <div class="flex flex-col items-center w-1/3">
                    <div class="w-14 h-14 rounded-full bg-[#F6921E] flex items-center justify-center shadow-md text-white border-4 border-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <span class="mt-3 text-[#0085C9] font-bold text-xs md:text-sm">Layanan</span>
                </div>

                <div class="flex flex-col items-center w-1/3">
                    <div class="w-14 h-14 rounded-full bg-[#F6921E]/40 flex items-center justify-center shadow-md text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                        </svg>
                    </div>
                    <span class="mt-3 text-gray-500 font-semibold text-xs md:text-sm">Laporan</span>
                </div>
            </div>

            {{-- ==========================================
                 FORM TRANSAKSI UTAMA (Action diarahkan ke Route Confirm)
                 ========================================== --}}
            <form action="{{ route('order.confirm') }}" method="POST" class="space-y-6">
                @csrf

                @if(isset($dataStep1))
                @foreach($dataStep1 as $key => $value)
                <input type="hidden" name="step1_{{ $key }}" value="{{ $value }}">
                @endforeach
                @endif

                {{-- Input Hidden Pengunci Data Logistik Biar Tidak Kebaca 0 Km Saat Disubmit --}}
                <input type="hidden" name="jarak_km" value="{{ $dataStep1['jarak_km'] ?? $jarak ?? 0 }}">
                <input type="hidden" name="ongkos_kirim" value="{{ $dataStep1['ongkos_kirim'] ?? $ongkir ?? 0 }}">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

                    {{-- ====================================================
                         KOLOM SEBELAH KIRI (Penjemputan & Pembayaran)
                         ==================================================== --}}
                    <div class="space-y-6">

                        <div class="bg-white rounded-[20px] shadow-lg p-6">
                            <h3 class="text-[#0085C9] font-bold text-lg mb-4">Detail Penjemputan</h3>
                            <div class="space-y-3">
                                <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                    <span class="block text-xs text-gray-400">Nama Pelanggan</span>
                                    <span class="text-sm font-semibold text-gray-700">{{ $dataStep1['nama_lengkap'] ?? 'maharani kusuma dewi' }}</span>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                    <span class="block text-xs text-gray-400">Alamat Lengkap</span>
                                    <span class="text-sm font-semibold text-gray-700">{{ $dataStep1['address'] ?? 'Belum mengisi alamat' }}</span>
                                </div>
                                <div class="flex justify-end pt-2">
                                    {{-- PERBAIKAN: Mengubah type="button" agar tombol submit tengah tidak memicu reload form --}}
                                    <button type="button" class="bg-[#F6921E] hover:bg-orange-600 text-white font-bold py-1.5 px-6 rounded-lg shadow-sm text-sm transition-all">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>

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
                                {{-- PERBAIKAN: Memperbaiki sintaks id="info-cod" yang sebelumnya salah ketik (terdapat kelebihan karakter) --}}
                                <div id="info-cod" class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-medium space-y-2 transition-all">
                                    <p class="font-bold flex items-center gap-2"><i class="fa-solid fa-lightbulb text-amber-600"></i> Petunjuk COD:</p>
                                    <p class="pl-5">Silakan siapkan uang tunai pas saat kurir datang menjemput atau mengantarkan pakaian Anda ke rumah.</p>
                                </div>
                                <div id="info-qris" class="hidden p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 text-xs font-medium space-y-3 transition-all">
                                    <p class="font-bold flex items-center gap-2"><i class="fa-solid fa-mobile-screen-button text-blue-600"></i> Petunjuk Pembayaran QRIS:</p>
                                    <div class="pl-5 space-y-2">
                                        <p>Silakan scan kode QRIS di bawah ini menggunakan e-wallet atau M-Banking Anda:</p>
                                        <div class="w-32 h-32 bg-white border border-gray-300 rounded-lg p-2 mx-auto flex items-center justify-center shadow-sm">
                                            <i class="fa-solid fa-qrcode text-6xl text-gray-800"></i>
                                        </div>
                                    </div>
                                </div>
                                <div id="info-card" class="hidden p-4 rounded-xl bg-purple-50 border border-purple-200 text-purple-800 text-xs font-medium space-y-2 transition-all">
                                    <p class="font-bold flex items-center gap-2"><i class="fa-solid fa-landmark text-purple-600"></i> Petunjuk Transfer Bank:</p>
                                    <div class="pl-5 space-y-2">
                                        <p>Silakan lakukan transfer ke rekening resmi Laundry Express:</p>
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

                        <div class="bg-white rounded-[20px] shadow-lg p-5 border border-blue-50">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Informasi Logistik Penjemputan</h4>
                            <div class="p-4 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Jarak ke Lokasi</p>
                                    <p class="text-lg font-black text-gray-800">{{ $dataStep1['jarak_km'] ?? $jarak ?? 0 }} Km</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 font-medium">Status Ongkos Kirim</p>

                                    @php
                                    $jarakTampil = (float) ($dataStep1['jarak_km'] ?? $jarak ?? 0);
                                    @endphp

                                    @if($jarakTampil > 0 && $jarakTampil <= 5.0)
                                        <span class="inline-block text-xs bg-green-100 text-green-700 font-bold px-2.5 py-1 rounded-full border border-green-200 mt-0.5">
                                        Gratis Ongkir (0-5 Km)
                                        </span>
                                        @elseif($jarakTampil > 5.0 && $jarakTampil <= 7.0)
                                            <span class="inline-block text-xs bg-orange-100 text-orange-700 font-bold px-2.5 py-1 rounded-full border border-orange-200 mt-0.5">
                                            + Rp 7.000 (5-7 Km)
                                            </span>
                                            @elseif($jarakTampil > 7.0 && $jarakTampil <= 10.0)
                                                <span class="inline-block text-xs bg-orange-100 text-orange-700 font-bold px-2.5 py-1 rounded-full border border-orange-200 mt-0.5">
                                                + Rp 12.000 (7-10 Km)
                                                </span>
                                                @else
                                                <span class="inline-block text-xs bg-red-100 text-red-700 font-bold px-2.5 py-1 rounded-full border border-red-200 mt-0.5">
                                                    Di Luar Jangkauan (+ Rp 15.000)
                                                </span>
                                                @endif
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-[20px] shadow-lg p-6">
                            <h3 class="text-[#0085C9] font-bold text-lg mb-4">Form Penimbangan</h3>

                            <div class="bg-[#e4f3fa] rounded-2xl p-5 border border-blue-100">
                                <label class="block text-gray-700 font-semibold text-sm mb-3">Masukan berat(Kg)</label>

                                <div class="flex items-center gap-5 mb-5">
                                    <button type="button" id="btn-minus" class="w-8 h-8 rounded-full bg-[#F6921E] text-white flex items-center justify-center shadow focus:outline-none hover:bg-orange-600 transition-all select-none">
                                        <span class="font-bold text-base">-</span>
                                    </button>

                                    <input type="number" id="input-berat" name="berat_laundry" value="1" min="1" class="w-12 text-center bg-transparent font-bold text-xl text-gray-800 border-none focus:ring-0 p-0 outline-none no-spinners" readonly>

                                    <button type="button" id="btn-plus" class="w-8 h-8 rounded-full bg-[#F6921E] text-white flex items-center justify-center shadow focus:outline-none hover:bg-orange-600 transition-all select-none">
                                        <span class="font-bold text-base">+</span>
                                    </button>
                                </div>

                                <label class="block text-gray-700 font-semibold text-sm mb-1.5">Harga <span class="text-[9px] text-gray-400 font-normal italic">*termasuk ongkir jarak</span></label>
                                <div class="w-full bg-white rounded-xl py-3 px-4 border border-gray-100 shadow-inner">
                                    <span id="text-harga" class="text-gray-700 font-bold text-base">
                                        Rp {{ number_format(8000 + ($dataStep1['ongkos_kirim'] ?? $ongkir ?? 0), 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>

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

                        <div class="bg-white rounded-[20px] shadow-lg p-6">
                            <h3 class="text-[#0085C9] font-bold text-lg mb-3">Intruksi Pencucian</h3>
                            <div class="bg-[#e4f3fa] rounded-2xl p-2 border border-blue-100">
                                <textarea name="instruksi_pencucian" rows="5" placeholder="contoh: jangan pakai pemutih" class="w-full bg-transparent border-none placeholder-gray-400/80 text-gray-700 text-sm focus:ring-0 resize-none outline-none p-3"></textarea>
                            </div>
                        </div>

                    </div>

                </div>
                <form action="{{ route('order.confirm') }}" method="POST">
                    @csrf
                    <input type="hidden" name="nama_pelanggan" value="{{ $dataStep1['nama_pelanggan'] ?? auth()->user()->name ?? 'Pelanggan' }}">
                    <input type="hidden" name="alamat_lengkap" value="{{ $dataStep1['address'] ?? auth()->user()->address ?? '' }}">
                    <input type="hidden" name="jarak_km" value="{{ $dataStep1['jarak_km'] ?? 5.7 }}">
                    <input type="hidden" name="ongkos_kirim" value="{{ $dataStep1['ongkos_kirim'] ?? 0 }}">

                    <button type="submit" class="w-full bg-[#F6921E] text-white font-bold py-4 rounded-xl shadow-lg hover:bg-orange-600 transition-all">
                        Konfirmasi & Jemput Sekarang
                    </button>
                </form>

        </div>
    </div>

    {{-- ====================================================
         SCRIPT UTAMA SINKRONISASI LOGIK
         ==================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hargaPerKg = 8000;

            const btnMinus = document.getElementById('btn-minus');
            const btnPlus = document.getElementById('btn-plus');
            const inputBerat = document.getElementById('input-berat');
            const textHarga = document.getElementById('text-harga');

            function dapatkanOngkirDariLayar() {
                const statusContainer = document.querySelector('.text-right span') || document.querySelector('.bg-orange-100') || document.querySelector('.bg-green-100');
                if (!statusContainer) return 0;

                const teksStatus = statusContainer.innerText;
                if (teksStatus.includes('Gratis')) {
                    return 0;
                }

                const bagianDepan = teksStatus.split('(')[0];
                const angkaMurni = bagianDepan.replace(/[^0-9]/g, '');
                return parseInt(angkaMurni) || 0;
            }

            function updateHarga() {
                let berat = parseInt(inputBerat.value) || 1;
                if (berat < 1) {
                    let berat = 1;
                    inputBerat.value = 1;
                }

                const ongkirJarak = dapatkanOngkirDariLayar();
                let totalHarga = (berat * hargaPerKg) + ongkirJarak;

                textHarga.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalHarga);
            }

            if (btnPlus) {
                btnPlus.addEventListener('click', function(e) {
                    e.preventDefault();
                    let currentVal = parseInt(inputBerat.value) || 0;
                    inputBerat.value = currentVal + 1;
                    updateHarga();
                });
            }

            if (btnMinus) {
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

            updateHarga();
        });
    </script>
</x-app-layout>