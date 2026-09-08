<?php

namespace App\Repositories\Eloquent;

use App\Models\Collection;
use App\Repositories\Contracts\CollectionRepositoryInterface;

class EloquentCollectionRepository implements CollectionRepositoryInterface
{
    protected Collection $model;

    public function __construct(Collection $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with('establishments')->get();
    }

    public function find(int $id)
    {
        return $this->model->with('establishments')->find($id);
    }
}
