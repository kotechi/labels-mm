<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

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
            'nomor_whatsapp' => 'required|string'
        ]);

        $user = Auth::user();
        $maxOrdersPerDay = $user->max_orders_per_day; // Use max_orders_per_day from user data

        $ordersToday = Pesanan::where('user_id', $user->id)
            ->whereDate('created_at', now()->toDateString())
            ->count();

        if ($ordersToday >= $maxOrdersPerDay) {
            return redirect()->back()->withErrors(['error' => 'You have reached the maximum number of orders for today.']);
        }

        $product = Product::findOrFail($request->product_id);

        // Hitung total harga
        $totalHarga = $product->harga * $request->jumlah_product;

        // Buat pesanan
        $pesanan = Pesanan::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'name_product' => $product->nama,
            'nama' => $user->name, // Use user's name
            'status' => 'proses',
            'total_harga' => $totalHarga,
            'jumlah_product' => $request->jumlah_product,
            'nomor_whatsapp' => $request->nomor_whatsapp,
        ]);

        // Generate pesan WhatsApp
        $message = "Halo, saya ingin memesan:\n"
            . "Produk: {$product->nama}\n"
            . "Jumlah: {$request->jumlah_product}\n"
            . "Total: Rp " . number_format($totalHarga, 0, ',', '.') . "\n"
            . "Nomor Pesanan: #{$pesanan->id_pesanan}";

        $whatsappUrl = "https://wa.me/+6282112327021?text=" . urlencode($message);

        return redirect()->away($whatsappUrl);
    }
}
