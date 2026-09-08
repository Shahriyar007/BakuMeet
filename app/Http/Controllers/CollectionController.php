<?php

namespace App\Http\Controllers;

use App\Services\CollectionService;

class CollectionController extends Controller
{
    protected CollectionService $service;

    public function __construct(CollectionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $collections = $this->service->getAllCollections();
        return view('collections.index', ['collections' => $collections]);
    }

    public function show(int $id)
    {
        $collection = $this->service->getCollectionById($id);

        if (!$collection) {
            abort(404);
        }

        return view('collections.show', ['collection' => $collection]);
    }
}
