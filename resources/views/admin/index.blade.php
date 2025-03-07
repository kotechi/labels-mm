{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="p-6 rounded-lg shadow-md bg-white">
    <h1 class="block font-extrabold text-center text-4xl" style="color: #7D0066;">Dashboard Admin</h1>
</div>

<div class="p-6 mt-6 rounded-lg shadow-md bg-white ">
    <h3 class="text-lg font-semibold text-gray-700 mb-4">Overview</h3>
    <div class="grid grid-cols-3 gap-6">
        <!-- Pengeluaran -->
        <div class="relative p-4 shadow-md border border-black rounded-lg ">
            <div class="flex items-center justify-between text-center">
                <span class="font-semibold text-gray-800 text-xl">Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</span>
                <i data-lucide="arrow-left" class="h-6 w-6 text-gray-600"></i>
            </div>
            <span class=" block mt-2 text-xl">Pengeluaran</span>
        </div>

        <!-- Pemasukan -->
        <div class="relative p-4 shadow-md border border-black rounded-lg ">
            <div class="flex items-center justify-between text-center">
                <span class="font-semibold text-gray-800 text-xl">Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}</span>
                <i data-lucide="wallet" class="h-6 w-6 text-gray-600"></i>
            </div>
            <span class="block mt-2 text-xl">Pemasukan</span>
        </div>

        <!-- Penghasilan -->
        <div class="relative p-4  shadow-md border border-black rounded-lg ">
            <div class="flex items-center justify-between text-center">
                <span class="font-semibold text-gray-800 text-xl">Rp {{ number_format($totalPenghasilan ?? 0, 0, ',', '.') }}</span>
                <i data-lucide="dollar-sign" class="h-6 w-6 text-gray-600"></i>
            </div>
            <span class="block mt-2 text-xl">Penghasilan</span>
        </div>
    </div>
    <div class="w-full p-2 text-center bg-labels rounded-md shadow-sm hover:shadow-lg mt-4 ">
        <a href="{{ route('report.pdf') }}" class="px-4 w-full py-2  text-white ">
            Download PDF Report
        </a>
    </div>
</div>



