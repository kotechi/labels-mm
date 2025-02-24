@extends('layouts.karyawan')

@section('title', 'Dashboard')

@section('content')
<div class="p-6 rounded-lg shadow bg-white ">
    <h1 class="block font-extrabold text-center text-4xl" style="color: #7D0066;">Dashboard Karyawan</h1>
</div>
<div class="p-6 mt-6 rounded-lg shadow-md bg-white ">
    <h3 class="text-lg font-semibold text-gray-700 mb-4">Overview</h3>
    <div class="grid grid-cols-3 gap-6">
        <!-- Pengeluaran -->
        <div class="relative p-4 bg-gray-50 border border-black rounded-lg ">
            <div class="flex items-center justify-between text-center">
                <span class="font-semibold text-gray-800 text-xl">{{ $pendingCount }}</span>
                <i data-lucide="arrow-left" class="h-6 w-6 text-gray-600"></i>
            </div>
            <span class=" block mt-2 text-xl">pending</span>
        </div>

        <!-- Pemasukan -->
        <div class="relative p-4 bg-gray-50 border border-black rounded-lg ">
            <div class="flex items-center justify-between text-center">
                <span class="font-semibold text-gray-800 text-xl">{{ $paidCount }}</span>
                <i data-lucide="wallet" class="h-6 w-6 text-gray-600"></i>
            </div>
            <span class="block mt-2 text-xl">Sudah dibayar</span>
        </div>

        <!-- Penghasilan -->
        <div class="relative p-4 bg-gray-50 border border-black rounded-lg ">
            <div class="flex items-center justify-between text-center">
                <span class="font-semibold text-gray-800 text-xl">{{ $completedCount }}</span>
                <i data-lucide="dollar-sign" class="h-6 w-6 text-gray-600"></i>
            </div>
            <span class="block mt-2 text-xl">Selesai</span>
        </div>
    </div>
</div>

