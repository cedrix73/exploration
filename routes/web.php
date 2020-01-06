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



Route::get('article/{n}', 'ArticleController@show')->where('n', '[0-9]+');

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
Route::get('contact', 'ContactController@create');

Route::post('contact', 'ContactController@store');


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
