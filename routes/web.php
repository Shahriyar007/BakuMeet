<?php

use App\Http\Controllers\WizardController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\NearbyController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstablishmentController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/establishments', [EstablishmentController::class, 'index']);
Route::get('/establishments/{id}', [EstablishmentController::class, 'show']);
Route::get('/nearby', [NearbyController::class, 'index'])->name('nearby.index');
Route::get('/areas', [AreaController::class, 'index'])->name('areas.index');
Route::get('/trending', [EstablishmentController::class, 'trending'])->name('establishments.trending');
Route::get('/wizard', [WizardController::class, 'index'])->name('wizard.index');
Route::get('/wizard/results', [WizardController::class, 'results'])->name('wizard.results');
Route::get('/surprise', [WizardController::class, 'surprise'])->name('wizard.surprise');
Route::get('/for-you', [WizardController::class, 'similarToFavorites'])->middleware('auth')->name('wizard.similar');
Route::get('/areas/{location}', [AreaController::class, 'show'])->name('areas.show');
Route::get('/establishments/map/view', [EstablishmentController::class, 'map']);
Route::get('/establishments-by-type/{type}', [EstablishmentController::class, 'filterByType'])->name('establishments.filterByType');
Route::get('/filter', [EstablishmentController::class, 'filterByLocationAndMood'])->name('establishments.filter');

Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index');
Route::get('/collections/{id}', [CollectionController::class, 'show'])->name('collections.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function () {
    Route::post('/establishments/{id}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
   
    Route::post('/establishments/{id}/favorite', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
});


require __DIR__.'/auth.php';
