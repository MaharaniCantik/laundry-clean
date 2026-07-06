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

        <div class="bg-white rounded-[32px] shadow-2xl p-7 border-2 border-[#F6921E]">
            <div class="text-center mb-5">
                <h1 class="text-[22px] font-bold text-gray-900">Daftar Akun Baru</h1>
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

                <div class="mb-3.5" x-data="{ showPass: false }">
                    <label class="block text-xs text-gray-600 mb-1.5 font-medium ml-1">Password</label>
                    <div class="relative">
                        <input :type="showPass ? 'text' : 'password'" name="password" required placeholder="Masukan Password"
                            class="w-full pl-4 pr-12 py-2.5 border-2 border-[#F6921E] rounded-2xl outline-none text-sm transition-all focus:ring-2 focus:ring-orange-100">

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

                <div class="mb-6" x-data="{ showConfirmPass: false }">
                    <label class="block text-xs text-gray-600 mb-1.5 font-medium ml-1">Ulangi Password</label>
                    <div class="relative">
                        <input :type="showConfirmPass ? 'text' : 'password'" name="password_confirmation" required placeholder="Konfirmasi Password"
                            class="w-full pl-4 pr-12 py-2.5 border-2 border-[#F6921E] rounded-2xl outline-none text-sm transition-all focus:ring-2 focus:ring-orange-100">

                        <button type="button" @click="showConfirmPass = !showConfirmPass" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#F6921E] transition-colors">
                            <svg x-show="!showConfirmPass" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showConfirmPass" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" x-cloak>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.4M9.9 4.24a9.122 9.122 0 012.1-.24c4.478 0 8.268 2.943 9.542 7a10.035 10.035 0 01-4.426 5.58M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
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