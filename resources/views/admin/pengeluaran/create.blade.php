@extends('layouts.admin')

@section('title','Pengeluaran')
@section('content')
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Admin | Pengeluaran</u>
    </div>
</div>
<div class="bg-white shadow-md border mt-6">
    <div class="bg-labels shadow-lg rounded-sm">
        <div class="p-4 w-auto">
            <h3 class="text-lg text-white font-semibold">Tambah Data Pengeluaran</h3>
        </div>
    </div>
    <div class="p-6 mt-2">
        <form action="{{ route('admin.pengeluaran.store') }}" method="POST" id="pengeluaranForm">
            @csrf
            <div class="mb-4">
                <label for="keterangan" class="block text-lg font-medium text-gray-700">Keterangan</label>
                <input type="text" name="keterangan" id="keterangan" placeholder="masukan keterangan" class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="nominal_pengeluaran" class="block text-lg font-medium text-gray-700">Nominal Pengeluaran</label>
                <input type="text" name="nominal_pengeluaran" id="nominal_pengeluaran" placeholder="masukan nominal pengeluaran" class="p-3 block w-full border rounded-md" required oninput="formatRupiah(this)">
                <input type="hidden" name="nominal_pengeluaran" id="nominal_pengeluaran_hidden">
            </div>
            <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Create</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('pengeluaranForm').addEventListener('submit', function() {
        var nominalInput = document.getElementById('nominal_pengeluaran');
        nominalInput.value = nominalInput.value.replace(/[^0-9]/g, '');
    });

    function formatRupiah(element) {
        let value = element.value.replace(/\D/g, '');
        element.value = new Intl.NumberFormat('id-ID', { style: 'decimal', maximumFractionDigits: 0 }).format(value);
        document.getElementById(element.id + '_hidden').value = value;
    }
</script>
@endsection
