$(document).on('click', '#toto', function(){
    $('#dismiss_task').hide();
});

$(document).on('click', '.saiyan', function(){
    let incident = JSON.parse($(this).attr('data-incident'));
    if(!incident.closure_date){
        $('#Kloture').attr('data-incident', JSON.stringify(incident));
        $(this).replaceWith(`<a style="text-decoration:none; color:green;" type="button" href="#" title="Clôturé Cet Incident" class="fe fe-toggle-right fe-32 saiyan"></a>`);
        $('#clos').attr('data-backdrop', 'static');
        $('#clos').attr('data-keyboard', false);
        $('#clos').modal('show');
    }
});

$(document).on('click', '#toggle', function(){
    let incident = JSON.parse($(this).attr('data-incident'));
    $('#nibiru').replaceWith(`<strong id="nibiru">${incident.number}</strong>`);
});

$(document).on('click', '#Kloture', function(){
    if($('#valeure').val() && $('#dotnet').val() && $('#cloture_comment').val()){
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
        console.log(tab);
        for (let index = 0; index < tab.length; index++) {
            const task = tab[index];
            if((task.status != "RÉALISÉ") && (task.status != "ANNULÉ")){
                count +=1;
            }
        }

        if(count == 0){
            $.ajax({
                type: 'PUT',
                url: "clotureIncident",
                data: {
                    number: incident.number,
                    valeur: $('#valeure').val(),
                    status: $('#dotnet').val(),
                    comment: $('#cloture_comment').val(),
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
            alert('Veuillez Réaliser Les Tâches De Cet Incident Avant De Le Clôturer !');
        }
    }else{
        alert('Veuillez Renseigner Les Champs !');
    }
});

$(document).on('click', '#infos_incident', function(){
    let departements = JSON.parse($(this).attr('data-departements'));
    let users = JSON.parse($(this).attr('data-users'));
    let users_incidents = JSON.parse($(this).attr('data-users_incidents'));
    let incident = JSON.parse($(this).attr('data-number'));
    let tasks = JSON.parse($(this).attr('data-task'));
    
    let count = 0;
    for (let index = 0; index < tasks.length; index++) {
        const task = tasks[index];
        if(parseInt(task.incident_number) == parseInt(incident.number)){
            count +=1;
        }
    }
    $('#inf_number').replaceWith(`<span class="inf_number">${incident.number}</span>`);
    $('.desc').replaceWith(`<span class="desc">${incident.description}</span>`);
    $('.cose').replaceWith(`<span class="cose">${incident.cause}</span>`);
    $('.perim').replaceWith(`<span class="desc">${incident.perimeter}</span>`);
    $('.tac').replaceWith(`<span class="tac">${count}</span>`);

    let mon_user = users_incidents.find((u => u.incident_number == incident.number) && (u.isTrigger === true));
    if(mon_user){
        let Utilisateur = users.find(u => u.id == mon_user.user_id);
        if(Utilisateur){
            var dept = departements.find(d => d.id == Utilisateur.departement_id);
        }
    }
    $('.deep').replaceWith(`<span class="deep">${dept ? dept.name : ''}</span>`)
});

$(document).on('click', '.incd', function(){
    $('#hids').val($(this).attr('data-id'));
    $('#txt_num_i').replaceWith(`<span id="txt_num_i" style="margin-left: 13em;" class="text">${$(this).attr('data-id')}</span>`)
});

$(document).ready(function() {
    $("#searchDate").on("change", function() {
        var value = $(this).val().toLowerCase();
        $(".agencies tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });

    $("#validationCustom04").on("change", function() {
      var value = $(this).val().toLowerCase();
      $(".agencies tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
});

$(document).ready(function() {
    // $('#year_courant_incident').val(new Date().getFullYear());
    // $(".agencies tr").filter(function() {
    //     $(this).toggle($(this).text().toLowerCase().indexOf(new Date().getFullYear()) > -1)
    // });

    $("#year_courant_incident").on("change", function() {
      var value = $(this).val().toLowerCase();
      $(".agencies tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
});


$(document).on('click', '#c1', function(){
    let a = $("input[name='radi']:checked").val();
    if(a){
        $('#espoir').hide();
        $('#dismiss_task').show();
    }else{
        $('#dismiss_task').hide();       
        $('#espoir').show();
    }
});

let tasks = [];
let taches = [];

$(document).on('click', '#btn_add_unique_task', function(){
    let good = true;
    let message = "";

    if(!$('#task_unique').val().trim()){
        good = false;
        message+="Veuillez Renseigner L'Intitulé De La Tâche !\n";
    }
    if(!$('#desc_unique').val().trim()){
        good = false;
        message+="Veuillez Renseigner La Description Ou Le But De La Tâche !\n";
    }
    if(!$('#date_echeance_unique').val()){
        good = false;
        message+="Veuillez Renseigner La Date D'échéance De La Tâche !\n";
    }
    if(!$('#user_task_unique').val()){
        good = false;
        message+="Veuillez Assigner Un Utilisateur A La Tâche !\n";
    }

    if(!good){
        good = false;
        $('#validtion_task').val(message);
        $('#modal_task').modal('hide');
        $('#FalcoTas').attr('data-backdrop', 'static');
        $('#FalcoTas').attr('data-keyboard', false);
        $('#FalcoTas').modal('show');
    }else{
        $('#apropos_conf').replaceWith(`
        <textarea style="color:white; background-color: #33393F;" disabled name="" id="apropos_conf" cols="30" rows="4">
            ${$('#task_unique').val()}
        </textarea>`);
        $('#decrit_conf').replaceWith(`
        <textarea style="color:white; background-color: #33393F;" disabled name="" id="decrit_conf" cols="30" rows="4">
            ${$('#desc_unique').val()}
        </textarea>`);
        $('#eche_conf').replaceWith(`<span style="color: white; font-size: 20px;" id="eche_conf">${$('#date_echeance_unique').val()}</span>`);
        $('#gerant_conf').replaceWith(`<span style="color: white; font-size: 20px;" id="gerant_conf">${$('#user_task_unique option:selected').text()}</span>`);
        $('#modalConfirmationSaveTask').attr('data-backdrop', 'static');
        $('#modalConfirmationSaveTask').attr('data-keyboard', false);
        $('#modalConfirmationSaveTask').modal('show');
    }
});

$(document).on('click', '#conf_save_t', function(){
    $.ajax({
        type: 'POST',
        url: "createTask",
        data: $('#frmtach').serialize(),
         headers:{
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         success: function(task){
            if(task.length > 0){              
                $('#frmtach')[0].reset();
                $('#modalConfirmationSaveTask').modal('toggle');
            }
         }
    })
});


$(document).on('click', '#btn_add_task', function(){
    let good = true;
    let message = "";

    if(!$('#desc').val().trim()){
        good = false;
        message+="Veuillez Renseigner La Description Ou Le But De La Tâche !\n";
    }
    if(!$('#date_echeance').val()){
        good = false;
        message+="Veuillez Renseigner La Date D'échéance De La Tâche !\n";
    }
    if(!$('#departement_task').val()){
        good = false;
        message+="Veuillez Assigner Un Département A La Tâche !\n";
    }

    if(!good){
        good = false;
        $('#validation').val(message);
        $('#modal_incident').modal('hide');
        $('#Falco').attr('data-backdrop', 'static');
        $('#Falco').attr('data-keyboard', false);
        $('#Falco').modal('show');
    }else{
        let task = {
            description: $('#desc').val(),
            date_echeance: $('#date_echeance').val(),
            departement: $('#departement_task').val(),
        };
        tasks.push(task);
        $('#number_task').replaceWith(`<i id="number_task">${tasks.length}</i>`);
        $('#btn_display').append(`<button id="btn_count_task" title="Annuler Cette Tâche" data-title="${task.title}" class="badge badge-pill badge-success mr-1">${tasks.length}<i class="fe fe-16 fe-trash-2"></i></button>`);            
        $('#form_tache')[0].reset();
    }
});

$(document).on('click', '#btn_count_task', function(){
    for (let index = 0; index < tasks.length; index++) {
        const task = tasks[index];
        if(task.title != $(this).attr('data-title')){
            taches.push(task);
        }
    }
    $('#number_task').replaceWith(`<i id="number_task">${taches.length}</i>`);
    tasks = [];
    for (let index = 0; index < taches.length; index++) {
        const t = taches[index];
        tasks.push(t);
    }
    taches = [];
    $(this).remove();
});

$(document).on('click', '#btn_reset_task', function(){
    for (let index = 0; index < tasks.length; index++) {
        $('#btn_count_task').remove();
    }
    tasks = [];
    taches = [];
    $('#number_task').replaceWith(`<i id="number_task">0</i>`);
});


$(document).on('click', '#dismiss_btn', function(){
    $('#Falco').modal('hide');
    $('#modal_incident').attr('data-backdrop', 'static');
    $('#modal_incident').attr('data-keyboard', false);
    $('#modal_incident').modal('show');
});


$(document).on('click', '#dismiss_btn_tasq', function(){
    $('#FalcoTas').modal('hide');
    $('#modal_task').attr('data-backdrop', 'static');
    $('#modal_task').attr('data-keyboard', false);
    $('#modal_task').modal('show');
});


$(document).on('click', 'button[name="buttonAddingIncidants"]', function(){
    let good = true;
    let message = "";

    // if(tasks.length == 0){
    //     good = false;
    //     message+="Veuillez Ajouter Une Tâche A Cette Incident !\n";
    // }

    if(!$('#description').val().trim()){
        good = false;
        message+="Veuillez Décrire L'incident !\n";
    }
    if(!$('#cause').val().trim()){
        good = false;
        message+="Veuillez Spécifier La Cause De L'incident !\n";
    }
    if(!$('#categorie').val()){
        good = false;
        message+="Veuillez Choisir La Catégorie De L'incident !\n";
    }
    if(!$('#process_incdent').val()[1]){
        good = false;
        message+="Veuillez Choisir Le(s) Procéssus Impacté(s) Par L'incident !\n";
    }
    if(!$('#priority').val()){
        good = false;
        message+="Veuillez Renseigner La Priorité De L'incident !\n";
    }

    if(!$('#date_echeance_incident').val()){
        good = false;
        message+="Veuillez Renseigner La Date D'échéance De L'incident !\n";
    }

    if(!good){
        good = false;

        $('#validation').val(message);
        $('#modal_incident').modal('hide');
        $('#Falco').attr('data-backdrop', 'static');
        $('#Falco').attr('data-keyboard', false);
        $('#Falco').modal('show');
    }else{

        let process = JSON.parse($(this).attr('data-processus'));

        $('#description_conf').replaceWith(`
        <textarea style="background-color: #343A40; color:white; resize:none;" disabled name="" id="description_conf" cols="30" rows="3">${$('#description').val()}</textarea>`);   
        $('#cause_conf').replaceWith(`
        <textarea style="background-color: #343A40; color:white; resize:none;" disabled name="" id="cause_conf" cols="30" rows="3">${$('#cause').val()}</textarea>`);   
        $('#perimeter_conf').replaceWith(`<span style="color: white; font-size: 20px;" id="perimeter_conf">${$('#perimeter').val()}</span>`);
        $('#categorie_conf').replaceWith(`<span style="color: white; font-size: 20px;" id="categorie_conf">${$('#categorie option:selected').text()}</span>`);
        $('#menees_actions_conf').replaceWith(`<span style="color: white; font-size: 20px;" id="menees_actions_conf">${$('#battles').val()}</span>`);

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
        <textarea style="background-color: #343A40; color:white; resize:none;" disabled name="" id="process_conf" cols="30" rows="3">${elt}</textarea>`);
        
        for (let index = 0; index < tasks.length; index++) {
            const task = tasks[index];
            $('#tbodys').append(`
                <tr id="tachesss">
                    <td>
                        <span class="text">Tache N° ${index+1}</span>
                    </td>
                    <td>
                        <textarea style="background-color: #343A40; color:white; resize:none;" disabled name="" cols="30" rows="3">${task.title}</textarea>
                    </td>
                </tr>
            `);
        }
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
                due_date: $('#date_echeance_incident').val(),
                priority: $('#priority').val(),
                description: $('#description').val(),
                cause: $('#cause').val(),
                categorie_id: $('#categorie').val(),
                processus_id: $('#process_incdent').val(),
                perimeter: $('#perimeter').val(),
                battles: $('#battles').val(),
                taches: tasks,
              },
         headers:{
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         success: function(data){
            if(data.length > 0){
                for (let index = 0; index < tasks.length; index++) {
                    $('#btn_count_task').remove();
                }
                for (let index = 0; index < tasks.length; index++) {
                    $('#tachesss').remove();
                }
                tasks = [];
                taches = [];

                $('#number_task').replaceWith(`
                <span class="badge badge-pill badge-primary"><i id="number_task">0</i></span>`);
                let incident = data[0];

                $('#dataTable-1 .agencies').prepend(`
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input">
                            <label class="custom-control-label"></label>
                        </div>
                    </td>
                    <td>${ incident.number }</td>
                    <td>${ incident.description }</td>
                    <td>${ incident.closure_date ? incident.closure_date : '' }</td>
                    <td>${ incident.processus.name }</td>
                    <td>${ incident.categories.name }</td>
                    <td></td>
                    <td>
                        <a 
                            style="text-decoration:none; color: white;" 
                            href="{{ route('listedTask', ['number' => ${incident.number}]) }}" 
                            title="Liste Des Tâches De L'incident">
                            <small class="text-white text-lg mr-1">00</small>
                            <span class="fe fe-list"></span>
                            <span class="fe fe-check"></span>
                        </a>
                    </td>
                    <td><a style="text-decoration:none; color:white;" type="button" href="{{ route('printIncident', ['number' => ${incident.number}]) }}" title="Imprimer Cet Incident" class="fe fe-printer fe-32"></a></td>
                    <td>
                        <a 
                            type="button" 
                            href="#" 
                            title="Cloturer Cet Incident"
                            style="text-decoration:none; color:white;"
                            class="fe fe-toggle-left fe-32 saiyan">
                        </a>
                    </td>
                    <td>
                        <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="text-muted sr-only">Action</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#"><span class="fe fe-edit-2 mr-2"></span>Editer</a>
                            <a class="dropdown-item" href="#"><span class="fe fe-trash mr-2"></span>Annuler</a>
                            <a class="dropdown-item" href="#"><span class="fe fe-eye mr-2"></span>Voir Infos Incident</a>
                            <a
                                class="dropdown-item mb-1"
                                href="{{ route('viewUser', ['number' => ${incident.number}]) }}">
                                <span class="fe fe-eye"></span>
                                <span class="fe fe-eye mr-2"></span>
                                Voir Technicien(s) Incident
                            </a>
                            <a class="dropdown-item" href="#"><span class="fe fe-x mr-2"></span>Supprimer</a>
                            <a class="dropdown-item" href="#"><span class="fe fe-list mr-4"></span> Liste Des Tâches</a>
                        </div>
                    </td>
                </tr>
                `);
                $('#form_incident')[0].reset();
                $('#modalConfirmationSaveIncident').modal('toggle');
            }
         }
    });
});

$(document).on('click', '#non_confirmation', function(){
    for (let index = 0; index < tasks.length; index++) {
        $('#tachesss').remove();
    }
});

$(document).on('click', '#btn_clear_fields', function(){
    $("#form_tache")[0].reset();
});

$(document).on('click', '#btn_clear_fields', function(){
    $("#frmtach")[0].reset();
});

$(document).on('click', '#btn_clear_fields_incident', function(){
    $("#form_incident")[0].reset();
});

$(document).on('click', '#btnExitModalIncident, #btnExitModalTask, #btnExitModalCloture, #bat_boy', function(){
    location.reload();
});



$(document).on('click', '#btn_edit_in', function(){

    let incident = JSON.parse($(this).attr('data-incident'));
    $('#nimero').replaceWith(`<span id="nimero" class="ml-4 text-xl">${incident.number}</span>`);
    $('.form-group #incid').val(incident.number);
    $('.form-group #description_edit').val(incident.description);
    $('.form-group #cause_edit').val(incident.cause);
    $('.form-group #perimeter_edit').val(incident.perimeter);
    $('.form-group #battles_edit').val(incident.battles ? incident.battles : '');
    $('.form-group #categorie_edit').val(incident.categorie_id);
    $('.form-group #process').val(incident.proces_id);
    $('.form-group #prioritys').val(incident.priority);
    $('.form-group #date_echeance_edit').val(incident.due_date);
})

$(document).on('click', '#dismiss_btn_edii', function(){
    $('#editIncidentError').modal('hide');
    $('#modaledit_incident').attr('data-backdrop', 'static');
    $('#modaledit_incident').attr('data-keyboard', false);
    $('#modaledit_incident').modal('show');
});


$(document).on('click', '#btn_edit_incident', function(){
    let good = true;
    let message = "";

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
    if(!$('#process_edit').val()[1]){
        good = false;
        message+="Veuillez Choisir Le(s) Procéssus Impacté Par L'incident !\n";
    }
    if(!$('#prioritys').val()){
        good = false;
        message+="Veuillez Renseigner La Priorité De L'incident !\n";
    }
    if(!$('#date_echeance_edit').val()){
        good = false;
        message+="Veuillez Renseigner La Date D'échéance De L'incident !\n";
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

$(document).on('click', '#btnDelete', function(){
    // let sites = JSON.parse($(this).attr('data-sites'));
    // let good = true;

    // sites.forEach(site => {
    //     if(site.region_id == parseInt($(this).attr('data-id'))){good = false;}
    // });
    // if(good){
        if(confirm("Voulez-Vous Vraiment Supprimer Cette Recètte : "+ $(this).attr('data-nature') +" ?") == true){
                $.ajax({
                    type: 'GET',
                    url: 'deleteRecette',
                    data: { id: $(this).attr('data-id')},
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(){
                        location.reload();
                    }
            })
        }
    // }else{
    //     $('#validation').val("Vous Ne Pouvez Pas Supprimer Cette Région : "+ $(this).attr('data-intituleRegion') +" Car Il Est Associé A Un Site !");
    //     $('#errorvalidationsModals').attr('data-backdrop', 'static');
    //     $('#errorvalidationsModals').attr('data-keyboard', false);
    //     $('#errorvalidationsModals').modal('show');        
    // }
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

$(document).on('click', '#sta_edi_inci', function(){
    let taches = JSON.parse($(this).attr('data-taches'));
    let incident = JSON.parse($(this).attr('data-incident'));
    
    if($('#stat_chs').val()){
        let tasks = [];
        let nbr = 0;
        for (let index = 0; index < taches.length; index++) {
            const tache = taches[index];
            if(parseInt(tache.incident_number) == parseInt(incident.number)){
                tasks.push(tache);
            }
        }

        for (let index = 0; index < tasks.length; index++) {
            const task = tasks[index];
            if(task.status == "EN-RÉALISATION"){
                nbr +=1;
            }
        }

        if(nbr == 0){
            $.ajax({
                type: 'PUT',
                url: "updateStatusIncident",
                data: {
                    status: $('#stat_chs').val(),
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
            alert("Veuillez D'abord Clôturé Toutes Les Tâches De L'incident !");
        }
    }else{
        alert('Veuillez Sélèctionner Un Statut !');
    }
});

$(document).on('click', '#define_prioriti', function(){
    $('#prior').replaceWith(`<span id="prior">${JSON.parse($(this).attr('data-incident')).number}</span>`);
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
        alert('Veuillez Sélèctionner Une Priorité !');
    }
});

$(document).on('click', '#motas', function(){
    $('#moties').replaceWith(`<span id="moties">${JSON.parse($(this).attr('data-incident')).number}</span></div>`);
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
        alert("Veuillez Renseigner Un Motif D'annulation !");
    }
});

$(document).on('click', '#motiannulitions', function(){
    let incident = JSON.parse($(this).attr('data-incident'));
    $('#prioro').replaceWith(`<span id="prioro">${incident.number}</span>`);
    $('#tiffmo').val(incident.motif_annulation);
});

$(document).on('click', '#delete_incids', function(){
    if(confirm("Voulez-vous Réelement Supprimer Cet Incident ?")){
        let incident = JSON.parse($(this).attr('data-incident'));
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

$(document).on('click', '#assign_other_user', function(){
    let incident = JSON.parse($(this).attr('data-incident'));
    $('#asign_te').replaceWith(`<span id="asign_te">${incident.number}</span>`)
    $('#save_assign').attr('data-incident', $(this).attr('data-incident'));
});

$(document).on('click', '#save_assign', function(){
    let incident = JSON.parse($(this).attr('data-incident'));

    if($('#users_s').val()){
        $.ajax({
            type: 'POST',
            url: 'assign_user',
            data: {
                number: incident.number,
                id_user: $('#users_s').val(),
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
        alert('Veuillez Sélèctionner Un Utilisateur !');
    }
});

$(document).on('click', '#due_date_set', function(){
    $('#echeance_btn_inc').attr('data-incident', $(this).attr('data-incident'));
});

$(document).on('click', '#echeance_btn_inc', function(){
    let incident = JSON.parse($(this).attr('data-incident'));

    if($('#date_due').val()){
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
        alert('Veuillez Renseigner La Date D\'échéance De L\'incident !');
    }
});

