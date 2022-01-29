@extends('admin.layouts.menu')
@section('content')
    <div class="justify-content-center">
        <div class="card">
            <div  class="card-header bg-dark" style="color: white">L'édite du profil</div>
            <div class="card-body">
                <div class="col-md-6 offset-md-3">
                    <form method="post" action="{{url('/administrateur/profil/'.$admin->id)}}" class="form">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">

                        <div class="form-group">
                            <label for="nom">Nom :</label>
                            <input type="text" name="nom" id="nom"  class="form-control @error('nom') is-invalid @enderror" value="{{$admin->nom}}">
                            @error('nom')
                            <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="prenom">Prénom :</label>
                            <input type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" id="prenom" value="{{$admin->prenom}}">
                            @error('prenom')
                            <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email :</label>
                            <input type="text"   class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{$admin->email}}">
                            @error('email')
                            <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>

                      {{--  <div class="form-group">
                            <label for="role">Role :</label>
                            <input type="text" class="form-control @error('role') is-invalid @enderror" name="role" id="role" value="{{$admin->role}}">
                            @error('role')
                            <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>--}}

                        <button class="btn btn-outline-dark col-6 offset-3">Enregistrer</button>

                    </form>
                </div>


            </div>
        </div>
    </div>
@endsection
