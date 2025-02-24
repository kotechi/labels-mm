<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_transaksi extends Model
{
    use HasFactory;

    protected $table = 'tbl_transaksis';
    protected $primaryKey = 'id_transaksi';
    protected $fillable = [
        'id_referens',
        'pelaku_transaksi',
        'keterangan',
        'nominal',
        'kategori',
        'tanggal'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'pelaku_transaksi', 'id_users');
    }
}
