@extends('layouts.admin')

@section('content')
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Admin | Edit Product</u>
    </div>
</div>
<div class="bg-white shadow-md border mt-6">
    <div class="bg-labels shadow-lg rounded-sm">
        <div class="p-4 w-auto">
            <h3 class="text-lg text-white font-semibold">Edit Product</h3>
        </div>
    </div>
    <div class="p-6 mt-2">
        <form action="{{ route('products.update', $product->id_product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="nama_produk" class="block text-lg font-medium text-gray-700">Product Name</label>
                <input type="text" name="nama_produk" id="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="harga_jual" class="block text-lg font-medium text-gray-700">Price</label>
                <input type="number" step="0.01" name="harga_jual" id="harga_jual" value="{{ old('harga_jual', $product->harga_jual) }}" class="p-3 block w-full border rounded-md" required>
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
                <a href="{{ route('products') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Update Product</button>
            </div>
        </form>
    </div>
</div>
@endsection