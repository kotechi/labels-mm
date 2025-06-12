@extends('layouts.admin')

@section('title', 'Pembayaran Pesanan')

@section('content')
<div class="p-5 rounded-lg shadow-md bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Admin | Pembayaran Pesanan</u>
    </div>
</div>
<div class="bg-white rounded-lg shadow-lg p-6 mx-auto mt-4">
    <!-- Content -->
    <div class="w-full">
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
                        <span class="text-gray-600">Sudah sibayar</span>
                        <span class="font-medium">Rp {{ number_format($pesanan->jumlah_pembayaran, 0, ',', '.') }}</span>
                    </div>


                    <div class="grid grid-cols-2 items-center py-2">
                        <span class="text-gray-600">Status</span>
                        <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            Menunggu Pembayaran
                        </span>
                    </div>

                    <div class="grid grid-cols-2 items-center py-2">
                        <span class="text-gray-600">Tanggal Pesanan</span>
                        <span class="font-medium">{{ $pesanan->created_at ? $pesanan->created_at->format('d M Y H:i') : '' }}</span>
                    </div>
                </div>
            </div>  

            <!-- Payment Section -->
            <div class="bg-gray-50 p-6 rounded-lg border-purple shadow-lg">
                <h2 class="text-xl font-semibold mb-6 pb-2 border-b">Pembayaran</h2>
                
                <div class="py-4">
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Total Pembayaran</span>
                        <span class="font-bold text-lg">Rp {{ number_format($pesanan->total_harga - $pesanan->jumlah_pembayaran, 0, ',', '.') }}</span>
                    </div>
                    
                    <form id="paymentForm" action="{{ route('pesanans.paymentProses', $pesanan->id_pesanan) }}" method="POST">
                        @csrf
                        <div class="mt-6">
                            <p class="text-gray-700 mb-4">Pilih metode pembayaran:</p>
                            
                            <!-- Payment methods selection -->
                            <div class="space-y-4">
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer payment-option" data-payment="cash">
                                    <div class="flex items-center">
                                        <div class="bg-green-100 p-2 rounded-md mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-medium">Cash</h3>
                                            <p class="text-sm text-gray-500">Pembayaran tunai langsung</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer payment-option" data-payment="midtrans">
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
                            
                            <!-- DP Options -->
                            <div class="mt-6">
                                <p class="text-gray-700 mb-4">Pilih opsi pembayaran:</p>
                                @php
                                    $totalHarga = $pesanan->total_harga;
                                    $dibayar = $pesanan->jumlah_pembayaran ?? 0;
                                    $sisaTagihan = max(0, $totalHarga - $dibayar);
                                @endphp
                                <div class="grid grid-cols-2 gap-4">
                                    <div id="DPOption" class="col-span-2 bg-gray-50 rounded-lg p-4 border">
                                        <div class="flex items-center">
                                            <input type="radio" id="full-payment" name="DP_option" value="full" checked class="mr-2">
                                            <label for="full-payment" class="text-gray-800">
                                                Bayar Penuh (Rp {{ number_format($sisaTagihan, 0, ',', '.') }})
                                            </label>
                                        </div>
                                        @foreach([30, 50, 75] as $dp)
                                            @php
                                                $dpNominal = ($sisaTagihan * $dp) / 100;
                                            @endphp
                                            @if($dpNominal >= 1)
                                            <div class="flex items-center mt-2">
                                                <input type="radio" id="DP-{{ $dp }}" name="DP_option" value="{{ $dp }}" class="mr-2">
                                                <label for="DP-{{ $dp }}" class="text-gray-800">
                                                    Bayar DP {{ $dp }}% (Rp {{ number_format($dpNominal, 0, ',', '.') }})
                                                </label>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Cash payment form -->
                            <div id="cashPaymentForm" class="mt-6 hidden">
                                <div class="space-y-4">
                                    <div>
                                        <label for="jumlah_pembayaran" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Pembayaran Cash</label>
                                        <div class="relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">Rp</span>
                                            </div>
                                            <input type="text" name="jumlah_pembayaran" id="jumlah_pembayaran"
                                                class="block w-full pl-10 pr-12 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                                                value="{{ number_format($sisaTagihan, 0, ',', '.') }}"
                                                {{ ($pesanan->status_pesanan === 'paid' || ($pesanan->jumlah_pembayaran >= $pesanan->total_harga)) ? 'readonly' : '' }}>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="kembalian" class="block text-sm font-medium text-gray-700 mb-1">Kembalian</label>
                                        <div class="relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">Rp</span>
                                            </div>
                                            <input type="text" name="kembalian" id="kembalian"
                                                class="block w-full pl-10 pr-12 py-2 border border-gray-300 rounded-md bg-gray-100"
                                                value="0" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <input type="hidden" name="payment_method" id="payment_method" value="cash">
                            <input type="hidden" name="DP_percentage" id="DP_percentage" value="0">
                            <input type="hidden" name="snap_token" id="snap_token" value="">

                            <!-- Pay button -->
                            <div class="mt-8">
                                <button type="submit" id="payButton" class="w-full bg-[#AF0893] text-white py-3 rounded-lg font-medium shadow-md hover:bg-purple-700 transition"
                                    @if($pesanan->status_pesanan === 'paid' || ($pesanan->jumlah_pembayaran >= $pesanan->total_harga)) disabled @endif>
                                    @if($pesanan->status_pesanan === 'paid' || ($pesanan->jumlah_pembayaran >= $pesanan->total_harga))
                                        Sudah Lunas
                                    @else
                                        Bayar Sekarang
                                    @endif
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Bottom buttons -->
        <div class="mt-9 w-full items-center justify-center d-flex flex">
            
            <a href="{{ route('pemasukan.index') }}" class="rounded-md bg-gray-500 text-white px-4 py-2 flex items-center shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali ke daftar pesanan
            </a>
        </div>
    </div>
