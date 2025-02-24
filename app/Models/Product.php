<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products'; // Ensure the table name is correct
    protected $primaryKey = 'id_product'; // Set the primary key
    protected $fillable = [
        'nama_produk', 'description', 'harga_jual', 'stock_product', 'image'
    ];
}
