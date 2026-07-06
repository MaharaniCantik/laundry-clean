<x-owner-layout>
    <x-slot name="title">Executive Summary Owner</x-slot>

    <div class="max-w-[1440px] mx-auto">
        <header class="mb-8">
            <h2 class="text-3xl font-bold text-primary">Ringkasan Eksekutif</h2>
            <p class="text-sm text-on-surface-variant">Data real-time operasional CleanFlow hari ini.</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 rounded-lg bg-primary/5 text-primary">
                        <span class="material-symbols-outlined text-3xl">payments</span>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold text-on-surface-variant uppercase mb-1">Total Pendapatan</p>
                    <h3 class="text-2xl font-bold text-primary">Rp 42.850.000</h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 rounded-lg bg-primary/5 text-primary">
                        <span class="material-symbols-outlined text-3xl">receipt_long</span>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold text-on-surface-variant uppercase mb-1">Total Transaksi</p>
                    <h3 class="text-2xl font-bold text-primary">1.248</h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 rounded-lg bg-primary/5 text-primary">
                        <span class="material-symbols-outlined text-3xl">group</span>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold text-on-surface-variant uppercase mb-1">Jumlah Pelanggan</p>
                    <h3 class="text-2xl font-bold text-primary">852</h3>
                </div>
            </div>
        </div>

        </div>
</x-owner-layout>