<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Providers\AppServiceProvider;
use App\Repositories\Permission\PermissionRepository;
use App\User;
use DB;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Console\Output\ConsoleOutput;


class FilmsTest extends DuskTestCase
{

    private $_roleName;
    private $_output;
    protected $permission;

    use WithFaker;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->_output = new ConsoleOutput();
        $this->_roleName = 'films-section';
    }

    /**
     * @return void
     */
    public function testBasicExample()
    {
        $this->_output->writeln('Test testBasicExample');
        $this->browse(function (Browser $browser) {
            $browser->visit('/exploration')
                    ->assertSee('Laravel');
        });
    }

    /**
     * Page index films
     * @group films
     *
     * @return void
     */
    public function testFilmsHomeContent()
    {
        $this->_output->writeln('Test testFilmsHomeContent');
        $this->browse(function (Browser $browser) {
            $browser->visit('/exploration/films')
                    ->assertSee('Films');
        });
    }

    /**
     * Selection d'un film par clic sur bouton voir
     * @group films
     *
     * @return void
     */
    public function testFilmsShowFilm()
    {

        $this->_output->writeln('Test testFilmsShowFilm');
        $this->browse(function (Browser $browser) {
            $browser->visit('/exploration/films')
                    ->clickLink('Voir')
                    ->assertSee('Titre')
                    ->pause(2000)
                    ->visit('/exploration');
        });
    }

    /**
     * Essai connexion avec permission en update
     * @group films
     *
     * @return void
     */
    public function testConnectPowerUser()
    {
        $faker = $this->faker;
        $this->_output->writeln('Test connectPowerUser');
        $this->browse(function (Browser $browser) use ($faker){
            $browser->visit('/exploration')
                    ->assertSee('LOGIN')
                    ->clickLink('Login')
                    ->assertPathIs('/exploration/login')
                    ->assertSee('Login')
                    ->waitForLink('Login')
                    ->pause(1000)
                    ->type('email', 'felten.cedric@gmail.com')
                    ->type('password', 'cedrix')
                    ->pause(2000)
                    ->click('@login-button')
                    ->pause(1000)
                    ->visit('/exploration/films')
                    ->pause(4000)
                    ->clickLink('Modifier', 'a')
                    ->pause(2000)
                    ->assertSee('Modification')
                    ->type('title', $faker->sentence(2, true))
                    ->type('year', $faker->year)
                    ->pause(2000)
                    ->press('Envoyer')
                    ->assertSee('Le film a bien été modifié')
                    ->pause(2000);
        });
    }

    /**
     * Login avec utilisateur avec pouvoir en update
     * @group films
     */


     /*
    public function testLoginFullPowerUser()
    {
        $output = new ConsoleOutput();
        $output->writeln('Test loginFullPowerUser');
        $permission = new PermissionRepository();
        /** @var User $user */
        /*
        $user = User::where('email', 'felten.cedric@gmail.com')->first();
        $output->writeln($user->name);
        $this->browse(function (Browser $browser) use ($user, $permission) {
            $browser->loginAs($user)
                assert($permission->isUpdate($this->_roleName))
                ->pause(2000)
                ->visit('/exploration/films')
                ->pause(2000)
                ->clickLink('#update_3')
                ->pause(2000)
                ->assertSee('Modification')
                ->type('title', $faker->sentence(2, true))
                ->pause(2000)
                ->press('Envoyer')
                ->assertSee('Le film a bien été modifié')
                ->pause(2000);
        });

        // use ($_permission)
        // $permission = new PermissionRepositoryInterface();
        // ->loginAs(User::firstWhere('email', 'felten.cedric@gmail.com'))
        // ->assert($permission->isUpdate($this->_roleName));
    }
    */


}
