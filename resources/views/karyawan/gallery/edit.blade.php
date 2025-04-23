@extends('layouts.karyawan')

@section('title', 'mModel')

@section('content')
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Karyawan | Edit model Item</u>
    </div>
</div>
<div class="bg-white shadow-md border mt-6">
    <div class="bg-labels shadow-lg rounded-sm">
        <div class="p-4 w-auto">
            <h3 class="text-lg text-white font-semibold">Edit Model</h3>
        </div>
    </div>
    <div class="p-6 mt-2">
        <form action="{{ route('karyawan.gallery.update', $product->id_product) }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="nama_produk" class="block text-lg font-medium text-gray-700">Model Name</label>
                <input type="text" name="nama_produk" id="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="harga_jual" class="block text-lg font-medium text-gray-700">Price</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-700">Rp</span>
                    <input type="text" name="harga_jual_display" id="harga_jual_display" 
                           value="{{ number_format(old('harga_jual', $product->harga_jual), 0, ',', '.') }}" 
                           class="p-3 block w-full border rounded-md pl-10" 
                           required oninput="formatRupiah(this, 'harga_jual')">
                    <input type="hidden" name="harga_jual" id="harga_jual" value="{{ old('harga_jual', $product->harga_jual) }}">
                </div>
            </div>
            <div class="mb-4">
                <label for="stock_product" class="block text-lg font-medium text-gray-700">Stock</label>
                <input type="number" name="stock_product" id="stock_product" value="{{ old('stock_product', $product->stock_product) }}" class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-lg font-medium text-gray-700">Image</label>
                <input type="file" name="image" id="image" accept="image/*" class="p-3 block w-full border rounded-md">
                @if($product->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->nama_produk }}" class="h-32 w-32 object-cover rounded-lg">
                    </div>
                @endif
            </div>
            <div class="mb-4">
                <label for="description" class="block text-lg font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" class="p-3 block w-full border rounded-md">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="flex justify-end">
                <a onclick="history.back()" class="mr-3 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Update Product</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('productForm').addEventListener('submit', function() {
        const hargaJualDisplay = document.getElementById('harga_jual_display');
        const hargaJual = document.getElementById('harga_jual');
        hargaJual.value = hargaJualDisplay.value.replace(/[^0-9]/g, '');
    });

    function formatRupiah(element, hiddenId) {
        let value = element.value.replace(/[^0-9]/g, '');
        
        document.getElementById(hiddenId).value = value;
        
        if(value.length > 0) {
            element.value =  new Intl.NumberFormat('id-ID').format(value);
        } else {
            element.value = '';
        }
    }

    window.onload = function() {
        const hargaJualDisplay = document.getElementById('harga_jual_display');
        if(hargaJualDisplay.value) {
            let value = hargaJualDisplay.value.replace(/[^0-9]/g, '');
            hargaJualDisplay.value =  new Intl.NumberFormat('id-ID').format(value);
        }
    };
</script>
@endsection