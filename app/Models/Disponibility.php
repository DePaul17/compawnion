<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disponibility extends Model
{
    protected $fillable = [
        'client_id',
        'day',
        'hours',
        'remarks',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'day' => 'json',
        'hours' => 'json',
    ];
}
