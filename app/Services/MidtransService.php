<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createTransaction($order, $nominal) // TAMBAHKAN $nominal di sini
    {
        $transaction_details = [
            'order_id' => 'ORDER-' . $order->id_pesanan . '-' . time(),
            'gross_amount' => intval($nominal) // PASTIKAN pakai $nominal dari parameter
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
            $snapToken = \Midtrans\Snap::getSnapToken($transaction_data);
            return $snapToken;
        } catch (\Exception $e) {
            return null;
        }
    }
}