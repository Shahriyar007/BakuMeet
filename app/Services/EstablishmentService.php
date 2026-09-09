<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Repositories\Contracts\EstablishmentRepositoryInterface;

class EstablishmentService
{
    protected EstablishmentRepositoryInterface $repository;

    public function __construct(EstablishmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Tüm işletmeleri getir
     */
    public function getAllEstablishments()
    {
        return $this->repository->all();
    }

    /**
     * ID'ye göre işletme getir
     */
    public function getEstablishmentById(int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * Yeni işletme oluştur
     */
    public function createEstablishment(array $data)
    {
        return $this->repository->create($data);
    }

    /**
     * Türe göre filtrele (restaurant, cafe)
     */
    public function getByType(string $type)
    {
        return $this->repository->filterByType($type);
    }

    /**
     * Konum ve mood'a göre filtrele
     */
    public function filterByLocationAndMood(string $location, string $mood)
    {
        return $this->repository->filterByLocationAndMood($location, $mood);
    }

    /**
     * Tür ve mood'a göre filtrele
     */
    public function filterByTypeAndMood(string $type, string $mood)
    {
        return $this->repository->filterByTypeAndMood($type, $mood);
    }
/**
     * Konuma göre filtrele
     */
    public function filterByLocation(string $location)
    {
        return $this->repository->filterByLocation($location);
    }

    /**
     * Mood'a göre filtrele
     */
    public function filterByMood(string $mood)
    {
        return $this->repository->filterByMood($mood);
    }

    public function getFeatured(int $limit = 6)
    {
        return $this->repository->getFeatured($limit);
    }

    public function filterByTag(int $tagId)
    {
        return $this->repository->filterByTag($tagId);
    }

    public function findNearby(float $lat, float $lng, float $radiusKm = 5, ?string $type = null, ?string $mood = null): Collection
{
    $establishments = $this->repository->getAllWithCoordinates();

    if ($type) {
        $establishments = $establishments->where('type', $type);
    }
    if ($mood) {
        $establishments = $establishments->where('mood', $mood);
    }

    return $establishments->map(function ($e) use ($lat, $lng) {
            $e->distance_km = $this->haversine($lat, $lng, $e->latitude, $e->longitude);
            return $e;
        })
        ->filter(fn ($e) => $e->distance_km <= $radiusKm)
        ->sortBy('distance_km')
        ->values();
}

     public function getTrending(int $limit = 10)
    {
        return $this->repository->getAllWithCounts()
            ->map(function ($e) {
                $e->trending_score = ($e->rating * 2) + ($e->reviews_count * 0.5) + ($e->favorited_by_count * 1);
                return $e;
            })
            ->sortByDesc('trending_score')
            ->take($limit)
            ->values();
    }

     public function getWizardRecommendations(array $answers, int $limit = 5)
    {
        $establishments = $this->repository->getAllWithCounts();

        return $establishments->map(function ($e) use ($answers) {
            $score = 0;

            if (!empty($answers['mood']) && $e->mood === $answers['mood']) {
                $score += 3;
            }

            if (!empty($answers['price_range']) && (int) $e->price_range === (int) $answers['price_range']) {
                $score += 2;
            }

            if (!empty($answers['location']) && $e->location === $answers['location']) {
                $score += 2;
            }

            if (!empty($answers['tag_id']) && $e->tags->contains('id', (int) $answers['tag_id'])) {
                $score += 2;
            }

            if (!empty($answers['lat']) && !empty($answers['lng']) && $e->latitude && $e->longitude) {
                $distance = $this->haversine((float) $answers['lat'], (float) $answers['lng'], $e->latitude, $e->longitude);
                $e->distance_km = $distance;
                if ($distance <= 3) {
                    $score += 2;
                } elseif ($distance <= 7) {
                    $score += 1;
                }
            }

            $e->wizard_score = $score;
            return $e;
        })
        ->sortByDesc('wizard_score')
        ->take($limit)
        ->values();
    }

    public function getSurpriseMe()
    {
        $establishments = $this->repository->getAllWithCounts();

        if ($establishments->isEmpty()) {
            return null;
        }

        $totalWeight = $establishments->sum(fn ($e) => max($e->rating, 0.5));
        $random = mt_rand() / mt_getrandmax() * $totalWeight;

        $cumulative = 0;
        foreach ($establishments as $e) {
            $cumulative += max($e->rating, 0.5);
            if ($random <= $cumulative) {
                return $e;
            }
        }

        return $establishments->last();
    }

     public function getSimilarToFavorites(\App\Models\User $user, int $limit = 5)
    {
        $favorites = $user->favorites;

        if ($favorites->isEmpty()) {
            return collect();
        }

        $favoriteMoods = $favorites->pluck('mood')->countBy();
        $favoriteTagIds = $favorites->flatMap(fn ($e) => $e->tags->pluck('id'))->countBy();
        $favoriteIds = $favorites->pluck('id');

        $candidates = $this->repository->all()->whereNotIn('id', $favoriteIds);

        return $candidates->map(function ($e) use ($favoriteMoods, $favoriteTagIds) {
                $score = 0;

                if (isset($favoriteMoods[$e->mood])) {
                    $score += $favoriteMoods[$e->mood] * 2;
                }

                foreach ($e->tags as $tag) {
                    if (isset($favoriteTagIds[$tag->id])) {
                        $score += $favoriteTagIds[$tag->id];
                    }
                }

                $e->similarity_score = $score;
                return $e;
            })
            ->filter(fn ($e) => $e->similarity_score > 0)
            ->sortByDesc('similarity_score')
            ->take($limit)
            ->values();
    }

    private function haversine(float $lat1, float $lng1, float $lat2, float $lng2): float
{
    $earthRadius = 6371; // km
    $dLat = deg2rad($lat2 - $lat1);
    $dLng = deg2rad($lng2 - $lng1);
    $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return round($earthRadius * $c, 2);
}
}

