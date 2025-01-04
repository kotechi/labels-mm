<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    @foreach($headers as $header) 
        {{ $header->tittle }}
        {{ $header->description }}
        {{$header->image}}
    @endforeach
    
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Katalog Produk</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                {{-- Gambar Produk --}}
                <div class="relative h-48">
                    <img 
                        src="{{ asset('storage/' . $product->image) }}" 
                        alt="{{ $product->nama }}"
                        class="w-full h-full object-cover"
                    >
                    {{-- Badge Stok --}}
                    <div class="absolute top-2 left-2">
                        <span class="px-2 py-1 text-xs font-semibold bg-green-500 text-white rounded-full">
                            Stok Tersedia
                        </span>
                    </div>
                </div>

                {{-- Informasi Produk --}}
                <div class="p-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $product->nama }}</h2>
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($product->deskripsi, 100) }}</p>
                    
                    {{-- Harga dan Tombol Pesan --}}
                    <div class="flex justify-between items-center">
                        <div class="text-lg font-bold text-gray-900">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </div>
                        <a href="{{ route('order.form', $product->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Pesan Sekarang
                        </a>
                    </div>

                    {{-- Fitur Tambahan --}}
                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                            Gratis Ongkir
                        </span>
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                            Pengiriman Cepat
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

</body>
</html>