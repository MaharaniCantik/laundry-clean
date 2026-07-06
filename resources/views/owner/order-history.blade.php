<x-owner-layout>
    <x-slot name="title">Arsip Riwayat Order - CleanFlow</x-slot>

    <div class="max-w-container-max mx-auto w-full p-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Arsip Riwayat Order</h2>
                <p class="text-sm text-gray-500">Pantau seluruh transaksi laundry pelanggan secara real-time langsung dari database.</p>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-6">
            
            <div class="col-span-12 lg:col-span-3 space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-500">Total Order Hari Ini</p>
                    <h4 id="kpi-hari-ini" class="text-2xl font-bold text-gray-900 mt-1">...</h4>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-500">Order Selesai</p>
                    <h4 id="kpi-selesai" class="text-2xl font-bold text-gray-900 mt-1">...</h4>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-9">
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="font-semibold text-gray-800">Daftar Transaksi Masuk (Auto-Sync)</h3>
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b border-gray-200">
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase">Nomor Resi</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase">Nama Pelanggan</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase">Berat Laundry</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase">Total Harga</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody id="realtime-order-table" class="divide-y divide-gray-100">
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400">Sinkronisasi database CleanFlow...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        async function loadCleanFlowData() {
            try {
                const response = await fetch("{{ route('owner.api.orders') }}");
                const data = await response.json();
                
                document.getElementById('kpi-hari-ini').innerText = data.kpi.total_hari_ini;
                document.getElementById('kpi-selesai').innerText = data.kpi.total_selesai;

                const tableBody = document.getElementById('realtime-order-table');
                let rowsHtml = '';

                if (data.orders.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-10 text-center text-gray-400">Belum ada transaksi masuk.</td></tr>`;
                    return;
                }

                data.orders.forEach(order => {
                    let badgeStyle = 'bg-amber-100 text-amber-700 border border-amber-200';
                    if (order.status === 'Selesai') {
                        badgeStyle = 'bg-green-100 text-green-700 border border-green-200';
                    } else if (order.status === 'Sedang Dicuci' || order.status === 'Proses') {
                        badgeStyle = 'bg-blue-100 text-blue-700 border border-blue-200';
                    }

                    // Ambil inisial dari kolom nama_pelanggan lo yang asli
                    const initials = order.nama_pelanggan ? order.nama_pelanggan.substring(0, 2).toUpperCase() : 'CF';

                    rowsHtml += `
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 font-mono text-sm text-blue-900 font-semibold">${order.nomor_resi ?? '#REF'}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-900 text-white flex items-center justify-center font-bold text-xs">${initials}</div>
                                    <span class="text-sm font-medium text-gray-900">${order.nama_pelanggan}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">${order.berat_laundry ?? 0} Kg</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rp ${Number(order.total_harga).toLocaleString('id-ID')}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase ${badgeStyle}">
                                    ${order.status}
                                </span>
                            </td>
                        </tr>
                    `;
                });

                tableBody.innerHTML = rowsHtml;

            } catch (error) {
                console.error("Koneksi gagal:", error);
            }
        }

        loadCleanFlowData();
        setInterval(loadCleanFlowData, 4000); // Polling update tiap 4 detik
    </script>
</x-owner-layout>