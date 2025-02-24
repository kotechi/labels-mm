{{-- resources/views/reports/financial-report.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan</title>
    <style>
        .chart-container {
            margin: 20px 0;
            text-align: center;
        }
        
        .chart-container img {
            max-width: 100%;
            height: auto;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .summary-box {  
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        .page-break {
            page-break-after: always;
        }
        .chart-container {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Keuangan</h1>
        <p>Periode: {{ $periode }}</p>
    </div>

    <div class="summary-box">
        <h3>Ringkasan Keuangan</h3>
        <table>
            <tr>
                <td><strong>Total Pemasukan:</strong></td>
                <td>Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Total Pengeluaran:</strong></td>
                <td>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Total Penghasilan:</strong></td>
                <td>Rp {{ number_format($totalPenghasilan, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div class="page-break"></div>

    <h3>Grafik Keuangan</h3>
    <div class="chart-container">
        <img src="data:image/png;base64,{{ $chartImage }}" alt="Grafik Keuangan">
    </div>

    <h3>Daftar Pesanan Terbaru</h3>
    <table>
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>User</th>
                <th>Produk</th>
                <th>Status</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanans as $pesanan)
            <tr>
                <td>{{ $pesanan->id_pesanan }}</td>
                <td>{{ $pesanan->nama_pemesan }}</td>
                <td>{{ $pesanan->nama_produk }}</td>
                <td>{{ $pesanan->status_pesanan }}</td>
                <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>

    <h3>Transaksi Terbaru</h3>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Pelaku</th>
                <th>Keterangan</th>
                <th>Nominal</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $transaksi)
            <tr>
                <td>{{ $transaksi->kategori }}</td>
                <td>{{ $transaksi->user->nama_lengkap }}</td>
                <td>{{ $transaksi->keterangan }}</td>
                <td>Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}</td>
                <td>{{ $transaksi->tanggal }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Analisis Bulanan</h3>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>Profit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monthlyData as $data)
            <tr>
                <td>{{ Carbon\Carbon::create()->month($data->month)->format('F') }}</td>
                <td>Rp {{ number_format($data->pemasukan, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($data->pengeluaran, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($data->pemasukan - $data->pengeluaran, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
