<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\ArticleController;



Route::get('/', 'WelcomeController@index');

Route::get('/welcome', function () {
    return view('welcome');
})->name('accueil');

// Réservé aux utilisateurs authentifiés
Auth::routes(['verify' => true]);

Route::middleware('auth')->group(function () {
    Route::get('comptes', function () {

    });
    Route::get('article/{n}', 'ArticleController@show')->where('n', '[0-9]+');

});

Route::get('protege', function () {
    return 'affichage de la route protégé';
})->middleware('verified');

/**
 * Films
 */
// Vue index par défaut

// CRUD corbeille
Route::delete('films/force/{id}', 'FilmController@forceDestroy')->name('films.force.destroy');
Route::put('films/restore/{id}', 'FilmController@restore')->name('films.restore');
// Catégories de films
Route::get('category/{slug}/films', 'FilmController@index')->name('films.category');
Route::get('actor/{slug}/films', 'FilmController@index')->name('films.actor');
Route::resource('films', 'FilmController');

/**
 * Formulaires classiques
 */

 // Demande de formulaire
Route::get('users', 'UsersController@create');

// Envoi de formulaire
Route::post('users', 'UsersController@store');

/**
 * Formulaires contact mail
 */
/**
 * Formulaires contacts
 */

Route::get('contact', 'ContactsController@create')->name('contact.create');
Route::post('contact', 'ContactsController@store')->name('contact.store');


// mail de retour
Route::get('/test-contact', function () {
    return new App\Mail\Contact([
      'nom' => 'Durand',
      'email' => 'felten.cedric@yahoo.fr',
      'message' => 'Je voulais vous dire que votre site est magnifique !'
      ]);
});

// Envoi photo
Route::get('photo', 'PhotoController@create');
Route::post('photo', 'PhotoController@store');

Route::get('facture/{n}', function($n) {
    return view('facture')->withNumero($n);
})->where('n', '[0-9]+');




/**
 * Autres exemples de routage
 */
Route::get('/json', function () {
    return ['un', 'deux', 'trois'];
});

Route::get('test', function () {
    return response('un test', 204)->header('Content-Type', 'text/plain');
})->name('test');

Route::get('{n}', function($n=1) {
    return 'Je suis la page ' . $n . ', page ' . $_SERVER['PHP_SELF'] . ' !';
})->where('n', '[1-3]');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


