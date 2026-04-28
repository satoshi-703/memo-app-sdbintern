<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    protected $fillable = ['content'];
    protected $casts = [
        'created_at' => 'datetime',
    ];
}
