<?php

namespace App\Models;

use Database\Factories\BusinessAccountFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Fillable(['establishment_id', 'name', 'email', 'password', 'status'])]
#[Hidden(['password', 'remember_token'])]
class BusinessAccount extends Authenticatable
{
    /** @use HasFactory<BusinessAccountFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}
