<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Establishment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'location',
        'mood',
        'price_range',
        'image',
        'latitude',
        'longitude',
        'rating',
        'opening_hours',
    ];

    protected $casts = [
        'type' => 'string',
        'rating' => 'float',
        'opening_hours' => 'array',
    ];

    public function photos()
    {
        return $this->hasMany(EstablishmentPhoto::class)->orderBy('sort_order');
    }

    public function primaryPhoto()
    {
        return $this->hasOne(EstablishmentPhoto::class)->where('is_primary', true);
    }

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

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'establishment_tag');
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isOpenNow(): ?bool
    {
        if (empty($this->opening_hours)) {
            return null;
        }

        $days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        $today = $days[Carbon::now()->dayOfWeek];
        $todayHours = $this->opening_hours[$today] ?? null;

        if (empty($todayHours) || ($todayHours['closed'] ?? false)) {
            return false;
        }

        $now = Carbon::now()->format('H:i');
        return $now >= $todayHours['open'] && $now <= $todayHours['close'];
    }

    public function statusText(): ?string
 
   {
        if (empty($this->opening_hours)) {
            return null;
        }

        $days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        $todayIndex = Carbon::now()->dayOfWeek;
        $today = $days[$todayIndex];
        $todayHours = $this->opening_hours[$today] ?? null;
        $now = Carbon::now()->format('H:i');

        if (!empty($todayHours) && !($todayHours['closed'] ?? false) && $now >= $todayHours['open'] && $now <= $todayHours['close']) {
            return 'Açık · ' . $todayHours['close'] . '\'e kadar';
        }

        for ($i = 0; $i <= 7; $i++) {
            $checkIndex = ($todayIndex + $i) % 7;
            $checkDay = $days[$checkIndex];
            $hours = $this->opening_hours[$checkDay] ?? null;

            if (empty($hours) || ($hours['closed'] ?? false)) {
                continue;
            }

            if ($i === 0 && $now < $hours['open']) {
                return 'Kapalı · Bugün ' . $hours['open'] . '\'de açılıyor';
            }

            if ($i > 0) {
                $dayLabel = $i === 1 ? 'Yarın' : Carbon::now()->addDays($i)->translatedFormat('l');
                return 'Kapalı · ' . $dayLabel . ' ' . $hours['open'] . '\'de açılıyor';
            }
        }

        return 'Kapalı';
    }
}
