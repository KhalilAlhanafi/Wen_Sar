<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

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
        // Rate Limiting Configuration
        RateLimiter::for('login', function () {
            return Limit::perMinute(5)->by(request()->ip());
        });

        RateLimiter::for('contact', function () {
            return Limit::perMinute(3)->by(request()->ip());
        });

        RateLimiter::for('search', function () {
            return Limit::perMinute(30)->by(request()->ip());
        });

        RateLimiter::for('api', function () {
            return Limit::perMinute(60)->by(request()->ip());
        });

        RateLimiter::for('manager', function () {
            return Limit::perMinute(10)->by(request()->ip());
        });
    }
}
