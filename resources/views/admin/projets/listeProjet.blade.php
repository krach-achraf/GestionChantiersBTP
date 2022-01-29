@extends('admin.layouts.menu')
@section('content')
    <div class="card">

        <div class="card-body">
            @if(session()->has('ProjetEncous'))
                <div class="alert alert-success">
                    {{session()->get('ProjetEncous')}}
                </div>
            @endif
            @if(session()->has('ProjetTerminé'))
                <div class="alert alert-success">
                    {{session()->get('ProjetTerminé')}}
                </div>
            @endif
            @if(session()->has('successEditProjet'))
                <div class="alert alert-success">
                    {{session()->get('successEditProjet')}}
                </div>
            @endif
            <table class="table table-hover" id="tablepat">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Libellé</th>
                    <th scope="col">Description</th>
                    <th scope="col">Localisation</th>
                    <th scope="col" style="width: 150px">État</th>
                    <th scope="col">Action</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($projets as $projet)
                    <tr>
                        <input type="hidden" class="projet_id" value="{{$projet->id}}">
                        <td>{{$projet->title}}</td>
                        <td>{{$projet->description}}</td>
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

                        @if($projet->etat == 'terminé')
                            <td></td>
                        @else
                            <td>

                                <a href="{{url('/projets/'.$projet->id.'/edit')}}">
                                    <i class="btn btn-dark fa fa-edit"></i>
                                </a>
                            </td>
                        @endif


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
                        @else
                            <td></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tablepat').DataTable({
                "language": {
                    "sProcessing": "Traitement en cours ...",
                    "sLengthMenu": "Afficher _MENU_ éléments",
                    "sZeroRecords": "Aucun résultat trouvé",
                    "sEmptyTable": "Aucune donnée disponible",
                    "sInfo": "Affichage de _START_ à _END_ sur _TOTAL_ éléments",
                    "sInfoEmpty": "Aucune ligne affichée",
                    "sInfoFiltered": "(Filtrer un maximum de_MAX_)",
                    "sInfoPostFix": "",
                    "sSearch": "Chercher:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Chargement...",
                    "oPaginate": {
                        "sFirst": "Premier", "sLast": "Dernier", "sNext": "Suivant", "sPrevious": "Précédent"
                    },
                    "oAria": {
                        "sSortAscending": ": Trier par ordre croissant", "sSortDescending": ": Trier par ordre décroissant"
                    }
                }
            });
        } );
    </script>
@endsection
