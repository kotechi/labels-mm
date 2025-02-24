@extends('layouts.admin')

@section('title','Transaksi')
@section('content')
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Admin | Transaksi</u>
    </div>
</div>
<div class="bg-white shadow-md border mt-6">
    <div class="bg-labels shadow-lg rounded-sm">
        <div class="p-4 w-auto">
            <h3 class="text-lg text-white font-semibold">Tambah Data Transaksi</h3>
        </div>
    </div>
    <div class="p-6 mt-2">
        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nama_transaksi" class="block text-lg font-medium text-gray-700">Nama Transaksi</label>
                <input type="text" name="nama_transaksi" id="nama_transaksi" placeholder="masukan nama transaksi" class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="jumlah" class="block text-lg font-medium text-gray-700">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" placeholder="masukan jumlah" class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="harga" class="block text-lg font-medium text-gray-700">Harga</label>
                <input type="number" name="harga" id="harga" placeholder="masukan harga" class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="total" class="block text-lg font-medium text-gray-700">Total</label>
                <input type="number" name="total" id="total" placeholder="masukan total" class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection
