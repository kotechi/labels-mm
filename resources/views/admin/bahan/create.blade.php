@extends('layouts.admin')

@section('title','Tambah Bahan')
@section('content')
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Admin | Bahan</u>
    </div>
</div>
<div class="bg-white shadow-md border mt-6">
    <div class="bg-labels shadow-lg rounded-sm">
        <div class="p-4 w-auto">
            <h3 class="text-lg text-white font-semibold">Tambah Data Bahan</h3>
        </div>
    </div>
    <div class="p-6 mt-2">
        <!-- Flash Notifications -->
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                {{ session('error') }}
            </div>
        @endif
        
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.bahan.store') }}" method="POST" id="bahanForm">
            @csrf
            <div class="mb-4">
                <label for="nama_bahan" class="block text-lg font-medium text-gray-700">Nama Bahan</label>
                <input type="text" name="nama_bahan" id="nama_bahan" 
                       value="{{ old('nama_bahan') }}" 
                       placeholder="masukan nama bahan" 
                       class="p-3 block w-full border rounded-md @if($errors->has('nama_bahan')) border-red-500 @endif" >
                @if($errors->has('nama_bahan'))
                    <span class="text-red-500 text-sm">{{ $errors->first('nama_bahan') }}</span>
                @endif
            </div>
            
            <div class="mb-4">
                <label for="jumlah_bahan" class="block text-lg font-medium text-gray-700">Jumlah Bahan</label>
                <input type="number" name="jumlah_bahan" id="jumlah_bahan" 
                       value="{{ old('jumlah_bahan') }}" 
                       placeholder="masukan jumlah bahan" 
                       class="p-3 block w-full border rounded-md @if($errors->has('jumlah_bahan')) border-red-500 @endif" 
                       required oninput="calculateTotal()">
                @if($errors->has('jumlah_bahan'))
                    <span class="text-red-500 text-sm">{{ $errors->first('jumlah_bahan') }}</span>
                @endif
            </div>
            
            <div class="mb-4">
                <label for="harga_satuan" class="block text-lg font-medium text-gray-700">Harga Satuan</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-700">Rp</span>
                    <input type="text" name="harga_satuan_display" id="harga_satuan_display" 
                           value="{{ old('harga_satuan_display', old('harga_satuan') ? number_format(old('harga_satuan'), 0, ',', '.') : '') }}" 
                           placeholder="masukan harga satuan" 
                           class="p-3 block w-full border rounded-md pl-10 @if($errors->has('harga_satuan')) border-red-500 @endif" 
                           required oninput="formatRupiah(this, 'harga_satuan'); calculateTotal()">
                    <input type="hidden" name="harga_satuan" id="harga_satuan" value="{{ old('harga_satuan') }}">
                </div>
                @if($errors->has('harga_satuan'))
                    <span class="text-red-500 text-sm">{{ $errors->first('harga_satuan') }}</span>
                @endif
            </div>
            
            <div class="mb-4">
                <label for="total_harga_display" class="block text-lg font-medium text-gray-700">Total Harga</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-700">Rp</span>
                    <input type="text" name="total_harga_display" id="total_harga_display" 
                           value="{{ old('total_harga_display', old('total_harga') ? number_format(old('total_harga'), 0, ',', '.') : '0') }}" 
                           class="p-3 block w-full border rounded-md pl-10 bg-gray-100 @if($errors->has('total_harga')) border-red-500 @endif" readonly>
                    <input type="hidden" name="total_harga" id="total_harga" value="{{ old('total_harga', 0) }}">
                </div>
                @if($errors->has('total_harga'))
                    <span class="text-red-500 text-sm">{{ $errors->first('total_harga') }}</span>
                @endif
            </div>
            
            <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
            
            <div class="flex justify-end">
                <a onclick="history.back()" class="mr-3 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Format harga satuan saat halaman dimuat jika ada old value
        const hargaSatuanDisplay = document.getElementById('harga_satuan_display');
        const hargaSatuan = document.getElementById('harga_satuan');
        
        if(hargaSatuanDisplay.value) {
            hargaSatuan.value = hargaSatuanDisplay.value.replace(/[^0-9]/g, '');
        }
        
        // Hitung total jika ada old value
        if(hargaSatuan.value && document.getElementById('jumlah_bahan').value) {
            calculateTotal();
        }
    });

    document.getElementById('bahanForm').addEventListener('submit', function(e) {
        // Format harga satuan sebelum submit
        const hargaSatuanDisplay = document.getElementById('harga_satuan_display');
        const hargaSatuan = document.getElementById('harga_satuan');
        
        // Pastikan hidden field memiliki nilai yang benar
        if(hargaSatuanDisplay.value) {
            hargaSatuan.value = hargaSatuanDisplay.value.replace(/[^0-9]/g, '');
        }
        
        // Format total harga sebelum submit
        const totalHargaDisplay = document.getElementById('total_harga_display');
        const totalHarga = document.getElementById('total_harga');
        
        if(totalHargaDisplay.value) {
            totalHarga.value = totalHargaDisplay.value.replace(/[^0-9]/g, '');
        }
    });

    function formatRupiah(element, targetId) {

        let value = element.value.replace(/[^0-9]/g, '');
        

        document.getElementById(targetId).value = value;
        
        if(value.length > 0) {
            element.value = new Intl.NumberFormat('id-ID').format(value);
        } else {
            element.value = '';
        }
    }

    function calculateTotal() {
        const jumlahBahan = document.getElementById('jumlah_bahan').value;
        const hargaSatuan = document.getElementById('harga_satuan').value;
        
        if(jumlahBahan && hargaSatuan) {
            const totalHarga = jumlahBahan * hargaSatuan;
            document.getElementById('total_harga_display').value = new Intl.NumberFormat('id-ID').format(totalHarga);
            document.getElementById('total_harga').value = totalHarga;
        } else {
            document.getElementById('total_harga_display').value = '0';
            document.getElementById('total_harga').value = '0';
        }
    }
</script>
@endsection