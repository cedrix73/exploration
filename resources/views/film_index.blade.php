@extends('bulma')

@section('css')
<style>
    .card-footer {
        justify-content: center;
        align-items: center;
        padding: 0.4em;
    }

    select, .is-info {
        margin: 0.3em;
    }
</style>
@endsection

@section('content')
@if(session()->has('info'))
<div class="notification is-success">
    {{ session('info') }}
</div>
@endif
    <div class="card">
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/') }}">Portail</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
        <header class="card-header" justify-content="flex-start">
            <p class="card-header-title">Films {{ $slug }}</p>
            <div class="select">
                <select onchange="window.location.href = this.value">
                    <option value="{{ route('films.index') }}" @unless($slug) selected @endunless>Toutes catégories</option>
                    @foreach($categories as $category)
                        <option value="{{ route('films.category', $category->slug) }}" {{ $slug == $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="select">
                <select onchange="window.location.href = this.value">
                    <option value="{{ route('films.index') }}" @unless($slug) selected @endunless>Tous les acteurs</option>
                    @foreach($actors as $actor)
                        <option value="{{ route('films.actor', $actor->slug) }}" {{ $slug == $actor->slug ? 'selected' : '' }}>{{ $actor->first_name }}&nbsp;{{ $actor->name }}</option>
                    @endforeach
                </select>
            </div>

            @reserved('films-section: isInsert')
            <a class="button is-info" href="{{ route('films.create') }}">Créer un film</a>
            @endreserved
        </header>
        <div class="card-content">
            <div class="content">
                <table class="table is-hoverable">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th></th>
                            @reserved('films-section: isUpdate')
                            <th></th>
                            @endreserved
                            @reserved('films-section: isDelete')
                            <th></th>
                            @endreserved
                            <th>Catégorie</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($films as $film)
                            <tr @if($film->deleted_at) class="has-background-grey-lighter" @endif>
                                <td><strong>{{ $film->title }}</strong></td>
                                <td>
                                @if($film->deleted_at)
                                    <form action="{{ route('films.restore', $film->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <button class="button is-primary" type="submit">Restaurer</button>
                                    </form>
                                @else
                                    <a class="button is-primary" href="{{ route('films.show', $film) }}">Voir</a>
                                @endif
                                </td>
                                @reserved('films-section: isUpdate')
                                <td>
                                    @if($film->deleted_at)
                                    @else
                                        <a class="button is-warning" href="{{ route('films.edit', $film) }}">Modifier</a>
                                    @endif
                                </td>
                                @endreserved
                                @reserved('films-section: isDelete')
                                <td>
                                    <form action="{{ route($film->deleted_at?'films.force.destroy' : 'films.destroy', $film->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="button is-danger" type="submit">Supprimer</button>
                                    </form>
                                </td>
                                @endreserved
                                <td>
                                    {{ $film->category_id }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <footer class="card-footer is-centered">
            {{ $films->links() }}
        </footer>

    </div>

@endsection
