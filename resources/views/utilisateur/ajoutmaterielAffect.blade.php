@extends('utilisateur.layouts.menuUser')
@section('contenu')
    <div class="card">
        <div class="card-header">Materiel Projet !</div>
        <div class="card-body">
            <div class="col-md-8 offset-md-2">
                <form action="{{route('materiel.projet.store')}}" class="form" method="post">
                    @csrf

                    <div class="form-group">
                        @if(session()->has('DejaAffecter'))
                            <div class="alert alert-danger">
                                {{session()->get('DejaAffecter')}}
                            </div>
                        @endif
                        <label for="libelle">Materiel :</label>
                        <select class="form-control" aria-label=".form-select-lg example" name="materiel_id">
                            @foreach($materiel as $a)
                                <option value="{{$a->id}}" >{{$a->libelle}}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('libelle')
                    <div style="color: red">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="libelle">Projet :</label>
                        <select class="form-control" aria-label=".form-select-lg example" name="projet_id">
                            @foreach($projet as $pa)
                                <option value="{{$pa->id}}" selected>{{$pa->libelle}}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('libelle')
                    <div style="color: red">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="dateDebut">Date Debut :</label>
                        <input type="date" class="form-control @error('dateDebut') is-invalid @enderror" name="dateDebut"
                               id="dateDebut" value="{{Request::old('dateDebut')}}">
                    </div>
                    @error('dateDebut')
                    <div style="color: red">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="dateFin">Date Fin :</label>
                        <input type="date" class="form-control @error('dateFin') is-invalid @enderror" name="dateFin"
                               id="dateFin" value="{{Request::old('dateFin')}}">
                    </div>
                    @error('dateFin')
                    <div style="color: red">{{ $message }}</div>
                    @enderror
                    @if(session()->has('dateFinInvalid'))
                        <div class="alert alert-danger">
                            {{session()->get('dateFinInvalid')}}
                        </div>
                    @endif


                    <button class="btn btn-outline-success  col-6 offset-3">Enregistrer</button>
                </form>
            </div>

        </div>
    </div>
@endsection
