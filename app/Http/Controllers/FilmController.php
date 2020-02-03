<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Film;
use App\Http\Requests\FilmRequest;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $films = Film::withTrashed()->oldest('title')->paginate(5);
        return view('film_index', compact('films'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('film_create');
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
        return view('film_show', compact('film'));
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
