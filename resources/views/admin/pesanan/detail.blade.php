@extends('layouts.admin')

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
                        <span class="text-gray-600">ID Pesanan</span>
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
            <button class="rounded-md bg-[#AF0893] text-white p-2 mx-5">cetak resi</button>
            <button>kembali</button>
        </div>
    </div>

    <div class="w-full">

    </div>
</div>
@endsection