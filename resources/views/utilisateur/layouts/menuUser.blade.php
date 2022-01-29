<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
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
            <li class="first"><a href="{{route('profil')}}">Profil</a></li>
            <li><a href="{{route('commande.create')}}">Commandes</a></li>
            <li><a href="{{route('stocks.show')}}">Stock</a></li>
            <li><a href="{{route('materiel.affect')}}">Matériels</a></li>
            <li  class="logout"><a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('Se déconnecter') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form></li>
        </ul>
    </div>

    <div class="main_content">
        <div class="header">
            <span>{{Auth::user()->nom}}</span>&nbsp;<span>{{Auth::user()->prenom}}</span>
        </div>

        <div class="info">@yield('contenu')</div>
    </div>
</div>

<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script>
    let msg = '{{Session::get('alertCommande')}}';
    let exist = '{{Session::has('alertCommande')}}';
    let article_id = '{{Session::get('id')}}';
    let quantite = '{{Session::get('quantite')}}';
    let token = '{{Session::get('token')}}';
    if(exist){
        swal({
            title: msg,
            text: "Vous voulez diminué l'article dans le stock?" ,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    let data ={
                        "_token" : token,
                        "id" : article_id,
                        "quantite" : quantite,
                    };

                    $.ajax({
                        type: "POST",
                        url: '/commandes/stock/' + article_id + '/' +  quantite,
                        data: data,
                        success: function (response){
                            swal(response.status, {
                                icon: "success",
                            })
                        }
                    })

                }
            });
    }
</script>
<script>
    let msgLivré = '{{Session::get('alertCommandeLivré')}}';
    let existLivré = '{{Session::has('alertCommandeLivré')}}';
    if(existLivré){
        swal({
            title: msgLivré,
            text: "Vous ne pouvez pas supprimer une commande livré" ,
            icon: "warning",
        })
    }
</script>

<script>
    let msgConfirme = '{{Session::get('confirmDeleteCommande')}}';
    let existConfirme = '{{Session::has('confirmDeleteCommande')}}';
    let commande_id = '{{Session::get('idCommande')}}';
    let tokenC = '{{Session::get('tokenCommande')}}';
    if(existConfirme){
        swal({
            title: msgConfirme,
            text: "Une fois supprimé, vous ne pourrez plus récupérer la commande!" ,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    let data ={
                        "_token" : tokenC,
                        "id" : commande_id,
                    };

                    $.ajax({
                        type: "DELETE",
                        url: '/commandes/' + commande_id ,
                        data: data,
                        success: function (response){
                            swal(response.status, {
                                icon: "success",
                            })
                                .then((result) => {
                                    location.reload();
                                });
                        }
                    })

                }
            });
    }
</script>
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
