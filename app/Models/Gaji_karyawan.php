<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gaji_karyawan extends Model
{
    protected $table = 'gaji_karyawan';

    protected $fillable = [
        'nama_karyawan',
        'nominal',
        'created_at',
    ];
}
