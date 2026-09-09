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

