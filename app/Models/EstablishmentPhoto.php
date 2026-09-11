<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EstablishmentPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'establishment_id',
        'path',
        'is_primary',
        'sort_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    public function url(): string
    {
        return Storage::disk('r2')->url($this->path);
    }
}
