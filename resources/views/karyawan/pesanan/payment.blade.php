@extends('layouts.karyawan')

@section('title', 'Pembayaran Pesanan')

@section('content')
<div class="min-h-screen bg-gray-100 py-6 flex justify-center">
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
                    <span class="font-medium">No. Pesanan</span>
                    <span>#{{ $pesanan->id_pesanan }}</span>
                </div>
                
                <div class="flex justify-between mb-2">
                    <span class="font-medium">Tanggal</span>
                    <span>{{ \Carbon\Carbon::now()->format('d F Y, H:i:s') }} WIB</span>
                </div>
                
                <div class="flex justify-between mb-2">
                    <span class="font-medium">Status</span>
                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">Menunggu Pembayaran</span>
                </div>
            </div>
            
            <hr class="border-t border-gray-300">
            
            <!-- Total Pembayaran -->
            <div class="p-4">
                <div class="flex justify-between font-bold text-lg">
                    <span>Total Pembayaran</span>
                    <span>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
            
            <!-- Payment Gateway -->
            <div class="p-4">
                <div id="snap-container" class="w-full"></div>
            </div>
            
            <!-- Tombol Kembali -->
            <div class="p-4 flex justify-center">
                <a href="{{ route('karyawan.pesanans.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md flex items-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Kembali ke daftar pesanan
                </a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    window.snapToken = "{{ $snapToken }}";
    
    window.snap.pay(window.snapToken, {
        onSuccess: function(result) {
            window.location.href = "{{ route('karyawan.pesanans.index') }}?status=success";
        },
        onPending: function(result) {
            window.location.href = "{{ route('karyawan.pesanans.index') }}?status=pending";
        },
        onError: function(result) {
            window.location.href = "{{ route('karyawan.pesanans.index') }}?status=error";
        },
        onClose: function() {
            window.location.href = "{{ route('karyawan.pesanans.index') }}?status=close";
        }
    });
</script>
@endsection