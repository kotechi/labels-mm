@extends('layouts.admin')

@section('title','Model')
@section('content')
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Admin | Model</u>
    </div>
</div>
<div class="bg-white shadow-md border mt-6">
    <div class="bg-labels shadow-lg rounded-sm">
        <div class="p-4 w-auto">
            <h3 class="text-lg text-white font-semibold">Tambah Data Model</h3>
        </div>
    </div>
    <div class="p-6 mt-2">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            <div class="mb-4">
                <label for="nama_produk" class="block text-lg font-medium text-gray-700">Nama Model</label>
                <input type="text" name="nama_produk" id="nama_produk" placeholder="Masukan nama model" 
                       value="{{ old('nama_produk') }}" class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="harga_jual" class="block text-lg font-medium text-gray-700">Harga Jual</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-700">Rp</span>
                    <input type="text" name="harga_jual_display" id="harga_jual_display" 
                           value="{{ old('harga_jual') ? number_format(old('harga_jual'), 0, ',', '.') : '' }}" 
                           placeholder="Masukan harga jual" 
                           class="p-3 block w-full border rounded-md pl-10" 
                           required oninput="formatRupiah(this, 'harga_jual')">
                    <input type="hidden" name="harga_jual" id="harga_jual" value="{{ old('harga_jual') }}">
                </div>
            </div>
            <div class="mb-4">
                <label for="stock_product" class="block text-lg font-medium text-gray-700">Stock</label>
                <input type="number" name="stock_product" id="stock_product" 
                       value="{{ old('stock_product') }}" placeholder="Masukan stock" 
                       class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-lg font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" 
                          placeholder="Masukan deskripsi model" 
                          class="p-3 block w-full border rounded-md">{{ old('description') }}</textarea>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-lg font-medium text-gray-700">Image</label>
                <input type="file" name="image" id="image" accept="image/*" 
                       class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="flex justify-end">
                <a onclick="history.back()" class="mr-3 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Create</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('productForm').addEventListener('submit', function(e) {
        // Format harga jual sebelum submit
        const hargaJualDisplay = document.getElementById('harga_jual_display');
        const hargaJual = document.getElementById('harga_jual');
        
        // Bersihkan format dan simpan nilai numerik
        let numericValue = parseInt(hargaJualDisplay.value.replace(/[^0-9]/g, ''));
        
        // Validasi minimal 4 juta di client side
        if (numericValue < 4000000) {
            e.preventDefault();
            alert('Harga harus minimal Rp 4.000.000');
            return false;
        }
        
        hargaJual.value = numericValue;
        return true;
    });

    function formatRupiah(element, hiddenId) {
        // Hapus semua karakter selain angka
        let value = element.value.replace(/[^0-9]/g, '');
        
        // Simpan nilai asli ke hidden input
        document.getElementById(hiddenId).value = value;
        
        // Format tampilan dengan "Rp" dan titik sebagai pemisah ribuan
        if(value.length > 0) {
            element.value = new Intl.NumberFormat('id-ID').format(value);
        } else {
            element.value = '';
        }
    }
</script>
@endsection