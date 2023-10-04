
$(document).on('click', '#btn_echeance_set_close', function(){
    $('#date_due').val('');
});

$(document).on('click', '#btn_Assign_Klose', function(){
    $('#deepartes').val('');
});

$(document).on('click', '#btn_prior_Kose', function(){
    $('#priority_it').val('');
});

$(document).on('click', '#serial_kill', function(){
    $('#form_incident')[0].reset();
});

$(document).on('click', '.saiyan', function(){
    let incident = JSON.parse($(this).attr('data-incident'));
    if(!incident.closure_date){
        $('#Kloture').attr('data-incident', JSON.stringify(incident));
        $(this).replaceWith(`<a type="button" href="#!" title="Clôturé Cet Incident" class="text-primary fe fe-toggle-right fe-32 saiyan"></a>`);
        $('#clos').attr('data-backdrop', 'static');
        $('#clos').attr('data-keyboard', false);
        $('#clos').modal('show');
    }
});

$(document).on('click', '#toggle', function(){
    let incident = JSON.parse($(this).attr('data-incident'));
    $('#nibiru_number').replaceWith(`<strong class="badge badge-success" id="nibiru_number">${incident.number}</strong>`);
});


$(document).on('click', '#Kloture', function(){
        let tasks = JSON.parse($(this).attr('data-tasks'));
        let incident = JSON.parse($(this).attr('data-incident'));

        let count = 0;
        let tab = [];
        for (let index = 0; index < tasks.length; index++) {
            const task = tasks[index];
            if(task.incident_number == incident.number){
                tab.push(task);
            }
        }

        for (let index = 0; index < tab.length; index++) {
            const task = tab[index];
            if((task.status.trim() != "RÉALISÉE")){
                count +=1;
            }
        }
        if($('#cloture_comment').val().trim()){
                if((count == 0) && (tab.length > 0)){
                    $.ajax({
                        type: 'PUT',
                        url: "clotureIncident",
                        data: {
                            status: "CLÔTURÉ",
                            number: incident.number,
                            valeur: $('#valeure').val() ? $('#valeure').val() : null,
                            comment: $('#cloture_comment').val().trim() ? $('#cloture_comment').val() : null,
                        },
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(element){
                            if(element.length > 0){
                                location.reload();
                            }
                        }
                    });
                }else{
                    $('#textClo').val('Veuillez Ajouter Et Réaliser Les Tâches De Cet Incident Avant De Le Clôturer !')
                    $('#clos').modal('hide');
                    $('#close_inc').attr('data-backdrop', 'static');
                    $('#close_inc').attr('data-keyboard', false);
                    $('#close_inc').modal('show');    
                }
        }else{
            $('#textClo').val('Veuillez Renseigner Un Commentaire De Clôture Pour Cet Incident !');
            $('#clos').modal('hide');
            $('#close_inc').attr('data-backdrop', 'static');
            $('#close_inc').attr('data-keyboard', false);
            $('#close_inc').modal('show');
        }
});

$(document).on('click', '#Kloture_rex', function(){
    //let tasks = JSON.parse($(this).attr('data-tasks'));
    let incident = JSON.parse($(this).attr('data-incident'));

    $.ajax({
        type: 'PUT',
        url: 'cloture_special_rex',
        data: {
            status : "CLÔTURÉ",
            number : incident.number,
            valeur : $('#valeure_rex').val(),
            comment : $('#cloture_comment_rex').val()
        },
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data){
            if(data.length > 0){
                location.reload();
            }
        }
    });

});


$(document).on('click', '#commentaire_cloture', function(){

    let incident = JSON.parse($(this).attr('data-incident'));

    $('#commix').val(incident.comment ? incident.comment : "");

    $('#comment_num_i').replaceWith(`<span class="badge badge-success" id="comment_num_i">${incident.number}</span>`);

});


