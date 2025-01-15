<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4">Form Pemesanan</h2>
        <div class="mb-4">
            <h3 class="font-semibold">{{ $product->nama }}</h3>
            <p class="text-gray-600">Harga: Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
        </div>

        @if ($errors->has('error'))
            <div class="alert alert-danger">
                {{ $errors->first('error') }}
            </div>
        @endif

        <form action="{{ route('order.create') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Jumlah</label>
                <input type="number" name="jumlah_product" min="1" value="1" 
                       class="w-full px-3 py-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nomor WhatsApp</label>
                <input type="text" name="nomor_whatsapp" class="w-full px-3 py-2 border rounded" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                Lanjutkan ke WhatsApp
            </button>
        </form>
    </div>
</div>
