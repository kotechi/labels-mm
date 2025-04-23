<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_bahan extends Model
{
    protected $primaryKey = 'id_bhn';
    protected $fillable = [
        'nama_bahan',
        'jumlah_bahan',
        'harga_satuan',
        'total_harga',
        'periode_hari' 
    ];
}
