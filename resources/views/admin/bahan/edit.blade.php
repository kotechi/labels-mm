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
                <label for="harga_satuan_display" class="block text-lg font-medium text-gray-700">Harga Satuan</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-700">Rp</span>
                    <input type="text" name="harga_satuan_display" id="harga_satuan_display" 
                           value="{{ number_format($bahan->harga_satuan, 0, ',', '.') }}" 
                           class="p-3 block w-full border rounded-md pl-10" 
                           required oninput="formatRupiah(this, 'harga_satuan'); calculateTotal()">
                    <input type="hidden" name="harga_satuan" id="harga_satuan" value="{{ $bahan->harga_satuan }}">
                </div>
            </div>
            <div class="mb-4">
                <label for="total_harga_display" class="block text-lg font-medium text-gray-700">Total Harga</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-700">Rp</span>
                    <input type="text" name="total_harga_display" id="total_harga_display" 
                           value="{{ number_format($bahan->total_harga, 0, ',', '.') }}" 
                           class="p-3 block w-full border rounded-md pl-10 bg-gray-100" readonly>
                    <input type="hidden" name="total_harga" id="total_harga" value="{{ $bahan->total_harga }}">
                </div>
            </div>
            
            <!-- New Period Days Field -->
            <div class="mb-4">
                <label for="periode_hari" class="block text-lg font-medium text-gray-700">Periode Hari</label>
                <input type="number" name="periode_hari" id="periode_hari" 
                       value="{{ old('periode_hari', isset($bahan->periode_hari) ? $bahan->periode_hari : 1) }}" 
                       min="1"
                       placeholder="masukan jumlah hari" 
                       class="p-3 block w-full border rounded-md" 
                       required oninput="calculateDailyAmount()">
            </div>
            
            <!-- Daily Amount Preview -->
            <div class="mb-4">
                <label for="nominal_per_hari_display" class="block text-lg font-medium text-gray-700">Nominal Per Hari</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-700">Rp</span>
                    <input type="text" name="nominal_per_hari_display" id="nominal_per_hari_display" 
                           value="0" 
                           class="p-3 block w-full border rounded-md pl-10 bg-gray-100" readonly>
                    <input type="hidden" name="nominal_per_hari" id="nominal_per_hari" value="0">
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
    document.addEventListener('DOMContentLoaded', function() {
        // Calculate daily amount on page load
        calculateTotal();
        calculateDailyAmount();
    });

    document.getElementById('bahanForm').addEventListener('submit', function(e) {
        // No need to prevent default here, we want the form to submit
        
        // Format harga satuan sebelum submit
        const hargaSatuanDisplay = document.getElementById('harga_satuan_display');
        const hargaSatuan = document.getElementById('harga_satuan');
        
        // Ensure the hidden field has the correct value
        if(hargaSatuanDisplay.value) {
            hargaSatuan.value = hargaSatuanDisplay.value.replace(/[^0-9]/g, '');
        }
        
        // Format total harga sebelum submit
        const totalHargaDisplay = document.getElementById('total_harga_display');
        const totalHarga = document.getElementById('total_harga');
        
        if(totalHargaDisplay.value) {
            totalHarga.value = totalHargaDisplay.value.replace(/[^0-9]/g, '');
        }
        
        // Format nominal per hari sebelum submit
        const nominalPerHariDisplay = document.getElementById('nominal_per_hari_display');
        const nominalPerHari = document.getElementById('nominal_per_hari');
        
        if(nominalPerHariDisplay.value) {
            nominalPerHari.value = nominalPerHariDisplay.value.replace(/[^0-9]/g, '');
        }
    });

    function formatRupiah(element, targetId) {
        // Hapus semua karakter selain angka
        let value = element.value.replace(/[^0-9]/g, '');
        
        // Simpan nilai asli ke hidden input
        document.getElementById(targetId).value = value;
        
        // Format tampilan dengan titik sebagai pemisah ribuan
        if(value.length > 0) {
            element.value = new Intl.NumberFormat('id-ID').format(value);
        } else {
            element.value = '';
        }
        
        // Recalculate other values when harga_satuan changes
        calculateTotal();
    }

    function calculateTotal() {
        const jumlahBahan = document.getElementById('jumlah_bahan').value || 0;
        const hargaSatuan = document.getElementById('harga_satuan').value || 0;
        
        if(jumlahBahan && hargaSatuan) {
            const totalHarga = jumlahBahan * hargaSatuan;
            document.getElementById('total_harga_display').value = new Intl.NumberFormat('id-ID').format(totalHarga);
            document.getElementById('total_harga').value = totalHarga;
            calculateDailyAmount(); // Recalculate daily amount when total changes
        } else {
            document.getElementById('total_harga_display').value = '0';
            document.getElementById('total_harga').value = '0';
        }
    }
    
    function calculateDailyAmount() {
        const totalHarga = parseInt(document.getElementById('total_harga').value) || 0;
        const periodeHari = parseInt(document.getElementById('periode_hari').value) || 1;
        
        if(totalHarga && periodeHari && periodeHari > 0) {
            const nominalPerHari = Math.floor(totalHarga / periodeHari);
            document.getElementById('nominal_per_hari_display').value = new Intl.NumberFormat('id-ID').format(nominalPerHari);
            document.getElementById('nominal_per_hari').value = nominalPerHari;
        } else {
            document.getElementById('nominal_per_hari_display').value = '0';
            document.getElementById('nominal_per_hari').value = '0';
        }
    }
</script>
@endsection