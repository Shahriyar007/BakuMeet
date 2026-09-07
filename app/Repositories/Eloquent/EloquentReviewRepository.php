<?php

namespace App\Repositories\Eloquent;

use App\Models\Review;
use App\Repositories\Contracts\ReviewRepositoryInterface;

class EloquentReviewRepository implements ReviewRepositoryInterface
{
    protected Review $model;

    public function __construct(Review $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function getByEstablishment(int $establishmentId)
    {
        return $this->model
            ->where('establishment_id', $establishmentId)
            ->with('user')
            ->latest()
            ->get();
    }

    public function delete(int $id)
    {
        return $this->model->destroy($id);
    }
}
