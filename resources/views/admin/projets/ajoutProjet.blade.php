@extends('admin.layouts.menu')
@section('content')
    <div class="card">
        <div class="card-header bg-dark" style="color: white">L'ajout d'un projet</div>
        <div class="card-body">
            <div class="col-md-6 offset-md-3">
                <form action="{{route('projets.store')}}" class="form" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="libelle">Libelle</label>
                        <input type="text" class="form-control @error('libelle') is-invalid @enderror" name="libelle" id="libelle" value="{{Request::old('libelle')}}">
                        @error('libelle')
                        <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" value="{{Request::old('description')}}" >
                        @error('description')
                        <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="localisation">Localisation</label>
                        <input type="text" class="form-control @error('localisation') is-invalid @enderror" name="localisation" id="localisation" value="{{Request::old('localisation')}}">
                        @error('localisation')
                        <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="dateDébut">Date de début</label>
                        <input type="date" class="form-control @error('dateDébut') is-invalid @enderror" name="dateDébut" id="dateDébut" value="{{Request::old('dateDébut')}}">
                        @error('dateDébut')
                        <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-outline-dark  col-6 offset-3">Enregistrer</button>
                </form >
            </div>

        </div>
    </div>
@endsection
