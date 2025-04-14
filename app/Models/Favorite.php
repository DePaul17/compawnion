<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'client_id',
        'petsitter_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function petsitter()
    {
        return $this->belongsTo(Client::class, 'petsitter_id');
    }
}
