<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(Auth::user()->role == 'admin')
                    <h3 class="text-lg font-bold">Selamat Datang, Admin!</h3>
                    <p>Ini panel kendali utama laundry.</p>
                    @elseif(Auth::user()->role == 'owner')
                    <h3 class="text-lg font-bold">Halo Owner</h3>
                    <p>Ini halaman pantau laporan keuangan.</p>
                    @else
                    <h3 class="text-lg font-bold">Semangat, Kurir!</h3>
                    <p>Cek daftar jemputan laundry hari ini ya.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>