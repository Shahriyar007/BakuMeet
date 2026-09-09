<?php

namespace App\Repositories\Eloquent;

use App\Models\Establishment;
use App\Repositories\Contracts\EstablishmentRepositoryInterface;

class EloquentEstablishmentRepository implements EstablishmentRepositoryInterface
{
    protected Establishment $model;

    public function __construct(Establishment $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function filterByType(string $type)
    {
        return $this->model->where('type', $type)->get();
    }

    public function filterByLocationAndMood(string $location, string $mood)
    {
        return $this->model
            ->where('location', $location)
            ->where('mood', $mood)
            ->get();
    }

    public function filterByTypeAndMood(string $type, string $mood)
    {
        return $this->model
            ->where('type', $type)
            ->where('mood', $mood)
            ->get();
    }
   public function filterByLocation(string $location)
    {
        return $this->model->where('location', $location)->get();
    }

   public function filterByMood(string $mood)
    {
        return $this->model->where('mood', $mood)->get();
    }
   public function getFeatured(int $limit = 6)
    {
        return $this->model->orderBy('rating', 'desc')->limit($limit)->get();
    }

   public function filterByPriceRange(int $priceRange)
    {
        return $this->model->where('price_range', $priceRange)->get();
    }

   public function getAllWithCoordinates(): \Illuminate\Support\Collection
    {
        return $this->model->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();
    }

   public function filterByTag(int $tagId): \Illuminate\Support\Collection
    {
        return $this->model->whereHas('tags', function ($query) use ($tagId) {
            $query->where('tags.id', $tagId);
        })->get();
    }

}
