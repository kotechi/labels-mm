@extends('layouts.admin')

@section('title','Pemasukan')
@section('content')
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Admin | Pemasukan</u>
    </div>
</div>
<div class="bg-white shadow-md border mt-6">
    <div class="bg-labels shadow-lg rounded-sm">
        <div class="p-4 w-auto">
            <h3 class="text-lg text-white font-semibold">Tambah Data Pemasukan</h3>
        </div>
    </div>
    <div class="p-6 mt-2">
        <form action="{{ route('pemasukan.store') }}" method="POST" id="pemasukanForm">
            @csrf
            <div class="mb-4">
                <label for="keterangan" class="block text-lg font-medium text-gray-700">Keterangan</label>
                <input type="text" name="keterangan" id="keterangan" placeholder="masukan keterangan" class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="nominal" class="block text-lg font-medium text-gray-700">Nominal</label>
                <input type="text" name="nominal" id="nominal" placeholder="masukan nominal" class="p-3 block w-full border rounded-md" required oninput="formatRupiah(this)">
                <input type="hidden" name="nominal" id="nominal_hidden">
            </div>
            <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
            <div class="flex justify-end">
                
                <a onclick="history.back()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Create</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('pemasukanForm').addEventListener('submit', function() {
        var nominalInput = document.getElementById('nominal');
        nominalInput.value = nominalInput.value.replace(/[^0-9]/g, '');
    });

    function formatRupiah(element) {
        let value = element.value.replace(/\D/g, '');
        element.value = new Intl.NumberFormat('id-ID', { style: 'decimal', maximumFractionDigits: 0 }).format(value);
        document.getElementById(element.id + '_hidden').value = value;
    }
</script>
@endsection
