@extends('layouts.admin')

@section('title', 'Pesanan')

@section('content')
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Admin | Edit Pesanan</u>
    </div>
</div>
<div class="bg-white shadow-md border mt-6">
    <div class="bg-labels shadow-lg rounded-sm">
        <div class="p-4 w-auto">
            <h3 class="text-lg text-white font-semibold">Edit Data Pesanan</h3>
        </div>
    </div>
    <div class="p-6 mt-2">
        <form action="{{ route('pesanans.update', $pesanan->id_pesanan) }}" method="POST">
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
                            data-stock="{{ $product->stock_product }}"
                            {{ $pesanan->product_id == $product->id_product ? 'selected' : '' }}>
                            {{ $product->nama_produk }} (Stok: {{ $product->stock_product }})
                        </option>
                    @endforeach
                    </select>
                    <input type="hidden" name="nama_produk" id="nama_produk" value="{{ $pesanan->nama_produk }}">
                    <div id="stock-message" class="text-sm text-red-600 hidden"></div>
                </div>

                <div class="space-y-2">
                    <label for="payment_method" class="block text-gray-700">Metode Pembayaran</label>
                    <select name="payment_method" id="payment_method" 
                        class="w-full p-2 border rounded-md" required>
                        <option value="cash" {{ $pesanan->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="midtrans" {{ $pesanan->payment_method == 'midtrans' ? 'selected' : '' }}>Online Payment (Midtrans)</option>
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
                
                <!-- Size Selection - Added to match create form -->
                <div class="space-y-2">
                    <label for="size_option" class="block text-gray-700">Pilihan Ukuran</label>
                    <select name="size_option" id="size_option" class="w-full p-2 border rounded-md">
                        <option value="custom" selected>Ukuran Kustom</option>
                        <option value="S">Small (S)</option>
                        <option value="M">Medium (M)</option>
                        <option value="L">Large (L)</option>
                        <option value="XL">Extra Large (XL)</option>
                        <option value="2XL">2XL</option>
                        <option value="3XL">3XL</option>
                        <option value="4XL">4XL</option>
                    </select>
                </div>

                <!-- Measurement Fields section -->
                <div class="col-span-2">
                    <div class="border-t pt-4 mb-2">
                        <h3 class="font-semibold text-lg">Ukuran</h3>
                    </div>
                </div>

                <!-- Measurement fields in pairs -->
                <div class="space-y-2">
                    <label for="lingkar_badan" class="block text-gray-700">Lingkar Badan (cm)</label>
                    <input type="number" step="0.01" name="lingkar_badan" id="lingkar_badan" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->lingkar_badan }}" required>
                </div>
                <div class="space-y-2">
                    <label for="lingkar_pinggang" class="block text-gray-700">Lingkar pinggang (cm)</label>
                    <input type="number" step="0.01" name="lingkar_pinggang" id="lingkar_pinggang" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->lingkar_pinggang }}" required>
                </div>

                <div class="space-y-2">
                    <label for="lingkar_panggul" class="block text-gray-700">Lingkar pinggul (cm)</label>
                    <input type="number" step="0.01" name="lingkar_panggul" id="lingkar_panggul" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->lingkar_panggul }}" required>
                </div>
                <div class="space-y-2">
                    <label for="lebar_pundak" class="block text-gray-700">Lebar pundak (cm)</label>
                    <input type="number" step="0.01" name="lebar_pundak" id="lebar_pundak" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->lebar_pundak }}" required>
                </div>

                <div class="space-y-2">
                    <label for="panjang_lengan" class="block text-gray-700">Panjang lengan (cm)</label>
                    <input type="number" step="0.01" name="panjang_lengan" id="panjang_lengan" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->panjang_lengan }}" required>
                </div>
                <div class="space-y-2">
                    <label for="lingkar_kerung_lengan" class="block text-gray-700">Lingkar kerung lengan (cm)</label>
                    <input type="number" step="0.01" name="lingkar_kerung_lengan" id="lingkar_kerung_lengan" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->lingkar_kerung_lengan }}" required>
                </div>

                <div class="space-y-2">
                    <label for="lingkar_pergelangan_lengan" class="block text-gray-700">Lingkar pergelangan lengan (cm)</label>
                    <input type="number" step="0.01" name="lingkar_pergelangan_lengan" id="lingkar_pergelangan_lengan" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->lingkar_pergelangan_lengan }}" required>
                </div>
                <div class="space-y-2">
                    <label for="panjang_punggung" class="block text-gray-700">Panjang punggung (cm)</label>
                    <input type="number" step="0.01" name="panjang_punggung" id="panjang_punggung" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->panjang_punggung }}" required>
                </div>

                <div class="space-y-2">
                    <label for="lebar_punggung" class="block text-gray-700">Lebar punggung (cm)</label>
                    <input type="number" step="0.01" name="lebar_punggung" id="lebar_punggung" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->lebar_punggung }}" required>
                </div>
                <div class="space-y-2">
                    <label for="lebar_muka" class="block text-gray-700">Lebar muka (cm)</label>
                    <input type="number" step="0.01" name="lebar_muka" id="lebar_muka" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->lebar_muka }}" required>
                </div>
                <div class="space-y-2">
                    <label for="panjang_baju" class="block text-gray-700">Panjang Baju (cm)</label>
                    <input type="number" step="0.01" name="panjang_baju" id="panjang_baju" 
                        class="w-full p-2 border rounded-md" 
                        value="{{ $pesanan->panjang_baju }}" required>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-2">
                <a onclick="history.back()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700" id="submit-button">
                    Update
                </button>
            </div>
            
        </form>
    </div>
