<div x-show="showLogin" 
     x-cloak
     class="fixed inset-0 z-[100] flex items-center justify-center p-4"
     style="background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px);">
    
    <div @click.away="showLogin = false" 
         x-show="showLogin"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         class="relative w-full max-w-[420px]">
        
        <button @click="showLogin = false" class="absolute -top-2 -right-2 bg-[#F6921E] text-white rounded-full w-8 h-8 flex items-center justify-center shadow-lg hover:bg-[#e07e0d] z-50">
            ✕
        </button>

        <div class="bg-white rounded-[32px] shadow-2xl p-10 border-2 border-[#F6921E]">
            <div class="text-center mb-8">
                <h1 class="text-[24px] font-bold text-gray-900">Masuk Ke Akun Anda</h1>
                <p class="text-sm text-gray-400 mt-1">Masukan Email dan Password Untuk Melanjutkan</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-5 text-left">
                    <label class="flex items-center gap-2 text-sm text-gray-600 mb-2 font-medium">
                         Email
                    </label>
                    <div class="relative">
                        <input type="email" name="email" required placeholder="Contoh: Example@gmail.com" 
                            class="w-full px-4 py-3 border-2 border-[#F6921E] rounded-2xl outline-none text-sm transition-all">
                    </div>
                </div>

                <div class="mb-8 text-left" x-data="{ showPass: false }">
                    <label class="flex items-center gap-2 text-sm text-gray-600 mb-2 font-medium">
                        Password
                    </label>
                    <div class="relative">
                        <input :type="showPass ? 'text' : 'password'" name="password" required 
                            class="w-full px-4 py-3 border-2 border-[#F6921E] rounded-2xl outline-none text-sm transition-all">
                        <button type="button" @click="showPass = !showPass" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                             </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#F6921E] text-white font-bold py-4 rounded-full shadow-lg">
                    Masuk
                </button>
            </form>

            <div class="mt-8 text-center space-y-3">
                <a href="{{ route('password.request') }}" class="block text-[#F6921E] text-sm font-bold hover:underline">Lupa Password?</a>
                <button type="button" 
                        @click="showLogin = false; setTimeout(() => { showRegister = true }, 50)" 
                        class="block text-[#F6921E] text-sm font-bold hover:underline mx-auto">
                    Belum Punya Akun? Daftar Disini
                </button>
            </div>
        </div>
    </div>
</div>