@extends('layouts.admin')

@section('title','Edit Bahan')
@section('content')
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Admin | Edit Bahan</u>
    </div>
</div>
<div class="bg-white shadow-md border mt-6">
    <div class="bg-labels shadow-lg rounded-sm">
        <div class="p-4 w-auto">
            <h3 class="text-lg text-white font-semibold">Edit Data Bahan</h3>
        </div>
    </div>
    <div class="p-6 mt-2">
        <form action="{{ route('admin.bahan.update', $bahan->id_bhn) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="nama_bahan" class="block text-lg font-medium text-gray-700">Nama Bahan</label>
                <input type="text" name="nama_bahan" id="nama_bahan" value="{{ $bahan->nama_bahan }}" class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="jumlah_bahan" class="block text-lg font-medium text-gray-700">Jumlah Bahan</label>
                <input type="number" name="jumlah_bahan" id="jumlah_bahan" value="{{ $bahan->jumlah_bahan }}" class="p-3 block w-full border rounded-md" required oninput="calculateTotal()">
            </div>
            <div class="mb-4">
                <label for="harga_satuan" class="block text-lg font-medium text-gray-700">Harga Satuan</label>
                <input type="text" name="harga_satuan" id="harga_satuan" value="{{ number_format($bahan->harga_satuan, 0, ',', '.') }}" class="p-3 block w-full border rounded-md" required oninput="formatRupiah(this); calculateTotal()">
                <input type="hidden" name="harga_satuan" id="harga_satuan_hidden" value="{{ $bahan->harga_satuan }}">
            </div>
            <div class="mb-4">
                <label for="total_harga" class="block text-lg font-medium text-gray-700">Total Harga</label>
                <input type="text" name="total_harga" id="total_harga" value="{{ number_format($bahan->total_harga, 0, ',', '.') }}" class="p-3 block w-full border rounded-md" readonly>
                <input type="hidden" name="total_harga" id="total_harga_hidden" value="{{ $bahan->total_harga }}">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    function formatRupiah(element) {
        let value = element.value.replace(/\D/g, '');
        element.value = new Intl.NumberFormat('id-ID', { style: 'decimal', maximumFractionDigits: 0 }).format(value);
        document.getElementById(element.id + '_hidden').value = value;
    }

    function calculateTotal() {
        const jumlahBahan = document.getElementById('jumlah_bahan').value;
        const hargaSatuan = document.getElementById('harga_satuan_hidden').value;
        const totalHarga = jumlahBahan * hargaSatuan;
        document.getElementById('total_harga').value = new Intl.NumberFormat('id-ID', { style: 'decimal', maximumFractionDigits: 0 }).format(totalHarga);
        document.getElementById('total_harga_hidden').value = totalHarga;
    }
</script>
@endsection
