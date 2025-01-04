<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pesanan extends Model
{
    protected $fillable = [
        'product_id', 'name_product', 'nama', 'status',
        'total_harga', 'jumlah_product'
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