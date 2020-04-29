<?php

use App\User;
use App\Role;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->fillRolesAndUsers();
    }

    public function fillRolesAndUsers() {
        $filmRole = new Role();
        $filmRole->name = 'Films section';
        $filmRole->slug = 'films-section';
        $filmRole->save();

        $contactRole = new Role();
        $contactRole->name = 'Contacts section';
        $contactRole->slug = 'contacts-section';
        $contactRole->save();

        /*
        App\User::create(
            [
                'name' => 'Dupont',
                'email' => 'dupont@la.fr',
                'password' => bcrypt('pass'),
            ]
        );
        */

        $user1 = new User();
        $user1->name = 'Jhon Deo';
        $user1->email = 'jhon@deo.com';
        $user1->password = bcrypt('secret');
        $user1->save();


        $admin = new User();
        $admin->name = 'Cedric Felten';
        $admin->email = 'felten.cedric@gmail.com';
        $admin->password = bcrypt('cedrix');
        $admin->save();
        $admin->giveRole('contacts-section', 8);
        $admin->giveRole('films-section', 8);



        $filmReader = new User();
        $filmReader->name = 'Jack Daniels';
        $filmReader->email = 'jack.daniels@mailtrap.io';
        $filmReader->password = bcrypt('jackdaniels');
        $filmReader->save();
        $filmReader->giveRole('films-section', 1);


        $filmCreator = new User();
        $filmCreator->name = 'John Campbell';
        $filmCreator->email = 'john.campbell@mailtrap.io';
        $filmCreator->password = bcrypt('johncampbell');
        $filmCreator->save();
        $filmCreator->giveRole('films-section', 3);

        $contactManager = new User();
        $contactManager->name = 'Glen Grant';
        $contactManager->email = 'glen.grant@mailtrap.io';
        $contactManager->password = bcrypt('glengrant');
        $contactManager->save();
        $contactManager->giveRole('contacts-section', 3);


        $user = App\User::find(4);
        dd($user->hasRole('films-section')); // will return true
        dd($user->hasRole('contacts-section'));// will return false

        $user = App\User::find(5);
        dd($user->hasRole('films-section')); // will return false
        dd($user->hasRole('contacts-section'));// will return true









    }
}
