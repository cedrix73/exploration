<?php

use App\Film;
use App\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    private $_nbCategories = 10;
    private $_nbFilmsMinByCategory = 2;
    private $_nbFilmsMaxByCategory = 8;
    private $_nbActors = 50;
    private $_nbActorsMaxByFilm = 4;
    private $_nbFilmsMax = 0;

    public function run()
    {
        $this->fillUsers();
        $this->fillCategoriesFilms();
        $this->fillActors();

    }

    /**
     * Function fillUsers
     * Fill user table
     *
     * @return void
     */
    public function fillUsers(){
        App\User::create(
            [
                'name' => 'Dupont',
                'email' => 'dupont@la.fr',
                'password' => bcrypt('pass'),
            ]
        );
    }

    /**
     * Function fillCategoriesFilms
     * Create 10 catégories (1) and for each one 8 films (n)
     *
     * @return void
     */
    public function fillCategoriesFilms()
    {
        $categories = [
            'Comédie',
            'Drame',
            'Action',
            'Fantastique',
            'Horreur',
            'Animation',
            'Espionnage',
            'Guerre',
            'Policier',
            'Pornographique',
        ];

        foreach($categories as $category) {
            $objCat = Category::create(['name' => $category, 'slug' => Str::slug($category)]);
            $i = rand($this->_nbFilmsMinByCategory, $this->_nbFilmsMaxByCategory);
            while(--$i){
                $this->_nbFilmsMax++;
                $objCat->films()->save(factory(App\Film::class)->make());
            }
        }

        // Desactivé: Génération aléatoire de 'éléments de catégories
        /*
        factory(App\Category::class, $this->_nbCategories)->create()->each(function($category) {
            $i = rand($this->_nbFilmsMinByCategory, $this->_nbFilmsMaxByCategory);
            while(--$i){
                $this->_nbFilmsMax++;
                $category->films()->save(factory(App\Film::class)->make());
            }
        });
        */
    }

    /**
     * Function fillActors
     * On utilisera une factory pour creer les noms des acteurs
     * Fill actors table with 50 actors (n) and dispatch them to all films (n)
     *
     * @return void
     */
    public function fillActors()
    {
        $ids = range(1, $this->_nbFilmsMax);
        factory(App\Actor::class, $this->_nbActors)->create()->each(function($actor) use($ids){
            shuffle($ids);
            $actor->films()->attach(array_slice($ids, 0, rand(1, $this->_nbActorsMaxByFilm)));
        });
    }





}
