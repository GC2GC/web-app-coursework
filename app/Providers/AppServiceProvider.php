<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

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
        // Fortify views and actions are now registered in FortifyServiceProvider
    }
}
