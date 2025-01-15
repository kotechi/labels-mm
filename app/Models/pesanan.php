<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $primaryKey = 'id_pesanan'; // Set primary key to id_pesanan

    protected $fillable = [
        'id_pesanan', 'user_id', 'product_id', 'name_product', 'nama', 'status',
        'total_harga', 'jumlah_product', 'nomor_whatsapp'
    ];

    protected $casts = [
        'status' => 'string',
        'tanggal' => 'datetime'
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