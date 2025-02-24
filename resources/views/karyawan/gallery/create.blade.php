{{-- filepath: /c:/laragon/www/labels-mm/resources/views/karyawan/model/create.blade.php --}}
@extends('layouts.karyawan')

@section('title', 'Create model Item')

@section('content')
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Karyawan | model</u>
    </div>
</div>
<div class="bg-white shadow-md border mt-6">
    <div class="bg-labels shadow-lg rounded-sm">
        <div class="p-4 w-auto">
            <h3 class="text-lg text-white font-semibold">Tambah Data model</h3>
        </div>
    </div>
    <div class="p-6 mt-2">
        <form action="{{ route('karyawan.gallery.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="nama_produk" class="block text-lg font-medium text-gray-700">Nama model</label>
                <input type="text" name="nama_produk" id="nama_produk" placeholder="masukan nama model" class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="harga_jual" class="block text-lg font-medium text-gray-700">Harga Jual</label>
                <input type="number" name="harga_jual" id="harga_jual" placeholder="masukan harga jual" class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="stock_product" class="block text-lg font-medium text-gray-700">Stock</label>
                <input type="number" name="stock_product" id="stock_product" placeholder="masukan stock" class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-lg font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" placeholder="masukan deskripsi model" class="p-3 block w-full border rounded-md" required></textarea>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-lg font-medium text-gray-700">Image</label>
                <input type="file" name="image" id="image" accept="image/*" class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection