<?php namespace App\Repositories\Permission;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

use App\Repositories\Permission\PermissionRepositoryInterface;

Class PermissionServiceProvider extends ServiceProvider {
    public function register() {
        $this->app->bind(
            'App\Repositories\Permission\PermissionRepositoryInterface',
            'App\Repositories\Permission\PermissionRepository'
        );
    }

    public function boot(PermissionRepositoryInterface $permission)
    {
        Blade::directive('reserved', function ($rolePermission) use ($permission){
            $feedback = false;
            $permissionName = false;
            $rolePermission = str_replace("'", '', $rolePermission);
            list($roleName, $permissionName) = explode(': ', $rolePermission);
            $roleName = trim($roleName);
            $permissionName = trim($permissionName);

            if(method_exists($permission, $permissionName)){
                $feedback = call_user_func(array($permission, $permissionName), $roleName);
            }

           $feedback = boolval($feedback);

            return "<?php if(Auth::check() && '$feedback') : ?>";
        });

        Blade::directive('endreserved', function ($rolePermission){
            return "<?php endif; ?>";
        });
    }


}

