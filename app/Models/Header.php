<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    protected $table = 'headers';
    protected $fillable = [
        'tittle', 'image', 'description'
    ];

}
