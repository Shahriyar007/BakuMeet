<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = [
        'title',
        'description',
        'emoji',
    ];

    public function establishments()
    {
        return $this->belongsToMany(Establishment::class, 'collection_establishment');
    }
}
