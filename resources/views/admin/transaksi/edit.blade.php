@extends('layouts.admin')

@section('title','transaksi')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Edit Transaksi</h1>
    <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="mb-4">
            <label for="id_referens" class="block text-sm font-medium text-gray-700">ID Referensi</label>
            <input type="text" name="id_referens" id="id_referens" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $transaksi->id_referens }}" required>
        </div>
        <div class="mb-4">
            <label for="pelaku_transaksi" class="block text-sm font-medium text-gray-700">Pelaku Transaksi</label>
            <input type="text" name="pelaku_transaksi" id="pelaku_transaksi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $transaksi->pelaku_transaksi }}" required>
        </div>
        <div class="mb-4">
            <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
            <input type="text" name="keterangan" id="keterangan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $transaksi->keterangan }}" required>
        </div>
        <div class="mb-4">
            <label for="nominal" class="block text-sm font-medium text-gray-700">Nominal</label>
            <input type="number" name="nominal" id="nominal" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $transaksi->nominal }}" required>
        </div>
        <div class="mb-4">
            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $transaksi->tanggal }}" required>
        </div>
        <div class="flex justify-end">
            <a onclick="history.back()" class="mr-3 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700">Kembali</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg">Update</button>
        </div>
    </form>
</div>
@endsection
