<?php

namespace App\Traits;

use App\Role;
use App\Permission;
use Illuminate\Support\Str;

trait HasRolesAndPermissions
{
    /**
     * @return mixed
     */

    private $_role;

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permissions')->withPivot('code')->withTimestamps();
    }

    /**
     * @name        hasRole
     * @description look for the user's roles
     * @parameter   array $roles
     * @return      boolean
     */
    public function hasRole($roleAsked) {
        $feedback=false;
        foreach ($this->roles as $role) {
            if (Str::contains($roleAsked, $role->slug)) {
                $feedback=true;
            }
        }
        return $feedback;
    }

    /**
     * @name        getPermissions
     * @description returns permission code for a given role
     *              or null if none
     * @parameter   String $roleAsked
     * @return      int code
     */
    public function getPermissions($roleAsked) {
        $code=null;
        foreach ($this->roles as $role) {
            if ($role->contains('slug', $roleAsked)) {
                $code = $role->pivot->code;
            }
        }
        return $code;
    }

    /**
     * @name        getAllRolesAndPermission
     * @description return array[role slug] = code
     */
    public function setRolesAndPermissionSession() {
        $rolesArray =array();
        foreach ($this->roles as $role) {
            $code = $role->pivot->code;
            $rolesArray[$role->slug] = $code;
        }
        session(['roles' => $rolesArray]);

    }

    public function getRole($roleAsked) {
        return Role::where('slug', $roleAsked)->get();
    }


    public function giveRole($roleAsked, $code) {
        $role = $this->getRole($roleAsked);
        if ($role === null) {
            return false;
        } else {
            $this->roles()->attach($role, ['code' => $code]);
            // a assayer avec save() sinon..
        }
        return $this;
    }

    public function detachRole($roleSlug) {
        $feedback = false;
        $role = $this->getRole($roleSlug);
        if($this->roles()->detach($role)) {
            $feedback =  true;
        }
        return $feedback;
    }
}
