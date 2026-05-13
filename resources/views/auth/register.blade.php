<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - CuciYuk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
</head>
<body class="bg-[#E0F2FE] min-h-screen flex items-center justify-center py-6 px-4">

    <div class="max-h-[95vh] overflow-y-auto custom-scroll bg-white rounded-[40px] p-8 md:p-10 max-w-[750px] w-full border-2 border-[#f15a24] shadow-2xl relative">
        
        <div class="text-center mb-6">
            <h1 class="text-[26px] font-bold text-gray-900">Daftar Akun Baru</h1>
            <p class="text-gray-400 text-sm">Buat akun CuciYuk sekarang!</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-1">
                        <i class="fa-solid fa-user text-[#F6921E]"></i> Nama Depan
                    </label>
                    <input type="text" name="name" required class="w-full px-4 py-2.5 border-2 border-[#F6921E] rounded-xl outline-none focus:ring-4 focus:ring-orange-50 text-sm">
                </div>
                <div>
                    <label class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-1">
                        <i class="fa-solid fa-user text-[#F6921E]"></i> Nama Belakang
                    </label>
                    <input type="text" name="last_name" required class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl outline-none focus:border-[#F6921E] text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-1">
                        <i class="fa-solid fa-phone text-[#F6921E]"></i> No Telepon
                    </label>
                    <input type="text" name="phone" required class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl outline-none focus:border-[#F6921E] text-sm">
                </div>
                <div>
                    <label class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-1">
                        <i class="fa-solid fa-venus-mars text-[#F6921E]"></i> Jenis Kelamin
                    </label>
                    <div class="flex gap-4 items-center h-[42px]">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="gender" value="perempuan" class="w-4 h-4 accent-[#F6921E]">
                            <span class="ms-2 text-sm text-gray-600">Perempuan</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="gender" value="laki-laki" class="w-4 h-4 accent-[#F6921E]">
                            <span class="ms-2 text-sm text-gray-600">Laki-Laki</span>
                        </label>
                    </div>
                </div>
            </div>

            <div>
                <label class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-1">
                    <i class="fa-solid fa-envelope text-[#F6921E]"></i> Email
                </label>
                <input type="email" name="email" required class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl outline-none focus:border-[#F6921E] text-sm">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-1">
                        <i class="fa-solid fa-lock text-[#F6921E]"></i> Password
                    </label>
                    <input type="password" name="password" required class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl outline-none focus:border-[#F6921E] text-sm">
                </div>
                <div>
                    <label class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-1">
                        <i class="fa-solid fa-shield-check text-[#F6921E]"></i> Konfirmasi
                    </label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl outline-none focus:border-[#F6921E] text-sm">
                </div>
            </div>

            <button type="submit" class="w-full bg-[#F6921E] hover:bg-[#d64a1b] text-white font-bold py-3.5 rounded-2xl shadow-lg transition-all active:scale-95 text-md mt-4">
                Daftar Sekarang
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-[#F6921E] font-bold text-sm hover:underline">
                Sudah Punya Akun? Masuk Disini
            </a>
        </div>
    </div>
</body>
</html>