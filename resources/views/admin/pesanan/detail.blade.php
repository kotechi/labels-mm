@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div class="p-5 rounded-lg shadow-md bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Admin | Detail Pesanan</u>
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

        <!-- Daftar Resi -->
        <div class="mt-8">
            <h2 class="text-lg font-bold mb-2">Daftar Resi Pembayaran</h2>
            <table class="min-w-full bg-white border">
                <thead>
                    <tr>
                        <th class="border px-3 py-2">No</th>
                        <th class="border px-3 py-2">Nomor Resi</th>
                        <th class="border px-3 py-2">Tanggal</th>
                        <th class="border px-3 py-2">Jumlah Bayar</th>
                        <th class="border px-3 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resis as $i => $resi)
                    <tr>
                        <td class="border px-3 py-2">{{ $i+1 }}</td>
                        <td class="border px-3 py-2">{{ $resi->nomor_resi }}</td>
                        <td class="border px-3 py-2">{{ \Carbon\Carbon::parse($resi->tanggal)->format('d M Y H:i') }}</td>
                        <td class="border px-3 py-2">Rp {{ number_format($resi->jumlah_pembayaran, 0, ',', '.') }}</td>
                        <td class="border px-3 py-2">
                            <button class="lihat-resi-btn bg-purple-600 text-white px-3 py-1 rounded" 
                                data-nomor-resi="{{ $resi->nomor_resi }}"
                                data-tanggal="{{ $resi->tanggal }}"
                                data-jumlah-pembayaran="{{ $resi->jumlah_pembayaran }}">
                                Lihat Resi
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-9 w-full items-center justify-center d-flex flex">
            <a class="rounded-md bg-[#AF0893] text-white p-2" href="{{ route('pemasukan.index')}}">kembali</a>
        </div>
    </div>
</div>

<!-- Modal Resi -->
<div id="resiModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="w-full max-w-md max-h-[90vh] flex flex-col">
        <div class="bg-white overflow-hidden shadow-lg rounded-lg flex flex-col max-h-full">
            <!-- Header Resi -->
            <div class="p-4 text-center border-b border-gray-200 flex-shrink-0">
                <h1 class="text-2xl font-bold">Labels MM</h1>
                <p class="text-sm">
                    Jln. Cibanteng Proyek, Cihideung Udik,<br>
                    Kec. Ciampea, Kabupaten Bogor,<br>
                    Jawa Barat 16620
                </p>
            </div>
            <!-- Content Area -->
            <div class="flex-1 overflow-y-auto">
                <hr class="border-t border-gray-300">
                <div class="p-4">
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">Tanggal</span>
                        <span id="resi-tanggal"></span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">Nomor Resi</span>
                        <span id="resi-nomor"></span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">Nama</span>
                        <span id="resi-nama-pemesan">{{ $pesanan->nama_pemesan }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">No telp</span>
                        <span id="resi-no-telp">{{ $pesanan->no_telp_pemesan }}</span>
                    </div>
                </div>
                <hr class="border-t border-gray-300">
                <div class="p-4">
                    <div class="flex justify-between font-medium">
                        <span id="resi-nama-produk">{{ $pesanan->nama_produk }}</span>
                        <span id="resi-harga-satuan">Rp {{ number_format($pesanan->total_harga / $pesanan->jumlah_produk, 0, ',', '.') }}</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <span id="resi-jumlah-produk">{{ $pesanan->jumlah_produk }}</span>×<span id="resi-harga-per-item">{{ number_format($pesanan->total_harga / $pesanan->jumlah_produk, 0, ',', '.') }}</span>
                    </div>
                </div>
                <hr class="border-t border-gray-300">
                <div class="p-4">
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">Subtotal</span>
                        <span id="resi-subtotal">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">Total Bayar</span>
                        <span id="resi-jumlah-bayar"></span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">Kembalian</span>
                        <span id="resi-kembalian"></span>
                    </div>
                </div>
            </div>
            <div class="p-4 flex justify-between">
                <button id="closeModal" class="px-4 py-2 bg-gray-500 text-white rounded-md flex items-center shadow-lg">
                    Tutup
                </button>
                <button id="printBtn" class="px-4 py-2 bg-green-500 text-white rounded-md flex items-center shadow-lg">
                    Print
                </button>
                <button id="downloadResiBtn" class="px-4 py-2 bg-blue-500 text-white rounded-md flex items-center shadow-lg">
                    Download
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<style>
@media print {
    body * {
        visibility: hidden;
    }
    
    #resiModal, 
    #resiModal * {
        visibility: visible;
    }
    
    #resiModal {
        position: absolute !important;
        left: 0 !important;
        top: 0 !important;
        width: 100% !important;
        height: 100% !important;
        background: white !important;
        display: flex !important;
        margin: 0 !important;
        padding: 0 !important;
        z-index: 9999 !important;
    }
    
    #resiModal .max-w-md {
        width: 100% !important;
        max-width: 100% !important;
        max-height: 100% !important;
    }
    
    #resiModal button,
    #resiModal .p-4:last-child,
    .lihat-resi-btn,
    #printResiBtn,
    .mt-9 {
        display: none !important;
    }
    
    @page {
        margin: 0;
        size: auto;
    }
    
    @page :first {
        margin-top: 0;
    }
    
    #resiModal .shadow-lg {
        box-shadow: none !important;
    }
    
    #resiModal * {
        color: black !important;
    }
    
    #resiModal .bg-white,
    #resiModal {
        background: white !important;
    }
}

