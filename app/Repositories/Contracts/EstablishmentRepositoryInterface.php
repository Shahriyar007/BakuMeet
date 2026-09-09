<?php

namespace App\Repositories\Contracts;

interface EstablishmentRepositoryInterface
{
    public function all();
    
    public function find(int $id);
    
    public function create(array $data);
    
    public function filterByType(string $type);
    
    public function filterByLocationAndMood(string $location, string $mood);
    
    public function filterByTypeAndMood(string $type, string $mood);
    
    public function filterByLocation(string $location);
    
    public function filterByMood(string $mood);
    
    public function getFeatured(int $limit = 6);

    public function filterByPriceRange(int $priceRange);

    public function getAllWithCoordinates(): \Illuminate\Support\Collection;

    public function filterByTag(int $tagId): \Illuminate\Support\Collection;
}
