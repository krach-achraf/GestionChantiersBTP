@extends('admin.layouts.menu')
@section('content')
    <div class="card">
        <div class="card-header bg-dark" style="color: white">Besoin des matériels</div>
        <div class="card-body">
            @if(session()->has('pasValidéMateriel'))
                <div class="alert alert-success">
                    {{session()->get('pasValidéMateriel')}}
                </div>
            @endif
            @if(session()->has('ValidéMateriel'))
                <div class="alert alert-success">
                    {{session()->get('ValidéMateriel')}}
                </div>
            @endif
            <table class="table table-hover ">
                <thead class="thead-light ">
                <tr>
                    <th scope="col">Matériel</th>
                    <th scope="col">Projet</th>
                    <th scope="col">Utilisateur</th>
                    <th scope="col">Date de début</th>
                    <th scope="col">Date de fin</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($materiels as $materiel)
                    <tr>
                        <td>{{$materiel->libelleMateriel}}</td>
                        <td>{{$materiel->libelle}}</td>
                        <td>{{$materiel->nom}} {{$materiel->prenom}}</td>
                        <td>{{$materiel->dateDebut}}</td>
                        <td>{{$materiel->dateFin}}</td>
                        @if($materiel->validité == 'En attend')
                            <td>

                                <a href="{{url('/materiels/validation/pasValidé/'.$materiel->id)}}">
                                    <i class="btn  btn-danger fa fa-times"></i>
                                </a>
                                <a href="{{url('/materiels/validation/validé/'.$materiel->id)}}">
                                    <i class="btn btn-primary fa fa-check"></i>
                                </a>
                            </td>
                        @elseif($materiel->validité == 'Validé')
                            <td class="validé">
                                <i class=" fa fa-check-circle" ></i>
                            </td>

                        @endif

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
