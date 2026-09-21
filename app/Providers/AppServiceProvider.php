<?php

namespace App\Providers;

use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\User;
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
        User::observe(UserObserver::class);
    }
}
