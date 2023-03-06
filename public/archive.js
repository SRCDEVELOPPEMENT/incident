
$(document).ready(function() {

    let categories = JSON.parse($('#validationCustom04').attr('data-categories'));
    let monthAndDay = new Date().getFullYear() +"-"+ String(new Date().getMonth() + 1).padStart(2, '0');

    table = $('#dataTable-1').DataTable({
        destroy: true,
        paging: false,
        searching: false,
    });

    $("#searchDate").on("change", function() {
        $('#assigner_as').val('');
        $('#emis_recus').val('');
        $('#searchMonth').val('');
        $('#search_text_simple').val('');
        $('#year_courant_incident').val('');

        //Mise A Jour Categorie
        $('#validationCustom04 option').remove();
        $('#validationCustom04').append(`<option selected value="">Choisissez Une Catégorie...</option>`);
        for (let h = 0; h < categories.length; h++) {
            const categorie = categories[h];
            $('#validationCustom04').append(`<option value="${categorie.name}">${categorie.name}</option>`);
        }
        //Mise A Jour Categorie

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

    $("#validationCustom04").on("change", function() {
        $('#year_courant_incident').val('');
        $('#searchDate').val('');
        $('#searchMonth').val('');
        $('#search_text_simple').val('');

        var value = $(this).val().toLowerCase();
        $(".agencies tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });


    // Chargement Incidents Année Encours
    $("#year_courant_incident").on("change", function() {
        $('#assigner_as').val('');
        $('#emis_recus').val('');
        $('#searchDate').val('');
        $('#searchMonth').val('');
        $('#search_text_simple').val('');

        //Mise A Jour Categorie
        $('#validationCustom04 option').remove();
        $('#validationCustom04').append(`<option selected value="">Choisissez Une Catégorie...</option>`);
        for (let h = 0; h < categories.length; h++) {
            const categorie = categories[h];
            $('#validationCustom04').append(`<option value="${categorie.name}">${categorie.name}</option>`);
        }
        //Mise A Jour Categorie

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
    
    $("#searchMonth").on("change", function() {
        $('#assigner_as').val('');
        $('#emis_recus').val('');
        $('#searchDate').val('');
        $('#search_text_simple').val('');
        $('#year_courant_incident').val('');

        //Mise A Jour Categorie
        $('#validationCustom04 option').remove();
        $('#validationCustom04').append(`<option selected value="">Choisissez Une Catégorie...</option>`);
        for (let h = 0; h < categories.length; h++) {
            const categorie = categories[h];
            $('#validationCustom04').append(`<option value="${categorie.name}">${categorie.name}</option>`);
        }
        //Mise A Jour Categorie

        var filter = $(this).val();
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

    // Chargement Incidents Mois Encours
    $('#searchMonth').val(monthAndDay);

    var table = document.getElementById("dataTable-1");
    var tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[3];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.indexOf(monthAndDay) > -1) {
                tr[i].style.display = "";
            } else {
                 tr[i].style.display = "none";
            }
        }
    }
    // Fin Chargement Incidents Mois Encours


    $('#search_text_simple').on('input', function(){
        $('#searchDate').val('');
        $('#searchMonth').val('');
        $('#year_courant_incident').val('');

        //Mise A Jour Categorie
        $('#validationCustom04 option').remove();
        $('#validationCustom04').append(`<option selected value="">Choisissez Une Catégorie...</option>`);
        for (let h = 0; h < categories.length; h++) {
            const categorie = categories[h];
            $('#validationCustom04').append(`<option value="${categorie.name}">${categorie.name}</option>`);
        }
        //Mise A Jour Categorie

        var value = $(this).val().toLowerCase();
        $(".agencies tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });


    // $(document).on('mouseover', '#myInc', function(){
    //     let incident = JSON.parse($(this).attr('data-incident'));

    //     if(incident.status == "CLÔTURÉ"){
    //         $(this).css("background-color", "#88A58F");
    //     }else{
    //     $(this).css("background-color", "#30363B");
    //     }

    //     if(incident.due_date){
    //         let echeance = parseInt(incident.due_date.replaceAll("-", ""));
    //         let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));

    //         if((echeance < today) && (incident.status == "ENCOURS")){
    //             $(this).css("background-color", "#9A7474");
    //         }
    //     }

    // });
    // $(document).on('mouseleave', '#myInc', function(){
    //     $(this).css("background-color", "#343A40");
    // });
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
    let departements = JSON.parse($(this).attr('data-departements'));
    let users = JSON.parse($(this).attr('data-users'));
    let users_incidents = JSON.parse($(this).attr('data-users_incidents'));
    let incident = JSON.parse($(this).attr('data-number'));
    let tasks = JSON.parse($(this).attr('data-task'));
    let sites = JSON.parse($(this).attr('data-sites'));

    let count = 0;
    for (let index = 0; index < tasks.length; index++) {
        const task = tasks[index];
        if(task.incident_number == incident.number){
            count +=1;
        }
    }

    if(incident.deja_pris_en_compte === "1"){
        $('.deja_pris_encompte').replaceWith(`<span class="text-xl text-danger deja_pris_encompte">${incident.comment ? incident.comment : ""}</span>`)
    }else if(!incident.deja_pris_en_compte){
        if(incident.observation_rex){
            $('.deja_pris_encompte').replaceWith(`<span class="text-xl text-success deja_pris_encompte">Incident Assigné Avec Succèss !</span>`)
        }else{
            $('.deja_pris_encompte').replaceWith(`<span class="text-xl text-warning deja_pris_encompte">Incident Pas Encore Assigné !</span>`)  
        }
    }

    $('.observation_coordos').replaceWith(`<span class="text-xl observation_coordos">${incident.observation_rex ? incident.observation_rex : ""}</span>`);
    $('#inf_number').replaceWith(`<span class="badge badge-success inf_number">${incident.number}</span>`);
    $('.desc').replaceWith(`<span class="text-xl desc">${incident.description}</span>`);
    $('.cose').replaceWith(`<span class="text-xl cose">${incident.cause}</span>`);
    $('.perim').replaceWith(`<span class="text-xl perim">${incident.perimeter ? incident.perimeter : ""}</span>`);
    $('.tac').replaceWith(`<span class="text-xl tac">${count < 10 ? 0 +""+ count : count}</span>`);
    $('.actions_do').replaceWith(`<span class="text-xl actions_do">${incident.battles ? incident.battles : ''}</span>`);
    $('.due_dat').replaceWith(`<span class="text-danger text-xl due_dat">${incident.due_date ? incident.due_date : ""}</span>`);
    $('.kate').replaceWith(`<span class="text-xl kate">${incident.categories ? incident.categories.name : ""}</span>`);

    $('.creat_dat').replaceWith(`<span class="text-xl text-white creat_dat"></span>`);

    let mon_user = users_incidents.find(u => u.incident_number == incident.number && u.isCoordo === '1' && u.isTrigger === '0');

    let mon_user_ince = users_incidents.find(u => u.incident_number == incident.number && u.isCoordo === '1' && u.isTrigger === '1' && u.isTriggerPlus === '1');
    
    if(mon_user){
        let Utilisateur = users.find(u => u.id == mon_user.user_id);

        if(Utilisateur){
            var dept = departements.find(d => d.id == Utilisateur.departement_id);
            var sit = sites.find(s => s.id == Utilisateur.site_id);
        }
    }
    
    $('.site_emeter').replaceWith(`<span class="site_emeter">${sit ? sit.name : dept ? dept.name : ''}</span>`);

    if(mon_user_ince){
        let Utilisateur = users.find(u => u.id == mon_user_ince.user_id);
        if(Utilisateur){
            var dept_recept = departements.find(d => d.id == Utilisateur.departement_id);
            var sit_recept = sites.find(s => s.id == Utilisateur.site_id);
        }
    }

    $('.syte_receppt').replaceWith(`<span class="syte_receppt">${sit_recept ? sit_recept.name : dept_recept ? dept_recept.name : ''}</span>`);
});

