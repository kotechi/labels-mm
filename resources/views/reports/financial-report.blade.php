<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $reportTitle }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #7D0066;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #7D0066;
            margin: 0;
            margin-bottom: 5px;
        }
        .header p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        .summary {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .summary-box {
            width: 30%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }
        .summary-box h3 {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        .summary-box p {
            margin: 10px 0 0;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .chart-container {
            margin-bottom: 30px;
            text-align: center;
        }
        .chart-container h2 {
            margin-bottom: 15px;
            color: #7D0066;
            font-size: 18px;
        }

        .monthly-charts {
            width: 32%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 10px;
        }


        .monthly-chart h3 {
            margin: 0 0 10px;
            font-size: 16px;
            color: #7D0066;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-size: 12px;
        }
        table th {
            background-color: #ffffff;
            font-weight: bold;
        }
        .page-break {
            page-break-after: always;
        }
        .chart-pemasukan {
            margin-bottom: 30px;
        }
        .chart-pengeluaran {
            margin-bottom: 30px;
        }
        .section-title {
            color: #7D0066;
            margin-top: 30px;
            margin-bottom: 20px;
            font-size: 20px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $reportTitle }}</h1>
        <p>Generated on {{ date('d F Y') }}</p>
    </div>

    <div class="summary">
        <div class="summary-box">
            <h3>Total Pemasukan</h3>
            <p>Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
        </div>
        <div class="summary-box">
            <h3>Total Pengeluaran</h3>
            <p>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
        </div>
        <div class="summary-box">
            <h3>Total Penghasilan</h3>
            <p>Rp {{ number_format($totalPenghasilan, 0, ',', '.') }}</p>
        </div>
    </div>

    @if($reportType === 'yearly')
        <div class="chart-container">
            <h2>Grafik Pendapatan Tahunan</h2>
            <img src="{{ $chartImage }}" alt="Combined Yearly Chart" style="max-width: 100%;">
        </div>
        
        <div class="page-break"></div>
        
        <!-- Separate Charts -->
        <div class="section-title">Grafik Terpisah</div>
        
        <!-- Pemasukan Chart -->
        <div class="chart-container chart-pemasukan">
            <h2>Grafik Pemasukan Tahunan</h2>
            <img src="{{ $chartImagePemasukan }}" alt="Yearly Income Chart" style="max-width: 100%;">
        </div>
        
        <!-- Pengeluaran Chart -->
        <div class="chart-container chart-pengeluaran">
            <h2>Grafik Pengeluaran Tahunan</h2>
            <img src="{{ $chartImagePengeluaran }}" alt="Yearly Expense Chart" style="max-width: 100%;">
        </div>
        
        <div class="page-break"></div>
        
        <!-- Monthly Combined Charts -->
        <div class="section-title">Grafik Bulanan Gabungan</div>
        <div class="monthly-charts ">
            @foreach($yearlyCharts as $index => $monthChart)
                <div class="monthly-chart">
                    <h3>{{ $monthChart['name'] }}</h3>
                    <img src="{{ $monthChart['chart'] }}" alt="{{ $monthChart['name'] }} Chart" style="max-width: 100%;">
                </div>

                {{-- @if(($index + 1) % 3 == 0 && !$loop->last)

                    </div>
                    <div class="page-break"></div>
                    <div class="monthly-charts">
                @endif --}}
            @endforeach
        </div>
        
        <div class="page-break"></div>
        
        <!-- Monthly Pemasukan Charts -->
        <div class="section-title">Grafik Bulanan Pemasukan</div>
        <div class="monthly-charts">
            @foreach($yearlyChartsPemasukan as $index => $monthChart)
                <div class="monthly-chart">
                    <h3>{{ $monthChart['name'] }}</h3>
                    <img src="{{ $monthChart['chart'] }}" alt="{{ $monthChart['name'] }} Chart" style="max-width: 100%;">
                </div>

                {{-- @if(($index + 1) % 3 == 0 && !$loop->last)

                    </div>
                    <div class="page-break"></div>
                    <div class="monthly-charts">
                @endif --}}
            @endforeach
        </div>
        
        <div class="page-break"></div>
        
        <!-- Monthly Pengeluaran Charts -->
        <div class="section-title">Grafik Bulanan Pengeluaran</div>
        <div class="monthly-charts">
            @foreach($yearlyChartsPengeluaran as $index => $monthChart)
                <div class="monthly-chart">
                    <h3>{{ $monthChart['name'] }}</h3>
                    <img src="{{ $monthChart['chart'] }}" alt="{{ $monthChart['name'] }} Chart" style="max-width: 100%;">
                </div>

                {{-- @if(($index + 1) % 3 == 0 && !$loop->last)

                    </div>
                    <div class="page-break"></div>
                    <div class="monthly-charts">
                @endif --}}
            @endforeach
        </div>
    @else
        <div class="chart-container">
            <h2>Grafik Pendapatan Harian</h2>
            <img src="{{ $chartImage }}" alt="Combined Monthly Chart" style="max-width: 100%;">
        </div>
        
        <div class="page-break"></div>
        
        <div class="section-title">Grafik Terpisah</div>

        <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
            <div class="chart-container chart-pemasukan" style="flex: 1; min-width: 30%;">
                <h2>Grafik Pemasukan Tahunan</h2>
                <img src="{{ $chartImagePemasukan }}" alt="Yearly Income Chart" style="width: 100%;">
            </div>

            <div class="chart-container chart-pengeluaran" style="flex: 1; min-width: 30%;">
                <h2>Grafik Pengeluaran Tahunan</h2>
                <img src="{{ $chartImagePengeluaran }}" alt="Yearly Expense Chart" style="width: 100%;">
            </div>

            <div class="chart-container chart-gabungan" style="flex: 1; min-width: 30%;">
                <h2>Grafik Gabungan Tahunan</h2>
                <img src="{{ $chartImage }}" alt="Combined Yearly Chart" style="width: 100%;">
            </div>
        </div>
    @endif

    <div class="page-break"></div>

    <h2 style="color: #7D0066; margin-bottom: 15px;">Data Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Kategori</th>
                <th>user</th>
                <th>Keterangan</th>
                <th>Nominal</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $index => $transaksi)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaksi->kategori }}</td>
                    <td>{{ isset($transaksi->user) ? ($transaksi->user->nama_lengkap ?? '-') : '-' }}</td>
                    <td>{{ $transaksi->keterangan }}</td>
                    <td>Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}</td>
                    <td>{{ $transaksi->tanggal }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if(count($pesanans) > 0)
        <div class="page-break"></div>
        
        <h2 style="color: #7D0066; margin-bottom: 15px;">Data Pesanan</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>User</th>
                    <th>Product</th>
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
    @endif

    <div style="text-align: center; margin-top: 30px; font-size: 12px; color: #666;">
        <p>&copy; {{ date('Y') }} - Sistem Laporan Keuangan</p>
    </div>
</body>
</html>