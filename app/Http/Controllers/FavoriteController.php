<?php

namespace App\Http\Controllers;

class FavoriteController extends Controller
{
    public function toggle(int $establishmentId)
    {
        $user = auth()->user();

        if ($user->favorites()->where('establishment_id', $establishmentId)->exists()) {
            $user->favorites()->detach($establishmentId);
            $message = 'Favorilerden çıkarıldı.';
        } else {
            $user->favorites()->attach($establishmentId);
            $message = 'Favorilere eklendi!';
        }

        return back()->with('success', $message);
    }

    public function index()
    {
        $favorites = auth()->user()->favorites;
        return view('favorites.index', ['favorites' => $favorites]);
    }
}
