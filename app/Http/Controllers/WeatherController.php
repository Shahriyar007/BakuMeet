<?php

namespace App\Http\Controllers;

use App\Services\EstablishmentService;

class WeatherController extends Controller
{
    public function __construct(protected EstablishmentService $service)
    {
    }

    public function index()
    {
        $data = $this->service->getWeatherSuggestions();
        return view('weather.index', $data);
    }
}
