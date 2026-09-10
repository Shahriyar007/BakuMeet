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
            'atmosphere_rating' => 'required|integer|min:1|max:5',
            'food_rating' => 'required|integer|min:1|max:5',
            'service_rating' => 'required|integer|min:1|max:5',
            'value_rating' => 'required|integer|min:1|max:5',
        ]);

        $overallRating = round((
            $request->atmosphere_rating +
            $request->food_rating +
            $request->service_rating +
            $request->value_rating
        ) / 4);
       $this->service->createReview([
            'user_id' => auth()->id(),
            'establishment_id' => $establishmentId,
            'comment' => $request->comment,
            'rating' => $overallRating,
            'atmosphere_rating' => $request->atmosphere_rating,
            'food_rating' => $request->food_rating,
            'service_rating' => $request->service_rating,
            'value_rating' => $request->value_rating,
        ]);

        $establishment = \App\Models\Establishment::find($establishmentId);
        $establishment->rating = round($establishment->reviews()->avg('rating'), 1);
        $establishment->save();

        return redirect("/establishments/{$establishmentId}")->with('success', 'Yorumunuz eklendi!');
    }

     public function destroy(int $id)
     {
        $review = \App\Models\Review::find($id);

        if (!$review) {
            abort(404);
        }

        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $establishmentId = $review->establishment_id;

        $this->service->deleteReview($id);
    
        if ($establishmentId) {
            $establishment = \App\Models\Establishment::find($establishmentId);
            $newRating = $establishment->reviews()->avg('rating');
            $establishment->rating = $newRating ? round($newRating, 1) : 0;
            $establishment->save();
        }

        return back()->with('success', 'Yorum silindi.');
    }
}
