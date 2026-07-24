<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blast extends Model
{
    protected $fillable = ['message', 'recipients', 'total', 'sent', 'failed', 'status'];

    protected $casts = [
        'recipients' => 'array',
    ];
}
