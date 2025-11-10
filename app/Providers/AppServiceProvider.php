<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Laravel\Fortify\Contracts\LoginResponse; // Fortify's LoginResponse contract
use App\Http\Responses\LoginResponse as AppLoginResponse;  // Our concrete LoginResponse
 use App\Models\Project;
use App\Policies\ProjectPolicy;

class AppServiceProvider extends ServiceProvider
{

   
protected $policies = [
    Project::class => ProjectPolicy::class,
];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        // Bind Fortify's LoginResponse to our implementation
        $this->app->singleton(LoginResponse::class, AppLoginResponse::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //

        Paginator::useTailwind();
        Paginator::useBootstrap();


    }
}
