<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-[#7ec8ea] to-[#d4effa] py-8 px-4 md:px-8 font-sans">
        <div class="max-w-5xl mx-auto">
            @include('partials.step-bar')

            <div class="max-w-2xl mx-auto py-8 px-4">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-black text-[#0085C9]">Nota Pesanan Laundry</h2>
                    <p class="text-xs text-gray-400 mt-1">Terima kasih telah mempercayakan laundry Anda kepada kami</p>
                </div>

                @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-xl font-semibold text-sm text-center">
                    🎉 {{ session('success') }}
                </div>
                @endif

                <div class="bg-white rounded-[20px] shadow-lg p-6 border border-gray-100 space-y-4">

                    <div class="border-b border-dashed border-gray-200 pb-4 space-y-2">
                        {{-- BARIS NOMOR RESI --}}
                        <div class="flex justify-between text-sm bg-blue-50 p-2 rounded-lg border border-blue-100">
                            <span class="text-blue-600 font-semibold">Nomor Resi / Pesanan:</span>
                            <span class="font-black text-blue-800 tracking-wider">{{ $order['nomor_resi'] ?? 'KODE-GENERATING' }}</span>
                        </div>

                        {{-- NAMA PELANGGAN --}}
                        <div class="flex justify-between text-sm pt-2">
                            <span class="text-gray-400">Nama Pelanggan:</span>
                            <span class="font-bold text-gray-800">{{ $order['nama_pelanggan'] ?? auth()->user()->name }}</span>
                        </div>
                    </div>

                    <div class="border-b border-dashed border-gray-200 pb-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Metode Pembayaran:</span>
                            <span class="px-2 py-0.5 bg-gray-100 rounded text-xs font-bold text-gray-700">{{ $order['metode_pembayaran'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Status Pesanan:</span>
                            <span class="px-3 py-0.5 rounded-full text-xs font-black bg-amber-100 text-amber-700">{{ $order['status'] }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-t border-dashed">
                            <span class="text-gray-600">Kurir Penjemput:</span>
                            <span class="font-semibold text-amber-600">
                                {{ $order->kurir->user->name ?? 'Mencari Kurir...' }}
                            </span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Tanggal Order:</span>
                            <span class="text-gray-600 text-xs">{{ date('d M Y - H:i', strtotime($order['created_at'])) }}</span>
                        </div>
                    </div>

                    {{-- 🌟 UPDATE: MENAMPILKAN DETAIL TANGGAL & SLOT JAM PILIHAN PELANGGAN --}}
                    {{-- JADWAL PICKUP --}}
                    <div class="flex justify-between text-sm pt-1">
                        <span class="text-gray-400">Jadwal Penjemputan:</span>
                        <span class="px-2 py-0.5 bg-blue-50 text-blue-700 rounded text-xs font-bold border border-blue-100">
                            🗓️ @if(!empty($order['hari_pickup']))
                            {{ date('d M Y', strtotime($order['hari_pickup'])) }} ({{ $order['jam_pickup'] ?? 'Jam Bebas' }})
                            @else
                            {{ $order['jadwal_pickup'] ?? 'Segera Di-pickup' }}
                            @endif
                        </span>
                    </div>

                    {{-- JADWAL PENGANTARAN KEMBALI --}}
                    <div class="flex justify-between text-sm pt-1">
                        <span class="text-gray-400">Jadwal Pengantaran Kembali:</span>
                        <span class="px-2 py-0.5 bg-green-50 text-green-700 rounded text-xs font-bold border border-green-100">
                            📦 @if(!empty($order['hari_delivery']))
                            {{ date('d M Y', strtotime($order['hari_delivery'])) }} ({{ $order['jam_delivery'] ?? 'Jam Bebas' }})
                            @else
                            {{ $order['jadwal_pengiriman'] ?? 'Sesuai Estimasi Selesai' }}
                            @endif
                        </span>
                    </div>

                    <div class="space-y-2 pb-4 border-b border-dashed border-gray-200 text-sm">
                        {{-- 🧸 TAMPILAN DINAMIS BERAT / JUMLAH DENGAN SATUAN YANG BENAR --}}
                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                @php
                                $jenisLayananLower = strtolower($order['jenis_layanan'] ?? $order->jenis_layanan ?? '');
                                @endphp

                                @if(str_contains($jenisLayananLower, 'permadani') || str_contains($jenisLayananLower, 'karpet'))
                                Luas Karpet:
                                @elseif(str_contains($jenisLayananLower, 'boneka'))
                                Jumlah Boneka:
                                @elseif(str_contains($jenisLayananLower, 'gorden'))
                                Luas Gorden:
                                @elseif(str_contains($jenisLayananLower, 'bedcover'))
                                Jumlah Bedcover:
                                @elseif(str_contains($jenisLayananLower, 'sepatu'))
                                Jumlah Sepatu:
                                @else
                                Berat Timbangan:
                                @endif
                            </span>
                            <span class="font-bold text-gray-800">
                                {{ number_format($order['berat_laundry'] ?? $order->berat_laundry ?? 0, 0) }}

                                @if(str_contains($jenisLayananLower, 'permadani') || str_contains($jenisLayananLower, 'karpet') || str_contains($jenisLayananLower, 'gorden'))
                                m²
                                @elseif(str_contains($jenisLayananLower, 'boneka') || str_contains($jenisLayananLower, 'bedcover'))
                                Pcs
                                @elseif(str_contains($jenisLayananLower, 'sepatu'))
                                Pasang
                                @else
                                Kg
                                @endif
                            </span>
                        </div>

                        {{-- ONGKOS KIRIM --}}
                        <div class="flex justify-between">
                            <span class="text-gray-500">Ongkos Kirim ({{ $order['jarak_km'] ?? $order->jarak_km ?? 0 }} Km):</span>
                            <span class="font-semibold text-gray-700">Rp {{ number_format($order['ongkos_kirim'] ?? $order->ongkos_kirim ?? 0, 0, ',', '.') }}</span>
                        </div>

                        {{-- 🧸 ESTIMASI BIAYA LAUNDRY (OTOMATIS AKURAT) --}}
                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Estimasi Biaya Laundry ({{ $order['tipe_durasi'] ?? $order->tipe_durasi ?? 'Reguler' }}):
                            </span>
                            <span class="font-semibold text-gray-700">
                                Rp
                                @php
                                // Trik paling aman: Harga murni laundry adalah Total dikurangi Ongkir
                                $totalHargaData = $order['total_harga'] ?? $order->total_harga ?? 0;
                                $ongkirData = $order['ongkos_kirim'] ?? $order->ongkos_kirim ?? 0;
                                $hargaLaundrySaja = $totalHargaData - $ongkirData;
                                @endphp
                                {{ number_format($hargaLaundrySaja, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- TOTAL HARGA DINAMIS --}}
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-base font-bold text-gray-800">Total Pembayaran:</span>
                            <span class="text-xl font-black text-[#0085C9]">
                                Rp {{ number_format($order['total_harga'] ?? $order->total_harga ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    {{-- ALAMAT UTAMA --}}
                    <div class="bg-gray-50 p-3 rounded-xl text-xs text-gray-500 mt-4">
                        <span class="font-bold text-gray-700 block mb-1">Alamat Penjemputan:</span>
                        {{ $order['alamat_lengkap'] }}
                    </div>

                    {{-- 🌟 TAMBAHAN BLOK INSTRUKSI ALAMAT/PATOKAN USER --}}
                    @php
                    $instruksiAlamat = $order['instruksi_alamat'] ?? $order->instruksi_alamat ?? '';
                    $instruksiDriver = $order['instruksi_driver'] ?? $order->instruksi_driver ?? '';
                    @endphp

                    @if(!empty($instruksiAlamat))
                    <div class="bg-orange-50 p-3 rounded-xl text-xs text-orange-700 mt-2 border border-orange-100">
                        <span class="font-bold text-orange-800 block mb-1">📍 Patokan / Instruksi Alamat:</span>
                        {{ $instruksiAlamat }}
                    </div>
                    @endif

                    {{-- 🌟 BOX CATATAN DRIVER --}}
                    @if(!empty($instruksiDriver))
                    <div class="bg-amber-50 p-3 rounded-xl text-xs text-amber-700 mt-2 border border-amber-100">
                        <span class="font-bold text-amber-800 block mb-1">📌 Catatan Untuk Driver:</span>
                        "{{ $instruksiDriver }}"
                    </div>
                    @endif

                    <div class="pt-4 text-center">
                        <a href="{{ route('dashboard') }}" class="inline-block bg-[#0085C9] hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-full text-xs shadow-md transition-transform hover:scale-105">
                            Kembali ke Dashboard
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>