<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    protected $fillable = [
        'name',
        'type',
        'description',
        'location',
        'mood',
        'image',
        'latitude',
        'longitude',
        'rating',
    ];

    protected $casts = [
        'type' => 'string',
        'rating' => 'float',
    ];
}
