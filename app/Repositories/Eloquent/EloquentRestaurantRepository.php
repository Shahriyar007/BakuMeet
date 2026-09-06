<?php

namespace App\Repositories\Eloquent;

use App\Models\Restaurant;
use App\Repositories\Contracts\RestaurantRepositoryInterface;

class EloquentRestaurantRepository implements RestaurantRepositoryInterface
{
    public function all()
    {
        return Restaurant::all();
    }

    public function find(int $id)
    {
        return Restaurant::findOrFail($id);
    }

    public function create(array $data)
    {
        return Restaurant::create($data);
    }

    public function filterByLocationAndMood(string $location, string $mood)
    {
        return Restaurant::where('location', $location)
            ->where('mood', $mood)
            ->get();
    }
}
