<x-owner-layout>
    <main class="ml-[260px] min-h-screen flex flex-col">
        <header class="h-16 px-8 flex justify-between items-center bg-surface dark:bg-inverse-surface border-b border-outline-variant dark:border-outline sticky top-0 z-40">
            <div class="flex items-center gap-4 flex-1">
                <div class="relative w-full max-w-md group">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant group-focus-within:text-primary transition-colors">search</span>
                    <input class="w-full bg-surface-container-low border-none rounded-full pl-10 pr-4 py-2 text-body-sm font-body-sm focus:ring-2 focus:ring-primary outline-none transition-all" placeholder="Cari transaksi atau pelanggan..." type="text"/>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <button class="relative text-on-surface-variant hover:text-primary transition-colors p-2 rounded-full hover:bg-surface-container-highest">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-surface"></span>
                </button>
                <div class="h-8 w-[1px] bg-outline-variant"></div>
                <div class="flex items-center gap-3">
                    <span class="font-title-sm text-title-sm font-semibold text-on-surface">CleanFlow</span>
                    <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-on-primary font-bold">C</div>
                </div>
            </div>
        </header>

        <div class="p-8 max-w-container-max w-full mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
                <div>
                    <h2 class="font-display-lg text-display-lg text-on-surface">Laporan Keuangan</h2>
                    <p class="text-on-surface-variant font-body-md text-body-md">Analisis performa pendapatan dan arus kas bisnis Anda secara real-time.</p>
                </div>
                <div class="bg-surface-container-lowest px-4 py-3 rounded-xl shadow-sm border border-outline-variant flex items-center gap-3">
                    <span class="flex h-3 w-3 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                    <span class="text-xs font-label-bold text-on-surface-variant uppercase tracking-wider">Engine Real-Time Active</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant flex flex-col gap-2 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <span class="font-label-bold text-label-bold text-on-surface-variant">ORDER HARI INI</span>
                        <div class="w-10 h-10 rounded-full bg-primary/5 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">shopping_cart</span>
                        </div>
                    </div>
                    <p id="kpi-hari-ini" class="font-headline-md text-headline-md text-on-surface">...</p>
                    <div class="text-[10px] text-green-600 font-label-bold flex items-center gap-1 animate-pulse">● Live Stream</div>
                </div>

                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant flex flex-col gap-2 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <span class="font-label-bold text-label-bold text-on-surface-variant">TOTAL DONE (ALL)</span>
                        <div class="w-10 h-10 rounded-full bg-primary/5 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">check_circle</span>
                        </div>
                    </div>
                    <p id="kpi-selesai" class="font-headline-md text-headline-md text-on-surface">...</p>
                    <div class="text-[10px] text-on-surface-variant font-body-sm">Terproses lunas</div>
                </div>

                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant flex flex-col gap-2 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <span class="font-label-bold text-label-bold text-on-surface-variant">PEMBAYARAN CASH</span>
                        <div class="w-10 h-10 rounded-full bg-primary/5 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">payments</span>
                        </div>
                    </div>
                    <p class="font-headline-md text-headline-md text-on-surface">Rp 18.200.000</p>
                    <div class="text-[10px] text-[#dc2626] font-label-bold">Target Terpantau</div>
                </div>

                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant flex flex-col gap-2 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <span class="font-label-bold text-label-bold text-on-surface-variant">PEMBAYARAN QRIS</span>
                        <div class="w-10 h-10 rounded-full bg-primary/5 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">qr_code_2</span>
                        </div>
                    </div>
                    <p class="font-headline-md text-headline-md text-on-surface">Rp 24.650.000</p>
                    <div class="text-[10px] text-[#059669] font-label-bold">Auto-matching</div>
                </div>
            </div>

            <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant overflow-hidden">
                <div class="px-6 py-4 border-b border-outline-variant flex items-center justify-between bg-surface-container-low">
                    <h3 class="font-title-sm text-title-sm font-semibold text-on-surface">Riwayat Transaksi Real-time (Supabase)</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low/50">
                                <th class="px-6 py-4 font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">ID Transaksi</th>
                                <th class="px-6 py-4 font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Nama Pelanggan</th>
                                <th class="px-6 py-4 font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider text-center">Metode</th>
                                <th class="px-6 py-4 font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider text-right">Nominal</th>
                                <th class="px-6 py-4 font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody id="realtime-table-body" class="divide-y divide-outline-variant">
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-on-surface-variant text-sm">Menghubungkan ke core engine CleanFlow...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        async function fetchLaporanRealtime() {
            try {
                const response = await fetch("{{ route('owner.api.orders') }}");
                const data = await response.json();

                // 1. Update KPI Box Atas
                document.getElementById('kpi-hari-ini').innerText = data.kpi.total_hari_ini + " Order";
                document.getElementById('kpi-selesai').innerText = data.kpi.total_selesai + " Done";

                // 2. Render Data Tabel Finansial
                const tableBody = document.getElementById('realtime-table-body');
                let tableRowsHtml = '';

                if (data.orders.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-10 text-center text-on-surface-variant text-sm">Belum ada data order masuk.</td></tr>`;
                    return;
                }

                data.orders.forEach(order => {
                    // Set up badge status style
                    let badgeStyle = 'bg-surface-container-highest text-on-surface-variant';
                    if (order.status === 'Selesai') {
                        badgeStyle = 'bg-[#d1fae5] text-[#065f46]';
                    } else if (order.status === 'Sedang Dicuci' || order.status === 'Proses') {
                        badgeStyle = 'bg-secondary-container text-on-secondary-container';
                    }

                    // Ambil inisial nama customer
                    const initials = order.nama_pelanggan ? order.nama_pelanggan.substring(0, 2).toUpperCase() : 'CF';

                    tableRowsHtml += `
                        <tr class="hover:bg-primary/5 transition-colors group">
                            <td class="px-6 py-4 font-data-tabular text-data-tabular text-primary font-mono text-xs">${order.nomor_resi ?? '#REF'}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center font-bold text-[10px] text-primary">${initials}</div>
                                    <span class="font-body-md text-body-md text-on-surface">${order.nama_pelanggan}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full bg-secondary-container text-on-secondary-container font-label-bold text-[10px] inline-flex items-center gap-1 uppercase">
                                    <span class="material-symbols-outlined text-[12px]">payments</span> ${order.metode_pembayaran ?? 'CASH'}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-data-tabular text-data-tabular text-on-surface text-right font-semibold">Rp ${Number(order.total_harga).toLocaleString('id-ID')}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full font-label-bold text-[10px] uppercase tracking-wider ${badgeStyle}">
                                    ${order.status}
                                </span>
                            </td>
                        </tr>
                    `;
                });

                tableBody.innerHTML = tableRowsHtml;

            } catch (error) {
                console.error("Gagal melakukan polling data finansial:", error);
            }
        }

        // Jalankan engine pertama kali & ulangi tiap 4 detik
        fetchLaporanRealtime();
        setInterval(fetchLaporanRealtime, 4000);
    </script>
</x-owner-layout>