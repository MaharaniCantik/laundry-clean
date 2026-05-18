<nav x-data="{ open: false, showLogin: false, showRegister: false }" class="sticky top-0 w-full z-50 pt-4 px-4">
    
    <div class="max-w-7xl mx-auto bg-white/90 backdrop-blur-md border border-gray-100 shadow-lg rounded-[30px] px-6 lg:px-10">
        <div class="flex justify-between items-center h-20">
            
            <div class="shrink-0 flex items-center">
                <a href="{{ route('welcome') }}">
                    <img src="{{ asset('images/logocuci.png') }}" class="h-12 w-auto" alt="Logo Laundry">
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-6 lg:space-x-8">
                <x-nav-link href="{{ route('welcome') }}" class="text-gray-700 hover:text-[#F6921E]">Beranda</x-nav-link>
                <x-nav-link href="{{ url('/#tentang-kami') }}" class="text-gray-700 hover:text-[#F6921E]">Tentang Kami</x-nav-link>
                <x-nav-link href="{{ url('/#layanan') }}" class="text-gray-700 hover:text-[#F6921E]">Layanan</x-nav-link>
                <x-nav-link href="{{ route('lacak') }}" class="text-gray-700 hover:text-[#F6921E]">Lacak</x-nav-link>
                <x-nav-link href="{{ url('/#kontak') }}" class="text-gray-700 hover:text-[#F6921E]">Kontak</x-nav-link>
            </div>

            <div class="flex items-center">
                @auth
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-bold text-blueDark italic">Halo, {{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-full text-xs font-bold hover:bg-red-600 transition">Keluar</button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center gap-3">
                        <button @click="showLogin = true" class="px-6 py-2.5 font-bold text-gray-700 hover:text-[#F6921E] transition-all">
                            Masuk
                        </button>
                        
                        <button @click="showRegister = true" class="px-6 py-2.5 bg-[#F6921E] text-white font-bold rounded-full shadow-md hover:bg-[#e08419] transition-all">
                            Daftar
                        </button>
                    </div>
                @endauth

                <div class="flex items-center md:hidden ml-4">
                    <button @click="open = ! open" class="text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div x-show="showLogin" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div @click.away="showLogin = false" class="bg-white p-2 rounded-2xl shadow-2xl relative max-w-md w-full mx-4">
            <button @click="showLogin = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">&times;</button>
            
            @include('auth.login') </div>
    </div>

    <div x-show="showRegister" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div @click.away="showRegister = false" class="bg-white p-2 rounded-2xl shadow-2xl relative max-w-md w-full mx-4">
            <button @click="showRegister = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">&times;</button>
            
            @include('auth.register') </div>
    </div>
</nav>