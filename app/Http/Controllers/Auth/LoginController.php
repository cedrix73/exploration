<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Permission\PermissionRepositoryInterface;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use App\User;
//use Illuminate\Http\Request;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $permission;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PermissionRepositoryInterface $permission)
    {
        $this->middleware('guest')->except('logout');
        $this->permission = $permission;
    }

    /**
     * After authentification
     * Override AuthenticatesUsers Trait method
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, User $user)
    {
        $user->setRolesAndPermissionSession();
        // $code=$this->permission->check('films-section');
        // dd($this->permission->isInsert());

    }


}
