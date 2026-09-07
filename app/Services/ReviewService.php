<?php

namespace App\Services;

use App\Repositories\Contracts\ReviewRepositoryInterface;

class ReviewService
{
    protected ReviewRepositoryInterface $repository;

    public function __construct(ReviewRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createReview(array $data)
    {
        return $this->repository->create($data);
    }

    public function getReviewsForEstablishment(int $establishmentId)
    {
        return $this->repository->getByEstablishment($establishmentId);
    }

    public function deleteReview(int $id)
    {
        return $this->repository->delete($id);
    }
}
