@extends('utilisateur.layouts.menuUser')
@section('contenu')

    <div class=" justify-content-center m-1">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Materiels en projets !
                </div>
                <div class="card-body">
                    @if(session()->has('succesAffect'))
                        <div class="alert alert-success">
                            {{session()->get('succesAffect')}}
                        </div>
                    @endif
                    @foreach($projetsAll as $pa)
                    <table class="table table-hover table-striped table-dark" style="height: 100%;overflow:scroll;">
                        <div class="row justify-content-center">
                            <div class="col-md-6 text-center"style="padding: 20px;"><h3>{{$pa->libelle}}</h3></div>
                            <div class="col-md-4" style="padding: 20px;"><a class="btn btn-block btn-outline-primary" href="{{route('materiel.projet.add',['id'=>$pa->id])}}">Ajouter</a></div>

                        </div>
                        <thead>
                        <th>Numéro</th>
                        <th>Libelle du materiel</th>
                        <th>Date Debut</th>
                        <th>Date Fin</th>
                        </thead>
                        <tbody>

                        @foreach($materielprojet as $mp)
                            @if($mp->projet_id == $pa->id)
                            <tr>
                                <input type="hidden" class="serdelete_val_stock_id" value="{{$mp->id}}">
                                <th>{{$mp->id}}</th>
                                <th>{{$mp->libelle}}</th>
                                <th>{{$mp->dateDebut}}</th>
                                <th>{{$mp->dateFin}}</th>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                        <hr style="background-color: #1d2124">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
