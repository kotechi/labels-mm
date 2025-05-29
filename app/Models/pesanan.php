<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Pesanan extends Model
{
    protected $primaryKey = 'id_pesanan'; 

    protected $fillable = [
        'jumlah_pembayaran',
        'product_id',
        'nama_produk',
        'nama_pemesan',
        'status_pesanan',
        'total_harga',
        'jumlah_produk',
        'no_telp_pemesan',
        'payment_method',
        'created_by',
        'order_date',
        'lebar_muka',
        'lebar_pundak',
        'lebar_punggung',
        'panjang_lengan',
        'panjang_punggung',
        'panjang_baju',
        'lingkar_badan',
        'lingkar_pinggang',
        'lingkar_panggul',
        'lingkar_kerung_lengan',
        'lingkar_pergelangan_lengan',
    ];
    

    protected $casts = [
        'status_pesanan' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()   
    {
        return $this->belongsTo(Product::class);
    }
}