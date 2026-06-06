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
                    <h3 class="text-lg font-bold text-red-600">Selamat Datang, Admin!</h3>
                    <p class="mb-4">Ini panel kendali utama laundry.</p>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                            Keluar dari Sistem
                        </button>
                    </form>

                    @elseif(Auth::user()->role == 'owner')
                    <h3 class="text-lg font-bold">Halo Owner</h3>
                    <p>Ini halaman pantau laporan keuangan.</p>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                            Keluar dari Sistem
                        </button>
                    </form>

                    @elseif(Auth::user()->role == 'kurir')
                    <h3 class="text-lg font-bold">Semangat, Kurir!</h3>
                    <p>Cek daftar jemputan laundry hari ini ya.</p>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                            Keluar dari Sistem
                        </button>
                    </form>

                    @else
                    <h3 class="text-lg font-bold">Halo Pengguna!</h3>
                    <p>Selamat datang di aplikasi laundry kami.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>