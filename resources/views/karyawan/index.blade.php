@extends('layouts.karyawan')

@section('title', 'Dashboard')

@section('content')
<div class="p-6 rounded-lg shadow bg-white ">
    <h1 class="block font-extrabold text-center text-4xl" style="color: #7D0066;">Dashboard Karyawan</h1>
</div>
    <div class="bg-white rounded-lg shadow-md p-6 mt-6">
        <div class="grid grid-cols-2  gap-6 mb-6">

            <!-- belum lunas -->
            <div class="relative p-4 shadow-lg border border-black rounded-lg ">
                <div class="flex items-center justify-between text-center">
                    <span class="font-semibold text-gray-800 text-xl">{{$pendingCount}}</span>
                    <i data-lucide="arrow-left" class="h-6 w-6 text-gray-600"></i>
                </div>
                <span class=" block mt-2 text-xl">Belum Lunas</span>
            </div>
    
            <!-- Sudah lunas -->
            <div class="relative p-4 shadow-lg border border-black rounded-lg ">
                <div class="flex items-center justify-between text-center">
                    <span class="font-semibold text-gray-800 text-xl">{{$paidCount+$completedCount}}</span>
                    <i data-lucide="wallet" class="h-6 w-6 text-gray-600"></i>
                </div>
                <span class="block mt-2 text-xl">Sudah Lunas</span>
            </div>
            
            <!-- Dalama Proses -->
            <div class="relative p-4 shadow-lg border border-black rounded-lg ">
                <div class="flex items-center justify-between text-center">
                    <span class="font-semibold text-gray-800 text-xl">{{$dp}}</span>
                    <i data-lucide="arrow-left" class="h-6 w-6 text-gray-600"></i>
                </div>
                <span class=" block mt-2 text-xl">Dalam Proses</span>
            </div>


    
            <!-- Dibatalkan -->
            <div class="relative p-4 shadow-lg border border-black rounded-lg ">
                <div class="flex items-center justify-between text-center">
                    <span class="font-semibold text-gray-800 text-xl">{{$completedCount}}</span>
                    <i data-lucide="dollar-sign" class="h-6 w-6 text-gray-600"></i>
                </div>
                <span class="block mt-2 text-xl">Selesai</span>
            </div>
        </div>
        <div class="card-tittle-section mt-20">
            <h2 class="card-tittle">Pesanan</h2>
        </div>
        <div class="overflow-x-auto table-responsive">
            <table class="datatable table table-stripped min-w-full divide-y divide-gray-200">
                <thead class="bg-thead">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Nama </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Model</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Total Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">No. telp</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                        $no_pesanan = 1;    
                    ?>
                    @foreach($pesanans as $pesanan)
                    <tr class="cursor-pointer hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $no_pesanan++ }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->nama_pemesan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->nama_produk }}</td>    
                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->jumlah_produk }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pesanan->no_telp_pemesan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($pesanan->status_pesanan == 'proses')
                                <form action="{{ route('pesanans.markAsPaid', $pesanan->id_pesanan) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="px-3 py-2 bg-yellow-500 hover:bg-yello-600 text-white rounded-md mark-as-paid-button">Belum bayar</button>
                                </form>
                            @elseif($pesanan->status_pesanan == 'DP')
                                <form action="{{ route('pesanans.markAsPaid', $pesanan->id_pesanan) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="px-3 py-2 bg-yellow-500 hover:bg-yello-600 text-white rounded-md mark-as-paid-button">DP</button>
                                </form>
                            @elseif($pesanan->status_pesanan == 'paid')
                                <form action="{{ route('pesanans.markAsCompleted', $pesanan->id_pesanan) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="px-3 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md mark-as-paid-button">Sudah bayar</button>
                                </form>
                            @elseif($pesanan->status_pesanan == 'batal')
                                <button class="px-3 py-2 bg-red-500 text-white rounded-md">Batal</button>
                            @elseif($pesanan->status_pesanan == 'completed')
                                <button class="px-3 py-2 bg-blue-600 text-white rounded-md">Selesai</button>
                            

                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap" id="actions-td">
                            <a href="{{ route('pesanans.detail', $pesanan->id_pesanan) }}" class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md"><i data-lucide="view" class="w-6 h-6 inline "></i></a>
                            <a href="{{ route('pesanans.edit', $pesanan->id_pesanan) }}" class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Edit</a>


                            @if($pesanan->status_pesanan !== 'batal')
                                <form action="{{ route('pesanans.batalkan', $pesanan->id_pesanan) }}" method="POST" class="inline-block delete-form">
                                    @csrf
                                    <button type="button" class="mt-3 sm:mt-0 px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md delete-button">Batalkan</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

