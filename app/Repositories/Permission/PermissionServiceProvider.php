<?php namespace App\Repositories\Permission;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

Class PermissionServiceProvider extends ServiceProvider {
    public function register() {
        $this->app->bind(
            'App\Repositories\Permission\PermissionRepositoryInterface',
            'App\Repositories\Permission\PermissionRepository'
        );
    }

    public function boot()
    {
        Blade::directive('role', function ($role){
            return "<?php if(auth()->check() && auth()->user()->hasRole({$role})) :";
        });

        Blade::directive('endrole', function ($role){
            return "<?php endif; ?>";
        });


    }


}