</div>

    <div id="snap-container" style="display:none;"></div>

    <div id="resiModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="w-full max-w-md max-h-[90vh] flex flex-col">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg flex flex-col max-h-full">
                <!-- Header Resi - Fixed -->
                <div class="p-4 text-center border-b border-gray-200 flex-shrink-0">
                    <h1 class="text-2xl font-bold">Labels MM</h1>
                    <p class="text-sm">
                        Jln. Cibanteng Proyek, Cihideung Udik,<br>
                        Kec. Ciampea, Kabupaten Bogor,<br>
                        Jawa Barat 16620
                    </p>
                </div>
                
                <!-- Content Area - Scrollable -->
                <div class="flex-1 overflow-y-auto">
                    <hr class="border-t border-gray-300">
                    
                    <!-- Detail Pesanan -->
                    <div class="p-4">
                        <div class="flex justify-between mb-2">
                            <span class="font-medium">Tanggal</span>
                            <span id="current-datetime"></span>
                        </div>
                        
                        <div class="flex justify-between mb-2">
                            <span class="font-medium">Nomor Resi</span>
                            <span id="nomor-resi"></span>
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
                    
                    <!-- Detail Produk -->
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
                    
                    <!-- Rincian Pembayaran -->
                    <div class="p-4">
                        <div class="flex justify-between mb-2">
                            <span class="font-medium">Subtotal</span>
                            <span>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                        </div>
                        
                        <!-- TAMBAHAN: Informasi pembayaran yang sudah dilakukan -->
                        @if($dibayar > 0)
                        <div class="flex justify-between mb-2 ">
                            <span class="font-medium">Sudah Dibayar</span>
                            <span id="sudah-dibayar">Rp {{ number_format($dibayar, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        
                        <div id="DP-info" class="flex justify-between mb-2 hidden">
                            <span class="font-medium ">DP (%)</span>
                            <span >Rp 0</span>
                        </div>
                        
                        <div class="flex justify-between mb-2">
                            <span class="font-medium">Total Bayar Sekarang</span>
                            <span id="total-bayar" class="font-bold">Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</span>
                        </div>
                        
                        <!-- TAMBAHAN: Sisa tagihan setelah pembayaran ini -->
                        <div class="flex justify-between mb-2 ">
                            <span class="font-medium">Sisa Tagihan</span>
                            <span id="sisa-tagihan">Rp 0</span>
                        </div>
                        
                        <hr class="border-t border-gray-200 my-3">
                        
                        <!-- Detail Cash Payment -->
                        <div class="flex justify-between mb-2" id="cash-row">
                            <span class="font-medium">Cash</span>
                            <span id="cash-amount">Rp 0</span>
                        </div>
                        
    <div class="flex justify-between mb-2" id="kembalian-row" style="display:none;">
        <span class="font-medium">Kembalian</span>
        <span id="kembalian-amount" class="font-bold">Rp 0</span>
    </div>
                        
                        <div class="flex justify-between mt-4 pt-2 border-t border-gray-300">
                            <span class="font-medium">Metode Pembayaran</span>
                            <span id="payment-method-text" class="font-medium">Cash</span>
                        </div>
                    </div>
                    
                </div>
                
                <!-- Tombol Konfirmasi Pembayaran - Fixed at bottom -->
                <div class="p-4 bg-gray-50 border-t flex-shrink-0">
                    <div class="text-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Konfirmasi Pembayaran</h3>
                        <p class="text-sm text-gray-600">Silahkan periksa detail pembayaran sebelum melanjutkan</p>
                    </div>
                    
                    <div class="flex gap-3">
                        <button id="cancelPaymentBtn" class="flex-1 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                            Batal
                        </button>
                        
                        <button id="proceedPaymentBtn" class="flex-1 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                            Lanjutkan Pembayaran
                        </button>
                    </div>
                </div>
                
                <!-- Tombol Print dan Download - Fixed at bottom (Hidden saat konfirmasi) -->
                <div id="printDownloadButtons" class="p-4 flex justify-between gap-2 flex-shrink-0 hidden">
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
    #resiModal .max-w-md {
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    }

    #resiModal .overflow-y-auto {
        max-height: calc(90vh - 200px); /* Dikurangi tinggi header dan footer */
        overflow-y: auto;
        overflow-x: hidden;
    }

    #resiModal .overflow-y-auto::-webkit-scrollbar {
        width: 6px;
    }

    #resiModal .overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    #resiModal .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    #resiModal .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    #payment-error {
        animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    .border-red-500 {
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
    }

    .opacity-50 {
        opacity: 0.5;
    }
    
    .cursor-not-allowed {
        cursor: not-allowed;
    }

    @media (max-width: 640px) {
        #resiModal .max-w-md {
            max-width: 95vw;
            max-height: 95vh;
            margin: 0 auto;
        }
        
        #resiModal .overflow-y-auto {
            max-height: calc(95vh - 180px);
        }
    }

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
            max-height: 100%;
        }
        .overflow-y-auto {
            overflow: visible !important;
            max-height: none !important;
        }
        @page {
            margin: 0;
            size: auto;
        }
        head, header, footer, .p-5, #printResiBtn, button, .mt-9, .header-print {
            display: none !important;
        }
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
    
    // Modal handling
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
    
    // Download functionality
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
                link.download = 'resi-pesanan-' + document.getElementById('nomor-resi').textContent + '.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        });
    }
    
    let selectedPayment = 'cash'; 
    
    const paymentOptions = document.querySelectorAll('.payment-option');
    const cashPaymentForm = document.getElementById('cashPaymentForm');
    const paymentMethodInput = document.getElementById('payment_method');
    
    
    function selectPaymentMethod(element, paymentType) {
        // Remove selection from all options
        paymentOptions.forEach(opt => {
            opt.classList.remove('border-[#AF0893]', 'bg-purple-50');
            opt.style.borderColor = '';
            opt.style.backgroundColor = '';
        });
        
        // Add selection to clicked option
        element.classList.add('border-[#AF0893]', 'bg-purple-50');
        element.style.borderColor = '#AF0893';
        element.style.backgroundColor = '#f3e8ff';
        
        // Update selected payment method
        selectedPayment = paymentType;
        if (paymentMethodInput) {
            paymentMethodInput.value = selectedPayment;
        }
        
        if (cashPaymentForm) {
            if (selectedPayment === 'cash') {
                cashPaymentForm.classList.remove('hidden');
                cashPaymentForm.style.display = 'block';
            } else {
                cashPaymentForm.classList.add('hidden');
                cashPaymentForm.style.display = 'none';
            }
        }
    }
    
    // Add click event listeners to payment options
    paymentOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const paymentType = this.getAttribute('data-payment') || this.dataset.payment;

            selectPaymentMethod(this, paymentType);
        });
        
        // Also add cursor pointer style to make it clear it's clickable
        option.style.cursor = 'pointer';
    });
    
    // Set default selected payment method (cash)
    if (paymentOptions.length > 0) {
        const defaultOption = Array.from(paymentOptions).find(opt => 
            opt.getAttribute('data-payment') === 'cash' || opt.dataset.payment === 'cash'
        ) || paymentOptions[0];
        
        if (defaultOption) {
            const paymentType = defaultOption.getAttribute('data-payment') || defaultOption.dataset.payment || 'cash';
            selectPaymentMethod(defaultOption, paymentType);
        }
    }
    
    // Constants for calculations
    const totalHarga = {{ $totalHarga ?? 0 }};
    const jumlahDibayar = {{ $dibayar ?? 0 }};
    const sisaTagihan = {{ $sisaTagihan ?? 0 }};
    
    // Handle DP option selection
    const DPOptions = document.querySelectorAll('input[name="DP_option"]');
    const DPPercentageInput = document.getElementById('DP_percentage');
    const jumlahPembayaranField = document.getElementById('jumlah_pembayaran');
    
    DPOptions.forEach(option => {
        option.addEventListener('change', function() {
            let dp = this.value === 'full' ? 0 : parseInt(this.value);
            let nominal = dp === 0 ? sisaTagihan : Math.floor(sisaTagihan * dp / 100);
            
            // Update DP percentage hidden input
            if (DPPercentageInput) {
                DPPercentageInput.value = dp;
            }
            
            // Update payment amount field
            if (jumlahPembayaranField) {
                jumlahPembayaranField.value = formatRupiah(String(nominal));
                jumlahPembayaranField.dispatchEvent(new Event('input'));
            }
            
            console.log('DP option changed:', { dp, nominal }); // Debug log
        });
    });
    
    // Format rupiah function
    function formatRupiah(angka) {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }

    // Setup hidden input for numeric value
    let hiddenJumlahPembayaran = document.getElementById('jumlah_pembayaran_numeric');
    if (!hiddenJumlahPembayaran) {
        hiddenJumlahPembayaran = document.createElement('input');
        hiddenJumlahPembayaran.type = 'hidden';
        hiddenJumlahPembayaran.name = 'jumlah_pembayaran_numeric';
        hiddenJumlahPembayaran.id = 'jumlah_pembayaran_numeric';
        const paymentForm = document.getElementById('paymentForm');
        if (paymentForm) {
            paymentForm.appendChild(hiddenJumlahPembayaran);
        }
    }

    if (jumlahPembayaranField) {
        jumlahPembayaranField.value = formatRupiah(String(sisaTagihan));
        hiddenJumlahPembayaran.value = sisaTagihan;
        
        jumlahPembayaranField.addEventListener('input', function(e) {
            let value = this.value.replace(/[^,\d]/g, '');
            this.value = formatRupiah(this.value);

            // Set hidden input with numeric value
            hiddenJumlahPembayaran.value = value;

            let bayar = parseInt(value) || 0;
            
            // Ambil nominal yang dipilih dari opsi DP
            let selectedDP = document.querySelector('input[name="DP_option"]:checked');
            let dpValue = selectedDP ? selectedDP.value : 'full';
            let nominalYangHarusDibayar = sisaTagihan; // default full payment
            
            if (dpValue !== 'full') {
                nominalYangHarusDibayar = Math.floor(sisaTagihan * parseInt(dpValue) / 100);
            }
            
            // VALIDASI: Cek apakah pembayaran kurang dari minimal
            const payButton = document.getElementById('payButton');
            const errorMessage = document.getElementById('payment-error');
            
            // Hapus error message yang ada
            if (errorMessage) {
                errorMessage.remove();
            }
            
            if (bayar < nominalYangHarusDibayar) {
                // Tampilkan error dan disable tombol bayar
                const errorDiv = document.createElement('div');
                errorDiv.id = 'payment-error';
                errorDiv.className = 'mt-2 text-red-600 text-sm font-medium';
                errorDiv.innerHTML = `⚠️ Pembayaran minimal Rp ${formatRupiah(String(nominalYangHarusDibayar))}`;
                
                this.parentElement.appendChild(errorDiv);
                this.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
                
                if (payButton && !payButton.hasAttribute('data-original-disabled')) {
                    payButton.disabled = true;
                    payButton.classList.add('opacity-50', 'cursor-not-allowed');
                }
            } else {
                // Hapus styling error dan enable tombol bayar
                this.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
                
                if (payButton && !payButton.hasAttribute('data-original-disabled')) {
                    payButton.disabled = false;
                    payButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
            
            // Hitung kembalian berdasarkan nominal yang dipilih
            let kembalian = 0;
            if (bayar >= nominalYangHarusDibayar) {
                kembalian = bayar - nominalYangHarusDibayar;
            }
            
            const kembalianField = document.getElementById('kembalian');
            if (kembalianField) {
                kembalianField.value = formatRupiah(String(kembalian));
            }
            
            console.log('Payment calculation:', {
                bayar: bayar,
                nominalYangHarusDibayar: nominalYangHarusDibayar,
                kembalian: kembalian,
                isValid: bayar >= nominalYangHarusDibayar
            });
        });
    }

    function getSelectedNominal() {
        let dp = document.querySelector('input[name="DP_option"]:checked');
        let dpVal = dp ? dp.value : 'full';
        let nominal = sisaTagihan;
        if (dpVal !== 'full') {
            nominal = Math.floor(sisaTagihan * parseInt(dpVal) / 100);
        }
        return nominal;
    }

    // Function to fetch Midtrans token
    function fetchMidtransToken(nominal) {
        const url = "{{ route('pesanans.midtransToken', $pesanan->id_pesanan ?? '') }}";
        return fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ nominal: nominal })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const snapTokenInput = document.getElementById('snap_token');
                if (snapTokenInput) {
                    snapTokenInput.value = data.snapToken;
                }
                return data.snapToken;
            } else {
                alert(data.message || 'Gagal mengambil token Midtrans');
                return '';
            }
        })
        .catch(error => {
            console.error('Error fetching Midtrans token:', error);
            alert('Terjadi kesalahan saat mengambil token Midtrans');
            return '';
        });
    }

    // Update Midtrans token when payment method or DP option changes
    function updateMidtransToken() {
        if (selectedPayment === 'midtrans') {
            let nominal = getSelectedNominal();
            fetchMidtransToken(nominal);
        }
    }

    DPOptions.forEach(option => {
        option.addEventListener('change', function() {
            let dp = this.value === 'full' ? 0 : parseInt(this.value);
            let nominal = dp === 0 ? sisaTagihan : Math.floor(sisaTagihan * dp / 100);
            
            // Update DP percentage hidden input
            if (DPPercentageInput) {
                DPPercentageInput.value = dp;
            }
            
            // Update payment amount field
            if (jumlahPembayaranField) {
                jumlahPembayaranField.value = formatRupiah(String(nominal));
                
                // Update hidden numeric value
                if (hiddenJumlahPembayaran) {
                    hiddenJumlahPembayaran.value = nominal;
                }
                
                // Hapus error message yang mungkin ada
                const errorMessage = document.getElementById('payment-error');
                if (errorMessage) {
                    errorMessage.remove();
                }
                
                // Reset styling error
                jumlahPembayaranField.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
                
                // Enable tombol bayar jika tidak disabled secara permanen
                const payButton = document.getElementById('payButton');
                if (payButton && !payButton.hasAttribute('data-original-disabled')) {
                    payButton.disabled = false;
                    payButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }
                
                // Trigger input event untuk menghitung kembalian
                jumlahPembayaranField.dispatchEvent(new Event('input'));
            }
            
            console.log('DP option changed:', { dp, nominal });
        });
    });

    const paymentForm = document.getElementById('paymentForm');
    if (paymentForm) {
        paymentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validasi form
            if (!validatePaymentForm()) {
                return;
            }
            
            console.log('Form submitted with payment method:', selectedPayment);
            
            // Tampilkan resi modal terlebih dahulu
            showResiPreview();
        });
    }

    function showResiPreview() {

        updateResiData();

        const pesananId = {{ $pesanan->id_pesanan }};
        const now = new Date();
        const pad = n => n.toString().padStart(2, '0');
        const resiSementara = `RESI-${now.getFullYear()}${pad(now.getMonth()+1)}${pad(now.getDate())}-${pesananId}`;

        document.getElementById('nomor-resi').textContent = resiSementara;

        showConfirmationButtons();
        const modal = document.getElementById('resiModal');
        if (modal) modal.classList.remove('hidden');
    }

    function updateResiData() {
        // Ambil nilai DP yang dipilih
        const selectedDP = document.querySelector('input[name="DP_option"]:checked');
        const dpValue = selectedDP ? selectedDP.value : 'full';
        const dpPercentage = dpValue === 'full' ? 0 : parseInt(dpValue);
        const kembalianRow = document.getElementById('kembalian-row');
        
        // Hitung nominal yang akan dibayar
        let nominalBayar = sisaTagihan;
        if (dpPercentage > 0) {
            nominalBayar = Math.floor(sisaTagihan * dpPercentage / 100);
        }
        
        // Update DP info di resi
        const dpInfo = document.getElementById('DP-info');
        const dpInfoText = dpInfo.querySelector('span:first-child');
        const dpInfoAmount = dpInfo.querySelector('span:last-child');
        
        if (dpPercentage > 0) {
            dpInfo.classList.remove('hidden');
            dpInfoText.textContent = `DP (${dpPercentage}%)`;
            dpInfoAmount.textContent = `Rp ${formatRupiah(String(nominalBayar))}`;
        } else {
            dpInfo.classList.add('hidden');
        }
        
        // Update total bayar saat ini
        const totalBayarElement = document.getElementById('total-bayar');
        if (totalBayarElement) {
            totalBayarElement.textContent = `Rp ${formatRupiah(String(nominalBayar))}`;
        }
        
        // TAMBAHAN: Update informasi total yang sudah dibayar sebelumnya
        const sudahDibayarElement = document.getElementById('sudah-dibayar');
        if (sudahDibayarElement) {
            sudahDibayarElement.textContent = `Rp ${formatRupiah(String(jumlahDibayar))}`;
        }
        
        // TAMBAHAN: Update sisa tagihan
        const sisaTagihanElement = document.getElementById('sisa-tagihan');
        if (sisaTagihanElement) {
            const sisaSetelahBayar = Math.max(0, sisaTagihan - nominalBayar);
            sisaTagihanElement.textContent = `Rp ${formatRupiah(String(sisaSetelahBayar))}`;
        }
        
        // Update informasi cash dan kembalian untuk cash payment
        const cashAmountElement = document.getElementById('cash-amount');
        const kembalianAmountElement = document.getElementById('kembalian-amount');
        
        if (selectedPayment === 'cash') {
            const jumlahCash = document.getElementById('jumlah_pembayaran').value.replace(/[^,\d]/g, '');
            const cashValue = parseInt(jumlahCash) || nominalBayar;
            const kembalianValue = Math.max(0, cashValue - nominalBayar);            
            if (cashAmountElement) {
                cashAmountElement.textContent = `Rp ${formatRupiah(String(cashValue))}`;
            }
            if (kembalianAmountElement) {
                kembalianAmountElement.textContent = `Rp ${formatRupiah(String(kembalianValue))}`;
            }
            
            // Show cash and kembalian rows
            if (cashAmountElement) cashAmountElement.parentElement.style.display = 'flex';
            if (kembalianAmountElement) kembalianAmountElement.parentElement.style.display = 'flex';
        } else {
            // Hide cash and kembalian rows for non-cash payment
            if (cashAmountElement) cashAmountElement.parentElement.style.display = 'none';
            if (kembalianAmountElement) kembalianAmountElement.parentElement.style.display = 'none';
        }
        
        // Update payment method text
        const paymentMethodText = document.getElementById('payment-method-text');
        if (paymentMethodText) {
            paymentMethodText.textContent = selectedPayment === 'cash' ? 'Cash' : 'Midtrans';
        }
    }

    function proceedWithPayment() {
        showPrintReceiptFirst();
    }

    function showPrintReceiptFirst() {
        const confirmationSection = document.querySelector('#resiModal .p-4.bg-gray-50.border-t.flex-shrink-0');
        if (confirmationSection) {
            confirmationSection.style.display = 'none';
        }
        
        // Tampilkan tombol print/download dengan tombol lanjutkan pembayaran
        const printDownloadButtons = document.getElementById('printDownloadButtons');
        if (printDownloadButtons) {
            printDownloadButtons.innerHTML = `
                <button id="backToConfirmation" class="px-4 py-2 bg-gray-500 text-white rounded-md flex items-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Kembali
                </button>
                
                <button id="printReceiptFirst" class="px-4 py-2 bg-green-500 text-white rounded-md flex items-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                    </svg>
                    Print Resi
                </button>
                
                <button id="continuePaymentAfterPrint" class="px-4 py-2 bg-blue-500 text-white rounded-md flex items-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                    Lanjutkan Pembayaran
                </button>
            `;
            
            printDownloadButtons.classList.remove('hidden');
            printDownloadButtons.style.display = 'flex';
        }
        
        // Tambahkan event listeners untuk tombol-tombol baru
        setupPrintFirstButtons();
    }

    function setupPrintFirstButtons() {
        // Tombol kembali ke konfirmasi
        const backToConfirmationBtn = document.getElementById('backToConfirmation');
        if (backToConfirmationBtn) {
            backToConfirmationBtn.addEventListener('click', function() {
                showConfirmationButtons();
            });
        }
        
        // Tombol print resi
        const printReceiptFirstBtn = document.getElementById('printReceiptFirst');
        if (printReceiptFirstBtn) {
            printReceiptFirstBtn.addEventListener('click', function() {
                printReceipt();
            });
        }
        
        // Tombol lanjutkan pembayaran setelah print
        const continuePaymentBtn = document.getElementById('continuePaymentAfterPrint');
        if (continuePaymentBtn) {
            continuePaymentBtn.addEventListener('click', function() {
                // Tutup modal dan lanjutkan proses pembayaran
                const modal = document.getElementById('resiModal');
                if (modal) {
                    modal.classList.add('hidden');
                }
                
                // Proses pembayaran
                processActualPayment();
            });
        }
    }

    function printReceipt() {
        const printButtons = document.querySelectorAll('#backToConfirmation, #printReceiptFirst, #continuePaymentAfterPrint');
        
        // Sembunyikan tombol saat print
        printButtons.forEach(button => {
            button.style.display = 'none';
        });
        
        const originalTitle = document.title;
        document.title = "Resi Pesanan";
        window.print();
        document.title = originalTitle;
        
        // Tampilkan kembali tombol setelah print
        setTimeout(function() {
            printButtons.forEach(button => {
                button.style.display = 'flex';
            });
        }, 500);
    }

    function processActualPayment() {
        if (selectedPayment === 'midtrans') {
            // Handle Midtrans payment
            let nominal = getSelectedNominal();
            fetchMidtransToken(nominal).then(function(token) {
                if (token && typeof snap !== 'undefined') {
                    snap.pay(token, {
                        onSuccess: function(result) {
                            console.log('Midtrans payment success:', result);
                            document.getElementById('paymentForm').submit();
                        },
                        onPending: function(result) {
                            console.log('Midtrans payment pending:', result);
                            alert('Pembayaran dalam status pending, silahkan selesaikan pembayaran');
                        },
                        onError: function(result) {
                            console.error('Midtrans payment error:', result);
                            alert('Pembayaran gagal!');
                        },
                        onClose: function() {
                            alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                        }
                    });
                } else {
                    alert('Token pembayaran tidak tersedia atau Midtrans belum dimuat.');
                }
            });
        } else {
            // For cash payment, submit form directly
            document.getElementById('paymentForm').submit();
        }
    }

    function cancelPayment() {
        const modal = document.getElementById('resiModal');
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    function validatePaymentForm() {
        if (selectedPayment === 'cash') {
            const jumlahCash = parseInt(document.getElementById('jumlah_pembayaran').value.replace(/[^,\d]/g, '')) || 0;
            const selectedDP = document.querySelector('input[name="DP_option"]:checked');
            const dpValue = selectedDP ? selectedDP.value : 'full';
            let nominalMinimal = sisaTagihan;
            
            if (dpValue !== 'full') {
                nominalMinimal = Math.floor(sisaTagihan * parseInt(dpValue) / 100);
            }
            
            if (jumlahCash < nominalMinimal) {
                alert(`Pembayaran cash tidak boleh kurang dari Rp ${formatRupiah(String(nominalMinimal))}`);
                return false;
            }
        }
        return true;
    }

    // Initialize default values
    const defaultDPOption = document.querySelector('input[name="DP_option"]:checked');
    if (defaultDPOption && DPPercentageInput) {
        const DPPercentage = defaultDPOption.value === 'full' ? 0 : parseInt(defaultDPOption.value);
        DPPercentageInput.value = DPPercentage;
    }

    const proceedPaymentBtn = document.getElementById('proceedPaymentBtn');
    const cancelPaymentBtn = document.getElementById('cancelPaymentBtn');

    if (proceedPaymentBtn) {
        proceedPaymentBtn.addEventListener('click', function() {
            proceedWithPayment();
        });
    }

    if (cancelPaymentBtn) {
        cancelPaymentBtn.addEventListener('click', function() {
            cancelPayment();
        });
    }

    // Update modal handling untuk tombol print resi (bukan dari form)
    if (openModalBtn && modal) {
        openModalBtn.addEventListener('click', function() {
            showPrintDownloadButtons();
            updateResiData(); 
            modal.classList.remove('hidden');
        });
    }

    // Function untuk menampilkan tombol print/download dan menyembunyikan tombol konfirmasi
    function showPrintDownloadButtons() {
        const confirmationSection = document.querySelector('#resiModal .bg-gray-50.border-t');
        const printDownloadButtons = document.getElementById('printDownloadButtons');
        
        if (confirmationSection) {
            confirmationSection.style.display = 'none';
        }
        
        if (printDownloadButtons) {
            printDownloadButtons.classList.remove('hidden');
            printDownloadButtons.style.display = 'flex';
        }
    }

    // Function untuk menampilkan tombol konfirmasi dan menyembunyikan tombol print/download  
    function showConfirmationButtons() {
        const confirmationSection = document.querySelector('#resiModal .p-4.bg-gray-50.border-t.flex-shrink-0');
        const printDownloadButtons = document.getElementById('printDownloadButtons');
        
        if (confirmationSection) {
            confirmationSection.style.display = 'block';
        }
        
        if (printDownloadButtons) {
            printDownloadButtons.classList.add('hidden');
            printDownloadButtons.style.display = 'none';
            
            // Reset content tombol print/download ke kondisi awal
            printDownloadButtons.innerHTML = `
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
            `;
            
            // Re-setup event listeners untuk tombol-tombol default
            setupDefaultPrintButtons();
        }
    }

    function setupDefaultPrintButtons() {
        // Setup close modal button
        const closeModalBtn = document.getElementById('closeModal');
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', function() {
                const modal = document.getElementById('resiModal');
                if (modal) {
                    modal.classList.add('hidden');
                }
            });
        }
        
        // Setup print button
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
        
        // Setup download button
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
                    link.download = 'resi-pesanan-' + document.getElementById('nomor-resi').textContent + '.png';
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                });
            });
        }
    }


});

setInterval(function() {
    fetch("{{ route('pesanans.detail', $pesanan->id_pesanan) }}")
        .then(res => res.text())
        .then(html => {
            if (html.includes('Sudah Lunas') || html.includes('Pesanan sudah dibayar')) {
                location.reload();
            }
        });
}, 5000); // cek setiap 5 detik
</script>
@endpush