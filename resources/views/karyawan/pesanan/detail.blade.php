@extends('layouts.karyawan')

@section('title', 'Detail Pesanan')

@section('content')
<div class="p-5 rounded-lg shadow-md bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Karyawan | Detail Pesanan</u>
    </div>
</div>
<div class="max-w-6xl bg-white rounded-lg shadow-lg p-6 mx-auto  mt-4">

    <!-- Content -->
    <div>
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Order Information -->
            <div class="bg-gray-50 p-6 rounded-lg border-purple shadow-lg">
                <h2 class="text-xl font-semibold mb-6 pb-2 border-b">Informasi Pesanan</h2>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 items-center py-2">
                        <span class="text-gray-600">No Pesanan</span>
                        <span class="font-medium">#{{ $pesanan->id_pesanan }}</span>
                    </div>
                    
                    <div class="grid grid-cols-2 items-center py-2">
                        <span class="text-gray-600">Nama Pemesan</span>
                        <span class="font-medium">{{ $pesanan->nama_pemesan }}</span>
                    </div>

                    <div class="grid grid-cols-2 items-center py-2">
                        <span class="text-gray-600">No. Telepon</span>
                        <span class="font-medium">{{ $pesanan->no_telp_pemesan }}</span>
                    </div>

                    <div class="grid grid-cols-2 items-center py-2">
                        <span class="text-gray-600">Produk</span>
                        <span class="font-medium">{{ $pesanan->nama_produk }}</span>
                    </div>

                    <div class="grid grid-cols-2 items-center py-2">
                        <span class="text-gray-600">Jumlah</span>
                        <span class="font-medium">{{ $pesanan->jumlah_produk }}</span>
                    </div>

                    <div class="grid grid-cols-2 items-center py-2">
                        <span class="text-gray-600">Total Harga</span>
                        <span class="font-medium">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                    </div>

                    <div class="grid grid-cols-2 items-center py-2">
                        <span class="text-gray-600">Metode Pembayaran</span>
                        <span class="font-medium">{{ $pesanan->payment_method }}</span>
                    </div>

                    <div class="grid grid-cols-2 items-center py-2">
                        <span class="text-gray-600">Status</span>
                        <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium
                            {{ $pesanan->status_pesanan === 'proses' ? 'bg-yellow-100 text-yellow-800' : 
                               ($pesanan->status_pesanan === 'selesai' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
                            {{ ucfirst($pesanan->status_pesanan) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 items-center py-2">
                        <span class="text-gray-600">Tanggal Pesanan</span>
                        <span class="font-medium">{{ $pesanan->order_date }}</span>
                    </div>
                </div>
            </div>  

            <!-- Measurements -->
            <div class="bg-gray-50 p-6 rounded-lg border-purple shadow-lg">
                <h2 class="text-xl font-semibold mb-6 pb-2 border-b">Ukuran</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <div class="flex flex-col space-y-1">
                            <span class="text-gray-600">Lebar Muka</span>
                            <span class="font-medium">{{ $pesanan->lebar_muka }} cm</span>
                        </div>
                        <div class="flex flex-col space-y-1">
                            <span class="text-gray-600">Lebar Pundak</span>
                            <span class="font-medium">{{ $pesanan->lebar_pundak }} cm</span>
                        </div>
                        <div class="flex flex-col space-y-1">
                            <span class="text-gray-600">Lebar Punggung</span>
                            <span class="font-medium">{{ $pesanan->lebar_punggung }} cm</span>
                        </div>
                        <div class="flex flex-col space-y-1">
                            <span class="text-gray-600">Panjang Lengan</span>
                            <span class="font-medium">{{ $pesanan->panjang_lengan }} cm</span>
                        </div>
                        <div class="flex flex-col space-y-1">
                            <span class="text-gray-600">Panjang Punggung</span>
                            <span class="font-medium">{{ $pesanan->panjang_punggung }} cm</span>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <div class="flex flex-col space-y-1">
                            <span class="text-gray-600">Panjang Baju</span>
                            <span class="font-medium">{{ $pesanan->panjang_baju }} cm</span>
                        </div>
                        <div class="flex flex-col space-y-1">
                            <span class="text-gray-600">Lingkar Badan</span>
                            <span class="font-medium">{{ $pesanan->lingkar_badan }} cm</span>
                        </div>
                        <div class="flex flex-col space-y-1">
                            <span class="text-gray-600">Lingkar Pinggang</span>
                            <span class="font-medium">{{ $pesanan->lingkar_pinggang }} cm</span>
                        </div>
                        <div class="flex flex-col space-y-1">
                            <span class="text-gray-600">Lingkar Panggul</span>
                            <span class="font-medium">{{ $pesanan->lingkar_panggul }} cm</span>
                        </div>
                        <div class="flex flex-col space-y-1">
                            <span class="text-gray-600">Lingkar Kerung Lengan</span>
                            <span class="font-medium">{{ $pesanan->lingkar_kerung_lengan }} cm</span>
                        </div>
                        <div class="flex flex-col space-y-1">
                            <span class="text-gray-600">Lingkar Pergelangan</span>
                            <span class="font-medium">{{ $pesanan->lingkar_pergelangan_lengan }} cm</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-9 w-full items-center justify-center d-flex flex">
            @if ($product)
            <button id="printResiBtn" class="rounded-md bg-[#AF0893] text-white p-2 mx-5 flex">
                cetak resi <i class="w-5 h-5" data-lucide="notepad-text"></i>
            </button>
            @endif
            <a href="{{ url()->previous() }}">kembali</a>
        </div>
    </div>
</div>

<!-- Modal for receipt -->
<div id="resiModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="w-full max-w-md">
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
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
                    <span id="current-datetime"></span>
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
            
            <!-- Tombol Print dan Download dan Tutup -->
            <div class="p-4 flex justify-between">
                <button id="closeModal" class="px-4 py-2 bg-gray-500 text-white rounded-md flex items-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Tutup
                </button>
                
                <button id="printBtn" class="px-4 py-2 bg-green-500 text-white rounded-md flex items-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                    </svg>
                    Print
                </button>
                
                <button id="downloadResiBtn" class="px-4 py-2 bg-blue-500 text-white rounded-md flex items-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    Download
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk download resi sebagai gambar dan handling modal -->
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<!-- Add this style section to your existing styles or adjust your current @media print section -->
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #resiModal, #resiModal * {
            visibility: visible;
        }
        #resiModal {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: white;
            display: flex !important;
            margin: 0;
            padding: 0;
        }
        .max-w-md {
            width: 100%;
            max-width: 100%;
        }
        /* Hide header and footer elements when printing */
        @page {
            margin: 0;
            size: auto;
        }
        head, header, footer, .p-5, #printResiBtn, button, .mt-9, .header-print {
            display: none !important;
        }
        /* Hide URL, date/time and page number */
        @page :first {
            margin-top: 0;
        }
        @page :left {
            margin-left: 0;
        }
        @page :right {
            margin-right: 0;
        }
    }
</style>

<!-- Update the print button script to ensure cleaner printing -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set current date and time
        const now = new Date();
        const options = { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        document.getElementById('current-datetime').textContent = now.toLocaleDateString('id-ID', options) + ' WIB';
        
        // Modal functionality
        const modal = document.getElementById('resiModal');
        const openModalBtn = document.getElementById('printResiBtn');
        const closeModalBtn = document.getElementById('closeModal');
        
        openModalBtn.addEventListener('click', function() {
            modal.classList.remove('hidden');
        });
        
        closeModalBtn.addEventListener('click', function() {
            modal.classList.add('hidden');
        });
        
        // Print functionality with enhanced cleanup
        document.getElementById('printBtn').addEventListener('click', function() {
            const printButtons = document.querySelectorAll('#closeModal, #printBtn, #downloadResiBtn');
            
            // Hide buttons before printing
            printButtons.forEach(button => {
                button.style.display = 'none';
            });
            
            // Create a clone of just the receipt content for printing
            const receiptContent = document.querySelector('.w-full.max-w-md .bg-white');
            
            // Print with clean settings
            const originalTitle = document.title;
            document.title = "Resi Pesanan";
            window.print();
            document.title = originalTitle;
            
            // Show buttons again after print dialog closes
            setTimeout(function() {
                printButtons.forEach(button => {
                    button.style.display = 'flex';
                });
            }, 500);
        });
        
        // Download as image functionality
        document.getElementById('downloadResiBtn').addEventListener('click', function() {
            const element = document.querySelector('.w-full.max-w-md .bg-white');
            const printButtons = document.querySelectorAll('#closeModal, #printBtn, #downloadResiBtn');
            
            // Hide buttons before creating screenshot
            printButtons.forEach(button => {
                button.style.display = 'none';
            });
            
            html2canvas(element).then(function(canvas) {
                // Show buttons again
                printButtons.forEach(button => {
                    button.style.display = 'flex';
                });
                
                // Create download link
                const link = document.createElement('a');
                link.download = 'resi-pesanan-{{ $pesanan->id_pesanan }}.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        });
    });
</script>
@endsection