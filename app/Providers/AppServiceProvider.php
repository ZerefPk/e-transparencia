<?php

namespace App\Providers;

use App\Models\NormativeAct\TypeNormativeAct;
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
            $publicationsMenu = PublicationTemplate::where('status', true)->orderBy('title')->get();
            $typesNormativesActsMenu = TypeNormativeAct::where('status', true)->orderBy('type')->get();
            $view->with([
                'typesNormativesActsMenu' => $typesNormativesActsMenu,
                'publicationsMenu' => $publicationsMenu
            ]);
        });
    }
}
