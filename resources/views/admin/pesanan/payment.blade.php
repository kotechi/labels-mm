@extends('layouts.admin')

@section('title', 'Pembayaran Pesanan')

@section('content')
<div class="p-5 rounded-lg shadow-md bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Admin | Pembayaran Pesanan</u>
    </div>
</div>
<div class="max-w-6xl bg-white rounded-lg shadow-lg p-6 mx-auto mt-4">
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
                        <span class="text-gray-600">Status</span>
                        <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            Menunggu Pembayaran
                        </span>
                    </div>

                    <div class="grid grid-cols-2 items-center py-2">
                        <span class="text-gray-600">Tanggal Pesanan</span>
                        <span class="font-medium">{{ $pesanan->order_date }}</span>
                    </div>
                </div>
            </div>  

            <!-- Payment Section -->
            <div class="bg-gray-50 p-6 rounded-lg border-purple shadow-lg">
                <h2 class="text-xl font-semibold mb-6 pb-2 border-b">Pembayaran</h2>
                
                <div class="py-4">
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Total Pembayaran</span>
                        <span class="font-bold text-lg">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="mt-6">
                        <p class="text-gray-700 mb-4">Pilih metode pembayaran:</p>
                        
                        <!-- Payment methods selection -->
                        <div class="space-y-4">
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer payment-option" data-payment="bank_transfer">
                                <div class="flex items-center">
                                    <div class="bg-blue-100 p-2 rounded-md mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium">Midtrans</h3>
                                        <p class="text-sm text-gray-500">transfer bank, e-money, qris</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                        <!-- Pay button -->
                        <div class="mt-8">
                            <button id="payButton" class="w-full bg-[#AF0893] text-white py-3 rounded-lg font-medium shadow-md hover:bg-purple-700 transition">
                                Bayar Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom buttons -->
        <div class="mt-9 w-full items-center justify-center d-flex flex">
            <button id="printResiBtn" class="rounded-md bg-[#AF0893] text-white p-2 mx-5 flex">
                cetak resi <i class="w-5 h-5" data-lucide="notepad-text"></i>
            </button>
            
            <a href="{{ route('pesanans.index') }}" class="rounded-md bg-gray-500 text-white px-4 py-2 flex items-center shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali ke daftar pesanan
            </a>
        </div>
    </div>
</div>

<div id="snap-container" style="display:none;"></div>

<!-- Modal for receipt  -->
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
            
            <div class="p-4">
                <div class="flex justify-between font-medium">
                    <span>{{ $pesanan->nama_produk }}</span>
                    <span>Rp {{ number_format($pesanan->total_harga / $pesanan->jumlah_produk, 0, ',', '.') }}</span>
                </div>
                <div class="text-sm text-gray-600">
                    {{ $pesanan->jumlah_produk }}×{{ number_format($pesanan->total_harga / $pesanan->jumlah_produk, 0, ',', '.') }}
                </div>
            </div>
            
            <hr class="border-t border-gray-300">
            
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
@endsection

@push('scripts')
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
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
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const now = new Date();
        const options = { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        
        const datetimeElement = document.getElementById('current-datetime');
        if (datetimeElement) {
            datetimeElement.textContent = now.toLocaleDateString('id-ID', options) + ' WIB';
        }
        
        const modal = document.getElementById('resiModal');
        const openModalBtn = document.getElementById('printResiBtn');
        const closeModalBtn = document.getElementById('closeModal');
        
        if (openModalBtn && modal) {
            openModalBtn.addEventListener('click', function() {
                modal.classList.remove('hidden');
            });
        }
        
        if (closeModalBtn && modal) {
            closeModalBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
        }
        
        // Print functionality
        const printBtn = document.getElementById('printBtn');
        if (printBtn) {
            printBtn.addEventListener('click', function() {
                const printButtons = document.querySelectorAll('#closeModal, #printBtn, #downloadResiBtn');
                
                printButtons.forEach(button => {
                    button.style.display = 'none';
                });
                
                const originalTitle = document.title;
                document.title = "Resi Pesanan";
                window.print();
                document.title = originalTitle;
                
                setTimeout(function() {
                    printButtons.forEach(button => {
                        button.style.display = 'flex';
                    });
                }, 500);
            });
        }
        
        const downloadBtn = document.getElementById('downloadResiBtn');
        if (downloadBtn) {
            downloadBtn.addEventListener('click', function() {
                const element = document.querySelector('.w-full.max-w-md .bg-white');
                const printButtons = document.querySelectorAll('#closeModal, #printBtn, #downloadResiBtn');
                
                printButtons.forEach(button => {
                    button.style.display = 'none';
                });
                
                html2canvas(element).then(function(canvas) {
                    printButtons.forEach(button => {
                        button.style.display = 'flex';
                    });
                    
                    const link = document.createElement('a');
                    link.download = 'resi-pesanan-{{ $pesanan->id_pesanan }}.png';
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                });
            });
        }
        
        let selectedPayment = 'bank_transfer';
        
        const paymentOptions = document.querySelectorAll('.payment-option');
        paymentOptions.forEach(option => {
            option.addEventListener('click', function() {
                paymentOptions.forEach(opt => opt.classList.remove('border-[#AF0893]', 'bg-purple-50'));
                
                this.classList.add('border-[#AF0893]', 'bg-purple-50');
                
                selectedPayment = this.dataset.payment;
            });
        });
        
        if (paymentOptions.length > 0) {
            paymentOptions[0].classList.add('border-[#AF0893]', 'bg-purple-50');
        }
        
        const snapToken = "{{ $snapToken ?? '' }}";
        const payButton = document.getElementById('payButton');
        
        if (payButton && snapToken) {
            payButton.addEventListener('click', function() {
                snap.pay(snapToken, {
                    onSuccess: function(result) {
                        window.location.href = "{{ route('pesanans.index') }}?success=true&order_id={{ $pesanan->id_pesanan }}";
                    },
                    onPending: function(result) {
                        window.location.href = "{{ route('pesanans.index') }}?pending=true&order_id={{ $pesanan->id_pesanan }}";
                    },
                    onError: function(result) {
                        alert('Payment failed!');
                        console.log(result);
                    },
                    onClose: function() {
                        alert('You closed the payment window before completing the transaction.');
                    }
                });
            });
        }
    });
</script>
@endpush