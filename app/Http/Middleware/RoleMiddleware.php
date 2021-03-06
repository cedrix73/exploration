<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use HasRolesAndPermissions;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if(auth()->user()==null || !auth()->user()->hasRole($role)) {
            abort(404);
            //redirect()->route('accueil');
        }
        return $next($request);
    }
}
