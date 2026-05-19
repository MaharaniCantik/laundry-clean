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
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                        </svg>
                    </div>
                    <span class="mt-3 text-gray-500 font-semibold text-xs md:text-sm">Laporan</span>
                </div>
            </div>

            {{-- ==========================================
                 FORM TRANSAKSI UTAMA
                 ========================================== --}}
            <form action="#" method="POST" class="space-y-6">
                @csrf
                
                @if(isset($dataStep1))
                    @foreach($dataStep1 as $key => $value)
                        <input type="hidden" name="step1_{{ $key }}" value="{{ $value }}">
                    @endforeach
                @endif

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
                                <span class="text-sm font-semibold text-gray-700">{{ $dataStep1['alamat_lengkap'] ?? 'Belum mengisi alamat' }}</span>
                            </div>
                            <div class="flex justify-end pt-2">
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
                    
                    <div class="bg-white rounded-[20px] shadow-lg p-6">
                        <h3 class="text-[#0085C9] font-bold text-lg mb-4">Form Penimbangan</h3>
                        
                        <div class="bg-[#e4f3fa] rounded-2xl p-5 border border-blue-100">
                            <label class="block text-gray-700 font-semibold text-sm mb-3">Masukan berat(Kg)</label>
                            
                            <div class="flex items-center gap-5 mb-5">
                                <button type="button" id="btn-minus" class="w-8 h-8 rounded-full bg-[#F6921E] text-white flex items-center justify-center shadow focus:outline-none hover:bg-orange-600 transition-all">
                                    <i class="fa-solid fa-minus text-xs"></i>
                                </button>
                                <input type="number" id="input-berat" name="berat_laundry" value="1" min="1" class="w-12 text-center bg-transparent font-bold text-xl text-gray-800 border-none focus:ring-0 p-0 outline-none">
                                <button type="button" id="btn-plus" class="w-8 h-8 rounded-full bg-[#F6921E] text-white flex items-center justify-center shadow focus:outline-none hover:bg-orange-600 transition-all">
                                    <i class="fa-solid fa-plus text-xs"></i>
                                </button>
                            </div>

                            <label class="block text-gray-700 font-semibold text-sm mb-1.5">Harga <span class="text-[9px] text-gray-400 font-normal italic">*dapat berubah sesuai timbangan</span></label>
                            <div class="w-full bg-white rounded-xl py-3 px-4 border border-gray-100 shadow-inner">
                                <span id="text-harga" class="text-gray-700 font-bold text-base">Rp 8.000</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-[20px] shadow-lg p-6">
                        <h3 class="text-[#0085C9] font-bold text-lg mb-3">Intruksi Pencucian</h3>
                        <div class="bg-[#e4f3fa] rounded-2xl p-2 border border-blue-100">
                            <textarea name="instruksi_pencucian" rows="5" placeholder="contoh: jangan pakai pemutih" class="w-full bg-transparent border-none placeholder-gray-400/80 text-gray-700 text-sm focus:ring-0 resize-none outline-none p-3"></textarea>
                        </div>
                    </div>

                </div>

            </div>

            <div class="pt-6">
                <button type="submit" class="w-full bg-[#F6921E] hover:bg-orange-600 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg transition-transform hover:scale-[1.01] text-base tracking-wide text-center">
                    Konfirmasi & Jemput Sekarang
                </button>
            </div>
    {{-- ==========================================
         JAVASCRIPT LOGIC COUNTER & HARGA (Frontend)
         ========================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnMinus = document.getElementById('btn-minus');
            const btnPlus = document.getElementById('btn-plus');
            const inputBerat = document.getElementById('input-berat');
            const textHarga = document.getElementById('text-harga');

            // Setup harga dasar per Kg (Misal Rp 8.000 per kilo)
            const hargaPerKg = 8000;

            // Fungsi pembantu memformat angka biasa ke Rupiah (Rp xx.xxx)
            function formatRupiah(angka) {
                return 'Rp ' + angka.toLocaleString('id-ID');
            }

            // Fungsi utama buat hitung dan update harga di layar
            function updateHarga() {
                let berat = parseInt(inputBerat.value) || 1;
                
                // Cegah angka drop di bawah 1
                if (berat < 1) {
                    berat = 1;
                    inputBerat.value = 1;
                }

                let totalHarga = berat * hargaPerKg;
                textHarga.innerText = formatRupiah(totalHarga);
            }

            // Aksi ketika tombol Plus diklik
            btnPlus.addEventListener('click', function () {
                let currentVal = parseInt(inputBerat.value) || 0;
                inputBerat.value = currentVal + 1;
                updateHarga();
            });

            // Aksi ketika tombol Minus diklik
            btnMinus.addEventListener('click', function () {
                let currentVal = parseInt(inputBerat.value) || 1;
                if (currentVal > 1) {
                    inputBerat.value = currentVal - 1;
                    updateHarga();
                }
            });

            // Antisipasi jika user mengetik manual angkanya di keyboard
            inputBerat.addEventListener('input', updateHarga);
        });

        // --- LOGIC FRONTEND TUKAR KOTAK INFO PEMBAYARAN ---
        const radioMetode = document.querySelectorAll('input[name="metode_pembayaran"]');
        const infoCod = document.getElementById('info-cod');
        const infoQris = document.getElementById('info-qris');
        const infoCard = document.getElementById('info-card');

        radioMetode.forEach(radio => {
            radio.addEventListener('change', function() {
                const pilihan = this.value; // Nilainya bisa: COD, QRIS, atau CARD

                // Sembunyikan semua kotak info terlebih dahulu
                infoCod.classList.add('hidden');
                infoQris.classList.add('hidden');
                infoCard.classList.add('hidden');

                // Buka kotak info yang sesuai dengan radio button yang diklik
                if (pilihan === 'COD') {
                    infoCod.classList.remove('hidden');
                } else if (pilihan === 'QRIS') {
                    infoQris.classList.remove('hidden');
                } else if (pilihan === 'CARD') {
                    infoCard.classList.remove('hidden');
                }
            });
        });
    </script>
</x-app-layout>