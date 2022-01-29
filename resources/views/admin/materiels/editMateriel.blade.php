@extends('admin.layouts.menu')
@section('content')
    <div class="card">
        <div class="card-header bg-dark" style="color: white">
            L'édite du materiel
        </div>

        <div class="card-body">

            <form action="{{url('/materiels/'.$materiel->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="PUT">

                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th style="width: 585.56px">Libelle</th>
                        <th>Photo du matériel</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input type="text" class="form-control" name="libelle" id="libelle" value="{{$materiel->libelle}}">
                        </td>
                        <td>
                            <input type="file" class="form-control" name="photo" id="photo" >
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Date accusé</th>
                        <th scope="col">Fournisseur</th>
                    </tr>
                    </thead>
                    <tbody class="resultbody">
                    @foreach($materielFournisseurs as $materielFournisseur)
                    <tr>
                        <td>
                            <input name="dateAccuse[]" type="date"  class="form-control" value="{{$materielFournisseur->dateAccuse}}">
                        </td>
                        <td>
                            <select name="fournisseur[]" class="form-control">
                                <option disabled="disabled">Choisissez le fournisseur :</option>
                                <option value="{{$materielFournisseur->fournisseur_id}}">{{$materielFournisseur->nom}} {{$materielFournisseur->prenom}}</option>
                                @foreach($fournisseurs as $fournisseur)
                                    @if($materielFournisseur->nom != $fournisseur->nom && $materielFournisseur->prenom != $fournisseur->prenom)
                                        <option value="{{$fournisseur->id}}" {{ old('fournisseur', $fournisseur->nom . ' ' .$fournisseur->prenom) == $fournisseur->id ? 'selected' : '' }}>{{$fournisseur->nom}} {{$fournisseur->prenom}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>
                <button class="btn btn-outline-dark col-md-4 offset-md-4">Enregistrer</button>
            </form>
        </div>

    </div>
@endsection
