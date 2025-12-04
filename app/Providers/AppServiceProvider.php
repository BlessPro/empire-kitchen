<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Laravel\Fortify\Contracts\LoginResponse; // Fortify's LoginResponse contract
use App\Http\Responses\LoginResponse as AppLoginResponse;  // Our concrete LoginResponse
use App\Models\Project;
use App\Policies\ProjectPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use App\Models\Measurement;
use App\Observers\MeasurementObserver;
use App\Observers\ProjectObserver;

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

        Project::observe(ProjectObserver::class);
        Measurement::observe(MeasurementObserver::class);

        Paginator::useTailwind();
        Paginator::useBootstrap();

        // Customize password reset email to include logo and brand content
        ResetPassword::toMailUsing(function ($notifiable, string $token) {
            $resetUrl = URL::to(
                route('password.reset', [
                    'token' => $token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ], false)
            );

            return (new MailMessage)
                ->subject('Reset Your Empire Kitchen Password')
                ->markdown('emails.password-reset', [
                    'resetUrl' => $resetUrl,
                    'user'     => $notifiable,
                    'loginUrl' => route('login'),
                    'logoUrl'  => asset('empire-kitchengold-icon.png'),
                    'appName'  => config('app.name', 'Empire Kitchen'),
                ]);
        });

    }
}