<div class="bg-white shadow-md border mt-6" id="form-pesanan-dashboard">
    <div class="bg-labels shadow-lg rounded-sm">
        <div class="p-4 w-auto">
            <h3 class="text-lg text-white font-semibold">Tambah Data Pesanan</h3>
        </div>
    </div>
    <div class="p-6 mt-2">
        <form action="{{ route('karyawan.pesanans.store') }}" method="POST" id="pesananForm">
            @csrf
            <div class="grid grid-cols-2 gap-6">
                <!-- Row 1 -->
                <div class="space-y-2">
                    <label for="nama_pemesan" class="block text-gray-700">Nama</label>
                    <input type="text" name="nama_pemesan" id="nama_pemesan" 
                        class="w-full p-2 border rounded-md @error('nama_pemesan') border-red-500 @enderror" 
                        placeholder="masukan nama"  value="{{ old('nama_pemesan') }}">
                    @error('nama_pemesan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="product_id" class="block text-gray-700">Model</label>
                    <select name="product_id" id="product_id" 
                        class="w-full p-2 border rounded-md @error('product_id') border-red-500 @enderror">
                        @foreach($products as $product)
                            <option value="{{ $product->id_product }}" 
                                data-price="{{ $product->harga_jual }}"
                                data-name="{{ $product->nama_produk }}"
                                data-stock="{{ $product->stock_product }}"
                                {{ old('product_id') == $product->id_product ? 'selected' : '' }}>
                                {{ $product->nama_produk }} (Stok: {{ $product->stock_product }})
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="nama_produk" id="nama_produk" value="{{ old('nama_produk') }}">
                    <div id="stock-message" class="text-sm text-red-600 hidden"></div>
                    @error('product_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Row 2 -->
                <div class="space-y-2">
                    <label for="total_harga" class="block text-gray-700">Total harga</label>
                    <input type="text" id="total_harga_display" 
                        class="w-full p-2 border rounded-md" 
                        readonly value="{{ old('total_harga') ? 'Rp ' . number_format(old('total_harga'), 0, ',', '.') : '' }}">
                    <input type="hidden" name="total_harga" id="total_harga" value="{{ old('total_harga') }}">
                    @error('total_harga')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="no_telp_pemesan" class="block text-gray-700">Nomor telepon</label>
                    <input type="number" name="no_telp_pemesan" id="no_telp_pemesan" 
                        class="w-full p-2 border rounded-md @error('no_telp_pemesan') border-red-500 @enderror" 
                        placeholder="masukan nomor telepon"  value="{{ old('no_telp_pemesan') }}">
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
                            value="{{ old('jumlah_produk', 1) }}" min="1" >
                        <button type="button" class="px-3 py-1 border rounded" onclick="incrementQuantity()">+</button>
                    </div>
                    @error('jumlah_produk')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
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

                <div class="col-span-2">
                    <div class="border-t pt-4 mb-2">
                        <h3 class="font-semibold text-lg">Ukuran</h3>
                    </div>
                </div>

                <!-- Ukuran fields (copy semua dari create.blade.php) -->
                <div class="space-y-2">
                    <label for="lingkar_badan" class="block text-gray-700">Lingkar Badan (cm)</label>
                    <input type="number" step="0.01" name="lingkar_badan" id="lingkar_badan" 
                        class="w-full p-2 border rounded-md @error('lingkar_badan') border-red-500 @enderror" 
                        placeholder="Contoh: 96"  value="{{ old('lingkar_badan') }}">
                    @error('lingkar_badan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="lingkar_pinggang" class="block text-gray-700">Lingkar pinggang (cm)</label>
                    <input type="number" step="0.01" name="lingkar_pinggang" id="lingkar_pinggang" 
                        class="w-full p-2 border rounded-md @error('lingkar_pinggang') border-red-500 @enderror" 
                        placeholder="Contoh: 80"  value="{{ old('lingkar_pinggang') }}">
                    @error('lingkar_pinggang')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="lingkar_panggul" class="block text-gray-700">Lingkar pinggul (cm)</label>
                    <input type="number" step="0.01" name="lingkar_panggul" id="lingkar_panggul" 
                        class="w-full p-2 border rounded-md @error('lingkar_panggul') border-red-500 @enderror" 
                        placeholder="Contoh: 100"  value="{{ old('lingkar_panggul') }}">
                    @error('lingkar_panggul')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="lebar_pundak" class="block text-gray-700">Lebar pundak (cm)</label>
                    <input type="number" step="0.01" name="lebar_pundak" id="lebar_pundak" 
                        class="w-full p-2 border rounded-md @error('lebar_pundak') border-red-500 @enderror" 
                        placeholder="Contoh: 42"  value="{{ old('lebar_pundak') }}">
                    @error('lebar_pundak')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="panjang_lengan" class="block text-gray-700">Panjang lengan (cm)</label>
                    <input type="number" step="0.01" name="panjang_lengan" id="panjang_lengan" 
                        class="w-full p-2 border rounded-md @error('panjang_lengan') border-red-500 @enderror" 
                        placeholder="Contoh: 60"  value="{{ old('panjang_lengan') }}">
                    @error('panjang_lengan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="lingkar_kerung_lengan" class="block text-gray-700">Lingkar kerung lengan (cm)</label>
                    <input type="number" step="0.01" name="lingkar_kerung_lengan" id="lingkar_kerung_lengan" 
                        class="w-full p-2 border rounded-md @error('lingkar_kerung_lengan') border-red-500 @enderror" 
                        placeholder="Contoh: 45"  value="{{ old('lingkar_kerung_lengan') }}">
                    @error('lingkar_kerung_lengan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="lingkar_pergelangan_lengan" class="block text-gray-700">Lingkar pergelangan lengan (cm)</label>
                    <input type="number" step="0.01" name="lingkar_pergelangan_lengan" id="lingkar_pergelangan_lengan" 
                        class="w-full p-2 border rounded-md @error('lingkar_pergelangan_lengan') border-red-500 @enderror" 
                        placeholder="Contoh: 20"  value="{{ old('lingkar_pergelangan_lengan') }}">
                    @error('lingkar_pergelangan_lengan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="panjang_punggung" class="block text-gray-700">Panjang punggung (cm)</label>
                    <input type="number" step="0.01" name="panjang_punggung" id="panjang_punggung" 
                        class="w-full p-2 border rounded-md @error('panjang_punggung') border-red-500 @enderror" 
                        placeholder="Contoh: 40"  value="{{ old('panjang_punggung') }}">
                    @error('panjang_punggung')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="lebar_punggung" class="block text-gray-700">Lebar punggung (cm)</label>
                    <input type="number" step="0.01" name="lebar_punggung" id="lebar_punggung" 
                        class="w-full p-2 border rounded-md @error('lebar_punggung') border-red-500 @enderror" 
                        placeholder="Contoh: 43"  value="{{ old('lebar_punggung') }}">
                    @error('lebar_punggung')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="lebar_muka" class="block text-gray-700">Lebar muka (cm)</label>
                    <input type="number" step="0.01" name="lebar_muka" id="lebar_muka" 
                        class="w-full p-2 border rounded-md @error('lebar_muka') border-red-500 @enderror" 
                        placeholder="Contoh: 33"  value="{{ old('lebar_muka') }}">
                    @error('lebar_muka')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="panjang_baju" class="block text-gray-700">Panjang Baju (cm)</label>
                    <input type="number" step="0.01" name="panjang_baju" id="panjang_baju" 
                        class="w-full p-2 border rounded-md @error('panjang_baju') border-red-500 @enderror" 
                        placeholder="Contoh: 70"  value="{{ old('panjang_baju') }}">
                    @error('panjang_baju')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
            </div>

            <input type="hidden" name="status_pesanan" value="proses">

            <div class="mt-6 flex justify-end space-x-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700" id="submit-button">
                    Submit
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

    @if(session('error') || isset($error))
        Swal.fire({
            title: 'Error!',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonText: 'OK'
        });
    @endif

    @if(session('success') || isset($success))
        Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @endif

    document.getElementById('product_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        document.getElementById('nama_produk').value = selectedOption.dataset.name;
        currentStock = parseInt(selectedOption.dataset.stock) || 0;
        updateStockMessage();
        updateTotal();
    });

    document.getElementById('size_option').addEventListener('change', function() {
        const selectedSize = this.value;
        
        if (selectedSize !== 'custom') {
            const measurements = standardSizes[selectedSize];
            
            for (const [field, value] of Object.entries(measurements)) {
                const input = document.getElementById(field);
                if (input) {
                    input.value = value;
                }
            }
        } else {
            const measurementFields = [
                'lingkar_badan', 'lingkar_pinggang', 'lingkar_panggul', 
                'lebar_pundak', 'panjang_lengan', 'lingkar_kerung_lengan',
                'lingkar_pergelangan_lengan', 'panjang_punggung', 'lebar_punggung',
                'lebar_muka', 'panjang_baju'
            ];
            
            measurementFields.forEach(field => {
                document.getElementById(field).value = '';
            });
        }
    });

    function updateStockMessage() {
        const quantityInput = document.getElementById('jumlah_produk');
        const stockMessage = document.getElementById('stock-message');
        const submitButton = document.getElementById('submit-button');
        
        if (currentStock > 0) {
            if (parseInt(quantityInput.value) > currentStock) {
                stockMessage.textContent = `Jumlah melebihi stok tersedia (${currentStock})`;
                stockMessage.classList.remove('hidden');
                submitButton.disabled = true;
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                stockMessage.textContent = `Stok tersedia: ${currentStock}`;
                stockMessage.classList.remove('hidden', 'text-red-600');
                stockMessage.classList.add('text-green-600');
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        } else {
            stockMessage.textContent = 'Stok produk ini habis';
            stockMessage.classList.remove('hidden');
            stockMessage.classList.add('text-red-600');
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    function incrementQuantity() {
        const quantityInput = document.getElementById('jumlah_produk');
        const currentValue = parseInt(quantityInput.value) || 0;
        
        if (currentValue < currentStock) {
            quantityInput.value = currentValue + 1;
            updateTotal();
            updateStockMessage();
        }
    }

    function decrementQuantity() {
        const quantityInput = document.getElementById('jumlah_produk');
        const currentValue = parseInt(quantityInput.value) || 0;
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
            updateTotal();
            updateStockMessage();
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
        const requiredFields = [
            'product_id', 'nama_pemesan', 'status_pesanan',
            'lingkar_badan', 'lingkar_pinggang', 'lingkar_panggul', 'lebar_pundak',
            'panjang_lengan', 'lingkar_kerung_lengan', 'lingkar_pergelangan_lengan',
            'panjang_punggung', 'lebar_punggung', 'lebar_muka', 'panjang_baju'
        ];

        const errorMessages = document.querySelectorAll('.text-red-500');
        errorMessages.forEach(error => {
            setTimeout(() => {
                error.style.display = 'none';
            }, 10000); 
        });

        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.addEventListener('input', function() {
                    if (this.value) {
                        this.classList.remove('border-red-500');
                        const errorElement = this.nextElementSibling;
                        if (errorElement && errorElement.classList.contains('text-red-500')) {
                            errorElement.style.display = 'none';
                        }
                    }
                });
            }
        });
        const productSelect = document.getElementById('product_id');
        if (productSelect.options.length > 0) {
            const firstOption = productSelect.options[0];
            document.getElementById('nama_produk').value = firstOption.dataset.name;
            currentStock = parseInt(firstOption.dataset.stock) || 0;
            updateStockMessage();
            updateTotal();
        }
        const quantityInput = document.getElementById('jumlah_produk');
        
        productSelect.addEventListener('change', function() {
            updateTotal();
            updateStockMessage();
        });
        
        quantityInput.addEventListener('input', function() {
            updateTotal();
            updateStockMessage();
        });
        
        document.getElementById('pesananForm').addEventListener('submit', function(e) {
            let hasError = false;
            
            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field.value) {
                    hasError = true;
                    field.classList.add('border-red-500');
                    if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('text-red-500')) {
                        const errorElement = document.createElement('p');
                        errorElement.className = 'text-red-500 text-xs mt-1';
                        errorElement.textContent = 'Field ini wajib diisi';
                        field.parentNode.insertBefore(errorElement, field.nextSibling);
                        
                        setTimeout(() => {
                            errorElement.style.display = 'none';
                        }, 5000);
                    }
                }
            });

            if (hasError) {
                e.preventDefault();
                Swal.fire({
                    title: 'Form tidak lengkap!',
                    text: 'Mohon lengkapi semua field yang diperlukan',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                
                const firstError = document.querySelector('.border-red-500');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
        
        @if(old('product_id'))
            const productOption = document.querySelector(`option[value="{{ old('product_id') }}"]`);
            if (productOption) {
                currentStock = parseInt(productOption.dataset.stock) || 0;
                updateStockMessage();
                updateTotal();
            }
        @endif
        
        updateTotal();
        updateStockMessage();
    });
</script>
@endpush