@php
    // Bank Data Jangkauan Wilayah CuciYuk (Simulasi Area Tangerang)
    $kecamatanTangerang = [
        'Batuceper'   => 9,
        'Ciledug'     => 12,
        'Cibodas'     => 5,
        'Pondok Aren' => 7.5,
        'Jatiuwung'   => 4,
        'Karawaci'    => 1, 
        'Balaraja'    => 25.0, 
    ];
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

                <input type="hidden" name="jenis_layanan" value="{{ $layanan }}">

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
                        <textarea id="instruksi-alamat" name="instruksi_alamat" rows="2" placeholder="Contoh: Pagar warna hitam, rumah nomor 4" class="w-full border border-[#F6921E]/50 rounded-[14px] px-4 py-2 focus:ring-2 focus:ring-[#F6921E] outline-none resize-none"></textarea>

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

                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold text-sm mb-1.5">Alamat Lengkap Konfirmasi</label>
                            <input type="text" name="alamat_lengkap" id="real-address" value="Jalan Aria Santika, Pabuaran, Karawaci, Tangerang, Banten," class="w-full rounded-xl border-gray-300 p-3 text-sm bg-gray-50 text-gray-700 focus:ring-[#0085C9] focus:border-[#0085C9]">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold text-sm mb-1.5">Kecamatan (Untuk Hitung Ongkir)</label>
                            <div class="relative">
                                <select name="kecamatan_ongkir" id="select_kecamatan" required class="w-full rounded-xl border-gray-300 p-3 text-sm text-gray-700 focus:ring-[#0085C9] focus:border-[#0085C9] bg-white shadow-sm appearance-none cursor-pointer">
                                    <option value="" disabled selected>-- Pilih Kecamatan Rumah Anda --</option>
                                    @foreach($kecamatanTangerang as $namaKecamatan => $jarak)
                                        <option value="{{ $jarak }}">
                                            Kecamatan {{ $namaKecamatan }} ({{ $jarak }} Km)
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold text-sm mb-1.5">Nama Lengkap</label>
                            <input type="text" name="nama_pelanggan" value="pelanggan" class="w-full rounded-xl border-gray-300 p-3 text-sm focus:ring-[#0085C9] focus:border-[#0085C9]">
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

                    <div class="space-y-4 md:border-l md:border-[#F6921E]/30 md:pl-10 relative">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Mau PickUp Kapan?</h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Hari apa?</label>
                                <input type="date" name="hari_pickup" class="w-full border border-[#F6921E]/50 rounded-[14px] px-4 py-2 focus:ring-2 focus:ring-[#F6921E] outline-none text-gray-600 text-sm" required>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Jam Berapa?</label>
                                <input type="time" name="jam_pickup" class="w-full border border-[#F6921E]/50 rounded-[14px] px-4 py-2 focus:ring-2 focus:ring-[#F6921E] outline-none text-gray-600 text-sm" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Intruksi Untuk Driver</label>
                            <textarea name="instruksi_driver" rows="5" class="w-full border border-[#F6921E]/50 rounded-[14px] px-4 py-3 focus:ring-2 focus:ring-[#F6921E] outline-none resize-none"></textarea>
                        </div>

                        <div class="hidden md:block absolute bottom-0 -left-[1px] h-24 w-[1px] bg-[#F6921E]"></div>
                    </div>
                </div>
                <div class="mt-8 flex justify-end">
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
    // 1. KOORDINAT OUTLET LAUNDRY ACUAN
    const koordinatOutlet = L.latLng(-6.5971, 106.7986);
    const map = L.map('map').setView(koordinatOutlet, 13);

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
                    if (realInput) realInput.value = data.display_name; // Sekarang udah gak error!
                }
            })
            .catch(err => console.error(err));
    }

    marker.on('dragend', function(e) {
        var position = marker.getLatLng(); 
        kalkulasiDanSimpanJarak(position);
        updateAlamatDariKoordinat(position.lat, position.lng);
    });

    // FIX 4: Jembatan Otomatis! Kalau User milih Dropdown Kecamatan, nilai jarak_km ikut terupdate otomatis!
    const selectKecamatan = document.getElementById('select_kecamatan');
    if(selectKecamatan) {
        selectKecamatan.addEventListener('change', function() {
            var jarakDariDropdown = this.value;
            var inputJarak = document.getElementById('jarak_km');
            if(inputJarak) {
                inputJarak.value = jarakDariDropdown;
                console.log("Jarak sukses diperbarui via Dropdown -> " + jarakDariDropdown + " Km");
            }
        });
    }

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
</script>