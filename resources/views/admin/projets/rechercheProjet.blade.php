@extends('admin.layouts.menu')
@section('content')
    <div class="card">
        <div class="card-header">Les projets recherchés</div>

        <div class="card-body">
            <table class="table table-hover ">
                <thead class="thead-light ">
                <tr>
                    <th scope="col">Libelle</th>
                    <th scope="col">Description</th>
                    <th scope="col">Date début</th>
                    <th scope="col">Localisation</th>
                    <th scope="col" style="width: 150px">Etat</th>
                    <th scope="col">Action</th>
                    <th scope="col"></th>
                </tr>
                </thead>

                <tbody>
                    @foreach($projets as $projet)
                        <tr>
                            <input type="hidden" class="serdelete_val_projet_id" value="{{$projet->id}}">
                            <td>{{$projet->libelle}}</td>
                            <td>{{$projet->description}}</td>
                            <td>{{$projet->dateDebut}}</td>
                            <td>{{$projet->localisation}}</td>

                            @if($projet->etat == 'à faire')
                                <td>
                                    <div class="progress mr-4">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                            @elseif($projet->etat == 'en cours')
                                <td>
                                    <div class="progress mr-4" >
                                        <div class="progress-bar" role="progressbar" aria-valuenow="50"  style="width: 50%" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                            @else
                                <td>
                                    <div class="progress mr-4">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="100"  style="width: 100%" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </td>
                            @endif

                            <td>
                                @csrf
                                <a href="{{url('/projets/'.$projet->id.'/delete/'.csrf_token())}}"><i class="btn btn-dark fa fa-trash"></i></a>
                                <a href="{{url('/projets/'.$projet->id.'/edit')}}">
                                    <i class="btn btn-primary fa fa-edit"></i>
                                </a>
                                <button class="btn btn-success fa" style="font-weight: bolder">T</button>
                            </td>

                            @if($projet->etat == 'à faire')
                                <td>
                                    <a href="{{url('/projets/'.$projet->id.'/enCours')}}">
                                        <i class="btn btn-primary fa" style="font-weight: bolder">En cours</i>
                                    </a>
                                </td>
                            @elseif($projet->etat == 'en cours')
                                <td>
                                    <a href="{{url('/projets/'.$projet->id.'/terminé')}}">
                                        <i class="btn btn-success fa" style="font-weight: bolder">Terminé</i>
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
