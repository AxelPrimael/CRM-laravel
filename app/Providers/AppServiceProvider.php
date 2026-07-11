<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Pagination\Paginator;



class AppServiceProvider extends ServiceProvider
{
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
    public function boot(): void
    {
    Paginator::useBootstrap();
    }
}
