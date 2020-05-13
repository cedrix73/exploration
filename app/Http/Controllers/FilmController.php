<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Film;
use App\Category;
use App\Actor;
use App\Providers\AppServiceProvider;
use App\Http\Requests\FilmRequest;
use Illuminate\Support\Facades\Auth;
use Session;

use App\Repositories\Permission\PermissionRepositoryInterface;


class FilmController extends Controller
{
    private $_roleName;
    protected $permission;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PermissionRepositoryInterface $permission)
    {
        $this->_roleName = 'films-section';
        $this->permission = $permission;
        $code=$this->permission->check($this->_roleName);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug = null)
    {
        $model = null;
        if($slug) {
            if(Route::currentRouteName() == 'films.category') {
                $model = new Category;
            } else {
                $model = new Actor;
            }
        }
        $query = $model ? $model->whereSlug($slug)->firstOrFail()->films() : Film::query();
        $films = $query->withTrashed()->oldest('title')->paginate(5);

        // Catégories et acteurs Chargé automatiquement avec AppServiceProvider:Boot
        $actors = Actor::all();
        $categories = Category::all();
        return view('film_index', compact('films', 'categories', 'actors', 'slug'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!$this->permission->isInsert($this->_roleName)){
            return redirect()->route('films.index')
                ->with('info', 'Vous n\'avez pas les authorisations nécessaires en création.');
        }else{
            $categories = Category::all();
            $actors = Actor::all();
            return view('film_create', compact('categories', 'actors'));
        }
    }

    /**
     * Back: Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\FilmRequest  $filmRequest
     * @return \Illuminate\Http\Response
     */
    public function store(FilmRequest $filmRequest)
    {
        $this->permission->check($this->_roleName);
        if(!$this->permission->isInsert()){
            return redirect()->route('films.index')
                ->with('info', 'Vous n\'avez pas les authorisations nécessaires en création.');
        }else{
            $storedFilm = Film::create($filmRequest->all());
            $storedFilm->actors()->attach($filmRequest->actors);
            return redirect()->route('films.index')->with('info', 'Le film a bien été créé');
        }
    }

    /**
     * Front: liste les films
     *
     * @param  Film $film
     * @return \Illuminate\Http\Response
     */
    public function show(Film $film)
    {
        // On ne devrait plus charger les acteurs en BD mais les lier
        // implicitement au films avec la méthode RouteServiceProvider:boot
        //$film->with('actors')->get();
        // mais ça ne marche pas.
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
        if(!$this->permission->isUpdate($this->_roleName)){
            return redirect()->route('films.index')
                ->with('info', 'Vous n\'avez pas les authorisations nécessaires en modification.');
        }else{
            $actors = Actor::all();
            $categories = Category::all();
            return view('film_edit', compact('film', 'categories', 'actors'));
        }




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
        if(!$this->permission->isUpdate($this->_roleName)){
            return redirect()->route('films.index')
                ->with('info', 'Vous n\'avez pas les authorisations nécessaires en modification.');
        }else{
            $film->update($filmRequest->all());
            $film->actors()->sync($filmRequest->actors);
            return redirect()->route('films.index')->with('info', 'Le film a bien été modifié');
        }
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
        if(!$this->permission->isDelete($this->_roleName)){
            return redirect()->route('films.index')
                ->with('info', 'Vous n\'avez pas les authorisations nécessaires en supression.');
        }else{
            $film->delete();
            return back()->with('info', 'Le film a bien été mis dans la corbeille.');
        }
    }

    /**
     * Supprime définitivement les films
     * Selection à partir de la méthode withTrashed() par l'utilisation
     * de Illuminate\Database\Eloquent\SoftDeletes
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy($id){
        if(!$this->permission->isAdmin($this->_roleName)){
            return redirect()->route('films.index')
                ->with('info', 'Vous n\'avez pas les les droits administrateurs.');
        }else{
            Film::withTrashed()->whereId($id)->firstOrFail()->forceDelete();
            return back()->with('info', 'Le film a bien été supprimé dans la base de données');
        }
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
        if(!$this->permission->isAdmin($this->_roleName)){
            return redirect()->route('films.index')
                ->with('info', 'Vous n\'avez pas les droits administrateurs.');
        }else{
            Film::withTrashed()->whereId($id)->firstOrFail()->restore();
            return back()->with('info', 'Le film a bien été restauré.');
        }
    }
}
