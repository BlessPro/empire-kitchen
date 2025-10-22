<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Laravel\Fortify\Contracts\LoginResponse; // Import the correct LoginResponse interface
use App\Http\Responses\CustomLoginResponse;  // Import the CustomLoginResponse class
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
        $this->app->singleton(LoginResponse::class, CustomLoginResponse::class);

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
