<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resi extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'nomor_resi',
        'tanggal',
        'total_pembayaran',
        'jumlah_pembayaran',
        'kembalian',
        'created_by'
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'total_pembayaran' => 'decimal:2',
        'jumlah_pembayaran' => 'decimal:2',
        'kembalian' => 'decimal:2',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id', 'id_pesanan');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_users');
    }
}