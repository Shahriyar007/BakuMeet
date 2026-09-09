<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'emoji'];

    public function establishments()
    {
        return $this->belongsToMany(Establishment::class, 'establishment_tag');
    }
}
