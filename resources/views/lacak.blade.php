<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Status Laundry - CuciYuk</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn 0.4s ease-out forwards; }
    </style>
</head>
<body class="min-h-screen bg-[#E2F3FC]" x-data="{ showLogin: false, showRegister: false }">
    @include('partials.navbar')
    <main class="relative pt-32 pb-12 flex items-center justify-center">
        <div class="bg-white w-full max-w-md rounded-[32px] shadow-2xl p-8 border-2 border-white">
             <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Lacak Laundry</h1>
                <p class="text-sm text-gray-500">Masukkan nomor nota anda</p>
             </div>

             <div class="space-y-4">
                <input type="text"placeholder="Contoh: KN-001" id="resi" class="w-full px-5 py-4 rounded-2xl border-2 border-gray-100 outline-none focus:border-[#F6921E] uppercase font-bold ">
                <button id="btn-lacak" class="w-full bg-[#F6921E] text-white font-bold py-4 rounded-2xl shadow-lg">
                    Lacak Sekarang
                </button>
             </div>

             <div id="hasil-lacak" class="hidden mt-8 pt-8 border-t-2 border-dashed">
                <h3 class="font-bold text-gray-800">Status Pesanan: <span id="display-resi" class="text-[#F6921E]"></span></h3>
             </div>
                <p id="error-message" class="text-red-500 text-xs mt-2 hidden">Nomor resi wajib diisi!</p>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btnLacak = document.getElementById('btn-lacak');
            const inputResi = document.getElementById('resi');
            const errorMessage = document.getElementById('error-message');
            const hasilLacak = document.getElementById('hasil-lacak');
            const displayResi = document.getElementById('display-resi');

            btnLacak.addEventListener('click', () => {
                const resiValue = inputResi.value.trim();

                // Reset state
                errorMessage.classList.add('hidden');
                hasilLacak.classList.add('hidden');
                hasilLacak.classList.remove('fade-in');

                // Validasi input kosong
                if (!resiValue) {
                    errorMessage.classList.remove('hidden');
                    inputResi.focus();
                    return;
                }

                // Efek loading pada tombol
                const originalText = btnLacak.innerHTML;
                btnLacak.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Mencari...
                `;
                btnLacak.disabled = true;

                // Simulasi delay pencarian ke database (1.5 detik)
                setTimeout(() => {
                    // Kembalikan tombol ke semula
                    btnLacak.innerHTML = originalText;
                    btnLacak.disabled = false;

                    // Tampilkan hasil
                    displayResi.textContent = resiValue.toUpperCase();
                    hasilLacak.classList.remove('hidden');
                    hasilLacak.classList.add('fade-in');
                }, 1000);
            });

            // Memungkinkan tekan 'Enter' untuk melacak
            inputResi.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    btnLacak.click();
                }
            });
        });
    </script>   
</body>
</html>