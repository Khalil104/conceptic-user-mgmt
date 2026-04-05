<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        // On vérifie si on est sur Vercel (où le storage doit être dans /tmp)
        if (env('APP_ENV') === 'production') {
            $this->app->bind('path.storage', function () {
                return '/tmp/storage';
            });
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
