<?php

namespace App\Providers;

use App\Services\Country\CountryExtractor;
use App\Services\Country\CountryExtractorInterface;
use App\Services\Guest\GuestRepository;
use App\Services\Guest\GuestRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CountryExtractorInterface::class, CountryExtractor::class);
        $this->app->bind(GuestRepositoryInterface::class, GuestRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
