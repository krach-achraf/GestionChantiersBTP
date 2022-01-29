@extends('admin.layouts.menu')
@section('content')

    <div class="card">
        <div class="card-header" style="background-color: #0f4c75">
            <div class="row">
                <div class="col-md-4">
                    <a href="{{route('materiel.create')}}">
                        <button class="btn btn-outline-light col-md-6">Ajouter</button>
                    </a>
                </div>
                <div class="offset-md-2"></div>
                <div class="col-md-6">
                    <form action="{{url('/materiels/recherche')}}"  method="get">
                        <div class="row">
                            <div class="offset-md-1"></div>
                            <input type="search" class="form-control col-md-5" name="queryMateriel" placeholder="libellé matériel">
                            <button class="btn btn-outline-light col-md-3 offset-md-1 rounded-pill" type="submit">Rechercher</button>
                            <div class="offset-md-2"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if(session()->has('successStoreMateriel'))
                <div class="alert alert-success">
                    {{session()->get('successStoreMateriel')}}
                </div>
            @endif

            @if(session()->has('successEditMateriel'))
                <div class="alert alert-success">
                    {{session()->get('successEditMateriel')}}
                </div>
            @endif

            <div class="container d-flex justify-content-center flex-wrap">

                @foreach($materiels as $key => $materiel)
                <div class="cardUser flex-item">
                    <div class="card_inner">
                        <div class="card_face card_face--front">
                            <div class="card_content">
                                <div class="card_header">
                                    <div class="img-thumbnail">
                                        <img src="{{asset('storage/images/materiels/'.$materiel->photo)}}" alt="" class="photoPersonelle">
                                    </div>
                                </div>
                                <div class="card_body">
                                    @csrf
                                    <button class ="btn btn-outline-light rotate">Détail</button>
                                    <a href="{{url('/materiels/'.$materiel->materiel_id.'/edit/')}}"><button class="btn btn-outline-light">Éditer</button></a>
                                    <button type="button" class="btn btn-outline-light " onclick="deleteMateriel({{ $materiel->materiel_id}},{{ $materiel->fournisseur_materiel_id}})">Supprimer</button>
                                </div>
                            </div>
                        </div>
                        <div class="card_face card_face--back caption">

                            <h5>Libellé</h5>
                            <p>{{$materiel->libelle}}</p>
                            <h5>Date accusée</h5>
                            <p>{{$materiel->dateAccuse}}</p>
                            <h5>Fournissseur</h5>
                            <p>{{$materiel->nom}} {{$materiel->prenom}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
