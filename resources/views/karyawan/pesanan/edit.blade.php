@extends('layouts.karyawan')

@section('title', 'Pesanan')

@section('content')
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Karyawan | Edit Pesanan</u>
    </div>
</div>
<div class="bg-white shadow-md border mt-6">
    <div class="bg-labels shadow-lg rounded-sm">
        <div class="p-4 w-auto">
            <h3 class="text-lg text-white font-semibold">Edit Data Pesanan</h3>
        </div>
    </div>
    <div class="p-6 mt-2">
        <form action="{{ route('karyawan.pesanans.update', $pesanan->id_pesanan) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-2 gap-6">
                <!-- Row 1 -->
                <div class="space-y-2">
                    <label for="nama_pemesan" class="block text-gray-700">Nama</label>
                    <input type="text" name="nama_pemesan" id="nama_pemesan" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->nama_pemesan }}" required>
                </div>
                <div class="space-y-2">
                    <label for="product_id" class="block text-gray-700">Model</label>
                    <select name="product_id" id="product_id" 
                        class="w-full p-2 border rounded-md" required>
                        @foreach($products as $product)
                            <option value="{{ $product->id_product }}" 
                                data-price="{{ $product->harga_jual }}"
                                data-name="{{ $product->nama_produk }}"
                                {{ $pesanan->product_id == $product->id_product ? 'selected' : '' }}>
                                {{ $product->nama_produk }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="nama_produk" id="nama_produk" value="{{ $pesanan->nama_produk }}">
                </div>

                <div class="space-y-2">
                    <label for="payment_method" class="block text-gray-700">Metode Pembayaran</label>
                    <select name="payment_method" id="payment_method" 
                        class="w-full p-2 border rounded-md" required>
                        <option value="cash" {{ $pesanan->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="transfer" {{ $pesanan->payment_method == 'transfer' ? 'selected' : '' }}>Transfer</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="status_pesanan" class="block text-gray-700">Status Pesanan</label>
                    <select name="status_pesanan" id="status_pesanan" 
                        class="w-full p-2 border rounded-md" required>
                        <option value="proses" {{ $pesanan->status_pesanan == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="paid" {{ $pesanan->status_pesanan == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="completed" {{ $pesanan->status_pesanan == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <!-- Row 2 -->
                <div class="space-y-2">
                    <label for="total_harga" class="block text-gray-700">Total harga</label>
                    <input type="text" id="total_harga_display" 
                        class="w-full p-2 border rounded-md" 
                        value="Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}" readonly>
                    <input type="hidden" name="total_harga" id="total_harga" value="{{ $pesanan->total_harga }}">
                </div>
                <div class="space-y-2">
                    <label for="no_telp_pemesan" class="block text-gray-700">Nomor telepon</label>
                    <input type="text" name="no_telp_pemesan" id="no_telp_pemesan" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->no_telp_pemesan }}" required>
                </div>

                <!-- Row 3 -->
                <div class="space-y-2">
                    <label for="jumlah_produk" class="block text-gray-700">Jumlah produk</label>
                    <div class="flex items-center space-x-2">
                        <button type="button" class="px-3 py-1 border rounded" onclick="decrementQuantity()">-</button>
                        <input type="number" name="jumlah_produk" id="jumlah_produk" 
                            class="w-20 p-2 border rounded-md text-center" 
                            value="{{ $pesanan->jumlah_produk }}" min="1" required>
                        <button type="button" class="px-3 py-1 border rounded" onclick="incrementQuantity()">+</button>
                    </div>
                </div>
                <div class="space-y-2">
                    <label for="lingkar_pinggang" class="block text-gray-700">Lingkar pinggang</label>
                    <input type="number" step="0.01" name="lingkar_pinggang" id="lingkar_pinggang" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->lingkar_pinggang }}" required>
                </div>

                <!-- Measurement fields -->
                <div class="space-y-2">
                    <label for="lingkar_panggul" class="block text-gray-700">Lingkar pinggul</label>
                    <input type="number" step="0.01" name="lingkar_panggul" id="lingkar_panggul" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->lingkar_panggul }}" required>
                </div>
                <div class="space-y-2">
                    <label for="lebar_pundak" class="block text-gray-700">Lebar pundak</label>
                    <input type="number" step="0.01" name="lebar_pundak" id="lebar_pundak" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->lebar_pundak }}" required>
                </div>

                <div class="space-y-2">
                    <label for="panjang_lengan" class="block text-gray-700">Panjang lengan</label>
                    <input type="number" step="0.01" name="panjang_lengan" id="panjang_lengan" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->panjang_lengan }}" required>
                </div>
                <div class="space-y-2">
                    <label for="lingkar_kerung_lengan" class="block text-gray-700">Lingkar kerung lengan</label>
                    <input type="number" step="0.01" name="lingkar_kerung_lengan" id="lingkar_kerung_lengan" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->lingkar_kerung_lengan }}" required>
                </div>

                <div class="space-y-2">
                    <label for="lingkar_pergelangan_lengan" class="block text-gray-700">Lingkar pergelangan lengan</label>
                    <input type="number" step="0.01" name="lingkar_pergelangan_lengan" id="lingkar_pergelangan_lengan" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->lingkar_pergelangan_lengan }}" required>
                </div>
                <div class="space-y-2">
                    <label for="panjang_punggung" class="block text-gray-700">Panjang punggung</label>
                    <input type="number" step="0.01" name="panjang_punggung" id="panjang_punggung" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->panjang_punggung }}" required>
                </div>

                <div class="space-y-2">
                    <label for="lebar_punggung" class="block text-gray-700">Lebar punggung</label>
                    <input type="number" step="0.01" name="lebar_punggung" id="lebar_punggung" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->lebar_punggung }}" required>
                </div>
                <div class="space-y-2">
                    <label for="lebar_muka" class="block text-gray-700">Lebar muka</label>
                    <input type="number" step="0.01" name="lebar_muka" id="lebar_muka" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->lebar_muka }}" required>
                </div>
                <div class="space-y-2">
                    <label for="panjang_baju" class="block text-gray-700">Panjang Baju</label>
                    <input type="number" step="0.01" name="panjang_baju" id="panjang_baju" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->panjang_baju }}" required>
                </div>
                <div class="space-y-2">
                    <label for="lingkar_badan" class="block text-gray-700">Lingkar Badan</label>
                    <input type="number" step="0.01" name="lingkar_badan" id="lingkar_badan" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->lingkar_badan }}" required>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-2">
                <a href="{{ route('karyawan.pesanans.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
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
        const totalPriceDisplay = document.getElementById('total_harga_display');
        const totalPriceInput = document.getElementById('total_harga');
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const price = parseFloat(selectedOption.dataset.price) || 0;
        const quantity = parseInt(quantityInput.value) || 0;
        const total = price * quantity;
        totalPriceDisplay.value = 'Rp ' + total.toLocaleString('id-ID');
        totalPriceInput.value = total;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const productSelect = document.getElementById('product_id');
        const quantityInput = document.getElementById('jumlah_produk');
        
        productSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            document.getElementById('nama_produk').value = selectedOption.dataset.name;
            updateTotal();
        });
        
        quantityInput.addEventListener('input', updateTotal);
        
        // Initial calculation
        updateTotal();
    });
</script>
@endsection