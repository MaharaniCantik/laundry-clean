@php
// Bank Data Jangkauan Wilayah dihapus karena kita pakai kalkulasi peta murni
@endphp

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-[#7ec8ea] to-[#d4effa] py-8 px-4 md:px-8 font-sans">
        <div class="max-w-5xl mx-auto">

            {{-- STEPBAR --}}
            @include('partials.step-bar')

            {{-- FORM CARD UTAMA --}}
            <form action="{{ route('order.service') }}" method="POST" class="bg-white rounded-[24px] shadow-xl p-6 md:p-10 mb-10">
                @csrf

                <input type="hidden" id="js-jenis-layanan" name="jenis_layanan" value="{{ $layanan }}">

                <input type="hidden" name="jarak_km" id="jarak_km" value="0">

                <h2 class="text-xl font-bold text-gray-900 mb-4">Alamat PickUp</h2>

                <div class="mb-4">
                    <label class="block text-xs text-gray-400 mb-1.5">Kategori Alamat</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach(['Rumah', 'Kost', 'Apartement', 'Hotel'] as $kat)
                        <label class="cursor-pointer">
                            <input type="radio" name="kategori_alamat" value="{{ $kat }}" class="peer sr-only" {{ $loop->first ? 'checked' : '' }}>
                            <div class="text-center py-1.5 px-4 rounded-xl border border-blue-400 text-[#0085C9] bg-white peer-checked:border-blue-600 peer-checked:bg-blue-50 font-medium text-sm transition-all">
                                {{ $kat }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="relative w-full mb-8">
                    <div class="absolute top-4 left-4 right-4 z-[1000]">
                        <input type="text" id="search-address" placeholder="Masukan Alamat Lengkap Anda (Tekan Enter untuk cari)" class="w-full bg-white/95 backdrop-blur-sm px-5 py-2.5 rounded-full shadow-md text-xs border border-gray-200 focus:ring-2 focus:ring-[#F6921E] outline-none" required>
                    </div>
                    <div id="map" class="w-full h-64 md:h-80 rounded-2xl shadow-inner border border-gray-100 z-0"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Instruksi Alamat <span id="label-tambahan">(Opsional)</span>
                        </label>
                        <textarea id="instruksi-alamat" name="instruksi_alamat" rows="2" placeholder="Contoh: Pagar warna hitam, depan warung Madura." class="w-full border border-[#F6921E]/50 rounded-[14px] px-4 py-2 focus:ring-2 focus:ring-[#F6921E] outline-none resize-none"></textarea>

                        <div class="mt-4">
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Jenis Kontak</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer">
                                    <input type="radio" name="jenis_kontak" value="Individu" class="peer sr-only" checked>
                                    <div class="text-center py-2 px-4 rounded-[12px] border border-[#F6921E] peer-checked:bg-[#F6921E] peer-checked:text-white text-[#F6921E] font-medium text-sm transition-all">Individu</div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="jenis_kontak" value="Perusahaan" class="peer sr-only">
                                    <div class="text-center py-2 px-4 rounded-[12px] border border-[#F6921E] peer-checked:bg-[#F6921E] peer-checked:text-white text-[#F6921E] font-medium text-sm transition-all">Perusahaan</div>
                                </label>
                            </div>
                        </div>

                        <div class="mb-4 mt-4">
                            <label class="block text-gray-700 font-semibold text-sm mb-1.5">Alamat Lengkap Konfirmasi</label>
                            <input type="text" name="alamat_lengkap" id="real-address" value="" class="w-full rounded-xl border-gray-300 p-3 text-sm bg-gray-50 text-gray-700 focus:ring-[#0085C9] focus:border-[#0085C9]" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold text-sm mb-1.5">Nama Lengkap</label>
                            <input type="text" name="nama_pelanggan" value="{{ auth()->user()->name }}" class="w-full rounded-xl border-gray-300 p-3 text-sm bg-gray-100 text-gray-700 focus:ring-blue-500 focus:border-blue-500" readonly>
                        </div>

                        <div class="mt-4">
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Jenis Kelamin</label>
                            <div class="flex items-center gap-6">
                                <label class="flex items-center cursor-pointer gap-2">
                                    <input type="radio" name="jenis_kelamin" value="Perempuan" class="peer sr-only" checked>
                                    <div class="w-5 h-5 rounded-full border-2 border-[#F6921E] peer-checked:bg-[#F6921E] transition-colors"></div>
                                    <span class="text-gray-700 text-sm">Perempuan</span>
                                </label>
                                <label class="flex items-center cursor-pointer gap-2">
                                    <input type="radio" name="jenis_kelamin" value="Laki-laki" class="peer sr-only">
                                    <div class="w-5 h-5 rounded-full border-2 border-[#F6921E] peer-checked:bg-[#F6921E] transition-colors"></div>
                                    <span class="text-gray-700 text-sm">Laki - laki</span>
                                </label>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-xs font-semibold text-gray-700 mb-1">No Telpon</label>
                            <input type="tel" name="phone" class="w-full border border-[#F6921E]/50 rounded-full px-4 py-2 focus:ring-2 focus:ring-[#F6921E] outline-none" required>
                        </div>
                    </div>

                    <div class="space-y-6 md:border-l md:border-[#F6921E]/30 md:pl-10 relative">

                        {{-- 1. FORM PICKUP (ATAS) --}}
                        <div class="space-y-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Mau PickUp Kapan?</h3>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Hari apa?</label>
                                    <input type="date"
                                        name="hari_pickup"
                                        min="{{ date('Y-m-d') }}"
                                        class="w-full border border-[#F6921E]/50 rounded-[14px] px-4 py-2 focus:ring-2 focus:ring-[#F6921E] outline-none text-gray-600 text-sm bg-white"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Jam Berapa?</label>
                                    <select name="jam_pickup"
                                        class="w-full border border-[#F6921E]/50 rounded-[14px] px-4 py-2 focus:ring-2 focus:ring-[#F6921E] outline-none text-gray-600 text-sm bg-white"
                                        required>
                                        <option value="" disabled selected>-- Pilih Jam --</option>
                                        <option value="09:00 - 11:00">Pagi (09:00 - 11:00)</option>
                                        <option value="11:00 - 13:00">Siang (11:00 - 13:00)</option>
                                        <option value="13:00 - 15:00">Siang (13:00 - 15:00)</option>
                                        <option value="15:00 - 17:00">Sore (15:00 - 17:00)</option>
                                        <option value="17:00 - 19:00">Sore/Malam (17:00 - 19:00)</option>
                                        <option value="19:00 - 21:00">Malam (19:00 - 21:00)</option>
                                        <option value="21:00 - 22:00">Malam Khusus Weekend (21:00 - 22:00)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- 2. FORM DELIVERY (TEPAT DI BAWAH PICKUP) --}}
                        <div class="space-y-4 pt-6 border-t border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Mau Diantar Kembali Kapan?</h3>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Hari apa?</label>
                                    <input type="date"
                                        id="hari_delivery" {{-- 🌟 Ditambahkan ID untuk JavaScript --}}
                                        name="hari_delivery"
                                        min="{{ date('Y-m-d') }}"
                                        class="w-full border border-[#F6921E]/50 rounded-[14px] px-4 py-2 focus:ring-2 focus:ring-[#F6921E] outline-none text-gray-600 text-sm bg-white"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Jam Berapa?</label>
                                    <select name="jam_delivery"
                                        class="w-full border border-[#F6921E]/50 rounded-[14px] px-4 py-2 focus:ring-2 focus:ring-[#F6921E] outline-none text-gray-600 text-sm bg-white"
                                        required>
                                        <option value="" disabled selected>-- Pilih Jam --</option>
                                        <option value="09:00 - 11:00">Pagi (09:00 - 11:00)</option>
                                        <option value="11:00 - 13:00">Siang (11:00 - 13:00)</option>
                                        <option value="13:00 - 15:00">Siang (13:00 - 15:00)</option>
                                        <option value="15:00 - 17:00">Sore (15:00 - 17:00)</option>
                                        <option value="17:00 - 19:00">Sore/Malam (17:00 - 19:00)</option>
                                        <option value="19:00 - 21:00">Malam (19:00 - 21:00)</option>
                                        <option value="21:00 - 22:00">Malam Khusus Weekend (21:00 - 22:00)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 pt-6 border-t border-gray-100">
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Instruksi Untuk Driver</label>
                            <textarea name="instruksi_driver" rows="5" class="w-full border border-[#F6921E]/50 rounded-[14px] px-4 py-3 focus:ring-2 focus:ring-[#F6921E] outline-none resize-none" placeholder="Contoh: Titipkan ke satpam atau taruh di teras pagar hitam..."></textarea>
                        </div>

                        {{-- Garis dekoratif samping kiri bawah (khusus desktop) --}}
                        <div class="hidden md:block absolute bottom-0 -left-[1px] h-24 w-[1px] bg-[#F6921E]"></div>

                    </div>
                </div>
                <div class="mt-8 flex justify-end">
                    <input type="hidden" name="layanan_utama" value="{{ $layanan }}">

                    <button type="submit" class="bg-[#F6921E] hover:bg-orange-600 text-white font-bold py-2.5 px-8 rounded-full shadow-md transition-transform hover:scale-105 text-sm">
                        Lanjut ke Layanan →
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // 1. 🔥 SET KOORDINAT OUTLET LAUNDRY HASIL WAWANCARA DI SINI 🔥
    const koordinatOutlet = L.latLng(-6.178550, 106.608420);
    const map = L.map('map').setView(koordinatOutlet, 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const marker = L.marker(koordinatOutlet, {
        draggable: true
    }).addTo(map);

    function kalkulasiDanSimpanJarak(posisiPin) {
        try {
            var jarakMeter = map.distance(posisiPin, koordinatOutlet);
            var jarakKm = (jarakMeter / 1000).toFixed(1);

            var inputJarak = document.getElementById('jarak_km');
            if (inputJarak) {
                inputJarak.value = jarakKm;
                console.log("Jarak sukses diperbarui via Peta -> " + jarakKm + " Km");
            }
        } catch (error) {
            console.error("Gagal menghitung jarak: ", error);
        }
    }

    function updateAlamatDariKoordinat(lat, lng) {
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.display_name) {
                    var searchInput = document.getElementById('search-address');
                    var realInput = document.getElementById('real-address');

                    if (searchInput) searchInput.value = data.display_name;
                    if (realInput) realInput.value = data.display_name;
                }
            })
            .catch(err => console.error(err));
    }

    marker.on('dragend', function(e) {
        var position = marker.getLatLng();
        kalkulasiDanSimpanJarak(position);
        updateAlamatDariKoordinat(position.lat, position.lng);
    });

    // PENCARIAN MANUAL VIA ENTER
    const searchInput = document.getElementById('search-address');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const query = searchInput.value;

                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            const lat = parseFloat(data[0].lat);
                            const lon = parseFloat(data[0].lon);
                            const posisiBaru = L.latLng(lat, lon);

                            map.setView(posisiBaru, 15);
                            marker.setLatLng(posisiBaru);

                            searchInput.value = data[0].display_name;
                            var realAddressInput = document.getElementById('real-address');
                            if (realAddressInput) realAddressInput.value = data[0].display_name;

                            kalkulasiDanSimpanJarak(posisiBaru);
                        } else {
                            alert("Lokasi tidak ditemukan!");
                        }
                    })
                    .catch(err => console.error(err));
            }
        });
    }

    kalkulasiDanSimpanJarak(marker.getLatLng());

    // SCRIPT PLACEHOLDER KATEGORI
    const kategoriRadios = document.querySelectorAll('input[name="kategori_alamat"]');
    const instruksiTextArea = document.getElementById('instruksi-alamat');
    const labelTambahan = document.getElementById('label-tambahan');

    const placeholders = {
        'Rumah': 'Contoh: Pagar warna hitam, depan warung Madura.',
        'Kost': 'Contoh: Kost Green House, Kamar 2B.',
        'Apartement': 'Contoh: Tower Aurora, Lantai 15.',
        'Hotel': 'Contoh: Kamar 304, atas nama Ahmad.'
    };

    kategoriRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const pilihan = this.value;
            if (instruksiTextArea) instruksiTextArea.placeholder = placeholders[pilihan];
            if (pilihan !== 'Rumah') {
                if (labelTambahan) {
                    labelTambahan.innerText = `(Wajib isi No. Kamar / Tower / Unit)`;
                    labelTambahan.className = "text-red-500 font-bold ml-1";
                }
            } else {
                if (labelTambahan) {
                    labelTambahan.innerText = `(Opsional)`;
                    labelTambahan.className = "text-gray-400 font-normal ml-1";
                }
            }
        });
    });