<div class="bg-white shadow-md border mt-6">
    <div class="bg-labels shadow-lg rounded-sm">
        <div class="p-4 w-auto">
            <h3 class="text-lg text-white font-semibold">Tambah Data Pesanan</h3>
        </div>
    </div>
    <div class="p-6 mt-2">
        <form action="{{ route('karyawan.pesanans.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-6">
                <!-- Row 1 -->
                <div class="space-y-2">
                    <label for="nama_pemesan" class="block text-gray-700">Nama</label>
                    <input type="text" name="nama_pemesan" id="nama_pemesan" 
                        class="w-full p-2 border rounded-md" 
                        placeholder="masukan nama" required>
                </div>
                <div class="space-y-2">
                    <label for="product_id" class="block text-gray-700">Model</label>
                    <select name="product_id" id="product_id" 
                        class="w-full p-2 border rounded-md" required>
                        <option value="">masukan pesanan</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id_product }}" 
                                data-price="{{ $product->harga_jual }}"
                                data-name="{{ $product->nama_produk }}">
                                {{ $product->nama_produk }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="nama_produk" id="nama_produk">
                </div>

                <div class="space-y-2">
                    <label for="payment_method" class="block text-gray-700">Metode Pembayaran</label>
                    <select name="payment_method" id="payment_method" 
                        class="w-full p-2 border rounded-md" required>
                        <option value="">Pilih metode pembayaran</option>
                        <option value="cash">Cash</option>
                        <option value="transfer">Transfer</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="status_pesanan" class="block text-gray-700">Status Pesanan</label>
                    <select name="status_pesanan" id="status_pesanan" 
                        class="w-full p-2 border rounded-md" required>
                        <option value="proses">Proses</option>
                        <option value="paid">Paid</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <!-- Row 2 -->
                <div class="space-y-2">
                    <label for="total_harga_display" class="block text-gray-700">Total harga</label>
                    <input type="text" id="total_harga_display" 
                        class="w-full p-2 border rounded-md" 
                        readonly>
                    <input type="hidden" name="total_harga" id="total_harga" 
                        class="w-full p-2 border rounded-md" 
                        readonly>
                </div>
                <div class="space-y-2">
                    <label for="no_telp_pemesan" class="block text-gray-700">Nomor telepon</label>
                    <input type="text" name="no_telp_pemesan" id="no_telp_pemesan" 
                        class="w-full p-2 border rounded-md" 
                        placeholder="masukan nomor telepon" required>
                </div>

                <!-- Row 3 -->
                <div class="space-y-2">
                    <label for="jumlah_produk" class="block text-gray-700">Jumlah produk</label>
                    <div class="flex items-center space-x-2">
                        <button type="button" class="px-3 py-1 border rounded" onclick="decrementQuantity()">-</button>
                        <input type="number" name="jumlah_produk" id="jumlah_produk" 
                            class="w-20 p-2 border rounded-md text-center" 
                            value="1" min="1" required>
                        <button type="button" class="px-3 py-1 border rounded" onclick="incrementQuantity()">+</button>
                    </div>
                </div>
                <div class="space-y-2">
                    <label for="lingkar_pinggang" class="block text-gray-700">Lingkar pinggang</label>
                    <input type="number" step="0.01" name="lingkar_pinggang" id="lingkar_pinggang" 
                        class="w-full p-2 border rounded-md" 
                        placeholder="None" required>
                </div>

                <!-- Row 4 -->
                <div class="space-y-2">
                    <label for="lingkar_panggul" class="block text-gray-700">Lingkar pinggul</label>
                    <input type="number" step="0.01" name="lingkar_panggul" id="lingkar_panggul" 
                        class="w-full p-2 border rounded-md" 
                        placeholder="None" required>
                </div>
                <div class="space-y-2">
                    <label for="lebar_pundak" class="block text-gray-700">Lebar pundak</label>
                    <input type="number" step="0.01" name="lebar_pundak" id="lebar_pundak" 
                        class="w-full p-2 border rounded-md" 
                        placeholder="None" required>
                </div>

                <!-- Additional measurement fields in pairs -->
                <div class="space-y-2">
                    <label for="panjang_lengan" class="block text-gray-700">Panjang lengan</label>
                    <input type="number" step="0.01" name="panjang_lengan" id="panjang_lengan" 
                        class="w-full p-2 border rounded-md" 
                        placeholder="None" required>
                </div>
                <div class="space-y-2">
                    <label for="lingkar_kerung_lengan" class="block text-gray-700">Lingkar kerung lengan</label>
                    <input type="number" step="0.01" name="lingkar_kerung_lengan" id="lingkar_kerung_lengan" 
                        class="w-full p-2 border rounded-md" 
                        placeholder="None" required>
                </div>

                <div class="space-y-2">
                    <label for="lingkar_pergelangan_lengan" class="block text-gray-700">Lingkar pergelangan lengan</label>
                    <input type="number" step="0.01" name="lingkar_pergelangan_lengan" id="lingkar_pergelangan_lengan" 
                        class="w-full p-2 border rounded-md" 
                        placeholder="None" required>
                </div>
                <div class="space-y-2">
                    <label for="panjang_punggung" class="block text-gray-700">Panjang punggung</label>
                    <input type="number" step="0.01" name="panjang_punggung" id="panjang_punggung" 
                        class="w-full p-2 border rounded-md" 
                        placeholder="None" required>
                </div>

                <div class="space-y-2">
                    <label for="lebar_punggung" class="block text-gray-700">Lebar punggung</label>
                    <input type="number" step="0.01" name="lebar_punggung" id="lebar_punggung" 
                        class="w-full p-2 border rounded-md" 
                        placeholder="None" required>
                </div>
                <div class="space-y-2">
                    <label for="lebar_muka" class="block text-gray-700">Lebar muka</label>
                    <input type="number" step="0.01" name="lebar_muka" id="lebar_muka" 
                        class="w-full p-2 border rounded-md" 
                        placeholder="None" required>
                </div>
                <div class="space-y-2">
                    <label for="panjang_baju" class="block text-gray-700">Panjang Baju</label>
                    <input type="number" step="0.01" name="panjang_baju" id="panjang_baju" 
                        class="w-full p-2 border rounded-md" 
                        placeholder="None" required>
                </div>
                <div class="space-y-2">
                    <label for="lingkar_badan" class="block text-gray-700">Lingkar Badan</label>
                    <input type="number" step="0.01" name="lingkar_badan" id="lingkar_badan" 
                        class="w-full p-2 border rounded-md" 
                        placeholder="None" required>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('product_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    document.getElementById('nama_produk').value = selectedOption.dataset.name;
    updateTotal();
});
    // Definisikan fungsi secara global
    function incrementQuantity() {
        const quantityInput = document.getElementById('jumlah_produk');
        quantityInput.value = parseInt(quantityInput.value) + 1;
        updateTotal();
    }

    function decrementQuantity() {
        const quantityInput = document.getElementById('jumlah_produk');
        const currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
            updateTotal();
        }
    }

    function updateTotal() {
        const productSelect = document.getElementById('product_id');
        const quantityInput = document.getElementById('jumlah_produk');
        const totalPriceInput = document.getElementById('total_harga');
        const totalPriceDisplay = document.getElementById('total_harga_display');
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const price = parseFloat(selectedOption.dataset.price) || 0;
        const quantity = parseInt(quantityInput.value) || 0;
        const total = price * quantity;
        totalPriceInput.value = total;
        totalPriceDisplay.value = 'Rp ' + total.toLocaleString('id-ID');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const productSelect = document.getElementById('product_id');
        const quantityInput = document.getElementById('jumlah_produk');
        
        productSelect.addEventListener('change', updateTotal);
        quantityInput.addEventListener('input', updateTotal);
        
        // Initial calculation
        updateTotal();
    });
</script>
@endsection
