<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\EstablishmentRepositoryInterface;
use App\Repositories\Eloquent\EloquentEstablishmentRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            EstablishmentRepositoryInterface::class,
            EloquentEstablishmentRepository::class
        );
        $this->app->bind(
            \App\Repositories\Contracts\ReviewRepositoryInterface::class,
            \App\Repositories\Eloquent\EloquentReviewRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
