<?php namespace App\Repositories\Role;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

Class RoleServiceProvider extends ServiceProvider {
    public function register() {
        $this->app->bind(
            'App\Repositories\Role\RoleRepositoryInterface',
            'App\Repositories\Role\RoleRepository'
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