$(document).on('click', '#infos_incident', function(){
    let incident = JSON.parse($(this).attr('data-incident'));
    // let incident = {
    //     number : $(this).attr('data-number'),
    //     description : $(this).attr("data-description"),
    //     status : $(this).attr('data-status'),
    //     cause : $(this).attr('data-cause'),
    //     motif_annulation : $(this).attr('data-motif_annulation'),
    //     proces_id : $(this).attr('data-proces_id'),
    //     perimeter : $(this).attr('data-perimeter'),
    //     priority : $(this).attr('data-priority'),
    //     declaration_date : $(this).attr('data-declaration_date'),
    //     battles : $(this).attr('data-battles'),
    //     comment : $(this).attr('data-comment'),
    //     site_id : $(this).attr('data-site_id'),
    //     observation_rex : $(this).attr('data-observation_rex'),
    //     archiver : $(this).attr('data-archiver'),
    //     deja_pris_en_compte : $(this).attr('data-deja_pris_en_compte'),
    //     categorie_id : $(this).attr('data-categorie_id'),
    //     site_declarateur : $(this).attr('data-site_declarateur'),
    //     observation : $(this).attr('data-observation'),
    //     fullname_declarateur : $(this).attr('data-fullname_declarateur'),
    //     closure_date : $(this).attr('data-closure_date'),
    //     due_date : $(this).attr('data-due_date'),
    //     valeur : $(this).attr('data-valeur'),
    // };

    let tasks = JSON.parse($(this).attr('data-tasks'));
    let categories = JSON.parse($(this).attr('data-categories'));
    let processus = JSON.parse($(this).attr('data-processus'));
    let sites = JSON.parse($(this).attr('data-sites'));

    let cate = categories.find(c => c.id == incident.categorie_id);
    let pro = processus.find(p => p.id == incident.proces_id);

    if(incident.site_incident){
        var site_incident = sites.find(s => s.id == incident.site_incident);
    }

    let r = 0;
    var text = "";
    for (let vg = 0; vg < tasks.length; vg++) {
        const t = tasks[vg];
        text = text + t.description + "     |     ";
        if(t.status == "ENCOURS"){
            r +=1;
        }
    }
    
    $('.les_taches').replaceWith(`<span class="les_taches">${text} </span>`);

    if(incident.deja_pris_en_compte === "1"){
        $('.deja_pris_encompte').replaceWith(`<span class="text-xl text-danger deja_pris_encompte">${incident.comment ? incident.comment : ""}</span>`)
    }else if(!incident.deja_pris_en_compte){
        if(incident.observation_rex){
            $('.deja_pris_encompte').replaceWith(`<span class="text-xl text-success deja_pris_encompte">Incident Assigné Avec Succèss !</span>`)
        }else{
            $('.deja_pris_encompte').replaceWith(`<span class="text-xl text-warning deja_pris_encompte">Incident Pas Encore Assigné !</span>`)  
        }
    }
    

    $('.site_de_lincident').replaceWith(`<div class="my-0 big"><span class="site_de_lincident">${site_incident ? site_incident.name : ""}</span></div>`);
    $('.declarateur').replaceWith(`<div class="my-0 big"><span class="text-xl declarateur">${incident.fullname_declarateur ? incident.fullname_declarateur : "AUCUN DECLARATEUR"}</span></div>`)
    $('.observation_coordos').replaceWith(`<span class="text-xl observation_coordos">${incident.observation_rex ? incident.observation_rex : ""}</span>`);
    $('.processus_impacter').replaceWith(`<span class="text-xl processus_impacter">${pro.name}</span>`);
    $('#inf_number').replaceWith(`<span class="badge badge-success" id="inf_number">${incident.number}</span>`);
    $('.desc').replaceWith(`<span class="text-xl desc">${incident.description}</span>`);
    $('.cose').replaceWith(`<span class="text-xl cose">${incident.cause}</span>`);
    $('.perim').replaceWith(`<span class="text-xl perim">${incident.perimeter ? incident.perimeter : ''}</span>`);
    $('.tac').replaceWith(`<span class="text-xl tac">${(tasks.length) < 10 ? 0 +""+ (tasks.length) : (tasks.length)}</span>`);
    
    if(tasks.length == 0){
        $('.statut_taches').replaceWith(`<span class="text-xl statut_taches">"ENCOURS DE REALISATION"</span>`);
    }else{
        $('.statut_taches').replaceWith(`<span class="text-xl statut_taches">${r == 0 ? "RÉALISÉE" : "ENCOURS DE REALISATION"}</span>`);
    }

    $('.actions_do').replaceWith(`<span class="text-xl actions_do">${incident.battles ? incident.battles : ''}</span>`);
    
    if(incident.due_date){
        if(parseInt(incident.due_date.replaceAll("-", "")) < parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""))){
            if(incident.status == "ENCOURS"){
                $('.due_dat').replaceWith(`<span class="text-warning text-xl due_dat">${incident.due_date ? incident.due_date : ''}</span>`);
            }else{
                $('.due_dat').replaceWith(`<span class="text-primary text-xl due_dat">${incident.due_date ? incident.due_date : ''}</span>`);
            }
        }else{
            $('.due_dat').replaceWith(`<span class="text-primary text-xl due_dat">${incident.due_date ? incident.due_date : ''}</span>`);
        }
    }else{
        $('.due_dat').replaceWith(`<span class="due_dat"></span>`);
    }

    $('.kate').replaceWith(`<span class="text-xl kate">${cate.name ? cate.name : ""}</span>`);

    $('.cloture_daaaate').replaceWith(`<span class="text-xl text-success cloture_daaaate">${incident.closure_date ? incident.closure_date : ""}</span>`);
    $('.creat_dat').replaceWith(`<span class="text-xl creat_dat">${incident.declaration_date}</span>`);

    if(incident.status == "ENCOURS"){
        $('.stat_inci').replaceWith(`<span class="text-xl text-primary stat_inci">${incident.status}</span>`);
    }else if(incident.status == "CLÔTURÉ"){
        $('.stat_inci').replaceWith(`<span class="text-xl text-success stat_inci">${incident.status}</span>`);
    }else{
        $('.stat_inci').replaceWith(`<span class="text-xl text-muted stat_inci">${incident.status}</span>`);
    }

});

$(document).on('click', '.incd', function(){
    $('#hids').val($(this).attr('data-id'));
    $('#txt_num_i').replaceWith(`<span id="txt_num_i" style="margin-left: 13em;" class="text">${$(this).attr('data-id')}</span>`)
});

