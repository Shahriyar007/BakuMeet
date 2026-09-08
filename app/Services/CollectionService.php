<?php

namespace App\Services;

use App\Repositories\Contracts\CollectionRepositoryInterface;

class CollectionService
{
    protected CollectionRepositoryInterface $repository;

    public function __construct(CollectionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllCollections()
    {
        return $this->repository->all();
    }

    public function getCollectionById(int $id)
    {
        return $this->repository->find($id);
    }
}
