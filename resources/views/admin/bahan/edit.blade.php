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
        <form action="{{ route('admin.bahan.update', $bahan->id_bhn) }}" method="POST" id="bahanForm">
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
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-700">Rp</span>
                    <input type="text" name="harga_satuan" id="harga_satuan" 
                           value="{{ number_format($bahan->harga_satuan, 0, ',', '.') }}" 
                           class="p-3 block w-full border rounded-md pl-10" 
                           required oninput="formatRupiah(this, 'harga_satuan_hidden'); calculateTotal()">
                    <input type="hidden" name="harga_satuan" id="harga_satuan_hidden" value="{{ $bahan->harga_satuan }}">
                </div>
            </div>
            <div class="mb-4">
                <label for="total_harga" class="block text-lg font-medium text-gray-700">Total Harga</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-700">Rp</span>
                    <input type="text" name="total_harga" id="total_harga" 
                           value="{{ number_format($bahan->total_harga, 0, ',', '.') }}" 
                           class="p-3 block w-full border rounded-md pl-10 bg-gray-100" readonly>
                    <input type="hidden" name="total_harga" id="total_harga_hidden" value="{{ $bahan->total_harga }}">
                </div>
            </div>
            <div class="flex justify-end">
                <a onclick="history.back()" class="mr-3 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('bahanForm').addEventListener('submit', function() {
        // Format harga satuan sebelum submit
        const hargaSatuan = document.getElementById('harga_satuan');
        hargaSatuan.value = hargaSatuan.value.replace(/[^0-9]/g, '');
        
        // Format total harga sebelum submit
        const totalHarga = document.getElementById('total_harga');
        totalHarga.value = totalHarga.value.replace(/[^0-9]/g, '');
    });

    function formatRupiah(element, hiddenId) {
        // Hapus semua karakter selain angka
        let value = element.value.replace(/[^0-9]/g, '');
        
        // Simpan nilai asli ke hidden input
        document.getElementById(hiddenId).value = value;
        
        // Format tampilan dengan "Rp" dan titik sebagai pemisah ribuan
        if(value.length > 0) {
            element.value =  new Intl.NumberFormat('id-ID').format(value);
        } else {
            element.value = '';
        }
    }

    function calculateTotal() {
        const jumlahBahan = document.getElementById('jumlah_bahan').value;
        const hargaSatuan = document.getElementById('harga_satuan_hidden').value;
        
        if(jumlahBahan && hargaSatuan) {
            const totalHarga = jumlahBahan * hargaSatuan;
            document.getElementById('total_harga').value = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalHarga);
            document.getElementById('total_harga_hidden').value = totalHarga;
        }
    }

    // Format awal saat halaman dimuat
    window.onload = function() {
        const hargaSatuan = document.getElementById('harga_satuan');
        if(hargaSatuan.value) {
            let value = hargaSatuan.value.replace(/[^0-9]/g, '');
            hargaSatuan.value =  new Intl.NumberFormat('id-ID').format(value);
        }
        
        const totalHarga = document.getElementById('total_harga');
        if(totalHarga.value) {
            let value = totalHarga.value.replace(/[^0-9]/g, '');
            totalHarga.value =  new Intl.NumberFormat('id-ID').format(value);
        }
    };
</script>
@endsection