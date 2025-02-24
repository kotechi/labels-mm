<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$merchantId = config('midtrans.merchant_id');
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createTransaction($order)
    {
        $transaction_details = [
            'order_id' => 'ORDER-' . $order->id_pesanan . '-' . time(),
            'gross_amount' => $order->total_harga
        ];

        $customer_details = [
            'first_name' => $order->nama_pemesan,
            'phone' => $order->no_telp_pemesan,
        ];

        $transaction_data = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
        ];

        try {
            $snapToken = Snap::getSnapToken($transaction_data);
            return $snapToken;
        } catch (\Exception $e) {
            return null;
        }
    }
}