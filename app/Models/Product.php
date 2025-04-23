<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products'; 
    protected $primaryKey = 'id_product'; 
    protected $fillable = [
        'nama_produk', 'description', 'harga_jual', 'stock_product', 'image'
    ];
}
