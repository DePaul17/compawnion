<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeptAnimal extends Model
{
    protected $fillable = [
        'client_id',
        'animal_type',
        'animal_size',
        'max_animals',
        'special_conditions',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
