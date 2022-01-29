@extends('utilisateur.layouts.menuUser')
@section('contenu')

    <div class="card">
        <div class="card-header" style="background-color: #0f4c75;color: white;text-align: right">
            <a href="{{route('commandes.index')}}">
                <button class="btn btn-outline-light">Mes commandes</button>
            </a>

        </div>
        <div class="card-body">
            <form method="post" action="{{route('commande.store')}}">
                @csrf
               <div class="row">

                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header">
                                    Choix d'article
                            </div>
                            <div class="card-body">
                                <table class="table table-hover" id="tablepat">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Référence</th>
                                        <th scope="col">Libellé</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($articles as $article)
                                        <tr>
                                            <td>
                                                <input type="radio" value="{{$article->id}}" name="article" style="width: 15px;height: 15px">
                                            </td>
                                            <td>{{$article->reference}}</td>
                                            <td>{{$article->libelle}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header">
                                Détail du commande
                            </div>
                            <div class="card-body">

                                    <div class="form-group">
                                        <label for="projet">Projet :</label>
                                        <select class="form-control projets" aria-label="Default select example" id="projet" name="projet" data-dependent="tache">
                                            <option disabled="disabled" selected>Choisissez le projet :</option>
                                            @foreach($projets as $projet)
                                                <option value="{{$projet->id}}">{{$projet->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="tache">Tâche :</label>
                                        <select class="form-control" aria-label="Default select example" id="tache" name="tache" >
                                        </select>
                                    </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="article">Fournisseur :</label>
                                            <select class="form-control" aria-label="Default select example" name="fournisseur">
                                                <option disabled="disabled" selected>Choisissez le fournisseur</option>
                                                @foreach($fournisseurs as $fournisseur)
                                                    <option value="{{$fournisseur->id}}">{{$fournisseur->nom}} {{$fournisseur->prenom}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="quantité">Quantité :</label>
                                            <input type="number" class="form-control" name="quantité" id="quantité" min="1">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="unité">Unité :</label>
                                                <select class="form-control" aria-label="Default select example" id="unité" name="unité" >
                                                    <option disabled="disabled" selected>Choisissez l'unité :</option>
                                                    <option value="m">m</option>
                                                    <option value="m2">m2</option>
                                                    <option value="ml">ml</option>
                                                    <option value="kg">kg</option>
                                                    <option value="u">u</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="priorité">Priorité :</label>
                                                <select class="form-control" aria-label="Default select example" id="priorité" name="priorité">
                                                    <option disabled="disabled" selected>Choisissez la priorité:</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-outline-dark  col-6 offset-3">Enregistrer</button>
                            </div>
                        </div>
                    </div>
            </div>
            </form>
        </div>

    </div>

@endsection
