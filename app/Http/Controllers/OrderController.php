<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\pesanan;

class OrderController extends Controller
{
    public function showOrderForm($productId)
    {
        $product = Product::findOrFail($productId);
        return view('order.form', compact('product'));
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:product,id',
            'jumlah_product' => 'required|integer|min:1',
            'nama' => 'required|string',
            'email' => 'required|email',
            'nomor_whatsapp' => 'required|string'
        ]);

        $product = Product::findOrFail($request->product_id);


        // Hitung total harga
        $totalHarga = $product->harga * $request->jumlah_product;

        // Buat pesanan
        $pesanan = Pesanan::create([
            'product_id' => $product->id,
            'name_product' => $product->nama,
            'nama' => $request->nama,
            'status' => 'proses',
            'total_harga' => $totalHarga,
            'jumlah_product' => $request->jumlah_product,
            'nomor_whatsapp' => $request->nomor_whatsapp,
            'tanggal' => now()
        ]);

        // Generate pesan WhatsApp
        $message = "Halo, saya ingin memesan:\n"
            . "Produk: {$product->nama}\n"
            . "Jumlah: {$request->jumlah_product}\n"
            . "Total: Rp " . number_format($totalHarga, 0, ',', '.') . "\n"
            . "Nomor Pesanan: #{$pesanan->id}";

        $whatsappUrl = "https://wa.me/+6282112327021?text=" . urlencode($message);

        return redirect()->away($whatsappUrl);
    }
}
