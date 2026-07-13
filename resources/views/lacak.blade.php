<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Status Laundry - CuciYuk</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        skyBg: '#D1E9F6',
                        skyMid: '#B8DCF0',
                        blueMed: '#38A1D1',
                        blueDark: '#2080B0',
                        purple: '#5D325E',
                        purpleLight: '#7A4A7B',
                        orange: '#F6921E',
                        orangeHot: '#E07E10',
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    }
                }
            }
        };
    </script>

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }
    </style>
</head>

<body class="min-h-screen bg-[#E2F3FC]">

    @include('partials.navbar')

    <main class="relative pt-32 pb-12 flex flex-col items-center justify-center px-4 space-y-8 w-full">

        {{-- FORM PENCARIAN --}}
        <div class="bg-white w-full max-w-md rounded-[32px] shadow-2xl p-8 border-2 border-white">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Lacak Laundry</h1>
                <p class="text-sm text-gray-500">Masukkan nomor nota anda</p>
            </div>

            <form action="{{ route('tracking.search') }}" method="POST" class="space-y-4" id="form-lacak">
                @csrf
                <input type="text" name="nomor_resi" id="resi"
                    value="{{ old('nomor_resi', isset($order) ? $order->nomor_resi : '') }}"
                    placeholder="Contoh: CY-260608-A1B2"
                    class="w-full px-5 py-4 rounded-2xl border-2 border-gray-100 outline-none focus:border-[#F6921E] uppercase font-bold text-center tracking-wider placeholder:tracking-normal placeholder:font-normal">

                <button type="submit" id="btn-lacak" class="w-full bg-[#F6921E] hover:bg-orange-600 text-white font-bold py-4 rounded-2xl shadow-lg transition-all flex items-center justify-center gap-2">
                    Lacak Sekarang
                </button>
            </form>

            @if(session('error'))
            <p class="text-red-500 text-xs mt-3 text-center font-semibold">❌ {{ session('error') }}</p>
            @endif
            <p id="error-message" class="text-red-500 text-xs mt-3 hidden text-center font-semibold">Nomor resi wajib diisi!</p>
        </div>

        {{-- DETAIL DATA ORDER --}}
        @if(isset($order))
        <div class="bg-white w-full max-w-2xl rounded-[32px] shadow-2xl p-6 md:p-8 border-2 border-white fade-in space-y-6">
            <div class="border-b border-dashed border-gray-100 pb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                <div>
                    <span class="text-gray-400 text-xs block">No. Nota / Resi:</span>
                    <span class="font-black text-gray-800 tracking-wider text-lg">{{ $order->nomor_resi ?? $order->nomor_nota }}</span>
                </div>
                <div class="sm:text-right">
                    <span class="text-gray-400 text-xs block">Status Terakhir:</span>
                    @if($order->status == 'To Pending' || $order->status == 'Pending Penjemputan')
                    <span class="inline-block px-3 py-1 rounded-full text-[11px] font-black bg-yellow-50 text-yellow-600 mt-0.5 border border-yellow-100">Pending Penjemputan</span>
                    @elseif($order->status == 'To Pickup')
                    <span class="inline-block px-3 py-1 rounded-full text-[11px] font-black bg-blue-50 text-blue-600 mt-0.5 border border-blue-100">Sedang Dijemput</span>
                    @elseif($order->status == 'To Washing')
                    <span class="inline-block px-3 py-1 rounded-full text-[11px] font-black bg-purple-50 text-purple-600 mt-0.5 border border-purple-100">Sedang Dicuci</span>
                    @elseif($order->status == 'To Delivery')
                    <span class="inline-block px-3 py-1 rounded-full text-[11px] font-black bg-indigo-50 text-indigo-600 mt-0.5 border border-indigo-100">Sedang Diantar</span>
                    @elseif($order->status == 'To Complete' || $order->status == 'Selesai')
                    <span class="inline-block px-3 py-1 rounded-full text-[11px] font-black bg-green-50 text-green-600 mt-0.5 border border-green-100">Selesai</span>
                    @else
                    <span class="inline-block px-3 py-1 rounded-full text-[11px] font-black bg-gray-50 text-gray-600 mt-0.5 border border-gray-100">{{ $order->status }}</span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                <div class="bg-gray-50 p-3 rounded-2xl text-gray-600">
                    <p class="text-gray-400">Pelanggan:</p>
                    <p class="font-bold text-gray-800 mt-0.5">{{ auth()->check() ? $order->nama_pelanggan : substr($order->nama_pelanggan, 0, 2) . '***' }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-xl">
                    <span class="text-xs text-gray-400 block mb-1">
                        @php
                        $jenisLayananLower = strtolower($order->jenis_layanan ?? $order['jenis_layanan'] ?? '');
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
                        Berat Estimasi:
                        @endif
                    </span>
                    <p class="font-bold text-gray-800 mt-0.5">
                        {{ number_format($order->berat_laundry ?? $order['berat_laundry'] ?? 0, 0) }}

                        @if(str_contains($jenisLayananLower, 'permadani') || str_contains($jenisLayananLower, 'karpet') || str_contains($jenisLayananLower, 'gorden'))
                        m²
                        @elseif(str_contains($jenisLayananLower, 'boneka') || str_contains($jenisLayananLower, 'bedcover'))
                        Pcs
                        @elseif(str_contains($jenisLayananLower, 'sepatu'))
                        Pasang
                        @else
                        Kg
                        @endif
                    </p>
                </div>

                <div class="bg-gray-50 p-3 rounded-2xl text-gray-600">
                    <p class="text-gray-400">Paket Layanan:</p>
                    <p class="font-bold text-gray-800 mt-0.5">{{ ucfirst($order->tipe_durasi ?? 'reguler') }}</p>
                </div>
                <div class="bg-gray-50 p-3 rounded-2xl text-gray-600">
                    <p class="text-gray-400">Total Biaya:</p>
                    <p class="font-bold text-green-600 mt-0.5">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-blue-50/70 p-3 rounded-2xl text-[11px] text-gray-500">
                <span class="font-bold text-[#2080B0] block mb-0.5">Alamat Penjemputan / Pengantaran:</span>
                <p class="italic leading-relaxed">
                    {{ auth()->check() ? $order->alamat_lengkap : '🔒 Login untuk melihat detail alamat lengkap.' }}
                </p>
            </div>

            <div class="mt-3 pt-3 border-t border-gray-100">
                <p class="text-xs font-bold text-gray-700">🗓️ Jadwal Penjemputan:</p>
                <p class="text-sm text-blue-600 font-semibold mt-0.5">
                    {{ $order->jadwal_pickup ?? $order['jadwal_pickup'] ?? 'Segera Di-pickup' }}
                </p>
            </div>

            <div class="mt-3 pt-3 border-t border-gray-100">
                <p class="text-xs font-bold text-gray-700">🛵 Kurir Penjemput:</p>
                <p class="text-sm text-blue-600 font-semibold mt-0.5">
                    {{ $order->kurir?->user?->name ?? 'Sedang mencari kurir terdekat...' }}
                </p>
            </div>

            <div class="mt-3 pt-3 border-t border-gray-100">
                <p class="text-xs font-bold text-gray-700">📦 Jadwal Pengantaran Kembali:</p>
                <p class="text-sm text-blue-600 font-semibold mt-0.5">
                    {{ $order->jadwal_pengiriman ?? $order['jadwal_pengiriman'] ?? '-' }}
                </p>
            </div>

            <div class="mt-3 pt-3 border-t border-gray-100">
                <p class="text-xs font-bold text-gray-700">💳 Metode Pembayaran:</p>
                <div class="mt-1">
                    <span class="inline-block bg-gray-100 text-gray-800 font-bold px-2.5 py-0.5 rounded text-xs">
                        {{ $order->metode_pembayaran ?? $order['metode_pembayaran'] ?? '-' }}
                    </span>
                </div>
            </div>

            @if(!empty($order->instruksi_driver) || !empty($order['instruksi_driver']))
            <div class="bg-amber-50 p-3 rounded-xl text-xs text-amber-700 mt-4 border border-amber-100">
                <span class="font-bold text-amber-800 block mb-1">📌 Catatan Untuk Driver:</span>
                "{{ $order->instruksi_driver ?? $order['instruksi_driver'] }}"
            </div>
            @endif
        </div>
        @endif

        {{-- RIWAYAT PESANAN --}}
        @auth
        @if(isset($ordersHistory) && $ordersHistory->count() > 0)
        <div class="bg-white w-full max-w-2xl rounded-[32px] shadow-2xl p-6 border-2 border-white fade-in space-y-3">
            <h3 class="text-xs font-black text-gray-400 uppercase tracking-wider border-b pb-2 border-gray-100 flex justify-between items-center">
                <span>📋 Riwayat Pesanan Saya</span>
                <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-full">{{ $ordersHistory->count() }} Order</span>
            </h3>

            <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                @foreach($ordersHistory as $histori)
                <div class="flex justify-between items-center p-3 bg-gray-50/80 hover:bg-orange-50/30 rounded-xl border border-gray-100 transition-all text-xs">
                    <div class="space-y-0.5">
                        <p class="font-bold text-gray-700 tracking-wider">{{ $histori->nomor_resi ?? $histori->nomor_nota ?? 'BELUM ADA RESI' }}</p>
                        <p class="text-gray-400 text-[11px]">{{ date('d M Y', strtotime($histori->created_at)) }} • <span class="font-semibold text-gray-600">Rp {{ number_format($histori->total_harga, 0, ',', '.') }}</span></p>
                    </div>
                    <div>
                        @if($histori->status == 'To Pending' || $histori->status == 'Pending Penjemputan')
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-yellow-50 text-yellow-600 border border-yellow-100">Pending Penjemputan</span>
                        @elseif($histori->status == 'To Pickup')
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-100">Sedang Dijemput</span>
                        @elseif($histori->status == 'To Washing')
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-600 border border-purple-100">Sedang Dicuci</span>
                        @elseif($histori->status == 'To Delivery')
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-600 border border-indigo-100">Sedang Diantar</span>
                        @elseif($histori->status == 'To Complete' || $histori->status == 'Selesai')
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-50 text-green-600 border border-green-100">Selesai</span>
                        @else
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-gray-50 text-gray-600 border border-gray-100">{{ $histori->status }}</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @endauth
    </main>

    {{-- JAVASCRIPT UTK LOADING BUTTON DAN AUTO REFRESH --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const formLacak = document.getElementById('form-lacak');
            const btnLacak = document.getElementById('btn-lacak');
            const inputResi = document.getElementById('resi');
            const errorMessage = document.getElementById('error-message');

            if (formLacak) {
                formLacak.addEventListener('submit', (e) => {
                    const resiValue = inputResi.value.trim();

                    if (!resiValue) {
                        e.preventDefault();
                        errorMessage.classList.remove('hidden');
                        inputResi.focus();
                        return;
                    }

                    btnLacak.innerHTML = `
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Mencari...
                    `;
                    btnLacak.disabled = true;
                });
            }
        });
    </script>

    {{-- AUTO REFRESH HALAMAN SECARA AMAN --}}
    @if(isset($order) && $order->status !== 'Selesai' && $order->status !== 'To Complete')
    <script>
        setTimeout(function() {
            window.location.reload();
        }, 15000); // Auto refresh setiap 15 detik
    </script>
    @endif
</body>

</html>