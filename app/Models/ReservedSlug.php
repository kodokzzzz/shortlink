<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservedSlug extends Model
{
    public $timestamps = false;

    protected $fillable = ['slug'];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
