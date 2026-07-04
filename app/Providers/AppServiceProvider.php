<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Suppress deprecation warnings from vendor packages on PHP 8.5
        error_reporting(E_ALL & ~E_DEPRECATED);

        // Use custom pagination view with Previous/Next buttons
        Paginator::defaultView('vendor.pagination.custom');
    }
}
