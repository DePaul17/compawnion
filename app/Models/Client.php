<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'first_name',
        'date_of_birth',
        'address',
        'type_client',
        'identity_document',
        'picture',
        'attestation',
        'petsitter_certificate_acaced',
        'verificate',
    ];

    protected $casts = [
        'address' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function keptAnimals()
    {
        return $this->hasMany(KeptAnimal::class);
    }

    public function disponibilities()
    {
        return $this->hasMany(Disponibility::class);
    }
}
