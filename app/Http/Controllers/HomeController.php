<?php

namespace App\Http\Controllers;

use App\Services\EstablishmentService;
use App\Models\Establishment;
use App\Models\Review;

class HomeController extends Controller
{
    protected EstablishmentService $service;

    public function __construct(EstablishmentService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $featured = $this->service->getFeatured(6);

        $stats = [
            'establishments' => Establishment::count(),
            'locations' => Establishment::distinct('location')->count('location'),
            'reviews' => Review::count(),
        ];

        return view('home', [
            'featured' => $featured,
            'stats' => $stats,
        ]);
    }
}