// 🌟 LOGIKA DINAMIS TANGGAL DELIVERY (SIAP UNTUK BANYAK LAYANAN) 🌟
    const inputHariPickup = document.querySelector('input[name="hari_pickup"]');
    const inputHariDelivery = document.querySelector('input[name="hari_delivery"]');
    const jsJenisLayanan = document.getElementById('js-jenis-layanan');

    if (inputHariPickup && inputHariDelivery) {
        inputHariPickup.addEventListener('change', function() {
            if (this.value) {
                const datePickup = new Date(this.value);

                // 1. Ambil nilai dari hidden input, jika tidak ada fallback ke URL, jika tidak ada default ke kiloan
                let jenisLayanan = jsJenisLayanan ? jsJenisLayanan.value : '';
                if (!jenisLayanan) {
                    // 🧸 UPDATE: Tambahkan kondisi deteksi 'boneka' dari path URL
                    if (window.location.pathname.includes('permadani')) {
                        jenisLayanan = 'permadani';
                    } else if (window.location.pathname.includes('setrika')) {
                        jenisLayanan = 'setrika';
                    } else if (window.location.pathname.includes('boneka')) {
                        jenisLayanan = 'boneka';
                    } else if (window.location.pathname.includes('gorden')) {
                        jenisLayanan = 'gorden';
                    } else if (window.location.pathname.includes('bedcover')) {
                        jenisLayanan = 'bedcover';
                    } else if (window.location.pathname.includes('sepatu')) {
                        jenisLayanan = 'sepatu';
                    } else {
                        jenisLayanan = 'kiloan';
                    }
                }

                // 2. Daftar durasi proses tiap layanan
                const durasiLayanan = {
                    'kiloan': 3,     // Kiloan nunggu 3 hari
                    'permadani': 14, // Permadani nunggu 14 hari
                    'setrika': 2,    // Setrika nunggu 2 hari
                    'boneka': 2,     // Boneka default nunggu 2 hari (Ukuran S)
                    'gorden':3,      // Gorden 3 hari
                    'bedcover':4,     // Bedcover nunggu 4 hari
                    'sepatu':3      // Sepatu 3 hari
                };

                // 3. Ambil jumlah hari berdasarkan layanan aktif (jika tidak terdaftar, default 3 hari)
                const jumlahHari = durasiLayanan[jenisLayanan] || 3;

                // 4. Tambahkan hari otomatis
                datePickup.setDate(datePickup.getDate() + jumlahHari);

                // Format kembali ke string YYYY-MM-DD
                const year = datePickup.getFullYear();
                const month = String(datePickup.getMonth() + 1).padStart(2, '0');
                const day = String(datePickup.getDate()).padStart(2, '0');

                const formattedDeliveryDate = `${year}-${month}-${day}`;

                // Set nilai ke input delivery
                inputHariDelivery.value = formattedDeliveryDate;
                inputHariDelivery.min = formattedDeliveryDate;
            }
        });
    }
</script>