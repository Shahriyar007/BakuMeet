<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Establishment;

class AreaController extends Controller
{
    public function index()
    {
        $locations = Establishment::select('location')
            ->selectRaw('count(*) as total')
            ->groupBy('location')
            ->orderBy('location')
            ->get();

        return view('areas.index', ['locations' => $locations]);
    }

    public function show(string $location)
    {
        $establishments = Establishment::where('location', $location)->get();

        if ($establishments->isEmpty()) {
            abort(404);
        }

        $stats = [
            'total' => $establishments->count(),
            'restaurants' => $establishments->where('type', 'restaurant')->count(),
            'cafes' => $establishments->where('type', 'cafe')->count(),
            'avg_rating' => round($establishments->avg('rating'), 1),
        ];

        $collections = Collection::whereHas('establishments', function ($query) use ($location) {
            $query->where('location', $location);
        })->get();

        $mapData = $establishments
            ->filter(fn ($e) => $e->latitude && $e->longitude)
            ->values();

        return view('areas.show', [
            'location' => $location,
            'establishments' => $establishments,
            'stats' => $stats,
            'collections' => $collections,
            'mapData' => $mapData,
        ]);
    }
}
