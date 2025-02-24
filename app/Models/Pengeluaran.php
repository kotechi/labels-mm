<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $table = 'pengeluaran';
    protected $primaryKey = 'id_pengeluaran';
    protected $fillable = [
        'id_modal', 'keterangan', 'nominal_pengeluaran', 'created_by', 'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_users');
    }
}
