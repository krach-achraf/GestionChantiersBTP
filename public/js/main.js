/********************* liste des matériels flip card *********************/
const button = document.querySelectorAll('.rotate');
const cardInner = document.querySelectorAll('.card_inner');
const cardBack = document.querySelectorAll('.card_face--back');

for (let i=0 ; i<button.length ; i++) {
    button[i].addEventListener('click',function(){
        reverse(i);
    })
}

for (let i=0 ; i<cardBack.length ; i++) {
    cardBack[i].addEventListener('click',function(){
        reverse(i);
    })
}

function reverse(i){
    for (let j=0 ; j<cardInner.length ; j++) {
        if (i===j){
            cardInner[j].classList.toggle('is-flipped');
        }
    }
}
/****************************************** USER ******************************************/
/********************* recupérer les taches d'utilisateur *********************/
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.taches').click(function (e) {
        e.preventDefault();
        let userId = $(this).closest("tr").find('.serdelete_val_user_id').val();
        let data ={
            "_token" : $('input[name="_token"]').val(),
            "id" : userId,
        };
        $.ajax({
            type: "post",
            url: '/utilisateurs/taches/' + userId,
            data: data,
            success: function (data){
                if (data.length === 0){
                    swal({
                        title:"Aucune tache trouvée!",
                        icon: "warning",
                    });
                }else{
                    let event_data = '';
                    event_data += '<div class="card mt-2">';
                    event_data += '<div class="card-header">' + 'Les tâches' ;
                    event_data += '</div>';
                    event_data += '<div class="card-body">';
                    event_data += '<table class="table table-hover">';
                    event_data += '<thead class="thead-light">';
                    event_data += '<tr>';
                    event_data += '<th scope="col">Libellé</th>';
                    event_data += '<th scope="col">Projet</th>';
                    event_data += '<th scope="col">Description</th>';
                    event_data += '<th scope="col">Date tâche</th>';
                    event_data += '<th scope="col">État</th>';
                    event_data += '<th scope="col">Famille</th>';
                    event_data += '</tr>';
                    event_data += '</thead>';
                    event_data += '<tbody>';

                    $.each(data, function (index,value){
                        event_data += '<tr>';
                        event_data += '<td>' + value.libelle + '</td>';
                        event_data += '<td>' + value.libelleProjet + '</td>';
                        event_data += '<td>' + value.description + '</td>';
                        event_data += '<td>' + value.dateTache + '</td>';
                        event_data += '<td>' + value.état + '</td>';
                        event_data += '<td>' + value.famille + '</td>';
                        event_data += '</tr>';
                    });

                    event_data += '</tbody>';
                    event_data += '</table>';
                    event_data += '</div>';
                    event_data += '</div>';
                    $("#taches").append(event_data);
                }
                $('.taches').click(function (e) {
                    $("#taches").empty();
                })
            }
        })
    })
})

/********************* alerte supprimer un utilisateur *********************/
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.servideletebtnUser').click(function (e) {
        e.preventDefault();
        let delete_id = $(this).closest("tr").find('.serdelete_val_user_id').val();
        swal({
            title: "Vous êtes sûr?",
            text: "Une fois supprimé, vous ne pourrez plus récupérer l'utilisateur!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    let data ={
                        "_token" : $('input[name="_token"]').val(),
                        "id" : delete_id,
                    };
                    $.ajax({
                        type: "DELETE",
                        url: '/utilisateurs/' + delete_id ,
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
    })
})

/****************************************** MATERIELS ******************************************/
/********************* alerte supprimer un materiel *********************/
function deleteMateriel(id,idTable2) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    swal({
        title: "Vous êtes sûr?",
        text: "Une fois supprimé, vous ne pourrez plus récupérer le matériel!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                let data = {
                    "_token": $('input[name="_token"]').val(),
                    "id": id,
                };
                $.ajax({
                    type: "DELETE",
                    url: '/materiels/' + id + '/' + idTable2 ,
                    data: data,
                    success: function (response) {
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
/********************* ajout materiel *********************/
$('thead').on('click','.addRow',function () {
    let fournisseurs = getFournisseurs();
    let options = '<option disabled="disabled" selected>Choisissez le fournisseur :</option>';
    var n = $('.resultbody tr').length - 0;

    for (let i=0 ; i<fournisseurs.length ; i++){
        options+= '<option value="' + fournisseurs[i].id + '">' + fournisseurs[i].nom + ' ' + fournisseurs[i].prenom + '</option>';
    }

    let tr = '<tr>' +
                '<td>' +
                    '<input name="libelle[]" type="text" class="form-control" >' +
                '</td>' +
                '<td>' +
                    '<input name="dateAccuse[]" type="date"  class="form-control">' +
                '</td>' +
                '<td>' +
                    '<input name="photo[]" type="file"  class="form-control">' +
                '</td>' +
                '<td>' +
                    '<select name="fournisseur[]" class="form-control">' +
                        options  +
                    '</select>' +
                '</td>' +
                '<td scope="col"><a href="javascript:" class="btn btn-dark deleteRow fa fa-minus"></a></td>' +
            '</tr>';
    $('tbody').append(tr);
});

$('tbody').on('click','.deleteRow',function () {
   $(this).parent().parent().remove();
});

function getFournisseurs(){
    let result = '';
        $.ajax({
            type:"get",
            url:'/getFournisseurs',
            async: false,
           success:function(res){
              result = res;
           }
        });
    return result;
}

/****************************************** COMMANDES ******************************************/
/********************* select taches de projet *********************/
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.projets').change(function (e) {
        e.preventDefault();
        let projet_id = $('#projet option:selected').val();
        let data ={
            "_token" : $('input[name="_token"]').val(),
            "id" : projet_id,
        };
        $.ajax({
            type: "post",
            url: '/commandes/taches/' + projet_id ,
            data: data,
            success: function (response){
                if (response.length === 0){
                    swal({
                        title:"Aucune tache trouvée pour ce projet!",
                        icon: "error",
                    });
                }else{
                    let event_data = '<option disabled="disabled" selected>Choisissez la tache :</option>';
                    $.each(response, function (index,value){
                        event_data += '<option value="' + value.id + '">' + value.libelle + '</option>';
                    });
                    $("#tache").append(event_data);
                }
                $('.projets').change(function (e) {
                    $("#tache").empty();
                })
            }
        })
    })
})



