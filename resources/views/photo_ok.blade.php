@extends('template')

@section('contenu')
    <br>
    <div class="container">
        <div class="row card text-white bg-dark">
            <h4 class="card-header">Envoi d'une photo</h4>
            <div class="card-body">
                <p class="card-text">Merci. Votre photo a bien été reçue et enregistrée dans le répértoire {{ $variable }}</p>
            </div>
        </div>
    </div>
@endsection
