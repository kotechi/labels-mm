
@extends('layouts.admin')

@section('title', 'Gallery')

@section('content')
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl" >Admin | Gallery</u>
    </div>
</div>

<div class="mt-6 p-6 rounded-lg shadow bg-white">
    <div class="card-tittle-section">
        <h2 class="card-tittle"> Daftar Model</h2>
        <a href="{{ route('products.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-600">
            <span class="mr-2">+</span> Tambah Model Baru
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="datatable min-w-full divide-y divide-gray-200">
            <thead class="bg-thead">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($products as $product)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $product->nama_produk }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $product->stock_product }}</td>
                    <td class="px-6 py-4 whitespace-normal max-w-xs truncate">{{ $product->description }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->nama_produk }}" 
                             class="h-16 w-16 object-cover rounded-lg">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('products.edit', $product->id_product) }}" 
                           class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Edit</a>
                        <form action="{{ route('products.destroy', $product->id_product) }}" 
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