@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Pesanan Management</h1>

    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-700">Pesanan</h2>
            <a href="{{ route('pesanans.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <span class="mr-2">+</span> Create New Pesanan
            </a>
        </div>
        <div class="overflow-x-auto">
            <table id="pesananTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-500">
                       <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">ID Pesanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Name Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Total Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Jumlah Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Nomor Whatsapp</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($pesanans as $pesanan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->id_pesanan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->name_product }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->status }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->total_harga }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->jumlah_product }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->nomor_whatsapp }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('pesanans.edit', $pesanan->id_pesanan) }}" class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Edit</a>
                            <form action="{{ route('pesanans.destroy', $pesanan->id_pesanan) }}" method="POST" class="inline-block delete-form">
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
</div>

<!-- jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- Datatables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#pesananTable').DataTable();

        // Add margin-bottom to show entries and search elements
        $('.dataTables_length').addClass('mb-4');
        $('.dataTables_filter').addClass('mb-4');

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
@endsection