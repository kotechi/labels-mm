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
                    <tr class="cursor-pointer hover:bg-gray-50">
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
                                    <button type="submit" class="px-3 py-2 bg-yellow-500 hover:bg-yello-600 text-white rounded-md mark-as-paid-button">Belum bayar</button>
                                </form>
                            @elseif($pesanan->status_pesanan == 'DP')
                                <form action="{{ route('pesanans.markAsPaid', $pesanan->id_pesanan) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="px-3 py-2 bg-yellow-500 hover:bg-yello-600 text-white rounded-md mark-as-paid-button">DP</button>
                                </form>
                            @elseif($pesanan->status_pesanan == 'paid')
                                <form action="{{ route('pesanans.markAsCompleted', $pesanan->id_pesanan) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="px-3 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md mark-as-paid-button">Sudah bayar</button>
                                </form>
                            @elseif($pesanan->status_pesanan == 'batal')
                                <button class="px-3 py-2 bg-red-500 text-white rounded-md">Batal</button>
                            @elseif($pesanan->status_pesanan == 'completed')
                                <button class="px-3 py-2 bg-blue-600 text-white rounded-md">Selesai</button>
                            

                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap" id="actions-td">
                            <a href="{{ route('pesanans.detail', $pesanan->id_pesanan) }}" class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md"><i data-lucide="view" class="w-6 h-6 inline "></i></a>
                            <a href="{{ route('pesanans.edit', $pesanan->id_pesanan) }}" class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Edit</a>


                            @if($pesanan->status_pesanan !== 'batal')
                                <form action="{{ route('pesanans.batalkan', $pesanan->id_pesanan) }}" method="POST" class="inline-block delete-form">
                                    @csrf
                                    <button type="button" class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md delete-button">Batalkan</button>
                                </form>
                            @endif
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">user</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Created At</th>
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
                        <td class="px-6 py-4 whitespace-nowrap">{{$pemasukan->user ? $pemasukan->user->nama_lengkap : 'Unknown'}}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pemasukan->created_at }}</td>
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