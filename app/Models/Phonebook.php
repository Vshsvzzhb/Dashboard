<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phonebook extends Model
{
    protected $fillable = ['name', 'description', 'type'];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
