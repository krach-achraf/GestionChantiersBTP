@extends('admin.layouts.menu')
@section('content')
    <div class="card">
        <div class="card-header bg-dark " style="color: white;text-align: right">
            <a href="{{url('/administrateur/profil/editer/'.Auth::user()->id)}}">
                <button class="btn btn-outline-light" >Editer profil</button>
            </a>
            <a href="{{route('motDePasseAdmin')}}">
                <button class="btn btn-outline-light" >Editer mot de passe</button>
            </a>
        </div>

        <div class="card-body">
            @if(session()->has('successEditAdmin'))
                <div class="alert alert-success">
                    {{session()->get('successEditAdmin')}}
                </div>
            @endif
            @if(session()->has('successStoreMdp'))
                <div class="alert alert-success">
                    {{session()->get('successStoreMdp')}}
                </div>
            @endif

            <div class="containerPtofil">
                <section class="p-3">
                    <h5 class="profil">Numéro : </h5>
                    <div class="profilChange">{{Auth::user()->id}}</div>
                </section>
                <section class="p-3">
                    <h5 class="profil">Nom : </h5>
                    <div class="profilChange">{{Auth::user()->nom}}</div>
                </section>
                <section class="p-3">
                    <h5 class="profil">Prénom : </h5>
                    <div class="profilChange">{{Auth::user()->prenom}}</div>
                </section>
                <section class="p-3">
                    <h5 class="profil">Émail : </h5>
                    <div class="profilChange">{{Auth::user()->email}}</div>
                </section>
                <section class="p-3">
                    <h5 class="profil">Rôle : </h5>
                    <div class="profilChange">{{Auth::user()->role}}</div>
                </section>
            </div>
        </div>
    </div>
@endsection
