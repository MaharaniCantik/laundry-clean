<div x-show="showRegister" 
     x-cloak
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 overflow-y-auto"
     style="background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px);">
    
    <div @click.away="showRegister = false" 
         x-show="showRegister"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         class="relative w-full max-w-[420px] my-auto"> <button @click="showRegister = false" class="absolute top-4 right-4 text-gray-400 hover:text-[#F6921E] transition-colors z-50 text-2xl">
            ✕
        </button>

        <div class="bg-white rounded-[32px] shadow-2xl p-7 border-2 border-[#F6921E]"> <div class="text-center mb-5"> <h1 class="text-[22px] font-bold text-gray-900">Daftar Akun Baru</h1>
                <p class="text-xs text-gray-400 mt-1">Gabung bersama CuciYuk sekarang</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="mb-3.5"> <label class="block text-xs text-gray-600 mb-1.5 font-medium ml-1">Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Masukan Nama Anda" 
                        class="w-full px-4 py-2.5 border-2 border-[#F6921E] rounded-2xl outline-none text-sm transition-all focus:ring-2 focus:ring-orange-100">
                </div>

                <div class="mb-3.5">
                    <label class="block text-xs text-gray-600 mb-1.5 font-medium ml-1">Email</label>
                    <input type="email" name="email" required placeholder="user@gmail.com" 
                        class="w-full px-4 py-2.5 border-2 border-[#F6921E] rounded-2xl outline-none text-sm transition-all focus:ring-2 focus:ring-orange-100">
                </div>

                <div class="mb-3.5">
                    <label class="block text-xs text-gray-600 mb-1.5 font-medium ml-1">Password</label>
                    <input type="password" name="password" required placeholder="Masukan Password" 
                        class="w-full px-4 py-2.5 border-2 border-[#F6921E] rounded-2xl outline-none text-sm transition-all focus:ring-2 focus:ring-orange-100">
                </div>

                <div class="mb-6">
                    <label class="block text-xs text-gray-600 mb-1.5 font-medium ml-1">Ulangi Password</label>
                    <input type="password" name="password_confirmation" required placeholder="Konfirmasi Password" 
                        class="w-full px-4 py-2.5 border-2 border-[#F6921E] rounded-2xl outline-none text-sm transition-all focus:ring-2 focus:ring-orange-100">
                </div>

                <button type="submit" class="w-full bg-[#F6921E] hover:bg-[#e07e0d] text-white font-bold py-3.5 rounded-full shadow-lg transition-all active:scale-95">
                    Daftar
                </button>
            </form>

            <div class="mt-5 text-center">
                <button type="button" 
                        @click="showRegister = false; setTimeout(() => { showLogin = true }, 50)" 
                        class="text-[#F6921E] text-xs font-bold hover:underline">
                    Sudah Punya Akun? Masuk Disini
                </button>
            </div>
        </div>
    </div>
</div>