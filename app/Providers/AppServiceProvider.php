<?php

namespace App\Providers;

use App\Domains\Property\Repositories\EloquentPropertyRepository;
use App\Domains\Property\Repositories\PropertyRepositoryContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PropertyRepositoryContract::class, EloquentPropertyRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
