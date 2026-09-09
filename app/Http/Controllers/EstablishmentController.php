<?php

namespace App\Http\Controllers;

use App\Services\EstablishmentService;
use Illuminate\Http\Request;

class EstablishmentController extends Controller
{
    protected EstablishmentService $service;

    public function __construct(EstablishmentService $service)
    {
        $this->service = $service;
    }

    /**
     * Tüm işletmeleri listele
     */
    public function index()
    {
        $establishments = $this->service->getAllEstablishments();
        return view('establishments.index', ['establishments' => $establishments]);
    }

    /**
     * Işletme detayını göster
     */
    public function show(int $id)
    {
        $establishment = $this->service->getEstablishmentById($id);
        
        if (!$establishment) {
            abort(404);
        }

        return view('establishments.show', ['establishment' => $establishment]);
    }

    /**
     * Türe göre filtrele (restaurant, cafe)
     */
    public function filterByType(string $type)
    {
        $establishments = $this->service->getByType($type);
        return view('establishments.index', ['establishments' => $establishments, 'filter' => "Tür: {$type}"]);
    }

    /**
     * Konum ve mood'a göre filtrele
     */

     public function filterByLocationAndMood(Request $request)
    {
        $location = $request->query('location');
        $mood = $request->query('mood');
        $priceRange = $request->query('price_range');
        $tagId = $request->query('tag');

        $establishments = $this->service->getAllEstablishments();
        $filterParts = [];

        if ($location) {
            $establishments = $establishments->where('location', $location);
            $filterParts[] = "📍 {$location}";
        }

        if ($mood) {
            $establishments = $establishments->where('mood', $mood);
            $filterParts[] = "🎭 {$mood}";
        }

        if ($priceRange) {
            $establishments = $establishments->where('price_range', $priceRange);
            $filterParts[] = str_repeat('₼', $priceRange);
        }

        if ($tagId) {
            $establishments = $establishments->filter(function ($e) use ($tagId) {
                return $e->tags->contains('id', (int) $tagId);
            });
            $tagName = \App\Models\Tag::find($tagId)?->name;
            if ($tagName) {
                $filterParts[] = "🏷️ {$tagName}";
            }
        }

        return view('establishments.index', [
            'establishments' => $establishments->values(),
            'filter' => $filterParts ? implode(' + ', $filterParts) : null
        ]);
    }

/**
     * Harita sayfasını göster
     */
    public function map()
    {
        $establishments = $this->service->getAllEstablishments();
        
        // Sadece koordinatı olan işletmeleri JSON'a çevir
        $mapData = $establishments
            ->filter(fn($e) => $e->latitude && $e->longitude)
            ->map(function ($e) {
                return [
                    'id' => $e->id,
                    'name' => $e->name,
                    'type' => $e->type,
                    'mood' => $e->mood,
                    'location' => $e->location,
                    'rating' => $e->rating,
                    'latitude' => $e->latitude,
                    'longitude' => $e->longitude,
                ];
            })
            ->values();

        return view('establishments.map', ['mapData' => $mapData]);
    }
}
