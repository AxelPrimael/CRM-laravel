<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
   
public function boot(): void
{
    if (app()->environment('production')) {
        URL::forceScheme('https');
    }
     Paginator::useBootstrap();
}
/**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
protected $listen = [

    \Illuminate\Auth\Events\Login::class => [
        \App\Listeners\UpdateLastLogin::class,
    ],

];

    /**
     * Bootstrap any application services.
     */

}
