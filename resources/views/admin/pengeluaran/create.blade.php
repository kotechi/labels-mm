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
                <input type="text" name="keterangan" id="keterangan" 
                       placeholder="Masukan keterangan" 
                       value="{{ old('keterangan') }}"
                       class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="nominal_pengeluaran" class="block text-lg font-medium text-gray-700">Nominal Pengeluaran</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-700">Rp</span>
                    <input type="text" name="nominal_pengeluaran_display" id="nominal_pengeluaran_display" 
                           value="{{ old('nominal_pengeluaran') ? number_format(old('nominal_pengeluaran'), 0, ',', '.') : '' }}"
                           placeholder="Masukan nominal pengeluaran" 
                           class="p-3 block w-full border rounded-md pl-10" 
                           required oninput="formatRupiah(this, 'nominal_pengeluaran')">
                    <input type="hidden" name="nominal_pengeluaran" id="nominal_pengeluaran" 
                           value="{{ old('nominal_pengeluaran') }}">
                </div>
            </div>
            <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
            <div class="flex justify-end">
                <a onclick="history.back()" class="mr-3 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Create</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('pengeluaranForm').addEventListener('submit', function(e) {
        // Format nominal pengeluaran sebelum submit
        const nominalDisplay = document.getElementById('nominal_pengeluaran_display');
        const nominalHidden = document.getElementById('nominal_pengeluaran');
        
        // Bersihkan format dan simpan nilai numerik
        let numericValue = nominalDisplay.value.replace(/[^0-9]/g, '');
        
        // Validasi minimal 1 rupiah
        if (numericValue < 1) {
            e.preventDefault();
            alert('Nominal pengeluaran harus lebih dari 0');
            return false;
        }
        
        nominalHidden.value = numericValue;
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