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
    const ctx = document.getElementById('earningsChart').getContext('2d');
    let currentDate = new Date();
    let period = 'monthly';
    
    // Initialize Chart
    let earningsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [
                {
                    label: 'Pemasukan',
                    data: @json($monthlyEarnings),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1
                },
                {
                    label: 'Pengeluaran',
                    data: @json($monthlyModal),
                    borderColor: '#6A1E55',
                    backgroundColor: 'rgba(106, 30, 85, 0.2)',
                    borderWidth: 1
                },
                {
                    label: 'Total Keuntungan',
                    data: @json($monthlyTotalPemasukan),
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

    

    function formatPeriodDisplay(date, period) {
        const months = ['January', 'February', 'March', 'April', 'May', 'June', 
                       'July', 'August', 'September', 'October', 'November', 'December'];
        
        if (period === 'daily') {
            return `${months[date.getMonth()]} ${date.getFullYear()}`;
        } else if (period === 'monthly') {
            return date.getFullYear().toString();
        } else {
            return `${date.getFullYear() - 4} - ${date.getFullYear()}`;
        }
    }

    function updatePeriodDisplay() {
        const displayElement = document.getElementById('periodDisplay');
        displayElement.textContent = formatPeriodDisplay(currentDate, period);
    }

    function fetchData() {
        $.ajax({
            url: '{{ route("admin.index") }}',
            method: 'GET',
            data: {
                period: period,
                year: currentDate.getFullYear(),
                month: currentDate.getMonth() + 1
            },
            success: function(response) {
                earningsChart.data.labels = response.labels;
                earningsChart.data.datasets[0].data = response.data.pendapatan;
                earningsChart.data.datasets[1].data = response.data.modal;
                earningsChart.data.datasets[2].data = response.data.totalPemasukan;
                earningsChart.update();
                
                document.getElementById('totalEarnings').textContent = 
                    `Total: Rp ${new Intl.NumberFormat('id-ID').format(response.totalEarnings)}`;
                
                updatePeriodDisplay();
            }
        });
    }

    // Event Listeners
    document.getElementById('earningsPeriod').addEventListener('change', function() {
        period = this.value;
        fetchData();
    });

    document.getElementById('prevPeriod').addEventListener('click', function() {
        if (period === 'daily') {
            currentDate.setMonth(currentDate.getMonth() - 1);
        } else if (period === 'monthly') {
            currentDate.setFullYear(currentDate.getFullYear() - 1);
        } else {
            currentDate.setFullYear(currentDate.getFullYear() - 5);
        }
        fetchData();
    });

    document.getElementById('nextPeriod').addEventListener('click', function() {
        if (period === 'daily') {
            currentDate.setMonth(currentDate.getMonth() + 1);
        } else if (period === 'monthly') {
            currentDate.setFullYear(currentDate.getFullYear() + 1);
        } else {
            currentDate.setFullYear(currentDate.getFullYear() + 5);
        }
        fetchData();
    });

    // Initialize period display
    updatePeriodDisplay();
});
</script>
@endpush