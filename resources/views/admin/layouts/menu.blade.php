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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
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

    <div class="main_content">
        <div class="header">
            <span>{{Auth::user()->nom}}</span>&nbsp;<span>{{Auth::user()->prenom}}</span>
        </div>

        <div class="info">@yield('content')</div>
    </div>
</div>

<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
<script>
    let msgProjetTerminéEdit = '{{Session::get('alertProjetTerminéEdit')}}';
    let existProjetTerminéEdit = '{{Session::has('alertProjetTerminéEdit')}}';
    if(existProjetTerminéEdit){
        swal({
            title: msgProjetTerminéEdit,
            text: "Vous ne pouvez pas éditer un projet terminé" ,
            icon: "warning",
        })
    }
</script>
<script>
    $(document).ready(function () {
        var SITEURL = "{{url('/')}}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var calendar = $('#calendar').fullCalendar({
            editable: true,
            header:{
                left:'prev,next today',
                center:'title',
                right:'month,agendaWeek,agendaDay'
            },
            monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
            dayNamesShort: ['Lun','Mar','Mer','Jeu','Ven','Sam','Dim'],
            buttonText: {
                today:    'Aujourd\'hui',
                month:    'Mois',
                week:     'Semaine',
                day:      'Jour',
                list:     'Liste'
            },
            events: SITEURL + "/projets",
            displayEventTime: true,

            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            selectable: true,
            selectHelper: true,

            select: function (start, end, allDay) {
                let date = new Date();
                let dateEntrée;
                var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                dateEntrée =  new Date(start);

                if (dateEntrée >= date){
                    var title = prompt('Libelle:');
                    var decription = prompt("Description: ");
                    var localisation = prompt("Localisation: ");
                    if (title && decription && localisation) {
                        let data ={
                            'title' : title,
                            'start' : start,
                            'description' : decription,
                            'localisation' : localisation,
                        };
                        $.ajax({
                            url: SITEURL + "/projets/create",
                            data: data,
                            type: "POST",
                            success: function (data) {
                                displayMessage("Le projet a été bien enregistré");
                                $('#calendar').fullCalendar('removeEvents');
                                $('#calendar').fullCalendar('refetchEvents' );
                            },
                            error: function (data) {
                                swal({
                                    title: "Il ya un erreur!",
                                    text: "Les champs entrés doivent être validé!",
                                    icon: "warning",
                                })
                            }
                        });
                        calendar.fullCalendar('renderEvent',
                            {
                                title: title,
                                start: start,
                                end: end,
                                allDay: allDay
                            },
                            true
                        );
                    }
                    calendar.fullCalendar('unselect');
                }else {
                    swal({
                        title: "La date choisit n'est pas validé!",
                        icon: "warning",
                    })
                }
            },

            eventDrop: function (event, delta) {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                let date = new Date();
                let dateEntrée;
                dateEntrée =  new Date(start);

                if (dateEntrée >= date){
                    $.ajax({
                        url: SITEURL + '/projets/dateChange',
                        data: 'title=' + event.title + '&start=' + start + '&id=' + event.id,
                        type: "POST",
                        success: function (response) {
                            displayMessage("La date a été bien changée");
                        },
                        error: function (data) {
                            swal({
                                text: "Interdit de changer la date d'un projet qui est en état en cours ou terminé",
                                icon: "warning",
                            })
                        }
                    });
                }else{
                    swal({
                        title: "La date choisit n'est pas validé!",
                        icon: "warning",
                    })
                }
            },

            eventClick: function (event) {
                var deleteMsg = confirm("Vous êtes sur?");
                if (deleteMsg) {
                    $.ajax({
                        type: "POST",
                        url: SITEURL + '/projets/delete',
                        data: "&id=" + event.id,
                        success: function (response) {
                            $('#calendar').fullCalendar('removeEvents', event.id);
                            displayMessage("Le projet a été bien supprimé");
                        },
                        error: function (data) {
                            swal({
                                title: "Le projet est terminé",
                                text: "Vous ne pouvez pas supprimer un projet terminé",
                                icon: "warning",
                            })
                        }
                    });
                }
            }
        });
    });

    function displayMessage(message) {
        $(".response").css('display','block');
        $(".response").html(""+message+"");
        setInterval(function() { $(".response").fadeOut(); }, 4000);
    }
</script>
@yield('scripts')
</body>
</html>
