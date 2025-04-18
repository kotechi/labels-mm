@extends('layouts.karyawan')

@section('title', 'Pesanan')

@section('content')
<div class="p-6 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <h1 class="font-extrabold text-4xl">Karyawan | Pesanan</h1>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md p-6 mt-6">
    <div class="flex justify-between items-center mb-2">
        <h2 class="text-2xl font-semibold text-gray-700">Pesanan</h2>
        <a href="{{ route('karyawan.pesanans.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
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
                    <tr data-href="{{ route('karyawan.pesanans.detail', $pesanan->id_pesanan) }}" class="cursor-pointer hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $no_pesanan++ }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->nama_pemesan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->nama_produk }}</td>    
                    <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->jumlah_produk }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->no_telp_pemesan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($pesanan->status_pesanan == 'proses')
                            <form action="{{ route('karyawan.pesanans.markAsPaid', $pesanan->id_pesanan) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="px-3 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md mark-as-paid-button">sudah bayar</button>
                            </form>
                        @elseif($pesanan->status_pesanan == 'paid')
                            <form action="{{ route('karyawan.pesanans.markAsCompleted', $pesanan->id_pesanan) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="px-3 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md mark-as-paid-button">Selesaikan</button>
                            </form>
                        @elseif($pesanan->status_pesanan == 'completed')
                            <button class="px-3 py-2 bg-blue-600 text-white rounded-md">Completed</button>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('karyawan.pesanans.edit', $pesanan->id_pesanan) }}" class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Edit</a>
                        <form action="{{ route('karyawan.pesanans.destroyWithPemasukan', $pesanan->id_pesanan) }}" method="POST" class="inline-block delete-form">
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

<script>
    $(document).ready(function() {
        $('table.datatable tbody tr').on('click', function(e) {
            if (!$(e.target).closest('button, a, form').length) {
                const href = $(this).data('href');
                if (href) {
                    window.location.href = href;
                }
            }
        });

        // SweetAlert for delete confirmation
        $('.delete-button').on('click', function() {
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Disable "Mark as Paid" button after click
        $('.mark-as-paid-button').on('click', function() {
            $(this).prop('disabled', true);
            $(this).closest('form').submit();
        });

    });
</script>
@endsection