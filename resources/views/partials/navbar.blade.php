<nav x-data="{ open: false, showLogin: false, showRegister: false }" class="sticky top-0 w-full z-50 pt-4 px-4">

    <div class="max-w-7xl mx-auto bg-white/90 backdrop-blur-md border border-gray-100 shadow-lg rounded-[30px] px-4 md:px-6 lg:px-10">
        <div class="flex justify-between items-center h-20">

            <div class="shrink-0 flex items-center">
                <a href="{{ route('welcome') }}">
                    <img src="{{ asset('images/logocuci.png') }}" class="h-11 md:h-12 w-auto" alt="Logo Laundry">
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-6 lg:space-x-8">
                <x-nav-link href="{{ route('welcome') }}" class="text-gray-700 hover:text-[#F6921E]">Beranda</x-nav-link>
                <x-nav-link href="{{ url('/#tentang-kami') }}" class="text-gray-700 hover:text-[#F6921E]">Tentang Kami</x-nav-link>
                <x-nav-link href="{{ url('/#layanan') }}" class="text-gray-700 hover:text-[#F6921E]">Layanan</x-nav-link>
                <x-nav-link href="{{ route('tracking.index') }}" class="text-gray-700 hover:text-[#F6921E]">Lacak</x-nav-link>
                <x-nav-link href="{{ url('/#kontak') }}" class="text-gray-700 hover:text-[#F6921E]">Kontak</x-nav-link>
            </div>

            <div class="flex items-center space-x-2 md:space-x-4">
                @auth
                <div class="flex items-center space-x-2 md:space-x-4">
                    <span class="text-sm font-bold text-blueDark italic">Halo, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-3 py-1.5 md:px-4 md:py-2 rounded-full text-[10px] md:text-xs font-bold hover:bg-red-600 transition shadow-sm whitespace-nowrap">
                            Keluar
                        </button>
                    </form>
                </div>
                @else
                <div class="hidden md:flex items-center gap-3">
                    <button @click="showLogin = true" class="px-6 py-2.5 font-bold text-gray-700 hover:text-[#F6921E] transition-all">
                        Masuk
                    </button>
                    <button @click="showRegister = true" class="px-6 py-2.5 bg-[#F6921E] text-white font-bold rounded-full shadow-md hover:bg-[#e08419] transition-all">
                        Daftar
                    </button>
                </div>
                @endauth

                <div class="block md:hidden">
                    <button @click="open = ! open" class="text-gray-600 hover:text-[#F6921E] focus:outline-none p-2 rounded-xl bg-gray-50 hover:bg-orange-50 transition-all flex items-center justify-center border border-gray-100">
                        <svg x-show="!open" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="open" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <div x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95 -translate-y-2"
        x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 transform scale-95 -translate-y-2"
        x-cloak
        class="md:hidden max-w-7xl mx-auto mt-2 bg-white/95 backdrop-blur-md border border-gray-100 shadow-xl rounded-[24px] p-3 space-y-1">

        <a href="{{ route('welcome') }}" class="block px-4 py-2.5 rounded-xl font-bold text-gray-700 hover:bg-orange-50 hover:text-[#F6921E] transition text-sm">Beranda</a>
        <a href="{{ url('/#tentang-kami') }}" class="block px-4 py-2.5 rounded-xl font-bold text-gray-700 hover:bg-orange-50 hover:text-[#F6921E] transition text-sm">Tentang Kami</a>
        <a href="{{ url('/#layanan') }}" class="block px-4 py-2.5 rounded-xl font-bold text-gray-700 hover:bg-orange-50 hover:text-[#F6921E] transition text-sm">Layanan</a>
        <a href="{{ route('tracking.index') }}" class="block px-4 py-2.5 rounded-xl font-bold text-[#F6921E] bg-orange-50/60 transition text-sm">Lacak</a>
        <a href="{{ url('/#kontak') }}" class="block px-4 py-2.5 rounded-xl font-bold text-gray-700 hover:bg-orange-50 hover:text-[#F6921E] transition text-sm">Kontak</a>

        @guest
        <hr class="border-gray-100 my-2">
        <div class="grid grid-cols-2 gap-2 pt-1">
            <button @click="open = false; showLogin = true" class="w-full py-2.5 font-bold text-gray-700 hover:bg-gray-50 rounded-xl text-xs transition">
                Masuk
            </button>
            <button @click="open = false; showRegister = true" class="w-full py-2.5 bg-[#F6921E] text-white font-bold rounded-xl text-xs text-center hover:bg-[#e08419] transition">
                Daftar
            </button>
        </div>
        @endguest
    </div>

    <div x-show="showLogin" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div @click.away="showLogin = false" class="bg-white p-2 rounded-2xl shadow-2xl relative max-w-md w-full mx-4">
            <button @click="showLogin = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            @include('auth.login')
        </div>
    </div>
    <div x-show="showRegister" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div @click.away="showRegister = false" class="bg-white p-2 rounded-2xl shadow-2xl relative max-w-md w-full mx-4">
            <button @click="showRegister = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            @include('auth.register')
        </div>
    </div>
</nav>