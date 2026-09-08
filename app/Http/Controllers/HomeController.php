<?php

namespace App\Http\Controllers;

use App\Services\EstablishmentService;
use App\Services\CollectionService;
use App\Models\Establishment;
use App\Models\Review;

class HomeController extends Controller
{
    protected EstablishmentService $service;
    protected CollectionService $collectionService;

    public function __construct(EstablishmentService $service, CollectionService $collectionService)
    {
        $this->service = $service;
        $this->collectionService = $collectionService;
    }

    public function index()
    {
        $featured = $this->service->getFeatured(6);
        $collections = $this->collectionService->getAllCollections()->take(3);

        $mapData = $featured
            ->filter(fn($e) => $e->latitude && $e->longitude)
            ->map(function ($e) {
                return [
                    'id' => $e->id,
                    'name' => $e->name,
                    'type' => $e->type,
                    'latitude' => $e->latitude,
                    'longitude' => $e->longitude,
                ];
            })
            ->values();

        $stats = [
            'establishments' => Establishment::count(),
            'locations' => Establishment::distinct('location')->count('location'),
            'reviews' => Review::count(),
        ];

        return view('home', [
            'featured' => $featured,
            'collections' => $collections,
            'mapData' => $mapData,
            'stats' => $stats,
        ]);
    }
}
