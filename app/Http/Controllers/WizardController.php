<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Services\EstablishmentService;
use Illuminate\Http\Request;

class WizardController extends Controller
{
    public function __construct(protected EstablishmentService $service)
    {
    }

    public function index()
    {
        $tags = Tag::all();
        return view('wizard.index', ['tags' => $tags]);
    }

    public function results(Request $request)
    {
        $answers = $request->only(['mood', 'price_range', 'location', 'tag_id', 'lat', 'lng']);
        $establishments = $this->service->getWizardRecommendations($answers);

        return view('wizard.results', ['establishments' => $establishments, 'answers' => $answers]);
    }
}
