<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Laravel\Fortify\Contracts\LoginResponse; // Import the correct LoginResponse interface
use App\Http\Responses\CustomLoginResponse;  // Import the CustomLoginResponse class

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(LoginResponse::class, CustomLoginResponse::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //

        Paginator::useTailwind();

    }
}
