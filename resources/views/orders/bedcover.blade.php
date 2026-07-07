<x-app-layout>
    <div class="min-h-screen bg-sky-100/50 pb-12">
        
        {{-- ==========================================
             SECTION 1: ATAS (Tombol & Banner Lebar Sesuai Figma)
             ========================================== --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            
            {{-- Tombol Chevron Kembali & Breadcrumb --}}
            <div class="flex items-center gap-1 text-sm font-semibold mb-2">
                <a href="{{ url('/') }}" class="text-gray-400 hover:text-gray-600 flex items-center gap-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Layanan
                </a>
                <span class="text-gray-400">/</span>
                <span class="text-orange-500">Laundry Bedcover</span>
            </div>

            {{-- Judul Besar --}}
            <h1 class="text-3xl font-extrabold text-sky-400 tracking-tight mb-6">Laundry Bedcover</h1>

            {{-- Banner Gambar Gede (Full Width di Container Besar) --}}
            <div class="w-full rounded-3xl overflow-hidden shadow-sm mb-8">
                <img src="{{ asset('images/bedcover.png') }}" alt="Banner Laundry Becover" class="w-full h-auto object-cover">
            </div>
        </div>

        {{-- ==========================================
             SECTION 2: BAWAH (Konten Detail Pilihan yang Lebih Rapat)
             ========================================== --}}
        <div class="max-w-3xl mx-auto px-4 space-y-8">

            {{-- PRICELIST --}}
            <div>
                <h2 class="text-xl font-bold text-sky-400 mb-3">
                    Pricelist Bedcover
                </h2>
                <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 overflow-hidden divide-y divide-gray-100">

                    <div class="flex justify-between items-center p-4 px-6">
                        <div class="space-y-0.5">
                            <h3 class="text-sm font-bold text-gray-700 tracking-wide">Single</h3>
                            <p class="text-xs text-gray-400 font-medium">FREE Stain Removal, Antibacterial & Linen Spray ( Bikin Relax ) | Estimasi hari 4 hari</p>
                        </div>
                        <span class="text-sm font-extrabold text-[#F6921E]">Rp 40.000</span>
                    </div>

                    <div class="flex justify-between items-center p-4 px-6">
                        <div class="space-y-0.5">
                            <h3 class="text-sm font-bold text-gray-700 tracking-wide">Double</h3>
                            <p class="text-xs text-gray-400 font-medium">FREE Stain Removal, Antibacterial & Linen Spray ( Bikin Relax ) |Estimasi Hari 7 hari</p>
                        </div>
                        <span class="text-sm font-extrabold text-[#F6921E]">Rp 55.000</span>
                    </div>

                    <div class="flex justify-between items-center p-4 px-6">
                        <div class="space-y-0.5">
                            <h3 class="text-sm font-bold text-gray-700 tracking-wide">King</h3>
                            <p class="text-xs text-gray-400 font-medium">FREE Stain Removal, Antibacterial & Linen Spray ( Bikin Relax ) | Estimasi 7 hari</p>
                        </div>
                        <span class="text-sm font-extrabold text-[#F6921E]">Rp 70.000</span>
                    </div>

                </div>
            </div>

            {{-- PICKUP & DELIVERY PRICING --}}
            <div>
                <h2 class="text-xl font-bold text-sky-400 mb-3">
                    Pickup &amp; delivery
                </h2>
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                    @php
                        $pricingRows = [
                            ['range' => '1–5 km',  'price' => 'Free',    'free' => true],
                            ['range' => '5–7 km',  'price' => '+ 7.000', 'free' => false],
                            ['range' => '7–10 km', 'price' => '+12.000', 'free' => false],
                        ];
                    @endphp

                    @foreach($pricingRows as $row)
                        <div class="flex justify-between items-center px-6 py-4 {{ !$loop->last ? 'border-b border-slate-100' : '' }}">
                            <span class="text-lg font-semibold text-slate-700">
                                {{ $row['range'] }}
                            </span>
                            <span @class([
                                'font-bold text-lg',
                                'text-blue-500' => $row['free'],
                                'text-slate-600' => !$row['free'],
                            ])>
                                {{ $row['price'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- JADWAL PICKUP & DELIVERY --}}
            <div>
                <h2 class="text-xl font-bold text-sky-400 mb-3">
                    Jadwal Pickup &amp; Delivery
                </h2>

                <div class="bg-white rounded-2xl shadow-sm px-6 py-6 space-y-6">
                    {{-- Weekday --}}
                    <div>
                        <p class="text-sky-500 font-bold text-base mb-3">Weekday</p>
                        <div class="space-y-2.5">
                            <div class="flex items-center gap-3 text-slate-700 text-sm font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Pickup : <span class="font-bold text-slate-800">09.00–21.00</span>
                            </div>
                            <div class="flex items-center gap-3 text-slate-700 text-sm font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m10-1h10a1 1 0 001-1v-4a1 1 0 00-.293-.707l-3-3A1 1 0 0017.5 8H14v8z" />
                                </svg>
                                Delivery : <span class="font-bold text-slate-800">09.00–21.00</span>
                            </div>
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    {{-- Weekend --}}
                    <div>
                        <p class="text-sky-500 font-bold text-base mb-3">Weekend</p>
                        <div class="space-y-2.5">
                            <div class="flex items-center gap-3 text-slate-700 text-sm font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Pickup : <span class="font-bold text-slate-800">09.00–22.00</span>
                            </div>
                            <div class="flex items-center gap-3 text-slate-700 text-sm font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m10-1h10a1 1 0 001-1v-4a1 1 0 00-.293-.707l-3-3A1 1 0 0017.5 8H14v8z" />
                                </svg>
                                Delivery : <span class="font-bold text-slate-800">09.00–22.00</span>
                            </div>
                        </div>
                    </div>

                    {{-- CTA Button --}}
                    <div class="pt-4 flex justify-center">
                        <a href="{{ route('order.checkout', ['layanan' => 'bedcover']) }}"
                           class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-bold text-base tracking-wide rounded-xl px-12 py-3.5 shadow-md hover:shadow-orange-200 transition-all duration-150 ease-out">
                            Pesan Sekarang
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>