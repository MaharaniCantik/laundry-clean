<x-owner-layout>
    <main class="p-8 max-w-[1440px] mx-auto animate-fadeIn">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-on-surface">Dashboard Owner</h2>
            <p class="text-sm text-on-surface-variant">Ringkasan performa bisnis CleanFlow hari ini.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
            <div class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant">
                <span class="text-xs font-bold text-on-surface-variant block mb-1">TOTAL PENDAPATAN</span>
                <p class="text-xl font-bold text-on-surface">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
            </div>
            <div class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant">
                <span class="text-xs font-bold text-on-surface-variant block mb-1">TOTAL TRANSAKSI</span>
                <p class="text-xl font-bold text-on-surface">{{ $totalTransaksi }}</p>
            </div>
            <div class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant">
                <span class="text-xs font-bold text-on-surface-variant block mb-1">TOTAL PELANGGAN</span>
                <p class="text-xl font-bold text-on-surface">{{ $jumlahPelanggan }}</p>
            </div>
            <div class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant border-l-4 border-l-primary">
                <span class="text-xs font-bold text-primary block mb-1">ORDER HARI INI</span>
                <p class="text-xl font-bold text-on-surface">{{ $orderHariIni }}</p>
            </div>
            <div class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant border-l-4 border-l-warning">
                <span class="text-xs font-bold text-yellow-600 block mb-1">SEDANG DIPROSES</span>
                <p class="text-xl font-bold text-on-surface">{{ $orderBekerja }} Antrean</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-surface-container-lowest p-6 rounded-xl border border-outline-variant">
            <h3 class="font-bold text-md mb-4">Tren Pendapatan (7 Hari Terakhir)</h3>
            <div class="relative w-full h-64">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

            <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant">
                <h3 class="font-bold text-md mb-4">Order Terbaru</h3>
                <div class="flex flex-col gap-3">
                    @foreach($latestOrders as $order)
                    <div class="flex items-center justify-between p-3 bg-surface-container-low rounded-lg text-sm">
                        <div>
                            <p class="font-semibold text-on-surface">{{ $order->nama_pelanggan }}</p>
                            <p class="text-xs text-on-surface-variant">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                        </div>
                        <span class="text-xs px-2 py-1 rounded bg-primary/10 text-primary font-medium">{{ $order->status }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Mengambil data dari PHP Laravel ke JavaScript (di-encode ke JSON)
        const labels = {!! json_encode($chartLabels) !!};
        const dataValues = {!! json_encode($chartData) !!};

        const ctx = document.getElementById('revenueChart').getContext('2d');
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: dataValues,
                    borderColor: '#0284c7', // Warna garis (Primary Tailwind Sky-600)
                    backgroundColor: 'rgba(2, 132, 199, 0.1)', // Warna bayangan di bawah garis
                    borderWidth: 3,
                    fill: true,
                    tension: 0.3, // Membuat garis sedikit melengkung halus (smooth)
                    pointBackgroundColor: '#0284c7',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Sembunyikan label kotak atas biar clean
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // Format angka Y-Axis jadi ribuan (e.g. 50.000)
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            },
                            font: { size: 11 }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)' // Garis bantu tipis horizontal
                        }
                    },
                    x: {
                        ticks: { font: { size: 11 } },
                        grid: { display: false } // Sembunyikan garis bantu vertikal biar rapi
                    }
                }
            }
        });
    });
</script>
</x-owner-layout>