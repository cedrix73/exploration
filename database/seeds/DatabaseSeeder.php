<?php

use App\Film;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        App\User::create(
            [
                'name' => 'Dupont',
                'email' => 'dupont@la.fr',
                'password' => bcrypt('pass'),
            ]
        );

       // factory(App\Category::class, 10)->create();
       // factory(App\Film::class, 50)->create();

        factory(App\Category::class, 10)->create()->each(function($category){
            $i = rand(2, 8);
            while(--$i){
                $category->films()->save(factory(App\Film::class)->make());
            }
        });

    }
}
