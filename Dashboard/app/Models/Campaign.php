<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = ['name', 'message', 'target_audience', 'sent_count', 'total_count', 'status', 'scheduled_at'];
}

