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

                <div class="card-header" style="color: white;background-color: #0f4c75">
                    Gestion des responsables
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    Les responsables
                                </div>

                                <div class="card-body">
                                    @if(session()->has('successStoreUser'))
                                        <div class="alert alert-success">
                                            {{session()->get('successStoreUser')}}
                                        </div>
                                    @endif

                                    @if(session()->has('successEditUser'))
                                        <div class="alert alert-success">
                                            {{session()->get('successEditUser')}}
                                        </div>
                                    @endif
                                    <table class="table table-hover" id="tablepat">
                                        <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Nom</th>
                                            <th scope="col">Prénom</th>
                                            <th scope="col">Adresse e-mail </th>
                                            <th scope="col">Rôle</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>

                                        <tbody>

                                        @foreach($users as $user)
                                            <tr>
                                                <input type="hidden" class="serdelete_val_user_id" value="{{$user->id}}">
                                                <td>{{$user->nom}}</td>
                                                <td>{{$user->prenom}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>{{$user->role}}</td>
                                                <td>
                                                    @csrf
                                                    <button type="button" class="btn btn-dark fa fa-trash servideletebtnUser"></button>
                                                    <a href="{{url('/utilisateurs/'.$user->id.'/edit')}}"><i class="btn btn-primary fa fa-edit"></i></a>
                                                    <button type="button" class="btn btn-success fa fa-plus taches"></button>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                    <div id="taches" class="taches"></div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="card">

                                <div class="card-header">
                                    L'ajout d'un responsable
                                </div>

                                <div class="card-body">
                                    <form method="post" action="{{url('/utilisateurs')}}" >
                                        @csrf

                                        {{--<div class="row">--}}
                                            {{--<div class="col-md-6">--}}
                                                <div class="form-group">
                                                    <label for="nom">Nom :</label>
                                                    <input type="text" name="nom" id="nom"  class="form-control @error('nom') is-invalid @enderror" value="{{Request::old('nom')}}">
                                                    @error('nom')
                                                    <div style="color: red">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                           {{-- </div>--}}

                                            {{--<div class="col-md-6">--}}
                                                <div class="form-group">
                                                    <label for="prenom">Prénom :</label>
                                                    <input type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" id="prenom" value="{{Request::old('prenom')}}">
                                                    @error('prenom')
                                                    <div style="color: red">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                            {{--</div>--}}
                                        {{--</div>--}}

                                        <div class="form-group">
                                            <label for="email">Adresse e-mail :</label>
                                            <input type="text"   class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{Request::old('email')}}">
                                            @error('email')
                                            <div style="color: red">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        {{--<div class="form-group">
                                            <label for="role">Rôle :</label>
                                            <input type="text" class="form-control @error('role') is-invalid @enderror" name="role" id="role" value="{{Request::old('role')}}" >
                                            @error('role')
                                            <div style="color: red">{{ $message }}</div>
                                            @enderror
                                        </div>--}}


                                        <div class="form-group">
                                            <label for="password">Mot de passe :</label>
                                            <input type="password"  class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                                            @error('password')
                                            <div style="color: red">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <button class="btn btn-outline-dark btn-block">Enregistrer</button>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
