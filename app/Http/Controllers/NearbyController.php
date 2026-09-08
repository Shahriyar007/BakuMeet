<?php

namespace App\Http\Controllers;

use App\Services\EstablishmentService;
use Illuminate\Http\Request;

class NearbyController extends Controller
{
    public function __construct(protected EstablishmentService $service)
    {
    }

    public function index(Request $request)
    {
        $lat = $request->query('lat');
        $lng = $request->query('lng');
        $radius = $request->query('radius', 5);
        $type = $request->query('type');
        $mood = $request->query('mood');

        $establishments = collect();
        if ($lat && $lng) {
            $establishments = $this->service->findNearby((float)$lat, (float)$lng, (float)$radius, $type, $mood);
        }

        return view('nearby.index', compact('establishments', 'lat', 'lng', 'radius', 'type', 'mood'));
    }
}
