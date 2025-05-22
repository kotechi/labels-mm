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
                        <span class="font-bold text-lg">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
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
                            
                            <!-- Deposit Options -->
                            <div class="mt-6">
                                <p class="text-gray-700 mb-4">Pilih opsi pembayaran:</p>
                                @php
                                    $totalHarga = $pesanan->total_harga;
                                    $dibayar = $pesanan->jumlah_pembayaran ?? 0;
                                    $sisaTagihan = max(0, $totalHarga - $dibayar);
                                @endphp
                                <div class="grid grid-cols-2 gap-4">
                                    <div id="depositOption" class="col-span-2 bg-gray-50 rounded-lg p-4 border">
                                        <div class="flex items-center">
                                            <input type="radio" id="full-payment" name="deposit_option" value="full" checked class="mr-2">
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
                                                <input type="radio" id="deposit-{{ $dp }}" name="deposit_option" value="{{ $dp }}" class="mr-2">
                                                <label for="deposit-{{ $dp }}" class="text-gray-800">
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
                            <input type="hidden" name="deposit_percentage" id="deposit_percentage" value="0">
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
            <button id="printResiBtn" class="rounded-md bg-[#AF0893] text-white p-2 mx-5 flex">
                cetak resi <i class="w-5 h-5" data-lucide="notepad-text"></i>
            </button>
            
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
                    <span class="font-medium">Nomor Resi</span>
                    <span id="nomor-resi">{{ $resi->nomor_resi ?? '-' }}</span>
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
                
                <div id="deposit-info" class="flex justify-between mb-2 {{ !isset($deposit_percentage) || $deposit_percentage == 0 ? 'hidden' : '' }}">
                    <span class="font-medium">DP ({{ $deposit_percentage ?? 0 }}%)</span>
                    <span>Rp {{ number_format(($pesanan->total_harga * ($deposit_percentage ?? 0)) / 100, 0, ',', '.') }}</span>
                </div>
                
                <div class="flex justify-between mb-2">
                    <span class="font-medium">Total Bayar</span>
                    <span id="total-bayar">
                        @if(isset($deposit_percentage) && $deposit_percentage > 0)
                            Rp {{ number_format(($pesanan->total_harga * $deposit_percentage) / 100, 0, ',', '.') }}
                        @else
                            Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                        @endif
                    </span>
                </div>
                
                @if(isset($pesanan->jumlah_pembayaran) && $pesanan->jumlah_pembayaran > 0)
                <div class="flex justify-between mb-2">
                    <span class="font-medium">Cash</span>
                    <span id="cash-amount">Rp {{ number_format($pesanan->jumlah_pembayaran, 0, ',', '.') }}</span>
                </div>
                
                <div class="flex justify-between mb-2">
                    <span class="font-medium">Kembali</span>
                    <span id="kembalian-amount">
                        @if(isset($deposit_percentage) && $deposit_percentage > 0)
                            Rp {{ number_format($pesanan->jumlah_pembayaran - (($pesanan->total_harga * $deposit_percentage) / 100), 0, ',', '.') }}
                        @else
                            Rp {{ number_format($pesanan->jumlah_pembayaran - $pesanan->total_harga, 0, ',', '.') }}
                        @endif
                    </span>
                </div>
                @endif
                
                <div class="flex justify-between mt-4 pt-2 border-t border-gray-300">
                    <span class="font-medium">Metode Pembayaran</span>
                    <span id="payment-method-text">{{ ucfirst($pesanan->payment_method ?? 'Cash') }}</span>
                </div>
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
    
    // ========== FIX UNTUK PAYMENT METHOD SELECTION ==========
    let selectedPayment = 'cash'; // Default payment method
    
    // Get all payment options
    const paymentOptions = document.querySelectorAll('.payment-option');
    const cashPaymentForm = document.getElementById('cashPaymentForm');
    const paymentMethodInput = document.getElementById('payment_method');
    
    console.log('Payment options found:', paymentOptions.length); // Debug log
    
    // Function to handle payment method selection
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
        
        console.log('Selected payment method:', selectedPayment); // Debug log
        
        // Show/hide cash payment form
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
            console.log('Payment option clicked:', paymentType); // Debug log
            
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
    
    console.log('Calculation values:', { totalHarga, jumlahDibayar, sisaTagihan }); // Debug log
    
    // Handle deposit option selection
    const depositOptions = document.querySelectorAll('input[name="deposit_option"]');
    const depositPercentageInput = document.getElementById('deposit_percentage');
    const jumlahPembayaranField = document.getElementById('jumlah_pembayaran');
    
    depositOptions.forEach(option => {
        option.addEventListener('change', function() {
            let dp = this.value === 'full' ? 0 : parseInt(this.value);
            let nominal = dp === 0 ? sisaTagihan : Math.floor(sisaTagihan * dp / 100);
            
            // Update deposit percentage hidden input
            if (depositPercentageInput) {
                depositPercentageInput.value = dp;
            }
            
            // Update payment amount field
            if (jumlahPembayaranField) {
                jumlahPembayaranField.value = formatRupiah(String(nominal));
                jumlahPembayaranField.dispatchEvent(new Event('input'));
            }
            
            console.log('Deposit option changed:', { dp, nominal }); // Debug log
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

    // Handle jumlah pembayaran input formatting and calculation
    if (jumlahPembayaranField) {
        jumlahPembayaranField.value = formatRupiah(String(sisaTagihan));
        hiddenJumlahPembayaran.value = sisaTagihan;
        
        jumlahPembayaranField.addEventListener('input', function(e) {
            let value = this.value.replace(/[^,\d]/g, '');
            this.value = formatRupiah(this.value);

            // Set hidden input with numeric value
            hiddenJumlahPembayaran.value = value;

            let bayar = parseInt(value) || 0;
            let kembalian = 0;
            if (bayar > sisaTagihan) {
                kembalian = bayar - sisaTagihan;
            }
            
            const kembalianField = document.getElementById('kembalian');
            if (kembalianField) {
                kembalianField.value = formatRupiah(String(kembalian));
            }
        });
    }

    // Function to get selected nominal for Midtrans
    function getSelectedNominal() {
        let dp = document.querySelector('input[name="deposit_option"]:checked');
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

    // Update Midtrans token when payment method or deposit option changes
    function updateMidtransToken() {
        if (selectedPayment === 'midtrans') {
            let nominal = getSelectedNominal();
            fetchMidtransToken(nominal);
        }
    }

    // Add event listeners for Midtrans token updates
    depositOptions.forEach(opt => {
        opt.addEventListener('change', updateMidtransToken);
    });

    // Form submission handling
    const paymentForm = document.getElementById('paymentForm');
    if (paymentForm) {
        paymentForm.addEventListener('submit', function(e) {
            console.log('Form submitted with payment method:', selectedPayment); // Debug log
            
            if (selectedPayment === 'midtrans') {
                e.preventDefault();
                
                let nominal = getSelectedNominal();
                fetchMidtransToken(nominal).then(function(token) {
                    if (token && typeof snap !== 'undefined') {
                        snap.pay(token, {
                            onSuccess: function(result) {
                                console.log('Midtrans payment success:', result);
                                paymentForm.submit();
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
            }
            // For cash payment, form submits normally
        });
    }

    // Initialize default values
    const defaultDepositOption = document.querySelector('input[name="deposit_option"]:checked');
    if (defaultDepositOption && depositPercentageInput) {
        const depositPercentage = defaultDepositOption.value === 'full' ? 0 : parseInt(defaultDepositOption.value);
        depositPercentageInput.value = depositPercentage;
    }

    console.log('Payment method selection initialized'); // Debug log
});
</script>
@endpush