#resiModal {
    backdrop-filter: blur(4px);
    transition: opacity 0.3s ease-in-out;
}

#resiModal.hidden {
    opacity: 0;
    pointer-events: none;
}

#downloadResiBtn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

#resiModal .bg-white {
    transform: scale(1);
    transition: transform 0.2s ease-in-out;
}

#resiModal.hidden .bg-white {
    transform: scale(0.95);
}

.lihat-resi-btn:hover {
    background-color: #7c3aed;
    transform: translateY(-1px);
    transition: all 0.2s ease-in-out;
}

@media (max-width: 768px) {
    #resiModal .max-w-md {
        margin: 1rem;
        max-height: calc(100vh - 2rem);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show success message if exists
    @if(session('success') || isset($success))
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') ?? $success }}"
            });
        } else {
            // Fallback if SweetAlert is not available
            alert("{{ session('success') ?? $success }}");
        }
    @endif
    
    // Utility function to format currency
    function formatCurrency(amount) {
        if (amount === null || amount === undefined || isNaN(amount)) {
            return 'Rp 0';
        }
        return 'Rp ' + Number(amount).toLocaleString('id-ID');
    }
    
    // Utility function to format date
    function formatDate(dateString) {
        if (!dateString) return '-';
        try {
            const date = new Date(dateString);
            if (isNaN(date.getTime())) return '-';
            return date.toLocaleString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        } catch (error) {
            console.error('Error formatting date:', error);
            return '-';
        }
    }
    
    // Calculate change amount
    function calculateChange(totalHarga, jumlahBayar) {
        const total = Number(totalHarga) || 0;
        const bayar = Number(jumlahBayar) || 0;
        return Math.max(0, bayar - total);
    }
    
    // Modal elements
    const resiModal = document.getElementById('resiModal');
    const closeModalBtn = document.getElementById('closeModal');
    const printBtn = document.getElementById('printBtn');
    const downloadResiBtn = document.getElementById('downloadResiBtn');
    const printResiBtn = document.getElementById('printResiBtn');
    
    // Check if modal exists
    if (!resiModal) {
        console.error('Resi modal not found');
        return;
    }
    
    // Handle "Lihat Resi" buttons
    document.querySelectorAll('.lihat-resi-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            try {
                // Get data from individual data attributes instead of JSON
                const nomorResi = this.getAttribute('data-nomor-resi');
                const tanggal = this.getAttribute('data-tanggal');
                const jumlahPembayaran = this.getAttribute('data-jumlah-pembayaran');
                
                console.log('Resi data:', { nomorResi, tanggal, jumlahPembayaran }); // Debug log
                
                // Get order data from server
                const totalHarga = {{ $pesanan->total_harga ?? 0 }};
                const namaPemesan = "{{ $pesanan->nama_pemesan ?? '' }}";
                const noTelpPemesan = "{{ $pesanan->no_telp_pemesan ?? '' }}";
                const namaProduk = "{{ $pesanan->nama_produk ?? '' }}";
                const jumlahProduk = {{ $pesanan->jumlah_produk ?? 1 }};
                const hargaSatuan = totalHarga / jumlahProduk;
                
                // Update modal content with all data
                const resiNomorEl = document.getElementById('resi-nomor');
                const resiTanggalEl = document.getElementById('resi-tanggal');
                const resiJumlahBayarEl = document.getElementById('resi-jumlah-bayar');
                const resiKembalianEl = document.getElementById('resi-kembalian');
                const resiSubtotalEl = document.getElementById('resi-subtotal');
                const resiNamaPemesanEl = document.getElementById('resi-nama-pemesan');
                const resiNoTelpEl = document.getElementById('resi-no-telp');
                const resiNamaProdukEl = document.getElementById('resi-nama-produk');
                const resiHargaSatuanEl = document.getElementById('resi-harga-satuan');
                const resiJumlahProdukEl = document.getElementById('resi-jumlah-produk');
                const resiHargaPerItemEl = document.getElementById('resi-harga-per-item');
                
                // Update basic resi info
                if (resiNomorEl) resiNomorEl.textContent = nomorResi || '-';
                if (resiTanggalEl) resiTanggalEl.textContent = formatDate(tanggal);
                if (resiJumlahBayarEl) resiJumlahBayarEl.textContent = formatCurrency(jumlahPembayaran);
                
                // Update customer info
                if (resiNamaPemesanEl) resiNamaPemesanEl.textContent = namaPemesan;
                if (resiNoTelpEl) resiNoTelpEl.textContent = noTelpPemesan;
                
                // Update product info
                if (resiNamaProdukEl) resiNamaProdukEl.textContent = namaProduk;
                if (resiHargaSatuanEl) resiHargaSatuanEl.textContent = formatCurrency(hargaSatuan);
                if (resiJumlahProdukEl) resiJumlahProdukEl.textContent = jumlahProduk;
                if (resiHargaPerItemEl) resiHargaPerItemEl.textContent = formatCurrency(hargaSatuan);
                
                // Update financial info
                if (resiSubtotalEl) resiSubtotalEl.textContent = formatCurrency(totalHarga);
                
                // Calculate and display change
                const kembalian = calculateChange(totalHarga, jumlahPembayaran);
                if (resiKembalianEl) resiKembalianEl.textContent = formatCurrency(kembalian);
                
                // Show modal
                resiModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
                
            } catch (error) {
                console.error('Error loading resi data:', error);
                alert('Terjadi kesalahan saat memuat data resi');
            }
        });
    });
    
    // Close modal function
    function closeModal() {
        if (resiModal) {
            resiModal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore scrolling
        }
    }
    
    // Close modal button
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }
    
    // Close modal when clicking outside
    resiModal.addEventListener('click', function(e) {
        if (e.target === resiModal) {
            closeModal();
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !resiModal.classList.contains('hidden')) {
            closeModal();
        }
    });
    
    // Print functionality
    if (printBtn) {
        printBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            try {
                // Add print-specific class before printing
                resiModal.classList.add('printing');
                
                setTimeout(() => {
                    window.print();
                    
                    // Remove print class after printing
                    setTimeout(() => {
                        resiModal.classList.remove('printing');
                    }, 100);
                }, 100);
                
            } catch (error) {
                console.error('Error printing:', error);
                alert('Terjadi kesalahan saat mencetak');
                resiModal.classList.remove('printing');
            }
        });
    }
    
    // Print all receipts button
    if (printResiBtn) {
        printResiBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // You can implement logic to print all receipts here
            // For now, show the first receipt
            const firstResiBtn = document.querySelector('.lihat-resi-btn');
            if (firstResiBtn) {
                firstResiBtn.click();
                setTimeout(() => {
                    if (printBtn) printBtn.click();
                }, 500);
            } else {
                alert('Tidak ada resi untuk dicetak');
            }
        });
    }
    
    // Download functionality
    if (downloadResiBtn) {
        downloadResiBtn.addEventListener('click', function(e) {
            e.preventDefault();

            if (typeof html2canvas === 'undefined') {
                alert('Fitur download tidak tersedia. Library html2canvas tidak ditemukan.');
                return;
            }

            const resiContent = resiModal.querySelector('.bg-white');
            if (!resiContent) {
                alert('Konten resi tidak ditemukan');
                return;
            }

            // Sembunyikan tombol sebelum capture
            const modalFooter = resiContent.querySelector('.p-4.flex.justify-between');
            if (modalFooter) modalFooter.style.display = 'none';

            downloadResiBtn.disabled = true;
            const originalText = downloadResiBtn.textContent;
            downloadResiBtn.textContent = 'Downloading...';

            html2canvas(resiContent, {
                scale: 2,
                backgroundColor: '#ffffff',
                logging: false,
                useCORS: true
            }).then(function(canvas) {
                try {
                    const link = document.createElement('a');
                    const resiNomor = document.getElementById('resi-nomor')?.textContent || 'resi';
                    link.download = `resi-${resiNomor}-${Date.now()}.png`;
                    link.href = canvas.toDataURL('image/png');
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                } catch (error) {
                    alert('Terjadi kesalahan saat mengunduh file');
                }
            }).catch(function(error) {
                alert('Terjadi kesalahan saat mengunduh resi');
            }).finally(function() {
                // Tampilkan lagi tombol setelah capture
                if (modalFooter) modalFooter.style.display = '';
                downloadResiBtn.disabled = false;
                downloadResiBtn.textContent = originalText;
            });
        });
    }
    
    // Print event listeners for better print handling
    window.addEventListener('beforeprint', function() {
        console.log('Preparing to print...');
    });
    
    window.addEventListener('afterprint', function() {
        console.log('Print job completed');
    });
    
    // Prevent form submission on buttons
    document.querySelectorAll('button[type="button"]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
        });
    });
    
    console.log('Order detail JavaScript initialized successfully');
});
</script>
@endsection