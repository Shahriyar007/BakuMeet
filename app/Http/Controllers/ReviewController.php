<?php

namespace App\Http\Controllers;

use App\Services\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected ReviewService $service;

    public function __construct(ReviewService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request, int $establishmentId)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $this->service->createReview([
            'user_id' => auth()->id(),
            'establishment_id' => $establishmentId,
            'comment' => $request->comment,
            'rating' => $request->rating,
        ]);

        return redirect("/establishments/{$establishmentId}")->with('success', 'Yorumunuz eklendi!');
    }

    public function destroy(int $id)
    {
        $this->service->deleteReview($id);
        return back()->with('success', 'Yorum silindi.');
    }
}
