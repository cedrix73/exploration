<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Category;
use App\Actor;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * Dependency injection:
     * Link between a class and it's interface
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\PhotoRepositoryInterface',
            'App\Repositories\PhotoRepository'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['index', 'create', 'edit'], function ($view) {
            $view->with('categories', Category::all());
            $view->with('actors', Actor::all());
        });
    }


}
