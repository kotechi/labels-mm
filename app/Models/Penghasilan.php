<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penghasilan extends Model
{
    protected $fillable = [
        'nama', 'harga', 'jumlah', 'total_harga', 'created_at', 'updated_at'
    ];
}