<!-- Earnings Chart -->
<div class="mt-6 p-6 rounded-lg shadow-md bg-white">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-700">Grafik Pendapatan</h3>
        <div class="flex items-center gap-4">
            <select id="earningsPeriod" class="px-4 py-2 bg-gray-200 rounded">
                <option value="daily">Daily</option>
                <option value="monthly" selected>Monthly</option>
                <option value="yearly">Yearly</option>
            </select>
            
            <div class="flex items-center gap-2">
                <button id="prevPeriod" class="p-2 bg-gray-200 rounded hover:bg-gray-300">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </button>
                
                <span id="periodDisplay" class="px-4 py-2 bg-gray-100 rounded font-medium"></span>
                
                <button id="nextPeriod" class="p-2 bg-gray-200 rounded hover:bg-gray-300">
                    <i data-lucide="chevron-right" class="w-5 h-5"></i>
                </button>
            </div>

            <div id="totalEarnings" class="px-4 py-2 bg-gray-100 rounded">
                Total: Rp {{ number_format($totalMonthlyEarnings ?? 0, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <div class="bg-gray-50 p-4 rounded-md" style="height: 400px;">
        <canvas id="earningsChart"></canvas>
    </div>
</div>

<!-- Orders Table -->
<div class="mt-6 p-6 rounded-lg shadow-lg bg-white">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-700">Daftar Pesanan</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="datatable min-w-full divide-y divide-gray-200">
            <thead class="bg-thead">
                <tr>
                    <th  h class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">ID Pesanan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Total Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($pesanans as $pesanan)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->id_pesanan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->nama_pemesan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->product_id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->nama_produk }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->status_pesanan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('pesanans.edit', $pesanan->id_pesanan) }}" 
                           class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Edit</a>
                        <form action="{{ route('pesanans.destroyWithPemasukan', $pesanan->id_pesanan) }}"
                              method="POST" class="inline-block delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md delete-button">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Transaksi Table -->
<div class="mt-6 p-6 rounded-lg shadow-lg bg-white">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-700">History transaksi</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="datatable min-w-full divide-y divide-gray-200">
            <thead class="bg-thead">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Pelaku</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Keterangan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nominal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php
                $no_transaksi = 0;    
                ?>
                @foreach($transaksis as $transaksi)
                <?php $no_transaksi++; ?>
                <tr data-kategori="{{ strtolower($transaksi->kategori) }}">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $no_transaksi }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $transaksi->kategori }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $transaksi->user->nama_lengkap }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $transaksi->keterangan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">Rp. {{ number_format($transaksi->nominal ?? 0, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{$transaksi->tanggal}}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form action="{{ route('transaksi.destroy', $transaksi->id_transaksi) }}" 
                              method="POST" class="inline-block delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md delete-button">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if the chart canvas exists
    const canvas = document.getElementById('earningsChart');
    if (!canvas) {
        console.error('Canvas element not found!');
        return;
    }

    const ctx = canvas.getContext('2d');
    let period = 'monthly'; // Default period
    let currentMonth = new Date().getMonth() + 1; // Current month (1-12)
    let currentYear = new Date().getFullYear(); // Current year
    let yearRangeStart = currentYear - 5; // Start of 5-year period for yearly view

    // Initialize data from PHP variables
    const allYearlyData = @json($yearlyData);
    const allMonthlyData = @json($allMonthlyData);
    const allDailyData = @json($allDailyData);
    
    // Month names for display
    const monthNames = ["January", "February", "March", "April", "May", "June", 
                        "July", "August", "September", "October", "November", "December"];

    // Create and configure the chart
    let earningsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [
                {
                    label: 'Pemasukan',
                    data: [],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1
                },
                {
                    label: 'Pengeluaran',
                    data: [],
                    borderColor: '#6A1E55',
                    backgroundColor: 'rgba(106, 30, 85, 0.2)',
                    borderWidth: 1
                },
                {
                    label: 'Total Keuntungan',
                    data: [],
                    borderColor: '#7C084E',
                    backgroundColor: 'rgba(124, 8, 78, 0.2)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': Rp ' + 
                                  new Intl.NumberFormat('id-ID').format(context.raw);
                        }
                    }
                }
            }
        }
    });

    // Function to get current data based on period, month, and year
    function getCurrentData() {
        let data = {
            labels: [],
            pemasukan: [],
            pengeluaran: [],
            keuntungan: [],
            total: 0
        };

        if (period === 'daily') {
            // Generate empty data for all days if needed
            const daysInMonth = new Date(currentYear, currentMonth, 0).getDate();
            data.labels = Array.from({length: daysInMonth}, (_, i) => i + 1);
            data.pemasukan = Array(daysInMonth).fill(0);
            data.pengeluaran = Array(daysInMonth).fill(0);
            data.keuntungan = Array(daysInMonth).fill(0);
            
            // Check if data exists for the specified month and year and override with actual data
            if (allDailyData[currentYear] && allDailyData[currentYear][currentMonth]) {
                const actualData = allDailyData[currentYear][currentMonth];
                // Map actual data values to their correct day position
                actualData.days.forEach((day, index) => {
                    const dayIdx = parseInt(day) - 1;
                    if (dayIdx >= 0 && dayIdx < daysInMonth) {
                        data.pemasukan[dayIdx] = actualData.pemasukan[index] || 0;
                        data.pengeluaran[dayIdx] = actualData.pengeluaran[index] || 0;
                        data.keuntungan[dayIdx] = actualData.keuntungan[index] || 0;
                    }
                });
                data.total = actualData.total || 0;
            }
        } else if (period === 'monthly') {
            // Generate empty data for all months
            data.labels = monthNames;
            data.pemasukan = Array(12).fill(0);
            data.pengeluaran = Array(12).fill(0);
            data.keuntungan = Array(12).fill(0);
            
            // Check if data exists for the specified year and override with actual data
            if (allMonthlyData[currentYear]) {
                const actualData = allMonthlyData[currentYear];
                // Map actual data values to their correct month position
                actualData.months.forEach((month, index) => {
                    const monthIdx = monthNames.indexOf(month);
                    if (monthIdx >= 0) {
                        data.pemasukan[monthIdx] = actualData.pemasukan[index] || 0;
                        data.pengeluaran[monthIdx] = actualData.pengeluaran[index] || 0;
                        data.keuntungan[monthIdx] = actualData.keuntungan[index] || 0;
                    }
                });
                data.total = actualData.total || 0;
            }
        } else if (period === 'yearly') {
            // Generate empty data for the 5-year range
            const yearRange = Array.from({length: 5}, (_, i) => yearRangeStart + i);
            data.labels = yearRange;
            data.pemasukan = Array(5).fill(0);
            data.pengeluaran = Array(5).fill(0);
            data.keuntungan = Array(5).fill(0);
            
            // Map actual yearly data to our fixed range
            yearRange.forEach((year, idx) => {
                const yearIdx = allYearlyData.years.indexOf(year);
                if (yearIdx !== -1) {
                    data.pemasukan[idx] = allYearlyData.pemasukan[yearIdx] || 0;
                    data.pengeluaran[idx] = allYearlyData.pengeluaran[yearIdx] || 0;
                    data.keuntungan[idx] = allYearlyData.keuntungan[yearIdx] || 0;
                }
            });
            
            // Calculate total for the selected range
            data.total = data.keuntungan.reduce((sum, val) => sum + parseFloat(val || 0), 0);
        }

        return data;
    }

    // Function to update the chart
    function updateChart() {
        const data = getCurrentData();
        
        // Update chart with new data
        earningsChart.data.labels = data.labels;
        earningsChart.data.datasets[0].data = data.pemasukan;
        earningsChart.data.datasets[1].data = data.pengeluaran;
        earningsChart.data.datasets[2].data = data.keuntungan;
        
        // Update the chart
        earningsChart.update();
        
        // Update total earnings display
        const totalEarnings = document.getElementById('totalEarnings');
        if (totalEarnings) {
            totalEarnings.textContent = `Total: Rp ${new Intl.NumberFormat('id-ID').format(data.total)}`;
        }
    }

    // Function to update the period display
    function updatePeriodDisplay() {
        const periodDisplay = document.getElementById('periodDisplay');
        if (!periodDisplay) return;
        
        if (period === 'daily') {
            periodDisplay.textContent = `${monthNames[currentMonth-1]} ${currentYear}`;
        } else if (period === 'monthly') {
            periodDisplay.textContent = `${currentYear}`;
        } else if (period === 'yearly') {
            periodDisplay.textContent = `${yearRangeStart} - ${yearRangeStart + 4}`;
        }
    }

    // Initialize the chart with the default period
    updateChart();
    updatePeriodDisplay();

    // Period selector event listener
    const periodSelector = document.getElementById('earningsPeriod');
    if (periodSelector) {
        periodSelector.addEventListener('change', function() {
            period = this.value;
            updateChart();
            updatePeriodDisplay();
        });
    }

    // Next period button event listener
    const nextButton = document.getElementById('nextPeriod');
    if (nextButton) {
        nextButton.addEventListener('click', function() {
            if (period === 'daily') {
                if (currentMonth < 12) {
                    currentMonth++;
                } else {
                    currentMonth = 1;
                    currentYear++;
                }
            } else if (period === 'monthly') {
                currentYear++;
            } else if (period === 'yearly') {
                yearRangeStart += 5;
            }
            
            updateChart();
            updatePeriodDisplay();
        });
    }

    // Previous period button event listener
    const prevButton = document.getElementById('prevPeriod');
    if (prevButton) {
        prevButton.addEventListener('click', function() {
            if (period === 'daily') {
                if (currentMonth > 1) {
                    currentMonth--;
                } else {
                    currentMonth = 12;
                    currentYear--;
                }
            } else if (period === 'monthly') {
                currentYear--;
            } else if (period === 'yearly') {
                yearRangeStart -= 5;
            }
            
            updateChart();
            updatePeriodDisplay();
        });
    }
});
</script>
@endpush