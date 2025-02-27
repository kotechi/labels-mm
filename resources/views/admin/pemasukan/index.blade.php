@extends('layouts.admin')

@section('title', 'Pemasukan')

@section('content')

    <div class="p-6 rounded-lg shadow bg-white">
        <div class="flex justify-between items-center">
            <h1 class="font-extrabold text-4xl" >Admin | Pemasukan</h1>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mt-6">
        <div class="grid grid-cols-3 gap-6 mb-6">
            <!-- Dalama Proses -->
            <div class="relative p-4 shadow-lg border border-black rounded-lg ">
                <div class="flex items-center justify-between text-center">
                    <span class="font-semibold text-gray-800 text-xl">{{$pendingCount}}</span>
                    <i data-lucide="arrow-left" class="h-6 w-6 text-gray-600"></i>
                </div>
                <span class=" block mt-2 text-xl">Dalam Proses</span>
            </div>
    
            <!-- Selesai -->
            <div class="relative p-4 shadow-lg border border-black rounded-lg ">
                <div class="flex items-center justify-between text-center">
                    <span class="font-semibold text-gray-800 text-xl">{{$paidCount+$completedCount}}</span>
                    <i data-lucide="wallet" class="h-6 w-6 text-gray-600"></i>
                </div>
                <span class="block mt-2 text-xl">Sudah bayar</span>
            </div>
    
            <!-- Dibatalkan -->
            <div class="relative p-4 shadow-lg border border-black rounded-lg ">
                <div class="flex items-center justify-between text-center">
                    <span class="font-semibold text-gray-800 text-xl">{{$completedCount}}</span>
                    <i data-lucide="dollar-sign" class="h-6 w-6 text-gray-600"></i>
                </div>
                <span class="block mt-2 text-xl">Selesai</span>
            </div>
        </div>
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-2xl font-semibold text-gray-700">Pesanan</h2>
            <a href="{{ route('pesanans.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <span class="mr-2">+</span> Buat Pesanan Baru
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="datatable min-w-full divide-y divide-gray-200">
                <thead class="bg-thead">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Nama </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Model</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Total Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">No. telp</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                        $no_pesanan = 1;    
                    ?>
                    @foreach($pesanans as $pesanan)
                        <tr data-href="{{ route('pesanans.detail', $pesanan->id_pesanan) }}" class="cursor-pointer hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $no_pesanan++ }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->nama_pemesan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->nama_produk }}</td>    
                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->jumlah_produk }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->no_telp_pemesan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($pesanan->status_pesanan == 'proses')
                                <form action="{{ route('pesanans.markAsPaid', $pesanan->id_pesanan) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="px-3 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md mark-as-paid-button">Tandai sudah bayar</button>
                                </form>
                            @elseif($pesanan->status_pesanan == 'paid')
                                <form action="{{ route('pesanans.markAsCompleted', $pesanan->id_pesanan) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="px-3 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md mark-as-paid-button">Selesaikan</button>
                                </form>
                            @elseif($pesanan->status_pesanan == 'completed')
                                <button class="px-3 py-2 bg-blue-600 text-white rounded-md">Completed</button>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('pesanans.edit', $pesanan->id_pesanan) }}" class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Edit</a>
                            <form action="{{ route('pesanans.destroyWithPemasukan', $pesanan->id_pesanan) }}" method="POST" class="inline-block delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mt-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-700">Pemasukan</h2>
            <a href="{{ route('pemasukan.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <span class="mr-2">+</span> Buat Pemasukan Baru
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="datatable min-w-full divide-y divide-gray-200">
                <thead class="bg-thead">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Keterangan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Nominal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Pelaku</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                        $no_pemasukan = 1;    
                    ?>
                    @foreach($pemasukans as $pemasukan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $no_pemasukan++ }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pemasukan->keterangan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($pemasukan->nominal ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pemasukan->user->username }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pemasukan->created_at }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('pemasukan.destroy', $pemasukan->id_pemasukan) }}" method="POST" class="inline-block delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md delete-button">Delete</button>
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

        
        $('table.datatable tbody tr').on('click', function(e) {
            // Don't trigger if clicking on buttons, links, or forms
            if (!$(e.target).closest('button, a, form').length) {
                const href = $(this).data('href');
                if (href) {
                    window.location.href = href;
                }
            }
        });
        // Initialize DataTables
        $('#pesananTable').DataTable();
        $('#pemasukanTable').DataTable();
        $('#transaksiTable').DataTable();

        // Add margin-bottom to show entries and search elements
        $('.dataTables_length').addClass('mb-4');
        $('.dataTables_filter').addClass('mb-4');

        $('table.datatable tbody tr').css('cursor', 'pointer');

        // Disable "Mark as Paid" button after click
        $('.mark-as-paid-button').on('click', function() {
            $(this).prop('disabled', true);
            $(this).closest('form').submit();
        });
    });
</script>
@endpush