</div>

<script>
    // Standard size measurements (in cm)
    const standardSizes = {
        'S': {
            lingkar_badan: 90,
            lingkar_pinggang: 76,
            lingkar_panggul: 96,
            lebar_pundak: 40,
            panjang_lengan: 58,
            lingkar_kerung_lengan: 42,
            lingkar_pergelangan_lengan: 18,
            panjang_punggung: 38,
            lebar_punggung: 40,
            lebar_muka: 31,
            panjang_baju: 68
        },
        'M': {
            lingkar_badan: 96,
            lingkar_pinggang: 80,
            lingkar_panggul: 100,
            lebar_pundak: 42,
            panjang_lengan: 60,
            lingkar_kerung_lengan: 45,
            lingkar_pergelangan_lengan: 20,
            panjang_punggung: 40,
            lebar_punggung: 43,
            lebar_muka: 33,
            panjang_baju: 70
        },
        'L': {
            lingkar_badan: 102,
            lingkar_pinggang: 86,
            lingkar_panggul: 106,
            lebar_pundak: 44,
            panjang_lengan: 61,
            lingkar_kerung_lengan: 48,
            lingkar_pergelangan_lengan: 22,
            panjang_punggung: 42,
            lebar_punggung: 46,
            lebar_muka: 35,
            panjang_baju: 72
        },
        'XL': {
            lingkar_badan: 108,
            lingkar_pinggang: 92,
            lingkar_panggul: 112,
            lebar_pundak: 46,
            panjang_lengan: 62,
            lingkar_kerung_lengan: 51,
            lingkar_pergelangan_lengan: 24,
            panjang_punggung: 44,
            lebar_punggung: 49,
            lebar_muka: 37,
            panjang_baju: 74
        },
        '2XL': {
            lingkar_badan: 116,
            lingkar_pinggang: 100,
            lingkar_panggul: 120,
            lebar_pundak: 48,
            panjang_lengan: 63,
            lingkar_kerung_lengan: 54,
            lingkar_pergelangan_lengan: 26,
            panjang_punggung: 46,
            lebar_punggung: 52,
            lebar_muka: 39,
            panjang_baju: 76
        },
        '3XL': {
            lingkar_badan: 124,
            lingkar_pinggang: 108,
            lingkar_panggul: 128,
            lebar_pundak: 50,
            panjang_lengan: 64,
            lingkar_kerung_lengan: 57,
            lingkar_pergelangan_lengan: 28,
            panjang_punggung: 48,
            lebar_punggung: 55,
            lebar_muka: 41,
            panjang_baju: 78
        },
        '4XL': {
            lingkar_badan: 132,
            lingkar_pinggang: 116,
            lingkar_panggul: 136,
            lebar_pundak: 52,
            panjang_lengan: 65,
            lingkar_kerung_lengan: 60,
            lingkar_pergelangan_lengan: 30,
            panjang_punggung: 50,
            lebar_punggung: 58,
            lebar_muka: 43,
            panjang_baju: 80
        }
    };

    let currentStock = 0;
    let originalQuantity = parseInt(document.getElementById('jumlah_produk').value) || 0;
    let originalProductId = document.getElementById('product_id').value;

    function incrementQuantity() {
        const quantityInput = document.getElementById('jumlah_produk');
        const newValue = parseInt(quantityInput.value) + 1;
        
        // Check if we have enough stock for increment
        if (checkStockAvailability(newValue)) {
            quantityInput.value = newValue;
            updateTotal();
        }
    }

    function decrementQuantity() {
        const quantityInput = document.getElementById('jumlah_produk');
        const currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
            updateTotal();
            updateStockMessage();
        }
    }
    
    function checkStockAvailability(requestedQuantity) {
        const productSelect = document.getElementById('product_id');
        const selectedId = productSelect.value;
        
        // If it's the same product as original order, we only need to check additional quantity
        if (selectedId == originalProductId) {
            // We only need to account for additional units beyond original order
            const additionalQuantity = requestedQuantity - originalQuantity;
            if (additionalQuantity > 0 && additionalQuantity > currentStock) {
                return false;
            }
            return true;
        } else {
            // It's a different product, so we need to check the full quantity
            return requestedQuantity <= currentStock;
        }
    }

    function updateStockMessage() {
        const quantityInput = document.getElementById('jumlah_produk');
        const stockMessage = document.getElementById('stock-message');
        const submitButton = document.getElementById('submit-button');
        const productSelect = document.getElementById('product_id');
        const selectedId = productSelect.value;
        const quantity = parseInt(quantityInput.value) || 0;
        
        stockMessage.classList.remove('hidden');
        
        if (selectedId == originalProductId) {
            // Same product as original order
            const additionalQuantity = quantity - originalQuantity;
            
            if (additionalQuantity > 0) {
                // Need additional stock
                if (additionalQuantity > currentStock) {
                    stockMessage.textContent = `Stok tidak cukup (sisa: ${currentStock})`;
                    stockMessage.classList.add('text-red-600');
                    stockMessage.classList.remove('text-green-600');
                    submitButton.disabled = true;
                    submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    stockMessage.textContent = `Stok tersedia: ${currentStock}`;
                    stockMessage.classList.add('text-green-600');
                    stockMessage.classList.remove('text-red-600');
                    submitButton.disabled = false;
                    submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            } else {
                // Reducing quantity, always allowed
                stockMessage.textContent = `Stok tersedia: ${currentStock}`;
                stockMessage.classList.add('text-green-600');
                stockMessage.classList.remove('text-red-600');
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        } else {
            // Different product
            if (quantity > currentStock) {
                stockMessage.textContent = `Stok tidak cukup (sisa: ${currentStock})`;
                stockMessage.classList.add('text-red-600');
                stockMessage.classList.remove('text-green-600');
                submitButton.disabled = true;
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                stockMessage.textContent = `Stok tersedia: ${currentStock}`;
                stockMessage.classList.add('text-green-600');
                stockMessage.classList.remove('text-red-600');
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            }
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
        updateStockMessage();
    }
    
    // Size selection handler
    document.getElementById('size_option').addEventListener('change', function() {
        const selectedSize = this.value;
        
        if (selectedSize !== 'custom') {
            // Fill in the form with standard measurements
            const measurements = standardSizes[selectedSize];
            
            for (const [field, value] of Object.entries(measurements)) {
                const input = document.getElementById(field);
                if (input) {
                    input.value = value;
                }
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const productSelect = document.getElementById('product_id');
        const quantityInput = document.getElementById('jumlah_produk');
        
        // Initialize with the current selected product's stock
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        currentStock = parseInt(selectedOption.dataset.stock) || 0;
        
        productSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            document.getElementById('nama_produk').value = selectedOption.dataset.name;
            currentStock = parseInt(selectedOption.dataset.stock) || 0;
            updateTotal();
        });
        
        quantityInput.addEventListener('input', function() {
            updateTotal();
        });
        
        // Initial calculation
        updateTotal();
    });
</script>
@endsection