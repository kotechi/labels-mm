@extends('layouts.admin')

@section('title','Edit Pengeluaran')
@section('content')
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Admin | Edit Pengeluaran</u>
    </div>
</div>
<div class="bg-white shadow-md border mt-6">
    <div class="bg-labels shadow-lg rounded-sm">
        <div class="p-4 w-auto">
            <h3 class="text-lg text-white font-semibold">Edit Data Pengeluaran</h3>
        </div>
    </div>
    <div class="p-6 mt-2">
        <form action="{{ route('admin.pengeluaran.update', $pengeluaran->id_pengeluaran) }}" enctype="multipart/form-data" method="POST" id="pengeluaranForm">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="keterangan" class="block text-lg font-medium text-gray-700">Keterangan</label>
                <input type="text" name="keterangan" id="keterangan" placeholder="masukan keterangan" 
                       class="p-3 block w-full border rounded-md" required
                       value="{{ old('keterangan', $pengeluaran->keterangan) }}">
            </div>
            <div class="mb-4">
                <label for="nominal_pengeluaran" class="block text-lg font-medium text-gray-700">Nominal Pengeluaran</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-700">Rp</span>
                    <input type="text" name="nominal_pengeluaran" id="nominal_pengeluaran" 
                           placeholder="masukan nominal pengeluaran" 
                           class="p-3 block w-full border rounded-md pl-10" required 
                           oninput="formatRupiah(this)"
                           value="{{ old('nominal_pengeluaran', number_format($pengeluaran->nominal_pengeluaran, 0, ',', '.')) }}">
                    <input type="hidden" name="nominal_pengeluaran" id="nominal_pengeluaran_hidden" 
                           value="{{ old('nominal_pengeluaran', $pengeluaran->nominal_pengeluaran) }}">
                </div>
            </div>
            <input type="hidden" name="created_by" value="{{$pengeluaran->created_by}}">
            <div class="flex justify-end">
                <a onclick="history.back()" class="mr-3 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Update</button>
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
        // Hapus semua karakter selain angka
        let value = element.value.replace(/[^0-9]/g, '');
        
        // Simpan nilai asli ke hidden input
        document.getElementById(element.id + '_hidden').value = value;
        
        // Format tampilan dengan titik sebagai pemisah ribuan
        if(value.length > 0) {
            element.value =  new Intl.NumberFormat('id-ID').format(value);
        } else {
            element.value = '';
        }
    }

    // Format awal saat halaman dimuat
    window.onload = function() {
        const nominalInput = document.getElementById('nominal_pengeluaran');
        if(nominalInput.value) {
            let value = nominalInput.value.replace(/[^0-9]/g, '');
            nominalInput.value =  new Intl.NumberFormat('id-ID').format(value);
        }
    };
</script>
@endsection