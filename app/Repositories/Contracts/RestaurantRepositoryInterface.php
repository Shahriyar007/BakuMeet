<?php

namespace App\Repositories\Contracts;

interface RestaurantRepositoryInterface
{
    public function all();

    public function find(int $id);

    public function create(array $data);

    public function filterByLocationAndMood(string $location, string $mood);
}
