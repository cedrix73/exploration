<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        //
    }


}
