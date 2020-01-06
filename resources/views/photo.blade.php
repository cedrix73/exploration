@extends('template')
@section('contenu')
    <br>
    <div class="container">
        <div class="row card text-white bg-dark">
            <h4 class="card-header">Envoi d'une photo</h4>
            <div class="card-body">
                <form action="{{ url('photo') }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image"  value="{{ old('image') }}">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-secondary">Envoyer !</button>
                </form>
            </div>
        </div>
    </div>
@endsection
