<?php

namespace App\Providers;

use App\Interfaces\AuthRepositoryInterface;
use App\Interfaces\LoginRepositoryInterface;
use App\Models\Product;
use App\Repositories\AuthRepository;
use App\Repositories\LoginRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(LoginRepositoryInterface::class, LoginRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $minPrice = Product::globalMinPrice();
        $maxPrice = Product::globalMaxPrice();
        View::share(['minPrice' => $minPrice, 'maxPrice' => $maxPrice]);
    }
}
