<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-[#7ec8ea] to-[#d4effa] py-8 px-4 md:px-8 font-sans">
        <div class="max-w-5xl mx-auto">
             @include('partials.step-bar')
    <div class="max-w-2xl mx-auto py-8 px-4"> <div class="text-center mb-6">
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
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Nama Pelanggan:</span>
                    <span class="font-bold text-gray-800">{{ $namaUser ?? 'Pelanggan' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Metode Pembayaran:</span>
                    <span class="px-2 py-0.5 bg-gray-100 rounded text-xs font-bold text-gray-700">{{ $order->metode_pembayaran }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Status Pesanan:</span>
                    <span class="px-3 py-0.5 rounded-full text-xs font-black bg-amber-100 text-amber-700">{{ $order->status }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Tanggal Order:</span>
                    <span class="text-gray-600 text-xs">{{ date('d M Y - H:i', strtotime($order->created_at)) }}</span>
                </div>
            </div>

            <div class="space-y-2 pb-4 border-b border-dashed border-gray-200 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Berat Timbangan:</span>
                    <span class="font-bold text-gray-800">{{ $order->berat_laundry }} Kg</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Ongkos Kirim ({{ $order->jarak_km }} Km):</span>
                    <span class="font-semibold text-gray-700">Rp {{ number_format($order->ongkos_kirim, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Estimasi Biaya Laundry:</span>
                    <span class="font-semibold text-gray-700">Rp {{ number_format($order->berat_laundry * 8000, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="flex justify-between items-center pt-2">
                <span class="text-base font-bold text-gray-800">Total Pembayaran:</span>
                <span class="text-xl font-black text-[#0085C9]">
                    Rp {{ number_format(($order->berat_laundry * 8000) + $order->ongkos_kirim, 0, ',', '.') }}
                </span>
            </div>

            <div class="bg-gray-50 p-3 rounded-xl text-xs text-gray-500 mt-4">
                <span class="font-bold text-gray-700 block mb-1">Alamat Penjemputan:</span>
                {{ $order->alamat_lengkap }}
            </div>

            <div class="pt-4 text-center">
                <a href="{{ route('dashboard') }}" class="inline-block bg-[#0085C9] hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-full text-xs shadow-md transition-transform hover:scale-105">
                    Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>