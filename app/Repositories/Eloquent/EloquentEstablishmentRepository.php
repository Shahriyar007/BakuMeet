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
}