$(document).ready(function() {

    $('#form_incident')[0].reset();
    //BUTTON ASSIGNATION
    $('.badji').hide();
    //END BUTTON ASSIGNATION
    let sites = JSON.parse($('#validationCustom04').attr('data-sites'));


    table = $('#dataTable-1').DataTable({
        destroy: true,
        paging: false,
        searching: false,
    });


    $("#searchDate").on("change", function() {
        $('#emis_recus').val('');
        $('#assigner_as').val('');
        $('#search_text_simple').val('');
        $('#year_courant_incident').val('');

        //Mise A Jour Site
        $('#validationCustom04 option').remove();
        $('#validationCustom04').append(`<option selected value="">Site...</option>`);
        for (let h = 0; h < sites.length; h++) {
            const site = sites[h];
            $('#validationCustom04').append(`<option value="${site.name}">${site.name}</option>`);
        }
        //Mise A Jour Site

        var value = $(this).val().toLowerCase();
        $(".agencies tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    $("#validationCustom04").on("change", function() {
        $('#emis_recus').val('');
        $('#assigner_as').val('');
        $('#year_courant_incident').val('');
        $('#searchDate').val('');
        $('#search_text_simple').val('');

        var value = $(this).val().toLowerCase();
        $(".agencies tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Chargement Incidents Année Encours
    $("#year_courant_incident").on("change", function() {
        $('#emis_recus').val('');
        $('#assigner_as').val('');
        $('#searchDate').val('');
        $('#search_text_simple').val('');

        //Mise A Jour Site
        $('#validationCustom04 option').remove();
        $('#validationCustom04').append(`<option selected value="">Site...</option>`);
        for (let h = 0; h < sites.length; h++) {
            const site = sites[h];
            $('#validationCustom04').append(`<option value="${site.name}">${site.name}</option>`);
        }
        //Mise A Jour Site

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
        $('#emis_recus').val('');
        $('#assigner_as').val('');
        $('#searchDate').val('');
        $('#year_courant_incident').val('');

        //Mise A Jour Site
        $('#validationCustom04 option').remove();
        $('#validationCustom04').append(`<option selected value="">Site...</option>`);
        for (let h = 0; h < sites.length; h++) {
            const site = sites[h];
            $('#validationCustom04').append(`<option value="${site.name}">${site.name}</option>`);
        }
        //Mise A Jour Site

        var value = $(this).val().toLowerCase();
        $(".agencies tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });


    $(document).on('change', '#emis_recus', function(){
        $('#assigner_as').val('');
        $('#searchDate').val('');
        $('#search_text_simple').val('');
        $('#validationCustom04').val('');
        $('#year_courant_incident').val('');

        //Mise A Jour Site
        $('#validationCustom04 option').remove();
        $('#validationCustom04').append(`<option selected value="">Site...</option>`);
        for (let h = 0; h < sites.length; h++) {
            const site = sites[h];
            $('#validationCustom04').append(`<option value="${site.name}">${site.name}</option>`);
        }
        //Mise A Jour Site

        var filter = $(this).val();
        var table = document.getElementById("dataTable-1");
        var tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
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

    $(document).on('change', '#assigner_as', function(){
        $('#emis_recus').val('');
        $('#searchDate').val('');
        $('#search_text_simple').val('');
        $('#validationCustom04').val('');
        $('#year_courant_incident').val('');

        //Mise A Jour Site
        $('#validationCustom04 option').remove();
        $('#validationCustom04').append(`<option selected value="">Site...</option>`);
        for (let h = 0; h < sites.length; h++) {
            const site = sites[h];
            $('#validationCustom04').append(`<option value="${site.name}">${site.name}</option>`);
        }
        //Mise A Jour Site

        var filter = $(this).val();
        var table = document.getElementById("dataTable-1");
        var tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[9];
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

});


$(document).on('click', '#customSwitch1', function(){
    let a = $("input[name='customSwitch1']:checked").val();
    if(a){
        $('.badji').show();
        $('.takeshi').hide();
        $('.anagaki').hide();
        $('#nino').remove();
        $('#regina').append(`<option selected value="">Choisissez...</option>`);

    }else{
        $('.takeshi').show();
        $('.anagaki').show();
        $('.badji').hide();
    }
});


$(document).on('click', 'button[name="buttonAddingIncidants"]', function(){
    let good = true;
    let message = "";

    if(!$('#fullname').val().trim()){
        good = false;
        message+="Veuillez Renseigner Votre Nom Complèt !\n";
    }
    

    if(!$('#site_incident').val()){
        good = false;
        message+="Veuillez Choisir Le Site Où Est Survenu L'incident !\n";
    }

    if(!$('#description').val().trim()){
        good = false;
        message+="Veuillez Décrire L'incident !\n";
    }
    if(!$('#cause').val().trim()){
        good = false;
        message+="Veuillez Renseigner La Cause De L'incident !\n";
    }

    if(!$('#deepa').val()){
        good = false;
        message+="Veuillez Choisir Un Site Au Quel Affecté L'incident !\n";
    }

    if(!$('#categorie').val()){
        good = false;
        message+="Veuillez Choisir La Catégorie De L'incident !\n";
    }

    if($('#process_incdent').val().length == 1){
        if(isNaN(parseInt($('#process_incdent').val()[0]))){
            good = false;
            message+="Veuillez Choisir Le(s) Procéssus Impacté(s) Par L'incident !\n";
        }
    }else if($('#process_incdent').val().length > 1){
        if(isNaN(parseInt($('#process_incdent').val()[1]))){
            good = false;
            message+="Veuillez Choisir Le(s) Procéssus Impacté(s) Par L'incident !\n";
        }
    }else if($('#process_incdent').val().length == 0){
        good = false;
        message+="Veuillez Choisir Le(s) Procéssus Impacté(s) Par L'incident !\n";
    }

    if(!$('#priority').val()){
        good = false;
        message+="Veuillez Choisir La Priorité De L'incident !\n";
    }

    if(!$('#obs').val().trim()){
        good = false;
        message+="Veuillez Renseigner Une Observation !\n";
    }
    
    if(!$('#date_due_insert').val()){
        good = false;
        message+="Veuillez Renseigner La Date D'échéance De L'incident !\n";
    }

    if(!good){
        good = false;

        $("#validation").val(message);
        $('#modal_incident').modal('hide');
        $('#Falco').attr('data-backdrop', 'static');
        $('#Falco').attr('data-keyboard', false);
        $('#Falco').modal('show');
    }else{

        $('#modal_incident').modal('toggle');

        let process = JSON.parse($(this).attr('data-processus'));

        $('#site_survenue_conf').replaceWith(`
            <textarea class="bg-light" style="resize:none;" disabled name="" id="site_survenue_conf" cols="30" rows="3">${$('#site_incident option:selected').text()}</textarea>
        `); 
        $('#fullname_conf').val($('#fullname').val());
        $('#description_conf').replaceWith(`
        <textarea class="bg-light" style="resize:none;" disabled name="" id="description_conf" cols="30" rows="5">${$('#description').val()}</textarea>`);   
        $('#cause_conf').replaceWith(`
        <textarea class="bg-light" style="resize:none;" disabled name="" id="cause_conf" cols="30" rows="5">${$('#cause').val()}</textarea>`);   
        $('#perimeter_conf').replaceWith(`<textarea class="bg-light" style="resize:none;" disabled name="" id="perimeter_conf" cols="30" rows="5">${$('#perimeter').val()}</textarea>`);
        $('#Kate_conf').replaceWith(`<span class="bg-light" style="font-size: 20px;" id="Kate_conf">${$('#categorie option:selected').text()}</span>`);
        $('#menees_actions_conf').replaceWith(`<textarea class="bg-light" style="resize:none;" disabled name="" id="menees_actions_conf" cols="30" rows="5">${$('#battles').val()}</textarea>`);
        $('#personne_assigne').replaceWith(`<textarea style="resize:none;" disabled name="" id="personne_assigne" cols="30" rows="1">${$('#deepa option:selected').text()}</textarea>`);
        $('#priori_conf').replaceWith(`<textarea style="resize:none;" disabled name="" id="priori_conf" cols="30" rows="1">${$('#priority').val()}</textarea>`);
        $('#observe_conf').replaceWith(`<textarea style="resize:none;" disabled name="" id="observe_conf" cols="30" rows="6">${$('#obs').val()}</textarea>`);

        let elt = '';
        
        for (let index = 0; index < $('#process_incdent').val().length; index++) {

            const id = $('#process_incdent').val()[index];

            for (let index = 0; index < process.length; index++) {
                const pro = process[index];

                if(pro.id == id){
                    elt += pro.name + ' | ';
                }
            }
        }

        $('#process_conf').replaceWith(`
            <textarea class="bg-light" style="resize:none;" disabled name="" id="process_conf" cols="30" rows="3">${elt}</textarea>`);
        
        $('#modalConfirmationSaveIncident').attr('data-backdrop', 'static');
        $('#modalConfirmationSaveIncident').attr('data-keyboard', false);
        $('#modalConfirmationSaveIncident').modal('show');
    }
});

$(document).on('click', '#conf_save_incident', function(){
    
    $.ajax({
        type: 'POST',
        url: "createIncident",
        data: {
                priority: $('#priority').val(),
                description: $('#description').val(),
                cause: $('#cause').val(),
                categorie: $('#categorie').val(),
                processus_id: $('#process_incdent').val(),
                perimeter: $('#perimeter').val(),
                battles: $('#battles').val(),
                domaine: $('#deepa').val(),
                observation: $('#obs').val(),
                due_date: $('#date_due_insert').val(),
                fullname : $('#fullname').val(),
                site_incident : $('#site_incident').val()
              },
         headers:{
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         success: function(data){
            if(data.length > 1){
                $('#modalConfirmationSaveIncident').modal('toggle');
                $("#validation").val('Incident Déja Enrégistré !');
                $('#Falco').attr('data-backdrop', 'static');
                $('#Falco').attr('data-keyboard', false);
                $('#Falco').modal('show');
            }else{
                location.reload();
            }
         }
    });
});


$(document).on('click', '#non_confirmation', function(){
    $('#modalConfirmationSaveIncident').modal('hide');
    $('#modal_incident').attr('data-backdrop', 'static');
    $('#modal_incident').attr('data-keyboard', false);
    $('#modal_incident').modal('show');
});

$(document).on('click', '#non_conf_save_t', function(){
    $('#modalConfirmationSaveTask').modal('hide');
    $('#modal_task').attr('data-backdrop', 'static');
    $('#modal_task').attr('data-keyboard', false);
    $('#modal_task').modal('show');
});


$(document).on('click', '#btn_clear_fields', function(){
    $("#form_tache")[0].reset();
});


$(document).on('click', '#btn_clear_fields_edit_incident', function(){
    $("#formEditIncident")[0].reset();
});


$(document).on('click', '#btn_clear_fields_edit', function(){
    $("#frmtach")[0].reset();
});


$(document).on('click', '#btn_clear_fields_incident, #btnExitModalIncident', function(){
    $("#form_incident")[0].reset();
});


$(document).on('click', '#btnExitModalCloture, #bat_boy, #btnCloseProposition, #btnCloseNon', function(){
    $('#form_incident')[0].reset();
    location.reload();
});


$(document).on('click', '#btncloseeditform', function(){
    $('#formEditIncident')[0].reset();
    $('#categorie_edit').empty().append(`<option value="">Choisissez...</option>`);
});


$(document).on('click', '#btn_edit_in', function(){

    let ca = [];
    let incident = JSON.parse($(this).attr('data-incident'));
    let categories = JSON.parse($(this).attr('data-categories'));

    $('#nimero').replaceWith(`<span class="badge badge-pill badge-success" id="nimero">${incident.number}</span>`);
    $('#number_incident').val(incident.number);
    $('#fullname_edit').val(incident.fullname_declarateur);
    $('.form-group #description_edit').val(incident.description);
    $('.form-group #cause_edit').val(incident.cause);
    $('.form-group #perimeter_edit').val(incident.perimeter);
    $('.form-group #battles_edit').val(incident.battles ? incident.battles : '');
    $('.form-group #process_editss').val(incident.proces_id);
    $('.form-group #prioritys').val(incident.priority);
    $('.form-group #obs_edit').val(incident.observation);
    $('.form-group #site_incident_edit').val(incident.site_incident);
    if(incident.due_date){
        $('.form-group #date_echeance_edit').val(incident.due_date);
    }

    if(incident.site_id){
        $('.form-group #deepaEdit').val(incident.site_id);
    }
    
    $('#categorie_edit').append(`<option value="${categorie.id}">${categorie.name}</option>`);
    if(incident.categorie_id){
        let categ = categories.find(c => c.id == incident.categorie_id);
        
        if(categ.type == "AGENCE" || categ.type == "MAGASIN"){

            for (let index = 0; index < categories.length; index++) {
                const categorie = categories[index];
                if(categorie.departement_id == categ.departement_id){
                    ca.push(categorie);
                }
            }

            for (let i = 0; i < ca.length; i++) {
                const categorie = ca[i];
                $('#categorie_edit').append(`<option value="${categorie.id}">${categorie.name}</option>`);
            }

            $('.form-group #categorie_edit').val(incident.categorie_id);
        }else{

            for (let index = 0; index < categories.length; index++) {
                const categorie = categories[index];
                if(categorie.type == categ.type){
                    ca.push(categorie);
                }
            }
            
            for (let i = 0; i < ca.length; i++) {
                const categorie = ca[i];
                $('#categorie_edit').append(`<option value="${categorie.id}">${categorie.name}</option>`);
            }

            $('.form-group #categorie_edit').val(incident.categorie_id);
        }
    }
});


$(document).on('click', '#btn_edit_incident', function(){
    let good = true;
    let message = "";


    if(!$('#fullname_edit').val().trim()){
        good = false;
        message+="Veuillez Renseigner Votre Nom Complèt !\n";
    }

    if(!$('#site_incident_edit').val().trim()){
        good = false;
        message+="Veuillez Choisir Le Site Où Est Survenu L'incident !\n";
    }

    if(!$('#description_edit').val().trim()){
        good = false;
        message+="Veuillez Renseigner La Description De L'incident !\n";
    }
    if(!$('#cause_edit').val().trim()){
        good = false;
        message+="Veuillez Renseigner La Cause De L'incident !\n";
    }
    if(!$('#categorie_edit').val()){
        good = false;
        message+="Veuillez Choisir La Catégorie De L'incident !\n";
    }

    if(!$('#process_editss').val()){
        good = false;
        message+="Veuillez Choisir Le Procéssus De L'incident !\n";
    }

    if(!$('#obs_edit').val().trim()){
        good = false;
        message+="Veuillez Renseigner Une Observation !\n";
    }


    if(!$('#prioritys').val()){
        good = false;
        message+="Veuillez Renseigner La Priorité De L'incident !\n";
    }
    
    if($('#date_echeance_edit').val()){
        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
        let date_saisi = parseInt($('#date_echeance_edit').val().replaceAll("-", ""));
        if(date_saisi < today){
            good = false;
            message +="Veuillez Renseigner Une Date D\'échéance Qui Est Supérieur Où Egale A La Date D'aujourd'huit !";
        }
    }

    if(!good){
        good = false;
        $('#validtion_edii').val(message);
        $('#modaledit_incident').modal('hide');
        $('#editIncidentError').attr('data-backdrop', 'static');
        $('#editIncidentError').attr('data-keyboard', false);
        $('#editIncidentError').modal('show');
    }else{
        $.ajax({
            type: 'PUT',
            url: 'editIncident',
            data: $('#formEditIncident').serialize(),
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                if(data.length > 0 ){
                    location.reload();
                }
            }
        })
    }

});


$(document).on('click', '#battle_actions', function(){
    let incident = JSON.parse($(this).attr('data-incident'));
    $('#num_In').val(incident.number);
    $('#batt_inc').replaceWith(`<span style="color:yellow; margin-left:3em;" id="batt_inc">${incident.number}</span>`);
});


$(document).on('click', '#btnSaveBattle', function(){
    let good = true;
    let message = "";

    if(!$('#cat1').val().trim()){
        good = false;
        message+="Veuillez Renseigner La Catégorie Du Travail !\n";
    }else{
        if(!$('#description1').val().trim()){
            good = false;
            message+="Veuillez Décrire Le Travail !\n";
        }else{
            if(!$('#cat2').val().trim() && $('#description2').val().trim()){
                good = false;
                message+="Veuillez Renseigner La Catégorie Du Travail 2 !\n";
            }else if($('#cat2').val().trim() && !$('#description2').val().trim()){
                good = false;
                message+="Veuillez Renseigner La Description Du Travail 2 !\n";
            }
        }
    }

    if($('#cat2').val().trim() && !$('#cat1').val().trim()){
        good = false;
        message+="Veuillez Tout D'abord Renseigner Les Informations Du Travail 1 !\n";
    }
    if(!good){
        good = false;
        alert(message);
    }else{
        $.ajax({
            type: 'POST',
            url: "createBattle",
            data: $('#frm_bat').serialize(),
             headers:{
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             success: function(battle){
                if(battle.length > 0){         
                    $('#frm_bat')[0].reset();
                    alert('Travail Enrégistré Avec Succèss !');
                }
             }
        })    
    }
});


$(document).on('click', '#status1', function(){
    $('#numi').replaceWith(`<span id="numi">${JSON.parse($(this).attr('data-incident')).number}</span>`);
    $('#sta_edi_inci').attr('data-incident', $(this).attr('data-incident'));
});


$(document).on('click', '#define_prioriti', function(){
    $('#prior').replaceWith(`<strong class="badge badge-success" id="prior">${JSON.parse($(this).attr('data-incident')).number}</strong>`);
    $('#modif_s_i').attr('data-incident', $(this).attr('data-incident'))
});


$(document).on('click', '#modif_s_i', function(){
    let incident = JSON.parse($(this).attr('data-incident'));

    if($('#priority_it').val()){
        $.ajax({
            type: 'PUT',
            url: "updatePrioriteIncident",
            data: {
                priorite: $('#priority_it').val(),
                number: incident.number,
            },
            headers:{
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
             success: function(data){
                if(data.length > 0){
                    location.reload();
                }
             }
        });
    }else{
        $('#textprio').val('Veuillez Sélectionner Une Priorité !');
        $('#edit_priority_incident').modal('hide');
        $('#prioryty').attr('data-backdrop', 'static');
        $('#prioryty').attr('data-keyboard', false);
        $('#prioryty').modal('show');
    }
});


$(document).on('click', '#motas', function(){
    $('#moties').replaceWith(`<span class="badge badge-success" id="moties">${JSON.parse($(this).attr('data-incident')).number}</span></div>`);
    $('#anule').attr('data-incident', $(this).attr('data-incident'));
});


$(document).on('click', '#anule', function(){
    let incident = JSON.parse($(this).attr('data-incident'));

    if($('#mottifs').val()){
        $.ajax({
            type: 'PUT',
            url: 'setMotifAnnulation',
            data: {
                motif: $('#mottifs').val(),
                number: incident.number
            },
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                if(data.length > 0 ){
                    location.reload();
                }
            }
        });
    }else{
        $('#validtion_annu').val('Veuillez Renseigner Un Motif D\'annulation !')
        $('#motif_danul').modal('hide');
        $('#annulationError').attr('data-backdrop', 'static');
        $('#annulationError').attr('data-keyboard', false);
        $('#annulationError').modal('show');
    }
});


$(document).on('click', '#motiannulitions', function(){
    let incident = JSON.parse($(this).attr('data-incident'));
    $('#prioro').replaceWith(`<strong id="prioro">${incident.number}</strong>`);
    $('#tiffmo').val(incident.motif_annulation);
});


$(document).on('click', '#delete_incids', function(){
    let incident = JSON.parse($(this).attr('data-incident'));
    if(confirm("Voulez-vous Réelement Supprimer Cet Incident "+incident.number+" ?")){

        $.ajax({
            type: 'DELETE',
            url: 'deleteIncident',
            data: {
                number: incident.number
            },
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                if(data.length > 0 ){
                    location.reload();
                }
            }
        });

    }
});


$(document).on('click', '#due_date_set', function(){
    $('#nibi').replaceWith(`<strong class="badge badge-success" id="nibi">${JSON.parse($(this).attr('data-incident')).number}</strong>`);
    $('#echeance_btn_inc').attr('data-incident', $(this).attr('data-incident'));
});


$(document).on('click', '#echeance_btn_inc', function(){
    let incident = JSON.parse($(this).attr('data-incident'));
    if($('#date_due').val()){
        if(parseInt($('#date_due').val().replaceAll("-", "")) >= parseInt((new Date().toISOString().split('T')[0]).replaceAll("-", ""))){
            $.ajax({
                type: 'PUT',
                url: 'set_echeance_date',
                data: {
                    number: incident.number,
                    date: $('#date_due').val(),
                },
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                    if(data.length > 0 ){
                        location.reload();
                    }
                }
            });
        }else{
            $('#date_due').val('');
            $('#validation_due_date').val('Veuillez Renseigner Une Date D\'échéance Qui Est Supérieur Où Egale A La Date D\'aujourd\'huit ! \n');
            $('#define_dat_echean').modal('hide');
            $('#dued').attr('data-backdrop', 'static');
            $('#dued').attr('data-keyboard', false);
            $('#dued').modal('show');
        }
    }else{
        $('#validation_due_date').val('Veuillez Renseigner La Date D\'échéance De L\'incident !')
        $('#define_dat_echean').modal('hide');
        $('#dued').attr('data-backdrop', 'static');
        $('#dued').attr('data-keyboard', false);
        $('#dued').modal('show');

    }
});



$(document).on('change', 'select[name="esperance"]', function(){
    let categoryies = [];
    let categos = [];
    let categories = JSON.parse($(this).attr('data-categories'));

    if($(this).val()){
            $('#categorie').empty().append(`<option selected value="">Choisissez...</option>`);
        
            for (let index = 0; index < categories.length; index++) {
                const categorie = categories[index];
                
                if(categorie.site_id){
                if(parseInt(categorie.site_id) == parseInt($(this).val())){
                    categoryies.push(categorie);
                }}else{
                    categos.push(categorie);
                }
            }
    
            if(categoryies.length > 0){
                for (let i = 0; i < categoryies.length; i++) {
                    const cat = categoryies[i];
                    $('#categorie').append(`<option value="${cat.id}">${cat.name}</option>`);
                }    
            }else{
                $('#categorie').empty().append(`<option selected value="">Choisissez...</option>`);
                for (let i = 0; i < categos.length; i++) {
                    const cat = categos[i];
                    $('#categorie').append(`<option value="${cat.id}">${cat.name}</option>`);
                }
            } 
        
        
    }else{
        $('#categorie').empty();
    }
});


$(document).on('change', 'select[name="assignatdeepartes"]', function(){
    let categoryies = [];
    let categos = [];
    let categories = JSON.parse($(this).attr('data-categories'));
    let types = JSON.parse($(this).attr('data-types'));

    if($(this).val()){
            $('#categor').empty().append(`<option selected value="">Choisissez...</option>`);
        
            for (let index = 0; index < categories.length; index++) {
                const categorie = categories[index];
    
                if(categorie.site_id){
                if(parseInt(categorie.site_id) == parseInt($(this).val())){
                    categoryies.push(categorie);
                }}else{
                    categos.push(categorie);
                }
            }
    
            if(categoryies.length > 0){
                for (let i = 0; i < categoryies.length; i++) {
                    const cat = categoryies[i];
                    $('#categor').append(`<option value="${cat.id}">${cat.name}</option>`);
                }
            }else{
                $('#categor').empty().append(`<option value="">Choisissez...</option>`);
                for (let i = 0; i < categos.length; i++) {
                    const cat = categos[i];
                    $('#categor').empty().append(`<option value="${cat.id}">${cat.name}</option>`);
                }
            } 
        
        
    }else{
        $('#categor').empty();
    }
});


$(document).on('change', 'select[name="esperanceEdit"]', function(){
    let categoryies = [];
    let categos = [];
    let categories = JSON.parse($(this).attr('data-categories'));
    let types = JSON.parse($(this).attr('data-types'));

    if($(this).val()){
        $('#categorie_edit').empty().append(`<option selected value="">Choisissez...</option>`);
        
            for (let index = 0; index < categories.length; index++) {
                const categorie = categories[index];
    
                if(categorie.site_id){
                if(parseInt(categorie.site_id) == parseInt($(this).val())){
                    categoryies.push(categorie);
                }}else{
                    categos.push(categorie);
                }
            }
    
            if(categoryies.length > 0){
                for (let i = 0; i < categoryies.length; i++) {
                    const cat = categoryies[i];
                    $('#categorie_edit').append(`<option value="${cat.id}">${cat.name}</option>`);
                }    
            }else{
                $('#categorie_edit').empty().append(`<option selected value="">Choisissez...</option>`);
                for (let i = 0; i < categos.length; i++) {
                    const cat = categos[i];
                    $('#categorie_edit').append(`<option value="${cat.id}">${cat.name}</option>`);
                }
            }         
    }else{
        $('#categorie_edit').empty();
    }
});


$(document).on('click', '#btn_save_arching', function(){
    $.ajax({
        type: 'PUT',
        url: 'archiving',
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


$(document).on('click', '#dismiss_btn_edii', function(){
    $('#editIncidentError').modal('hide');
    $('#modaledit_incident').attr('data-backdrop', 'static');
    $('#modaledit_incident').attr('data-keyboard', false);
    $('#modaledit_incident').modal('show');
});


$(document).on('click', '#dismiss_btn_ude', function(){
    $('#dued').modal('hide');
    $('#define_dat_echean').attr('data-backdrop', 'static');
    $('#define_dat_echean').attr('data-keyboard', false);
    $('#define_dat_echean').modal('show');
});


$(document).on('click', '#dismiss_btn', function(){
    $('#Falco').modal('hide');
    $('#modal_incident').attr('data-backdrop', 'static');
    $('#modal_incident').attr('data-keyboard', false);
    $('#modal_incident').modal('show');
});


$(document).on('click', '#btnCloture', function(){
    $('#close_inc').modal('hide');
    $('#clos').attr('data-backdrop', 'static');
    $('#clos').attr('data-keyboard', false);
    $('#clos').modal('show');
});

$(document).on('click', '#btnpriorite', function(){
    $('#prioryty').modal('hide');
    $('#edit_priority_incident').attr('data-backdrop', 'static');
    $('#edit_priority_incident').attr('data-keyboard', false);
    $('#edit_priority_incident').modal('show');
});

$(document).on('click', '#dismiss_btn_annu', function(){
    $('#annulationError').modal('hide');
    $('#motif_danul').attr('data-backdrop', 'static');
    $('#motif_danul').attr('data-keyboard', false);
    $('#motif_danul').modal('show');
});

$(document).on('click', '#dismiss_dassign', function(){
    $('#error_dassign').modal('hide');
    $('#assignat').attr('data-backdrop', 'static');
    $('#assignat').attr('data-keyboard', false);
    $('#assignat').modal('show');
});


$(document).on('click', '#set_categ', function(){

    let incident = JSON.parse($(this).attr('data-incident'));

    $('#incassignt').replaceWith(`<strong class="badge badge-success" id="incassignt">${incident.number}</strong>`);

});

$(document).on('click', '#btn_assign', function(){
    if($('#categor').val()){

        $.ajax({
            type: 'PUT',
            url: 'assign_incident',
            data: {
                number: $('#incassignt').text(),
                categorie: $('#categor').val(),
            },
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                if(data.length > 0){
                    location.reload();
                }
            }
        });

    }else{

        $('#text_dassign').val('Veuillez Choisir Une Catégorie !');
        $('#assignat').modal('hide');
        $('#error_dassign').attr('data-backdrop', 'static');
        $('#error_dassign').attr('data-keyboard', false);
        $('#error_dassign').modal('show');

    }
});


$(document).on('change', '#set_departement_or_site', function(){

    let allSites = [];
    let sites = JSON.parse($(this).attr('data-sites'));
    let types = JSON.parse($(this).attr('data-types'));

    if($(this).val()){
        
        if(isNaN($(this).val())){

            for (let index = 0; index < types.length; index++) {
                const type = types[index];
                if(type.name == $(this).val()){
                    for (let j = 0; j < sites.length; j++) {
                        const site = sites[j];
                        if(site.type_id == type.id){
                            allSites.push(site);
                        }
                    }
                }
            }


            if(allSites.length > 0){

                $('#nino').remove();
                $('#devdocs').append(`
                    <div id="nino" class="form-group my-4">
                        <label for="sity"><span class="fe fe-navigation-2 mr-2"></span>Site Chargé De Resoudre L'incident<span style="color:red;"> *</span></label>
                        <select style="font-size: 1.2em;" data-sites="{{ $sites }}" class="form-control custom-select border-primary" id="sity" name="site_id">
                            <option selected value="">Choisissez...</option>
                        </select>
                    </div>
                `);
                for (let i = 0; i < allSites.length; i++) {
                    const sit = allSites[i];
                    $('#sity').append(`<option value="${sit.id}">${sit.name}</option>`);
                }

            }else{

                $('#nino').remove();
                $('#devdocs').append(`
                    <div id="nino" class="form-group my-4">
                        <label for="sity"><span class="fe fe-navigation-2 mr-2"></span>Site Chargé De Resoudre L'incident<span style="color:red;"> *</span></label>
                        <select style="font-size: 1.2em;" data-sites="{{ $sites }}" class="form-control custom-select border-primary" id="sity" name="site_id">
                            <option selected value="">Choisissez...</option>
                        </select>
                    </div>
                `);

                $('#sity').empty().append(`<option value="">AUCUNE OPTION DISPONIBLE</option>`);
            } 

        }else{
            $('#nino').remove();
        }
        
    }else{
        $('#nino').remove();
    }
});

//DEBUT A EFFACER
$(document).on('click', '#assign_elt_krilin', function(){

    let incident = JSON.parse($(this).attr('data-incident'));
    let sites = JSON.parse($(this).attr('data-sites'));
    let utilisateurs = JSON.parse($(this).attr('data-utilisateurs'));
    let departements = JSON.parse($(this).attr('data-departements'));
    let users_incidents = JSON.parse($(this).attr('data-users_incidents'));

    $('#kimeros').
    replaceWith(`
    <span id="kimeros" 
          class="badge badge-pill badge-success text-lg ml-4">
          ${incident.number}
    </span>`);

    let entiter = [];
    let mes_users_incidents = [];
    let entiter_utilisateurs = [];

    for (let i = 0; i < users_incidents.length; i++) {
        const ui = users_incidents[i];
        if(ui.incident_number == incident.number){
            mes_users_incidents.push(ui);
        }
    }

    for (let j = 0; j < mes_users_incidents.length; j++) {
        const iu = mes_users_incidents[j];
        
        let monUser = utilisateurs.find(u => u.id == iu.user_id);

        if(monUser){

            entiter_utilisateurs.push(monUser);

            if(monUser.departement_id){

                let depart = departements.find(d => d.id == monUser.departement_id);
    
                entiter.push(depart);
    
            }else if(monUser.site_id){
    
                let syt = sites.find(s => s.id == monUser.site_id);
    
                entiter.push(syt);
            }    
        }
    }

    for (let a = 0; a < entiter.length; a++) {
        const entite = entiter[a];
        
        $('#terunoki').append(`
                <div class="row my-4">
                    <div class="col-md-11">
                        <div 
                            class="row"
                            style="text-decoration:none; color:white;"
                        >
                            <div class="col-md-8 text-left">
                                <small class="text-xl mr-4">
                                <i class="fe fe-home mr-3"></i>
                                    ${entite.name}
                                </small>
                            </div>

                            <div class="col-md-3 text-right">
                                <small class="text-muted text-lg">
                                    ${entiter_utilisateurs[a].fullname}
                                </small>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-1">
                            <div class="file-action">
                                <button type="button" class="btn btn-link dropdown-toggle more-vertical p-0 text-muted mx-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="text-muted sr-only">Action</span>
                                </button>

                                <div class="dropdown-menu m-2">
                                    <a class="dropdown-item" href="#!"><i class="fe fe-x fe-16 mr-2"></i>Révoquer ${entiter_utilisateurs[a].fullname}</a>
                                    <a 
                                        class="dropdown-item" href="#!">
                                        <i class="fe fe-lock fe-16 mr-2"></i>Révoquer La Modification Des Infos
                                    </a>
                                </div>
                            </div>
                    </div>
            </div>
        `);
    }
    
});
// FIN



$(document).on('click', '#erreur_assign_et_btn', function(){
    $('#erreur_assign_et_edition').modal('hide');
    $('#Grimjow_jagerjack').attr('data-backdrop', 'static');
    $('#Grimjow_jagerjack').attr('data-keyboard', false);
    $('#Grimjow_jagerjack').modal('show');
});


$(document).on('change', 'select[name="deepartes_hila"]', function(){
    let allSites = [];
    let sites = JSON.parse($(this).attr('data-sites'));
    let types = JSON.parse($(this).attr('data-types'));

    if($(this).val()){
        
        if(isNaN($(this).val())){

            for (let index = 0; index < types.length; index++) {
                const type = types[index];
                if(type.name == $(this).val()){
                    for (let j = 0; j < sites.length; j++) {
                        const site = sites[j];
                        if(site.type_id == type.id){
                            allSites.push(site);
                        }
                    }
                }
            }


            if(allSites.length > 0){

                $('#nino').remove();
                $('#devdocs').append(`
                    <div id="nino" class="form-group my-4">
                        <label for="sity"><span class="fe fe-navigation-2 mr-4"></span>Site De L'incident <span style="color:red;"> *</span></label>
                        <select style="font-size: 1.2em;" class="form-control custom-select border-primary" id="sity">
                            <option selected value="">Choisissez...</option>
                        </select>
                    </div>
                `);

                for (let i = 0; i < allSites.length; i++) {
                    const sit = allSites[i];
                    $('#sity').append(`<option value="${sit.id}">${sit.name}</option>`);
                }

            }else{

                $('#nino').remove();
                $('#devdocs').append(`
                    <div id="nino" class="form-group my-4">
                        <label for="sity"><span class="fe fe-navigation-2 mr-4"></span>Site De L'incident <span style="color:red;"> *</span></label>
                        <select style="font-size: 1.2em;" class="form-control custom-select border-primary" id="sity">
                            <option selected value="">Choisissez...</option>
                        </select>
                    </div>
                `);

                $('#sity').empty().append(`<option value="">AUCUNE OPTION DISPONIBLE</option>`);
            } 

        }else{
            $('#nino').remove();
        }
        
    }else{
        $('#nino').remove();
    }
});

$(document).on('change', '#regina', function(){
    let allSites = [];
    let sites = JSON.parse($(this).attr('data-sites'));
    let types = JSON.parse($(this).attr('data-types'));

    if($(this).val()){
        
        if(isNaN($(this).val())){

            for (let index = 0; index < types.length; index++) {
                const type = types[index];
                if(type.name == $(this).val()){
                    for (let j = 0; j < sites.length; j++) {
                        const site = sites[j];
                        if(site.type_id == type.id){
                            allSites.push(site);
                        }
                    }
                }
            }


            if(allSites.length > 0){

                $('#nino').remove();
                $('#artefact_intelligence').append(`
                    <div id="nino" class="form-group my-4">
                        <label for="sity"><span class="fe fe-navigation-2 mr-4"></span>Site De L'incident <span style="color:red;"> *</span></label>
                        <select style="font-size: 1.2em;" class="form-control custom-select border-primary" name="city" id="sity_dome">
                            <option selected value="">Choisissez...</option>
                        </select>
                    </div>
                `);

                for (let i = 0; i < allSites.length; i++) {
                    const sit = allSites[i];
                    $('#sity_dome').append(`<option value="${sit.id}">${sit.name}</option>`);
                }

            }else{

                $('#nino').remove();
                $('#devdocs').append(`
                    <div id="nino" class="form-group my-4">
                        <label for="sity"><span class="fe fe-navigation-2 mr-4"></span>Site De L'incident <span style="color:red;"> *</span></label>
                        <select style="font-size: 1.2em;" class="form-control custom-select border-primary" name="city" id="sity_dome">
                            <option selected value="">Choisissez...</option>
                        </select>
                    </div>
                `);

                $('#sity_dome').empty().append(`<option value="">AUCUNE OPTION DISPONIBLE</option>`);
            }

        }else{
            $('#nino').remove();
        }
        
    }else{
        $('#nino').remove();
    }
});


$(document).on('click', '#btn_edit_incident_mappo', function(){
    
    let good = true;
    let message = "";

    if($('#regina').val()){

        if(isNaN($('#regina').val())){

            if(!$('#sity_dome').val()){
                good = false;
                message+="Veuillez Choisir Un Site !\n";
            }
        }
    }else{
        good = false;
        message+="Veuillez Choisir Un Site !\n";
    }

    if(!$('#observation_rex').val().trim()){
        good = false;
        message+="Veuillez Renseigner Une Observation Concernant L'incident !\n";
    }

    if(!good){
        good = false;
        $('#ulkior').val(message);
        $('#Grimjow_jagerjack').modal('hide');
        $('#erreur_assign_et_edition').attr('data-backdrop', 'static');
        $('#erreur_assign_et_edition').attr('data-keyboard', false);
        $('#erreur_assign_et_edition').modal('show');
    }else{
        $.ajax({
            type: 'PUT',
            url: 'editAndAssignIncident',
            data: $('#formEditIncident_mappo').serialize(),
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                if(data.length > 0){
                    location.reload();
                }
            }
        });
    }

});

$(document).on('click', '#cloture_rex', function(){

    let incident = JSON.parse($(this).attr('data-incident'));
    if(!incident.closure_date){
        $('#nibiru_number_rex').replaceWith(`<strong id="nibiru_number_rex">${incident.number}</strong>`);
        $('#Kloture_rex').attr('data-incident', JSON.stringify(incident));
        $('#clos_rex').attr('data-backdrop', 'static');
        $('#clos_rex').attr('data-keyboard', false);
        $('#clos_rex').modal('show');
    }
});


$(document).on('click', '#assign_elt_gohan', function(){

    let incident = JSON.parse($(this).attr('data-incident'));

    $('#number_incident_mappo').val(incident.number);
    $('#nimero_mappo').replaceWith(`<span class="badge badge-success" id="nimero_mappo">${incident.number}</span>`);

    $('.form-group #description_edit_mappo').val(incident.description);
    $('.form-group #cause_edit_mappo').val(incident.cause);
    $('.form-group #perimeter_edit_mappo').val(incident.perimeter);
    $('.form-group #battles_edit_mappo').val(incident.battles ? incident.battles : '');
    $('.form-group #prioritys_mappo').val(incident.priority);
    $('.form-group #caty_edit_mappo').val(incident.categories ? incident.categories.name : "");
    if(incident.due_date){
        $('.form-group #date_echeance_edit_mappo').val(incident.due_date);
    }

});

$(document).on('click', '#btn_clear_fields_edit_incident_mappo', function(){
    $('#formEditIncident_mappo')[0].reset();
});

$(document).on('click', '#groupage', function(){
    if($('#observation_rex').val()){
        $.ajax({
            type: 'PUT',
            url: 'incident_deja_pris_encompte',
            data: {
                number: $('#nimero_mappo').text(),
                observation: $('#observation_rex').val(),
            },
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                if(data.length > 0){
                    location.reload();
                }
            }
        });
    }else{
        alert('Veuillez Renseigner Une Observation !');
    }
});