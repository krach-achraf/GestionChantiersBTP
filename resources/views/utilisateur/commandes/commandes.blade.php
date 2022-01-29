@extends('utilisateur.layouts.menuUser')
@section('contenu')
    <div class="card">
        <div class="card-header" style="background-color: #0f4c75;color: white">
            Liste des commandes
        </div>

        <div class="card-body">
            @if(session()->has('successStoreCommande'))
                <div class="alert alert-success">
                    {{session()->get('successStoreCommande')}}
                </div>
            @endif
            @if(session()->has('successEditCommande'))
                <div class="alert alert-success">
                    {{session()->get('successEditCommande')}}
                </div>
            @endif
            <table class="table table-hover" id="tablepat">
                <thead class="thead-light ">
                    <tr>
                        <th scope="col">Article</th>
                        <th scope="col">Tâche</th>
                        <th scope="col">Fournisseur</th>
                        <th scope="col">Quantité</th>
                        <th scope="col">Unité</th>
                        <th scope="col">Priorité</th>
                        <th scope="col">Date commande</th>
                        <th scope="col">Date réception</th>
                        <th scope="col">État commande</th>
                        <th scope="col">Action</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($commandes as $commande)
                <tr>
                    <td>{{$commande->libelleArticle}}</td>
                    <td>{{$commande->libelleTache}}</td>
                    <td>{{$commande->nom}} {{$commande->prenom}}</td>
                    <td>{{$commande->quantité}}</td>
                    <td>{{$commande->unité}}</td>
                    <td>{{$commande->priorité}}</td>
                    <td>{{ \Carbon\Carbon::parse($commande->created_at)->format('d/m/Y')}}</td>
                    @if($commande->dateReception == '')
                        <td> -- &nbsp;/&nbsp; -- &nbsp;/&nbsp; -- &nbsp;</td>
                    @else
                        <td>{{ \Carbon\Carbon::parse($commande->dateReception)->format('d/m/Y')}}</td>
                    @endif
                    <td>{{$commande->étatCommande}}</td>

                    @if($commande->validité == 'En attend')
                        <td></td>
                        <td>
                            En attend de validation
                        </td>
                    @else
                        @if($commande->étatCommande == 'En commande')
                            <td>
                                @csrf
                                <a href="{{url('/commandes/'.$commande->id.'/delete/'.csrf_token())}}">
                                    <i class="btn btn-dark fa fa-trash"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{url('/commandes/'.$commande->id.'/edit')}}">
                                    <i class="btn btn-success fa" style="font-weight: bolder">Reçu</i>
                                </a>
                            </td>
                        @else
                            <td></td>
                            <td></td>
                        @endif
                    @endif

                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
