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
                <div class="mb-5">
                    <label class="flex items-center gap-2 text-sm text-gray-600 mb-2 font-medium">
                        <i class="ti ti-user-circle text-lg"></i> Email
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="ti ti-user"></i>
                        </span>
                        <input type="email" name="email" required placeholder="Contoh: Example@gmail.com"
                            class="w-full pl-11 pr-4 py-3 border-2 border-[#F6921E] rounded-2xl focus:ring-4 focus:ring-orange-100 outline-none text-sm transition-all">
                    </div>
                </div>

                <div class="mb-8 text-left" x-data="{ showPass: false }">
                    <label class="flex items-center gap-2 text-sm text-gray-600 mb-2 font-medium">
                        Password
                    </label>
                    <div class="relative">
                        <input :type="showPass ? 'text' : 'password'" name="password" required placeholder="Masukkan password"
                            class="w-full pl-4 pr-12 py-3 border-2 border-[#F6921E] rounded-2xl outline-none text-sm transition-all">

                        <button type="button" @click="showPass = !showPass" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#F6921E] transition-colors">

                            <svg x-show="!showPass" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>

                            <svg x-show="showPass" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" x-cloak>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.4M9.9 4.24a9.122 9.122 0 012.1-.24c4.478 0 8.268 2.943 9.542 7a10.035 10.035 0 01-4.426 5.58M3 3l18 18" />
                            </svg>

                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#F6921E] hover:bg-[#e07e0d] text-white font-bold py-4 rounded-full shadow-lg shadow-orange-200 transition-all active:scale-95">
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