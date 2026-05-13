<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CuciYuk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
</head>
<body class="bg-skyBg min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-[32px] shadow-2xl p-10 max-w-[420px] w-full border-2 border-[#F6921E] relative">
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
                    <input type="email" name="email" required placeholder="Contoh: user@gmail.com" 
                        class="w-full pl-11 pr-4 py-3 border-2 border-[#F6921E] rounded-2xl focus:ring-4 focus:ring-orange-100 outline-none text-sm transition-all">
                </div>
            </div>

            <div class="mb-8" x-data="{ showPass: false }">
                <label class="flex items-center gap-2 text-sm text-gray-600 mb-2 font-medium">
                    <i class="ti ti-lock text-lg"></i> Password
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <i class="ti ti-lock"></i>
                    </span>
                    <input :type="showPass ? 'text' : 'password'" name="password" required placeholder="Masukan Password Anda" 
                        class="w-full pl-11 pr-12 py-3 border-2 border-[#F6921E] rounded-2xl focus:ring-4 focus:ring-orange-100 outline-none text-sm transition-all">
                    
                    <button type="button" @click="showPass = !showPass" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#F6921E]">
                        <i :class="showPass ? 'ti ti-eye-off' : 'ti ti-eye'" class="text-xl"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-[#F6921E] hover:bg-[#e07e0d] text-white font-bold py-4 rounded-full shadow-lg shadow-orange-200 transition-all active:scale-95">
                Masuk
            </button>
        </form>

        <div class="mt-8 text-center space-y-3">
            <a href="{{ route('password.request') }}" class="block text-[#F6921E] text-sm font-bold hover:underline">Lupa Password?</a>
            <a href="{{ route('register') }}" class="block text-[#F6921E] text-sm font-bold hover:underline mx-auto">
                Belum Punya Akun? Daftar Disini
            </a>
        </div>
    </div>

    @include('partials.scripts')
</body>
</html>