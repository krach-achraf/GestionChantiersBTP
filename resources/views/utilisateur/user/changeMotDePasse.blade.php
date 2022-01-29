@extends('utilisateur.layouts.menuUser')
@section('contenu')
    <div class="card">
        <div class="card-header bg-dark" style="color: white">L'édite du mot de passe</div>


        <div class="card-body">
            <div class="col-md-6 offset-md-3">
                <form action="{{route('storeMotDePasse')}}" method="post" class="form">
                    @csrf
                    <div class="form-group">
                        <label for="ancienMotDePasse">Ancien mot de passe :</label>
                        <input type="password" name="ancienMotDePasse" id="ancienMotDePasse" class="form-control @error('ancienMotDePasse') is-invalid @enderror" >
                        @if(session('errorAncienmdp'))
                            <div style="color: red">{{ session('errorAncienmdp') }}</div>
                        @endif
                        @error('ancienMotDePasse')
                        <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="nouveauMotDePasse">Nouveau mot de passe :</label>
                        <input type="password" name="nouveauMotDePasse" id="nouveauMotDePasse" class="form-control @error('nouveauMotDePasse') is-invalid @enderror" >
                        @if(session('errorAncienNouveaumdp'))
                            <div style="color: red">{{ session('errorAncienNouveaumdp') }}</div>
                        @endif
                        @error('nouveauMotDePasse')
                        <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="confirmationMotDePasse">Confirme mot de passe :</label>
                        <input type="password" name="confirmationMotDePasse" id="confirmationMotDePasse" class="form-control" >
                    </div>

                    <button type="submit" class="btn btn-outline-dark col-6 offset-3">Enregistrer</button>

                </form>
            </div>
        </div>
    </div>
@endsection
