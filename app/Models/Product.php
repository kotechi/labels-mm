<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = [
        'nama', 'harga', 'link', 'deskripsi', 'image'
    ];

    public function getWhatsAppLink()
    {
        return route('order.form', $this->id);
    }
}
