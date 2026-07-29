<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'phonebook_id', 'name', 'message', 'target_audience',
        'session', 'sent_count', 'total_count', 'status',
        'scheduled_at', 'sent_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at'      => 'datetime',
    ];

    public function phonebook()
    {
        return $this->belongsTo(Phonebook::class);
    }

    public function getProgressAttribute(): int
    {
        if ($this->total_count === 0) return 0;
        return (int) round(($this->sent_count / $this->total_count) * 100);
    }
}
