<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <title>Gestion Btp</title>
</head>
<body>

<div class="wrapper">
    <div class="sidebar">
        <h5>Gestion BTP</h5>
        <ul class="menu">
            <li class="first"><a href="{{route('users.profil')}}">Profil</a></li>
            <li><a href="{{route('users.index')}}">Responsables</a></li>
            <li><a href="#">Fournisseurs</a></li>
            <li><a href="{{route('projets.index')}}">Projets</a></li>
            <li><a href="{{route('materiel.index')}}">Matériels</a></li>
            <li><a href="#">Articles</a></li>
            <li><a href="#">Tâches</a>
            </li>
            <li class="menudown">
                <a class="link" href="javascript:">
                    Besoins
                </a>
                <i class="fa fa-chevron-down" style="color: white"></i>
                <ul class="besoins">
                    <li><a href="{{route('materiels.validation')}}">Matériels</a></li>
                    <li><a href="{{route('articles.validation')}}">Articles</a></li>
                </ul>
            </li>

            <li class="logout"><a href="{{ route('logout') }}"
                                  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('Se déconnecter') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form></li>
        </ul>
    </div>

    <div class="main_content" >
        <div class="header">
            <span>{{Auth::user()->nom}}</span>&nbsp;<span>{{Auth::user()->prenom}}</span>
        </div>

        <div class="info">
            <div class="card">
                <div class="card-header" style="background-color: #0f4c75;color: white">Besoin des articles</div>
                <div class="card-body">
                    @if(session()->has('pasValidéCommande'))
                        <div class="alert alert-success">
                            {{session()->get('pasValidéCommande')}}
                        </div>
                    @endif
                    @if(session()->has('ValidéCommande'))
                        <div class="alert alert-success">
                            {{session()->get('ValidéCommande')}}
                        </div>
                    @endif
                    <table class="table table-hover " id="tablepat">
                        <thead class="thead-light ">
                        <tr>
                            <th scope="col">Article</th>
                            <th scope="col">Responsable</th>
                            <th scope="col">Tâche</th>
                            <th scope="col">Fournisseur</th>
                            <th scope="col">Quantité</th>
                            <th scope="col">Unité</th>
                            <th scope="col">Priorité</th>
                            <th scope="col">Date commande</th>
                            <th scope="col">Date réception</th>
                            <th scope="col">État commande</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($commandes as $commande)
                            <tr>
                                <td>{{$commande->libelleArticle}}</td>
                                <td>{{$commande->Usernom}} {{$commande->Userprenom}}</td>
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
                                    <td>

                                        <a href="{{url('/articles/validation/pasValidé/'.$commande->id)}}">
                                            <i class="btn  btn-danger fa fa-times"></i>
                                        </a>
                                        <a href="{{url('/articles/validation/validé/'.$commande->id)}}">
                                            <i class="btn btn-primary fa fa-check"></i>
                                        </a>
                                    </td>
                                @elseif($commande->validité == 'Validé')
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
        </div>
    </div>
</div>

<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
</body>
</html>
