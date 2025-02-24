@extends('layouts.admin')

@section('title', 'Pengeluaran')

@section('content')
<div class="p-6 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <h1 class="font-extrabold text-4xl" >Admin | Pengeluaran</h1>
    </div>
</div>


<!-- Data Bahan Section -->
<div class="mt-6 p-6 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-700">Daftar Bahan</h2>
        <a href="{{ route('admin.bahan.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-600">
            <span class="mr-2">+</span>Buat Bahan Baru
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="datatable min-w-full divide-y divide-gray-200">
            <thead class="bg-thead">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Bahan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Jumlah Bahan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Harga Satuan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Total Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php
                $no_bahan = 1;    
                ?>
                @foreach($bahans as $bahan)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $no_bahan++ }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $bahan->nama_bahan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $bahan->jumlah_bahan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($bahan->harga_satuan, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($bahan->total_harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('admin.bahan.edit', $bahan->id_bhn) }}" 
                           class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Edit</a>
                        <form action="{{ route('admin.bahan.destroy', $bahan->id_bhn) }}" 
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

<!-- Data Pengeluaran Section -->
<div class="mt-6 p-6 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-700">Daftar Pengeluaran</h2>
        <a href="{{ route('admin.pengeluaran.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-600">
            <span class="mr-2">+</span>Buat Pengeluaran Baru
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="datatable min-w-full divide-y divide-gray-200">
            <thead class="bg-thead">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Keterangan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nominal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Created By</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php
                    $no_pengeluaran = 1;    
                ?>
                @foreach($pengeluarans as $pengeluaran)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $no_pengeluaran++ }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pengeluaran->keterangan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($pengeluaran->nominal_pengeluaran, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pengeluaran->user->username }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form action="{{ route('admin.pengeluaran.destroy', $pengeluaran->id_pengeluaran) }}" 
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
    $(document).ready(function() {

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
    });
</script>
@endpush