<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Http\Request;


use Tests\TestCase;

use App\User;
use App\Role;
use App\Repositories\Permission\PermissionRepository;

class UsersControllerTest extends TestCase
{
    use RefreshDatabase;

    const LOGIN_URL = '/login';


    /**
     * setUp
     *
     * @return void
     */
    public function setUp() :void
    {
        parent::setUp();

        // Role and permission setUp part:
        $this->permission = new PermissionRepository();

        $this->filmRole = factory(Role::class)->create([
            'name' => 'Films section',
            'slug' => 'films-section'
        ]);


        // User SetUp part:
        $this->cedrixPwd = 'i_love_rhum';

        $this->userCedrix = factory(User::class)
            ->create([
                'password' => bcrypt($this->cedrixPwd),
            ]);

        // Création toutes permission sauf INSERT
        $this->userCedrix->giveRole('films-section', 13);
        // Mise en session
        $this->userCedrix->setRolesAndPermissionSession();

        $this->userCedrix->save();

    }


    /**
     * testFilmsDefaut
     * teste si la route par défaut des films retourne
     * bien la vue film_index
     *
     * @return void
     */

    public function testFilmsDefaut()
    {
        $response = $this->call('GET', 'films');
        $response->assertSuccessful();
        $response->assertStatus(200);
    }

    public function test_user_can_view_a_login_form()
    {
        $response = $this->get(self::LOGIN_URL);

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    public function testLoginFalse()
    {
        /**
         * Login d'un utlisateur avec mauvais password:
         * Teste si en session le bon user email est enregistré
         * mais pas le mot de passe.
         */



        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'right_password'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'wrong_password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }





    public function testLoginPoweruserTrue()
    {
        $response = $this->post('/login', [
            'email' => $this->userCedrix->email,
            'password' => $this->cedrixPwd,
        ]);
        // On s'assure que la vue est rafraichie pour les conditions de permission
        $response->assertRedirect('view-clear');
        $this->assertAuthenticatedAs($this->userCedrix);

    }


    /**
     * Session Permission en modification
     */
    public function testPowerUserUpdate()
    {
        $this->assertTrue($this->permission->isUpdate('films-section'));
    }

    /**
     * Session Permission en suppression
     */
    public function testPowerUserDelete()
    {
        $this->assertTrue($this->permission->isDelete('films-section'));
    }

    /**
     * Session Permission en création
     * Devrait être à false
     */
    public function testPowerUserCreate()
    {
        $this->assertFalse($this->permission->isInsert('films-section'));
    }




}
