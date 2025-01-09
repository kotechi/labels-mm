<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penghasilan extends Model
{
    protected $fillable = [
        'nama', 'harga', 'jumlah', 'created_at', 'updated_at'
    ];
}
