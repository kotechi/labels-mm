<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{   
    protected $table = 'pemasukan';
    protected $primaryKey = 'id_pemasukan';
    protected $fillable = [
        'id_referensi', 'keterangan', 'nominal', 'created_by', 'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_users');
    }
}
