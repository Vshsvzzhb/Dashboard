<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['phonebook_id', 'name', 'phone', 'type', 'labels'];

    protected $casts = ['labels' => 'array'];

    public function phonebook()
    {
        return $this->belongsTo(Phonebook::class);
    }
}
