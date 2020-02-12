<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Film;
use App\Category;
use App\Actor;
use App\Http\Requests\FilmRequest;
use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug = null)
    {
        $query = $slug ? Category::whereSlug($slug)->firstOrFail()->films() : Film::query();
        $films = $query->withTrashed()->oldest('title')->paginate(5);
        /*$films = DB::table('films')
            ->leftJoin('categories', 'films.category_id', '=', 'categories.id')
            ->oldest('title')
            ->get();
            */
        $categories = Category::all();
        return view('film_index', compact('films', 'categories', 'slug'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $actors = Actor::all();
        return view('film_create', compact('categories', 'actors'));
    }

    /**
     * Back: Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\FilmRequest  $filmRequest
     * @return \Illuminate\Http\Response
     */
    public function store(FilmRequest $filmRequest)
    {
        Film::create($filmRequest->all());
        return redirect()->route('films.index')->with('info', 'Le film a bien été créé');
    }

    /**
     * Front: list les films
     *
     * @param  Film $film
     * @return \Illuminate\Http\Response
     */
    public function show(Film $film)
    {
        $category = $film->category->name;
        // On ne va plus charger les acteurs en BD mais les lier
        // implicitement au films avec la méthode RouteServiceProvider:boot
        //$film->with('actors')->get();
        return view('film_show', compact('film', 'category'));
    }

    /**
     * Front: Show the form for editing the specified resource.
     *
     * @param  Film  $film
     * @return \Illuminate\Http\Response
     */
    public function edit(Film $film)
    {
        return view('film_edit', compact('film'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Film $film
     * @return \Illuminate\Http\Response
     */
    public function update(FilmRequest $filmRequest, Film $film)
    {
        $film->update($filmRequest->all());
        return redirect()->route('films.index')->with('info', 'Le film a bien été modifié');
    }

    /**
     * Met le film dans la corbeille (Illuminate\Database\Eloquent\SoftDeletes
     * dans le modèle Film))
     *
     * @param  Film $film
     * @return \Illuminate\Http\Response
     */
    public function destroy(Film $film)
    {
        $film->delete();
        return back()->with('info', 'Le film a bien été mis dans la corbeille.');
    }

    /**
     * Supprime définitivement les films
     * Selection à partir de la méthode withTrashed() par l'utilisation
     * de Illuminate\Database\Eloquent\SoftDeletes
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy($id){
        Film::withTrashed()->whereId($id)->firstOrFail()->forceDelete();
        return back()->with('info', 'Le film a bien été supprimé dans la base de données');
    }

    /**
     * Restaure un film deleté (destoyed)
     * Selection à partir de la méthode withTrashed() par l'utilisation
     * de Illuminate\Database\Eloquent\SoftDeletes
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        Film::withTrashed()->whereId($id)->firstOrFail()->restore();
        return back()->with('info', 'Le film a bien été restauré.');
    }
}
