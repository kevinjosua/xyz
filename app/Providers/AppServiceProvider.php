<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // if (app()->environment('local')) {
        //     // Check if the application is running behind ngrok
        //     if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
        //         URL::forceScheme('https');
        //         config(['app.url' => 'https://b54b-182-253-183-22.ngrok-free.app' . $_SERVER['HTTP_HOST']]);
        //     }
        // }
    }
}
