@extends('layouts.karyawan')

@section('title', 'Pesanan')

@section('content')
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Karyawan | Edit Pesanan</u>
    </div>
</div>

<!-- Flash Messages -->
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

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
                        class="w-full p-2 border rounded-md @error('nama_pemesan') border-red-500 @enderror" 
                        value="{{ old('nama_pemesan', $pesanan->nama_pemesan) }}" >
                    @error('nama_pemesan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="product_id" class="block text-gray-700">Model</label>
                    <select name="product_id" id="product_id" 
                        class="w-full p-2 border rounded-md @error('product_id') border-red-500 @enderror">
                    
                        <!-- Add the original product if it's been deleted -->
                        @if(!$products->contains('id_product', $pesanan->product_id))
                            <option value="{{ $pesanan->product_id }}" 
                                    data-price="{{ $pesanan->total_harga / $pesanan->jumlah_produk }}"
                                    data-name="{{ $pesanan->nama_produk }}"
                                    data-stock="{{ $pesanan->jumlah_produk }}"
                                    data-deleted="true"
                                    {{ old('product_id', $pesanan->product_id) == $pesanan->product_id ? 'selected' : '' }}>
                                {{ $pesanan->nama_produk }} (Product deleted)
                            </option>
                        @endif
                        
                        <!-- List all active products -->
                        @foreach($products as $product)
                            <option value="{{ $product->id_product }}" 
                                    data-price="{{ $product->harga_jual }}"
                                    data-name="{{ $product->nama_produk }}"
                                    data-stock="{{ $product->stock_product }}"
                                    data-deleted="false"
                                    {{ old('product_id', $pesanan->product_id) == $product->id_product ? 'selected' : '' }}>
                                {{ $product->nama_produk }} (Stok: {{ $product->stock_product }})
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="nama_produk" id="nama_produk" value="{{ old('nama_produk', $pesanan->nama_produk) }}">
                    <div id="stock-message" class="text-sm text-red-600 hidden"></div>
                    @error('product_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="payment_method" class="block text-gray-700">Metode Pembayaran</label>
                    <select name="payment_method" id="payment_method" 
                        class="w-full p-2 border rounded-md @error('payment_method') border-red-500 @enderror" >
                        <option value="cash" {{ old('payment_method', $pesanan->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="midtrans" {{ old('payment_method', $pesanan->payment_method) == 'midtrans' ? 'selected' : '' }}>Online Payment (Midtrans)</option>
                    </select>
                    @error('payment_method')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="status_pesanan" class="block text-gray-700">Status Pesanan</label>
                    <select name="status_pesanan" id="status_pesanan" 
                        class="w-full p-2 border rounded-md @error('status_pesanan') border-red-500 @enderror" >
                        <option value="proses" {{ old('status_pesanan', $pesanan->status_pesanan) == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="paid" {{ old('status_pesanan', $pesanan->status_pesanan) == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="completed" {{ old('status_pesanan', $pesanan->status_pesanan) == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status_pesanan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Row 2 -->
                <div class="space-y-2">
                    <label for="total_harga" class="block text-gray-700">Total harga</label>
                    <input type="text" id="total_harga_display" 
                        class="w-full p-2 border rounded-md" 
                        value="Rp {{ number_format(old('total_harga', $pesanan->total_harga), 0, ',', '.') }}" readonly>
                    <input type="hidden" name="total_harga" id="total_harga" value="{{ old('total_harga', $pesanan->total_harga) }}">
                    @error('total_harga')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="no_telp_pemesan" class="block text-gray-700">Nomor telepon</label>
                    <input type="text" name="no_telp_pemesan" id="no_telp_pemesan" 
                        class="w-full p-2 border rounded-md @error('no_telp_pemesan') border-red-500 @enderror" 
                        value="{{ old('no_telp_pemesan', $pesanan->no_telp_pemesan) }}" >
                    @error('no_telp_pemesan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Row 3 -->
                <div class="space-y-2">
                    <label for="jumlah_produk" class="block text-gray-700">Jumlah produk</label>
                    <div class="flex items-center space-x-2">
                        <button type="button" class="px-3 py-1 border rounded" onclick="decrementQuantity()">-</button>
                        <input type="number" name="jumlah_produk" id="jumlah_produk" 
                            class="w-20 p-2 border rounded-md text-center @error('jumlah_produk') border-red-500 @enderror" 
                            value="{{ old('jumlah_produk', $pesanan->jumlah_produk) }}" min="1" >
                        <button type="button" class="px-3 py-1 border rounded" onclick="incrementQuantity()">+</button>
                    </div>
                    @error('jumlah_produk')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Size Selection -->
                <div class="space-y-2">
                    <label for="size_option" class="block text-gray-700">Pilihan Ukuran</label>
                    <select name="size_option" id="size_option" class="w-full p-2 border rounded-md">
                        <option value="custom" {{ old('size_option', 'custom') == 'custom' ? 'selected' : '' }}>Ukuran Kustom</option>
                        <option value="S" {{ old('size_option') == 'S' ? 'selected' : '' }}>Small (S)</option>
                        <option value="M" {{ old('size_option') == 'M' ? 'selected' : '' }}>Medium (M)</option>
                        <option value="L" {{ old('size_option') == 'L' ? 'selected' : '' }}>Large (L)</option>
                        <option value="XL" {{ old('size_option') == 'XL' ? 'selected' : '' }}>Extra Large (XL)</option>
                        <option value="2XL" {{ old('size_option') == '2XL' ? 'selected' : '' }}>2XL</option>
                        <option value="3XL" {{ old('size_option') == '3XL' ? 'selected' : '' }}>3XL</option>
                        <option value="4XL" {{ old('size_option') == '4XL' ? 'selected' : '' }}>4XL</option>
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
                        class="w-full p-2 border rounded-md @error('lingkar_badan') border-red-500 @enderror" 
                        value="{{ old('lingkar_badan', $pesanan->lingkar_badan) }}" >
                    @error('lingkar_badan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="lingkar_pinggang" class="block text-gray-700">Lingkar pinggang (cm)</label>
                    <input type="number" step="0.01" name="lingkar_pinggang" id="lingkar_pinggang" 
                        class="w-full p-2 border rounded-md @error('lingkar_pinggang') border-red-500 @enderror" 
                        value="{{ old('lingkar_pinggang', $pesanan->lingkar_pinggang) }}" >
                    @error('lingkar_pinggang')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="lingkar_panggul" class="block text-gray-700">Lingkar pinggul (cm)</label>
                    <input type="number" step="0.01" name="lingkar_panggul" id="lingkar_panggul" 
                        class="w-full p-2 border rounded-md @error('lingkar_panggul') border-red-500 @enderror" 
                        value="{{ old('lingkar_panggul', $pesanan->lingkar_panggul) }}" >
                    @error('lingkar_panggul')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="lebar_pundak" class="block text-gray-700">Lebar pundak (cm)</label>
                    <input type="number" step="0.01" name="lebar_pundak" id="lebar_pundak" 
                        class="w-full p-2 border rounded-md @error('lebar_pundak') border-red-500 @enderror" 
                        value="{{ old('lebar_pundak', $pesanan->lebar_pundak) }}" >
                    @error('lebar_pundak')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="panjang_lengan" class="block text-gray-700">Panjang lengan (cm)</label>
                    <input type="number" step="0.01" name="panjang_lengan" id="panjang_lengan" 
                        class="w-full p-2 border rounded-md @error('panjang_lengan') border-red-500 @enderror" 
                        value="{{ old('panjang_lengan', $pesanan->panjang_lengan) }}" >
                    @error('panjang_lengan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="lingkar_kerung_lengan" class="block text-gray-700">Lingkar kerung lengan (cm)</label>
                    <input type="number" step="0.01" name="lingkar_kerung_lengan" id="lingkar_kerung_lengan" 
                        class="w-full p-2 border rounded-md @error('lingkar_kerung_lengan') border-red-500 @enderror" 
                        value="{{ old('lingkar_kerung_lengan', $pesanan->lingkar_kerung_lengan) }}" >
                    @error('lingkar_kerung_lengan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="lingkar_pergelangan_lengan" class="block text-gray-700">Lingkar pergelangan lengan (cm)</label>
                    <input type="number" step="0.01" name="lingkar_pergelangan_lengan" id="lingkar_pergelangan_lengan" 
                        class="w-full p-2 border rounded-md @error('lingkar_pergelangan_lengan') border-red-500 @enderror" 
                        value="{{ old('lingkar_pergelangan_lengan', $pesanan->lingkar_pergelangan_lengan) }}" >
                    @error('lingkar_pergelangan_lengan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="panjang_punggung" class="block text-gray-700">Panjang punggung (cm)</label>
                    <input type="number" step="0.01" name="panjang_punggung" id="panjang_punggung" 
                        class="w-full p-2 border rounded-md @error('panjang_punggung') border-red-500 @enderror" 
                        value="{{ old('panjang_punggung', $pesanan->panjang_punggung) }}" >
                    @error('panjang_punggung')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="lebar_punggung" class="block text-gray-700">Lebar punggung (cm)</label>
                    <input type="number" step="0.01" name="lebar_punggung" id="lebar_punggung" 
                        class="w-full p-2 border rounded-md @error('lebar_punggung') border-red-500 @enderror" 
                        value="{{ old('lebar_punggung', $pesanan->lebar_punggung) }}" >
                    @error('lebar_punggung')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="lebar_muka" class="block text-gray-700">Lebar muka (cm)</label>
                    <input type="number" step="0.01" name="lebar_muka" id="lebar_muka" 
                        class="w-full p-2 border rounded-md @error('lebar_muka') border-red-500 @enderror" 
                        value="{{ old('lebar_muka', $pesanan->lebar_muka) }}" >
                    @error('lebar_muka')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="panjang_baju" class="block text-gray-700">Panjang Baju (cm)</label>
                    <input type="number" step="0.01" name="panjang_baju" id="panjang_baju" 
                        class="w-full p-2 border rounded-md @error('panjang_baju') border-red-500 @enderror" 
                        value="{{ old('panjang_baju', $pesanan->panjang_baju) }}" >
                    @error('panjang_baju')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-2">
                <a onclick="history.back()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700 cursor-pointer">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700" id="submit-button">
                    Update
                </button>
            </div>
            
        </form>
    </div>
</div>
@endsection
@push('scripts')
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
    const quantityIncButton = document.querySelector('button[onclick="incrementQuantity()"]');
    const quantityDecButton = document.querySelector('button[onclick="decrementQuantity()"]');
    
    // Initialize with the current selected product's stock
    const selectedOption = productSelect.options[productSelect.selectedIndex];
    currentStock = parseInt(selectedOption.dataset.stock) || 0;
    const isDeleted = selectedOption.dataset.deleted === 'true';
    
    // Handle deleted product initially
    if (isDeleted) {
        quantityInput.readOnly = true;
        quantityIncButton.disabled = true;
        quantityDecButton.disabled = true;
        quantityIncButton.classList.add('opacity-50', 'cursor-not-allowed');
        quantityDecButton.classList.add('opacity-50', 'cursor-not-allowed');
    }
    
    productSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        document.getElementById('nama_produk').value = selectedOption.dataset.name;
        currentStock = parseInt(selectedOption.dataset.stock) || 0;
        
        // Check if selected product is deleted
        const isDeleted = selectedOption.dataset.deleted === 'true';
        
        if (isDeleted) {
            // Disable quantity controls for deleted product
            quantityInput.readOnly = true;
            quantityIncButton.disabled = true;
            quantityDecButton.disabled = true;
            quantityIncButton.classList.add('opacity-50', 'cursor-not-allowed');
            quantityDecButton.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            // Enable quantity controls for active products
            quantityInput.readOnly = false;
            quantityIncButton.disabled = false;
            quantityDecButton.disabled = false;
            quantityIncButton.classList.remove('opacity-50', 'cursor-not-allowed');
            quantityDecButton.classList.remove('opacity-50', 'cursor-not-allowed');
        }
        
        updateTotal();
    });
    
    quantityInput.addEventListener('input', function() {
        updateTotal();
    });
    
    // Initial calculation
    updateTotal();
});
</script>
@endpush