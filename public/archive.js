
$(document).ready(function() {

    table = $('#dataTable-1').DataTable({
        destroy: true,
        paging: false,
        searching: false,
    });

    $("#searchDate").on("change", function() {
        $('#assigner_as').val('');
        $('#emis_recus').val('');
        $('#search_text_simple').val('');
        $('#year_courant_incident').val('');

        var filter =$(this).val();
        var table = document.getElementById("dataTable-1");
        var tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[3];
            if (td) {
              txtValue = td.textContent || td.innerText;
              if (txtValue.indexOf(filter) > -1) {
                tr[i].style.display = "";
              } else {
                tr[i].style.display = "none";
              }
            }
        }
    });

    // Chargement Incidents Année Encours
    $("#year_courant_incident").on("change", function() {
        $('#assigner_as').val('');
        $('#emis_recus').val('');
        $('#searchDate').val('');
        $('#search_text_simple').val('');

        var filter =$(this).val();
        var table = document.getElementById("dataTable-1");
        var tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[3];
            if (td) {
              txtValue = td.textContent || td.innerText;
              if (txtValue.indexOf(filter) > -1) {
                tr[i].style.display = "";
              } else {
                tr[i].style.display = "none";
              }
            }
        }
    });
    

    $('#search_text_simple').on('input', function(){
        $('#searchDate').val('');
        $('#year_courant_incident').val('');

        var value = $(this).val().toLowerCase();
        $(".agencies tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});


$(document).on('click', '#desarchive_incident', function(){
    let incident = JSON.parse($(this).attr('data-incident'));
    $('#taboo').replaceWith(`<strong class="badge badge-success" id="taboo">${incident.number}</strong>`);
    $('#desarchivag').attr('data-backdrop', 'static');
    $('#desarchivag').attr('data-keyboard', false);
    $('#desarchivag').modal('show');

});

$(document).on('click', '#btn_save_desarching', function(){
    $.ajax({
        type: 'PUT',
        url: 'desarchiving',
        data: {
            number: $('#taboo').text(),
        },
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(){
            location.reload();
        }
    });
});


$(document).on('click', '#restorer_incident', function(){

    let incident = JSON.parse($(this).attr('data-incident'));
    $('#id_numbers').replaceWith(`<strong class="badge badge-success" id="id_numbers">${incident.number}</strong>`);
    $('#restauration').attr('data-backdrop', 'static');
    $('#restauration').attr('data-keyboard', false);
    $('#restauration').modal('show');

});


$(document).on('click', '#btn_restaurasion', function(){

    $.ajax({
        type: 'PUT',
        url: 'restoration',
        data: {
            number: $('#id_numbers').text(),
        },
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(){
            location.reload();
        }
    });

});

$(document).on('click', '#infos_incident', function(){
    let incident = JSON.parse($(this).attr('data-incident'));

    let tasks = JSON.parse($(this).attr('data-task'));

    if(incident.deja_pris_en_compte === "1"){
        $('.deja_pris_encompte').replaceWith(`<span class="text-xl text-danger deja_pris_encompte">${incident.comment ? incident.comment : ""}</span>`)
    }else if(!incident.deja_pris_en_compte){
        if(incident.observation_rex){
            $('.deja_pris_encompte').replaceWith(`<span class="text-xl text-success deja_pris_encompte">Incident Assigné Avec Succèss !</span>`)
        }else{
            $('.deja_pris_encompte').replaceWith(`<span class="text-xl text-warning deja_pris_encompte">Incident Pas Encore Assigné !</span>`)  
        }
    }

    $('.stat_inci').replaceWith(`<span class="text-xl stat_inci">${incident.status}</span>`);
    $('.declarateur').replaceWith(`<div class="my-0 big"><span class="text-xl declarateur">${incident.fullname_declarateur ? incident.fullname_declarateur : "AUCUN DECLARATEUR"}</span></div>`)
    $('.observation_coordos').replaceWith(`<span class="text-xl observation_coordos">${incident.observation_rex ? incident.observation_rex : ""}</span>`);
    $('.inf_numbers').text(incident.number);
    $('.desc').replaceWith(`<span class="text-xl desc">${incident.description}</span>`);
    $('.cose').replaceWith(`<span class="text-xl cose">${incident.cause}</span>`);
    $('.perim').replaceWith(`<span class="text-xl perim">${incident.perimeter ? incident.perimeter : ""}</span>`);
    $('.tac').replaceWith(`<span class="text-xl tac">${tasks < 10 ? 0 +""+ tasks : tasks}</span>`);
    $('.actions_do').replaceWith(`<span class="text-xl actions_do">${incident.battles ? incident.battles : ''}</span>`);
    $('.due_dat').replaceWith(`<span class="text-danger text-xl due_dat">${incident.due_date ? incident.due_date : ""}</span>`);
    $('.kate').replaceWith(`<span class="text-xl kate">${incident.categories ? incident.categories.name : ""}</span>`);

    $('.creat_dat').replaceWith(`<span class="text-xl creat_dat">${incident.declaration_date}</span>`);
    $('.cloture_daaaate').replaceWith(`<span class="text-xl cloture_daaaate">${incident.closure_date}</span>`);
    
});

$(document).on('click', '#commentaire_cloture', function(){

    let incident = JSON.parse($(this).attr('data-incident'));

    $('#commix').val(incident.comment ? incident.comment : "");

    $('#comment_num_i').replaceWith(`<span class="badge badge-success" id="comment_num_i">${incident.number}</span>`);

});
