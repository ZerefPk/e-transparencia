<?php

namespace App\Providers;

use App\Models\Publication\PublicationTemplate;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
        //
        Paginator::useBootstrap();
        view()->composer(['*'], function ($view) {
            $publications = PublicationTemplate::where('status', true)->orderBy('title')->get();
            $view->with('publications', $publications);
        });
    }
}
