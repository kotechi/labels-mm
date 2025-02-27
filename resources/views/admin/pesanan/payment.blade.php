@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold mb-4">Pembayaran Pesanan #{{ $pesanan->id_pesanan }}</h2>
                
                <div class="mb-4">
                    <p class="text-gray-600">Total Pembayaran:</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                </div>

                <div id="snap-container" class="mt-4"></div>
                
                <div class="mt-4">
                    <a href="{{ route('pesanans.index') }}" class="text-blue-600 hover:text-blue-800">
                        ← Kembali ke daftar pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    window.snapToken = "{{ $snapToken }}";
    
    window.snap.pay(window.snapToken, {
        onSuccess: function(result) {
            window.location.href = "{{ route('pesanans.index') }}?status=success";
        },
        onPending: function(result) {
            window.location.href = "{{ route('pesanans.index') }}?status=pending";
        },
        onError: function(result) {
            window.location.href = "{{ route('pesanans.index') }}?status=error";
        },
        onClose: function() {
            window.location.href = "{{ route('pesanans.index') }}?status=close";
        }
    });
</script>
@endsection 


