<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .title { font-size: 18px; font-weight: bold; color: #1e3a8a; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-right { text-align: right; }
    </style>
</head>
<body>

    <div class="header">
        <div class="title">LAPORAN KEUANGAN CLEANFLOW</div>
        <p>Tanggal Cetak: {{ date('d F Y') }}</p>
    </div>

    <table>
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 15%;">ID Transaksi</th>
            <th style="width: 25%;">Nama Pelanggan</th>
            <th style="width: 25%;">Tanggal Lunas</th>
            <th style="width: 15%;">Metode</th>
            <th style="width: 15%;">Nominal</th>
        </tr>
    </thead>
    <tbody>
        @forelse($laporan as $index => $item)
        <tr>
            <td style="text-align: center;">{{ $index + 1 }}</td>
            <td>#{{ $item->id }}</td> {{-- Kalau di database namanya id_transaksi, ganti jadi $item->id_transaksi --}}
            <td>{{ $item->nama_pelanggan }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal_lunas ?? $item->created_at)->format('d M Y, H:i') }}</td>
            <td style="text-align: center;">{{ strtoupper($item->metode_pembayaran) }}</td>
            <td style="text-align: right; font-weight: bold;">Rp {{ number_format($item->nominal ?? $item->total_harga, 0, ',', '.') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align: center; padding: 20px;">Belum ada riwayat transaksi untuk periode ini.</td>
        </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>