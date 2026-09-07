<?php

namespace App\Services;

use App\Repositories\Contracts\EstablishmentRepositoryInterface;

class EstablishmentService
{
    protected EstablishmentRepositoryInterface $repository;

    public function __construct(EstablishmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Tüm işletmeleri getir
     */
    public function getAllEstablishments()
    {
        return $this->repository->all();
    }

    /**
     * ID'ye göre işletme getir
     */
    public function getEstablishmentById(int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * Yeni işletme oluştur
     */
    public function createEstablishment(array $data)
    {
        return $this->repository->create($data);
    }

    /**
     * Türe göre filtrele (restaurant, cafe)
     */
    public function getByType(string $type)
    {
        return $this->repository->filterByType($type);
    }

    /**
     * Konum ve mood'a göre filtrele
     */
    public function filterByLocationAndMood(string $location, string $mood)
    {
        return $this->repository->filterByLocationAndMood($location, $mood);
    }

    /**
     * Tür ve mood'a göre filtrele
     */
    public function filterByTypeAndMood(string $type, string $mood)
    {
        return $this->repository->filterByTypeAndMood($type, $mood);
    }
/**
     * Konuma göre filtrele
     */
    public function filterByLocation(string $location)
    {
        return $this->repository->filterByLocation($location);
    }

    /**
     * Mood'a göre filtrele
     */
    public function filterByMood(string $mood)
    {
        return $this->repository->filterByMood($mood);
    }
}

