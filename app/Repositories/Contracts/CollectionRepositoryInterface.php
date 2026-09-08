<?php

namespace App\Repositories\Contracts;

interface CollectionRepositoryInterface
{
    public function all();
    public function find(int $id);
}
