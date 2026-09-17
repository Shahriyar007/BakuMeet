<?php

namespace App\Repositories\Eloquent;

use App\Models\Establishment;
use App\Repositories\Contracts\EstablishmentRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class EloquentEstablishmentRepository implements EstablishmentRepositoryInterface
{
    protected Establishment $model;

    public function __construct(Establishment $model)
    {
        $this->model = $model;
    }

    /**
     * Base query with the relations every listing view needs eager-loaded,
     * to avoid N+1 queries as the establishment count grows.
     */
    private function baseQuery(): Builder
    {
        return $this->model->with(['primaryPhoto', 'tags']);
    }

    public function all()
    {
        return $this->baseQuery()->get();
    }

    public function find(int $id)
    {
        return $this->model->with(['photos', 'tags', 'reviews.user'])->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function filterByType(string $type)
    {
        return $this->baseQuery()->where('type', $type)->get();
    }

    public function filterByLocationAndMood(string $location, string $mood)
    {
        return $this->baseQuery()
            ->where('location', $location)
            ->where('mood', $mood)
            ->get();
    }

    public function filterByTypeAndMood(string $type, string $mood)
    {
        return $this->baseQuery()
            ->where('type', $type)
            ->where('mood', $mood)
            ->get();
    }

    public function filterByLocation(string $location)
    {
        return $this->baseQuery()->where('location', $location)->get();
    }

    public function filterByMood(string $mood)
    {
        return $this->baseQuery()->where('mood', $mood)->get();
    }

    public function getFeatured(int $limit = 6)
    {
        return $this->baseQuery()->orderBy('rating', 'desc')->limit($limit)->get();
    }

    public function filterByPriceRange(int $priceRange)
    {
        return $this->baseQuery()->where('price_range', $priceRange)->get();
    }

    public function getAllWithCoordinates(): \Illuminate\Support\Collection
    {
        return $this->baseQuery()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();
    }

    public function filterByTag(int $tagId): \Illuminate\Support\Collection
    {
        return $this->baseQuery()->whereHas('tags', function ($query) use ($tagId) {
            $query->where('tags.id', $tagId);
        })->get();
    }

    public function getAllWithCounts(): \Illuminate\Support\Collection
    {
        return $this->baseQuery()->withCount(['reviews', 'favoritedBy'])->get();
    }
}
