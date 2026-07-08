<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        
        /* --- CSS BARU UNTUK KOP SURAT --- */
        .kop-surat { 
            border-bottom: 3px double #333; /* Garis ganda khas kop surat resmi */
            padding-bottom: 10px; 
            margin-bottom: 20px; 
            overflow: hidden;
        }
        .kop-detail {
            text-align: center;
        }
        .nama-toko { 
            font-size: 22px; 
            font-weight: bold; 
            color: #1e3a8a; 
            text-transform: uppercase;
            margin: 0 0 5px 0;
        }
        .alamat-toko { 
            font-size: 11px; 
            color: #555; 
            margin: 0 0 5px 0;
            line-height: 1.4;
        }
        .kontak-toko { 
            font-size: 11px; 
            font-weight: bold;
            color: #333; 
            margin: 0;
        }
        
        /* --- STYLE BAWAN KAMU --- */
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 16px; font-weight: bold; color: #333; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-right { text-align: right; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <div class="kop-detail">
            <h1 class="nama-toko">Nugraha Laundry</h1>
            <p class="alamat-toko">
                Jl. Aria Santika No.34, RT.003/RW.03, Margasari, Kec. Karawaci, Kota Tangerang, Banten 15113
            </p>
            <p class="kontak-toko">
                WhatsApp: +62 82324347254 | Email: nugrahalaundry@gmail.com
            </p>
        </div>
    </div>
    <div class="header">
        <div class="title">LAPORAN KEUANGAN CLEANFLOW</div>
        <p style="margin: 5px 0 0 0; color: #666;">Tanggal Cetak: {{ date('d F Y') }}</p>
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
            <td>#{{ $item->id }}</td>
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