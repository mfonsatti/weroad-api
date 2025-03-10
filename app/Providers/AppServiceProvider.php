<?php

namespace App\Providers;

use App\Repositories\Interfaces\TravelRepositoryInterface;
use App\Repositories\TravelRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TravelRepositoryInterface::class, TravelRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::prefix('api')->group(base_path('routes/api.php'));
    }
}
