@extends('layouts.karyawan')

@section('content')
<div class="min-h-screen bg-gray-100 py-6 flex justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <!-- Header Resi -->
            <div class="p-4 text-center border-b border-gray-200">
                <h1 class="text-2xl font-bold">Labels MM</h1>
                <p class="text-sm">
                    Jln. Cibanteng Proyek, Cihideung Udik,<br>
                    Kec. Ciampea, Kabupaten Bogor,<br>
                    Jawa Barat 16620
                </p>
            </div>
            
            <!-- Divider -->
            <hr class="border-t border-gray-300">
            
            <!-- Detail Pesanan -->
            <div class="p-4">
                <div class="flex justify-between mb-2">
                    <span class="font-medium">Tanggal</span>
                    <span>{{ \Carbon\Carbon::now()->format('d F Y, H:i:s') }} WIB</span>
                </div>
                
                <div class="flex justify-between mb-2">
                    <span class="font-medium">Nama</span>
                    <span>{{ $pesanan->nama_pemesan }}</span>
                </div>
                
                <div class="flex justify-between mb-2">
                    <span class="font-medium">No telp</span>
                    <span>{{ $pesanan->no_telp_pemesan }}</span>
                </div>
            </div>
            
            <hr class="border-t border-gray-300">
            
            <!-- Item Pesanan (Single Item) -->
            <div class="p-4">
                <div class="flex justify-between font-medium">
                    <span>{{ $pesanan->nama_produk }}</span>
                    <span>Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                </div>
                <div class="text-sm text-gray-600">
                    {{ $pesanan->jumlah_produk }}×{{ number_format($product->harga_jual, 0, ',', '.') }}
                </div>
            </div>
            
            <!-- Divider -->
            <hr class="border-t border-gray-300">
            
            <!-- Total -->
            <div class="p-4">
                <div class="flex justify-between mb-2">
                    <span class="font-medium">Subtotal</span>
                    <span>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                </div>
                
                @if($pesanan->jumlah_pembayaran)
                <div class="flex justify-between mb-2">
                    <span class="font-medium">Cash</span>
                    <span>Rp {{ number_format($pesanan->jumlah_pembayaran, 0, ',', '.') }}</span>
                </div>
                
                <div class="flex justify-between mb-2">
                    <span class="font-medium">Kembali</span>
                    <span>Rp {{ number_format($pesanan->jumlah_pembayaran - $pesanan->total_harga, 0, ',', '.') }}</span>
                </div>
                @endif
            </div>
            
            <!-- Tombol Download dan Kembali -->
            <div class="p-4 flex justify-between">
                <a href="{{ route('karyawan.pesanans.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Kembali
                </a>
                
                <button id="downloadBtn" class="px-4 py-2 bg-blue-500 text-white rounded-md flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    Download Image
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk download resi sebagai gambar -->
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script>
    document.getElementById('downloadBtn').addEventListener('click', function() {
        const element = document.querySelector('.max-w-md .bg-white');
        
        // Sembunyikan tombol download saat membuat screenshot
        const downloadBtn = document.getElementById('downloadBtn');
        const backBtn = document.querySelector('a.bg-gray-500');
        
        const originalDownloadDisplay = downloadBtn.style.display;
        const originalBackDisplay = backBtn.style.display;
        
        downloadBtn.style.display = 'none';
        backBtn.style.display = 'none';
        
        html2canvas(element).then(function(canvas) {
            // Tampilkan kembali tombol
            downloadBtn.style.display = originalDownloadDisplay;
            backBtn.style.display = originalBackDisplay;
            
            // Buat link download
            const link = document.createElement('a');
            link.download = 'resi-pesanan-{{ $pesanan->id_pesanan }}.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        });
    });
</script>
@endsection