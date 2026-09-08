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
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }
    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'collection_establishment');
    }
}
