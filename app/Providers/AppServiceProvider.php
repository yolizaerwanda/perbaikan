<?php

namespace App\Providers;

use App\Http\Responses\CustomLogoutResponse;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse;
// use Filament\Http\Responses\Auth\LogoutResponse;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LogoutResponse::class, CustomLogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
