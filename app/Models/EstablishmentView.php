<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstablishmentView extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'establishment_id',
        'visitor_id',
        'ip_address',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }
}
