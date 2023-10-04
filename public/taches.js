$(document).on('click', '#btnExitModalTask', function(){
    location.reload();
});

$(document).on('click', '#close_page_chargement_fichier', function(){
    $('#inputfile').val('');
    $('#btn_uploads').prop('disabled', true);
});


$(document).on('click', '#btn_clear_fields', function(){
    $('#frmtasks')[0].reset();
});

$(document).on('click', '#btn_clear_fields_edit', function(){
    $('#frmedittasks')[0].reset();
});

$(document).on('click', '#btnKali', function(){
    location.reload();
});


$(document).on('click', '#btn_tach_err_ok', function(){
    $('#tache_error_validations').modal('hide');
    $('#modal_task').attr('data-backdrop', 'static');
    $('#modal_task').attr('data-keyboard', false);
    $('#modal_task').modal('show');
});

$(document).on('click', '#toto', function(){

    let incident = JSON.parse($(this).attr('data-incident'));
    console.log(incident)
    $('#txt_num_i').replaceWith(`<span id="txt_num_i" style="margin-left: 13em;" class="text-xl badge badge-success">${incident.number}</span>`);
    $('#inco').val(incident.number);

    if(incident.status == "ENCOURS"){
        $('#modal_task').attr('data-backdrop', 'static');
        $('#modal_task').attr('data-keyboard', 'false');
        $('#modal_task').attr('data-toggle', 'modal');
        $('#modal_task').modal('show');

    }else{

        $('#eror_task_add_in').attr('data-backdrop', 'static');
        $('#eror_task_add_in').attr('data-keyboard', 'false');
        $('#validat_tsk').val("Vous Ne Pouvez Pas Ajoutez De Tâche A Un Incident Clôturé !");
        $('#eror_task_add_in').modal('show');

    }
});

$(document).on('click', '#btn_add_unique_task', function(){
    let good = true;
    let message = "";

    if(!$('#desc_unique').val().trim()){
        good = false;
        message+="Veuillez Renseigner La Description Où Le But De La Tâche !\n";
    }

    if(!$('#obs_task').val().trim()){
        good = false;
        message+="Veuillez Renseigner Une Observation De La Tâche !\n";
    }

    if(!$('#date_echeance_unique').val()){
        good = false;
        message+="Veuillez Renseigner La Date D'échéance De La Tâche !\n";
    }else{
        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
        let date_saisi = parseInt($('#date_echeance_unique').val().replaceAll("-", ""));
        if(date_saisi < today){
            good = false;
            message +="Veuillez Renseigner Une Date D\'échéance Qui Est Supérieur Où Egale A La Date D'aujourd'huit ! \n";
        }
    }

    if(!$('#deepartes').val()){
        good = false;
        message += "Veuillez Choisir Le Site Chargé De Resoudre L'incident ! \n";
    }

    if(!good){
        good = false;
        $('#modal_task').modal('hide');
        $('#validation').val(message);
        $('#tache_error_validations').attr('data-backdrop', 'static');
        $('#tache_error_validations').attr('data-keyboard', false);
        $('#tache_error_validations').modal('show');
    }else{
        $('#decrit_conf').replaceWith(`
        <textarea class="text-lg bg-light" style="resize:none;" disabled name="" id="decrit_conf" rows="8">
            ${$('#desc_unique').val()}
        </textarea>`);

        $('#obss_conf').replaceWith(`
            <textarea class="text-lg bg-light" style="resize:none;" disabled name="" id="obss_conf" rows="8">${$('#obs_task').val()}</textarea>
        `);

        $('#dsis_conf').replaceWith(`<span class="bg-light" style="font-size: 20px;" id="dsis_conf">${$('#number_ds_task').val()}</span>`);
        $('#eche_conf').replaceWith(`<span class="bg-light" style="font-size: 20px;" id="eche_conf">${$('#date_echeance_unique').val()}</span>`);
        
        if(isNaN($('#deepartes').val())){
            $('#gerant_conf').replaceWith(`<span class="bg-light" style="font-size: 20px;" id="gerant_conf">${$('#sity option:selected').text()}</span>`);
        }else{
            $('#gerant_conf').replaceWith(`<span class="bg-light" style="font-size: 20px;" id="gerant_conf">${$('#deepartes option:selected').text()}</span>`);
        }

        $('#modalConfirmationSaveTask').attr('data-backdrop', 'static');
        $('#modalConfirmationSaveTask').attr('data-keyboard', false);
        $('#modal_task').modal('hide');
        $('#modalConfirmationSaveTask').modal('show');
    }
});


$(document).on('click', '#infir_save_t', function(){
    $('#modal_task').attr('data-backdrop', 'static');
    $('#modal_task').attr('data-keyboard', false);
    $('#modal_task').modal('show');
});


$(document).on('click', '#conf_save_t', function(){
    $.ajax({
        type: 'POST',
        url: "createTask",
        data: $('#frmtasks').serialize(),
         headers:{
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         success: function(data){
            if(data.length > 0){
                let task = data[0];

                $('#dataTable-1 .tachsx').prepend(`
                    <tr>
                        <td></td>
                        <td></td>
                        <td><p class="mb-0 text-muted">${task.description}</p></td>
                        <td>                            
                            <a
                                id="modif_stay_tach"
                                data-key=""
                                ${task.status} == 'ENCOURS' ? style="color: #EEA303; text-decoration:none;":${task.status} == 'RÉALISÉE' ? style="color: #3ABF71; text-decoration:none;":style="color: #1B68FF; text-decoration:none;"
                                href="#"
                                data-backdrop="static"
                                data-keyboard="false" 
                                data-toggle="modal"
                                data-target="#change_status">
                                ${task.status}
                            </a>
                        </td>
                        <td></td>
                        <td>${task.maturity_date}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <a
                                id="set_priority_degr"
                                href="#"
                                style="text-decoration:none;"
                                data-backdrop="static"
                                data-keyboard="false"
                                data-toggle="modal"
                                data-target="#update_degree">
                                ${task.resolution_degree}
                            </a>
                        </td>
                        <td><a
                                    style="text-decoration:none;"
                                    data-backdrop="static"
                                    data-keyboard="false" 
                                    data-toggle="modal" 
                                    data-target="#defaultModal"
                                    href="/" 
                                    title="Joindre Le Fichier Justificatif" 
                                    class="fe fe-upload-cloud fe-32 files_id">
                            </a>
                        </td>
                        <td>
                            <a 
                                style="text-decoration:none; color:white;"
                                href="#!" 
                                title="Télécharger Le Fichier De La Tâche"
                                class="fe fe-download-cloud fe-32">
                            </a>
                        </td>
                        <td></td>
                        <td>
                                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="text-muted sr-only">Action</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                <a 
                                id="ask_service"
                                class="dropdown-item"
                                href="#"
                                data-backdrop="static"
                                data-keyboard="false"
                                data-toggle="modal"
                                data-target="#serviceAski" ><span class="fe fe-smile mr-4"></span>Demande De Service
                                </a>
                                    <a class="dropdown-item" href="#"><span class="fe fe-edit-2 mr-4"></span> Editer</a>
                                    <a class="dropdown-item" href="#"><span class="fe fe-trash mr-4"></span> Annuler</a>
                                    <a class="dropdown-item" href="#"><span class="fe fe-x mr-4"></span> Supprimer</a>
                                </div>
                        </td>
                    </tr>
                `);
            $('#frmtasks')[0].reset();
            $('#modalConfirmationSaveTask').modal('toggle');
            $('#modal_task').modal('show');
            }
         }
    })
});

$(document).ready(function() {

    table = $('#dataTable-1').DataTable({
        destroy: true,
        paging: false,
        searching: false,
    });


    $("#departe").on("change", function() {
        
        $('#searchDate').val('');
        $('#search_text_simple').val('');
        $('#validationCustom04').val('');

        var value = $(this).val().toLowerCase();
        $(".tachsx tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
  
    $("#validationCustom04").on("change", function() {

        $('#searchDate').val('');
        $('#search_text_simple').val('');
        $('#departe').val('');

        var value = $(this).val().toLowerCase();
        $(".tachsx tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $("#searchDate").on("change", function() {

        $('#departe').val('');
        $('#search_text_simple').val('');
        $('#validationCustom04').val('');

        var filter = $(this).val();
        var table = document.getElementById("dataTable-1");
        var tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[5];
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
        $('#departe').val('');
        $('#searchDate').val('');
        $('#validationCustom04').val('');

        var value = $(this).val().toLowerCase();
        $(".tachsx tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    $(document).on('change', '#emis_recus', function(){
        $('#departe').val('');
        $('#searchDate').val('');
        $('#search_text_simple').val('');
        $('#validationCustom04').val('');
        $('#year_courant_incident').val('');


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

});

$(document).on('click', '.files_id', function(){
    let key = $(this).attr('data-key');
    let task = JSON.parse($(this).attr('data-task'));
    $('#id_task').val(task.id);
    $('.ispad').replaceWith(`<span class="ispad badge badge-success text-lg">${task.incident_number}</span>`);
    $('.radjad').replaceWith(`<span class="radjad text-xl">${key}</span>`);
});

$(document).on('click', '.down_id', function(){
    let key = $(this).attr('data-key');
    let task = JSON.parse($(this).attr('data-task'));
    let files = JSON.parse($(this).attr('data-files'));
    let files_task = [];
    $('.zaya').replaceWith(`<span class="zaya badge badge-success text-lg">${task.incident_number}</span>`);
    $('.citedor').replaceWith(`<span class="citedor text-xl">${key}</span>`);

    $('#idtach').val(task.id);

    for (let index = 0; index < files.length; index++) {
        const file = files[index];
        if(parseInt(file.tache_id) == parseInt(task.id)){
            files_task.push(file);
        }
    }

    if(files_task.length == 0){
        $('#span_info').replaceWith(`<span id="span_info" style="font-size: 1em; text-align: center; margin-bottom:1em;"><i class="fe fe-file fe-32"></i><i class="fe fe-x fe-16 mr-2"></i> Aucun Fichier Charger Pour Cette Tâche</span>`);
    }else{
        $('#span_info').replaceWith(`<span id="span_info" style="font-size: 1em; text-align: center; margin-bottom:1em;"><i class="fe fe-file fe-32 mr-2"></i> TéléCharger Le(s) Fichier(s) De Réalisation De La Tâche</span>`);
    }

    for (let index = 0; index < files_task.length; index++) {
        const file = files_task[index];

        $('#bakugo').append(`
            <div class="row" id="roys${index}">
                <div class="col-md-6 text-left" style="margin-top: 3em;">
                    <span style="font-size:15px;">${file.filename.substring(7)}</span>
                </div>

                <div class="col-md-4 text-right">
                    <button title="Télécharger Le Fichier" data-file_id="${file.id}" class="mt-4 squircle bg-primary border-primary justify-content-center" name="submit_download" type="submit">
                        <span class="fe fe-download fe-32 align-self-center text-white"></span>
                    </button>
                </div>
                <div class="col-md-2" style="margin-top: 3em;">
                    <span 
                        id="remove_file_task"
                        data-index="roys${index}"
                        data-file="${file.id}"
                        data-task_id="${file.tache_id}"
                        title="Supprimer Le Fichier Charger" 
                        class="fe fe-32 fe-x text-danger" 
                        style="cursor:pointer;">
                    </span>
                </div>
            </div>
        `);
    }
});

$(document).on('click', '#remove_file_task', function(){
    let id_fichier = $(this).attr('data-file');
    let index_row = $(this).attr('data-index');
    let id_tache = $(this).attr('data-task_id');

    $.ajax({
        type: 'DELETE',
        url: "delete_file",
        data: {
            id: id_fichier,
            id_Task: id_tache,
        },
         headers:{
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         success: function(data){
            if(data.length > 0){
                $(`#${index_row}`).remove();
            }
         }
    })    

});


$(document).on('click', '#see_task', function(){
    let numero_ligne = $(this).attr('data-key');
    let task = JSON.parse($(this).attr('data-task'));
    $('.obbs_tas').replaceWith(`<span class="text-xl obbs_tas">${task.observation_task}</span>`);
    $('.nidis').replaceWith(`<span class="nidis badge badge-pill badge-success">${task.incident_number}</span>`);
    $('#burpi').replaceWith(`<span id="burpi">${numero_ligne}</span>`);
    $('.creat_dat').replaceWith(`<span class="text-xl creat_dat">${task.created_at.substring(0, 10)}</span>`);
    $('.due_dat').replaceWith(`<span class="text-xl due_dat">${task.maturity_date}</span>`);
    $('.desc').replaceWith(`<span class="text-xl desc">${task.description}</span>`);
    $('.comment_show').replaceWith(`<span class="text-xl comment_show">${task.commentaire ? task.commentaire : ''}</span>`);
    $('.observation_show').replaceWith(`<span class="text-xl observation_show">${task.observation ? task.observation : ''}</span>`);
    $('.motif_an').replaceWith(`<span class="text-xl motif_an">${task.motif_annulation ? task.motif_annulation : ''}</span>`);
    $('.motif_misenatou').replaceWith(`<span class="text-xl motif_misenatou">${task.motif_attente ? task.motif_attente : ''}</span></div>`);
});

$(document).on('click', 'button[name="submit_download"]', function(){
    $('#midoriya').val($(this).attr('data-file_id'));
});

$(document).on('click', '#btnExitModalStatus', function(){
    $('#statut_e').val('');
    $('#segment').empty();
});

$(document).on('click', '#exit_modal_down', function(){
    location.reload();
});

$(document).on('click', '#vue_other_infos_incident, #infos_incident', function(){
    $.ajax({
        type: 'GET',
        url: "get_un_incident",
        data: {
            number : $(this).attr('data-number'),
        },
         headers:{
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         success: function(incident){
            
            let categories = JSON.parse($('#vue_other_infos_incident').attr('data-categories'));
            let processus = JSON.parse($('#vue_other_infos_incident').attr('data-processus'));
            let sites = JSON.parse($('#vue_other_infos_incident').attr('data-sites'));

            let cate = categories.find(c => c.id == incident.categorie_id);
            let pro = processus.find(p => p.id == incident.proces_id);
        
            if(incident.site_incident){
                var site_incident = sites.find(s => s.id == incident.site_incident);
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
            
            $('.site_de_lincident').replaceWith(`<div class="my-0 big"><span class="site_de_lincident">${site_incident ? site_incident.name : ""}</span></div>`);
            $('.declarateur').replaceWith(`<div class="my-0 big"><span class="text-xl declarateur">${incident.fullname_declarateur ? incident.fullname_declarateur : "AUCUN DECLARATEUR"}</span></div>`)
            $('.observation_coordos').replaceWith(`<span class="text-xl observation_coordos">${incident.observation_rex ? incident.observation_rex : ""}</span>`);
            $('.processus_impacter').replaceWith(`<span class="text-xl processus_impacter">${pro.name}</span>`);
            $('.sident').replaceWith(`<span class="sident badge badge-info text-xl">${incident.number}</span>`);
            $('.desc').replaceWith(`<span class="text-xl desc">${incident.description}</span>`);
            $('.cose').replaceWith(`<span class="text-xl cose">${incident.cause}</span>`);
            $('.perim').replaceWith(`<span class="text-xl perim">${incident.perimeter ? incident.perimeter : ''}</span>`);
        
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
        
         }
    })    
});


$(document).on('click', '#ask_service', function(){
    let task = JSON.parse($(this).attr('data-task'));
    $('#t_In').val(task.id);
});

$(document).on('click', '#btnSaveAskingServie', function(){
    let good = true;
    let message = "";

    if(!$('#tit').val().trim()){
        good = false;
        message+="Veuillez Renseigner L'objet De La Demande De Service !\n";
    }

    if(!$('#maturity_dat').val().trim()){
        good = false;
        message+="Veuillez Renseigner La Date D'échéance !\n";
    }

    if(!good){
        good = false;
        alert(message);
    }else{
        $.ajax({
            type: 'POST',
            url: "demandeService",
            data: $('#frm_askService').serialize(),
             headers:{
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             success: function(demandeService){
                if(demandeService.length > 0){
                    $('#frm_askService')[0].reset();
                    alert('Demande De Service Enrégistré Avec Succèss !');
                }
             }
        })    
    }
});

$(document).on('click', '#modif_stay_tach', function(){
    $('#tachi').replaceWith(`<strong id="tachi">${$(this).attr('data-key')}</strong>`);
    $('#tasch_m').attr('data-task', $(this).attr('data-task'));
});

$(document).on('click', '#tasch_m', function(){
    let task = JSON.parse($(this).attr('data-task'));

    if($('#statut_e').val()){
        
        if($('#statut_e').val() == "RÉALISÉE"){
                $.ajax({
                    type: 'PUT',
                    url: "updateStatusTask",
                    data: {
                        id: task.id,
                        status: $('#statut_e').val(),
                        commentaire: $('#realise_comment').val(),
                        observation: $('#observation').val(),
                        motif_annulation: $('#motif_annulation').val(),
                        motif_attente: $('#motif_attente').val(),
                    },
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data){
                        if(data.length == 1){
                            location.reload();
                        }else if(data.length == 2){
                            $('#textstat').val('Veuillez Renseigner Tous Les Champs De Saisis !');
                            $('#change_status').modal('hide');
                            $('#stat_task').attr('data-backdrop', 'static');
                            $('#stat_task').attr('data-keyboard', false);
                            $('#stat_task').modal('show');                            
                        }
                    }
                });
        }else{
            $.ajax({
                type: 'PUT',
                url: "updateStatusTask",
                data: {
                    id: task.id,
                    status: $('#statut_e').val(),
                    commentaire: $('#realise_comment').val(),
                    observation: $('#observation').val(),
                    motif_annulation: $('#motif_annulation').val(),
                    motif_attente: $('#motif_attente').val(),
                },
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                    if(data.length == 1){
                        location.reload();
                    }else if(data.length == 2){
                        $('#textstat').val('Veuillez Renseigner Tous Les Champs De Saisis !');
                        $('#change_status').modal('hide');
                        $('#stat_task').attr('data-backdrop', 'static');
                        $('#stat_task').attr('data-keyboard', false);
                        $('#stat_task').modal('show');                            
                    }
                }
            });
        }
    }else{
        $('#textstat').val('Veuillez Sélectionner Un Statut !');
        $('#change_status').modal('hide');
        $('#stat_task').attr('data-backdrop', 'static');
        $('#stat_task').attr('data-keyboard', false);
        $('#stat_task').modal('show');
    }
});


$(document).on('change', '#statut_e', function(){
    if($(this).val()){
        if($('#statut_e').val() == "ENCOURS"){
            $('#realise_comment').val('');
            $('#motif_annulation').val('');
            $('#motif_attente').val('');

            $('#segment').empty();
            $('#segment').append(`
            <div id="segment">
                <div class="form-group mb-3">
                        <label class="text-xl" for="observation"> <span class="fe fe-edit mr-2"></span>Observation <span style="color:red;"> *</span></label>
                        <textarea style="resize:none;" rows="5" class="form-control" id="observation" name="observation" placeholder="Veuillez Entrer Une Observation."></textarea>
                        <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                </div>
            </div>
            `);
        }else if($('#statut_e').val() == "RÉALISÉE"){
            $('#observation').val('');
            $('#motif_annulation').val('');
            $('#motif_attente').val('');

            $('#segment').empty();
            $('#segment').append(`
            <div id="segment">
                <div class="form-group mb-3">
                        <label class="text-xl" for="realise_comment"> <span class="fe fe-edit mr-2"></span>Commentaire De Réalisation <span style="color:red;"> *</span></label>
                        <textarea style="resize:none;" rows="5" class="form-control" id="realise_comment" name="commentaire" placeholder="Veuillez Entrer Un Commentaire."></textarea>
                        <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                </div>
            </div>
            `)
        }else if($('#statut_e').val() == "ANNULÉE"){
            $('#observation').val('');
            $('#realise_comment').val('');
            $('#motif_attente').val('');

            $('#segment').empty();
            $('#segment').append(`
                <div class="form-group mb-3">
                    <label class="text-xl" for="motif_annulation"> <span class="fe fe-edit-2 mr-1"></span> Motif D'annulation De Cette Tâche <span style="color:red;"> *</span></label>
                    <textarea style="resize:none;" rows="5" class="form-control" id="motif_annulation" name="motif_annulation" placeholder="Veuillez Entrer La Raison De L'annulation De La Tâche."></textarea>
                    <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                </div>
            `)
        }else if($('#statut_e').val() == "EN-ATTENTE"){
            $('#observation').val('');
            $('#realise_comment').val('');
            $('#motif_annulation').val('');

            $('#segment').empty();
            $('#segment').append(`
                <div class="form-group mb-3">
                    <label class="text-lg" for="motif_attente"> <span class="fe fe-edit-2 mr-1"></span> Motif De Mise En-Attente De Cette Tâche <span style="color:red;"> *</span></label>
                    <textarea style="resize:none;" rows="5" class="form-control" id="motif_attente" name="motif_attente" placeholder="Veuillez Entrer La Raison De La Mise En-Attente De Cette Tâche."></textarea>
                    <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                </div>
            `)
        }
    }else{
        $('#segment').empty();
    }
});

$(document).on('click', '#log_task', function(){
    let meslogs = [];
    let task = JSON.parse($(this).attr('data-task'));
    let logs = JSON.parse($(this).attr('data-logs'));
    console.log(logs)
    $('#tekila').replaceWith(`<strong class="text-xl" id="tekila">${$(this).attr('data-key')}</strong>`);

    for (let index = 0; index < logs.length; index++) {
        const log = logs[index];
        if(log.tache_id == task.id){
            meslogs.push(log);
        }
    }

    for (let i = 0; i < meslogs.length; i++) {
        const log = meslogs[i];
        
        $('.dubai').append(`
            <div class="list-group-item">
                <div class="row align-items-center">
                    <div class="col-auto">
                    <span class="fe fe-info fe-16"></span>
                </div>
                <div class="col">
                    <small><strong></strong></small>
                    <div class="my-0 text-lg big"><span>${log.title ? log.title : ""}</span></div>
                </div>
                <div class="col">
                    <div class="my-0 text-lg big"><span>${log.created_at ? log.created_at : ""}</span></div>
                </div>
                <div class="col">
                    <small class="badge badge-pill text-lg badge-light text-uppercase">${log.statut ? log.statut : ''}</small>
                </div>
                <div class="col">
                    <small class="badge badge-pill text-lg badge-light text-uppercase">${log.users ? log.users.fullname : ""}</small>
                </div>
            </div>
        `)
    }
});


$(document).on('click', '#resetlog', function(){
    $('.dubai').empty().append(`
        <div class="row text-xl my-4">
            <div class="col">
                <small><strong style="margin-left:4em;">Description</strong></small>
            </div>
            <div class="col">
                <small><strong style="margin-left:3em;"><span class="fe fe-calendar fe-16 mr-2"></span>Date De Modification</strong></small>
            </div>
            <div class="col">
                <small><strong style="margin-left:1.5em;"><span class="fe fe-battery-charging fe-16 mr-2"></span>Nouveau(x) Statu(s)</strong></small>
            </div>
            <div class="col">
                <small><strong><span class="fe fe-user fe-16 mr-2"></span>Utilisateur</strong></small>
            </div>
        </div>
    `);
});


$(document).on('click', '#set_priority_degr', function(){
    $('#ttach').replaceWith(`<strong id="ttach">${$(this).attr('data-key')}</strong>`);
    $('#valid_deg').attr('data-tache', $(this).attr('data-task'));
});


$(document).on('click', '#valid_deg', function(){
    let task = JSON.parse($(this).attr('data-tache'));

    if($('#degree_r').val()){
        $.ajax({
            type: 'PUT',
            url: "updateDegreeTask",
            data: {
                degree: $('#degree_r').val(),
                id: task.id,
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
        $('#validation_degree').val('Veuillez Sélectionner Un Dégré De Réalisation De La Tâche !');
        $('#update_degree').modal('hide');
        $('#degreerealisation_error').attr('data-backdrop', 'static');
        $('#degreerealisation_error').attr('data-keyboard', false);
        $('#degreerealisation_error').modal('show'); 
    }
});


$(document).on('input', '#inputfile', function(){
    if($(this).val()){
        $('#btn_uploads').prop('disabled', false);
    }else{
        $('#btn_uploads').prop('disabled', true);
    }
});


$(document).on('click', '#supp_task', function(){
    if(confirm("Voulez-Vous Vraiment Supprimer La Tâche N° : "+ $(this).attr('data-key') +" ?") == true){
        $.ajax({
            type: 'DELETE',
            url: 'deleteTask',
            data: { id: $(this).attr('data-id')},
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(){
                location.reload();
            }
        })
    }
});


$(document).on('click', '#editions', function(){

    let task = JSON.parse($(this).attr('data-task'));
    console.log(task)
    let sites = JSON.parse($('#toto').attr('data-sites'));
    let incident = JSON.parse($('#toto').attr('data-incident'));

    $('#txt_num_i_edit').replaceWith(`<span id="txt_num_i_edit" style="margin-left: 13em;" class="text-xl badge badge-success">${incident.number}</span>`);
    $('#id_edit').val(task.id);
    $('.form-group #desc_uniques').val(task.description);
    $('.form-group #obs_task_edit').val(task.observation_task);
    $('.form-group #degree_realis').val(task.resolution_degree);
    $('.form-group input[id="dateing"]').val(task.maturity_date);
    $('#deepartes_edit').val(task.site_id);
    
});


$(document).on('click', '#btn_edit_unique_task', function(){
    let good = true;
    let message = "";

    if(!$('#desc_uniques').val().trim()){
        good = false;
        message+="Veuillez Renseigner La Description Où Le But De La Tâche !\n";
    }

    if(!$('#obs_task_edit').val()){
        good = false;
        message+="Veuillez Renseigner L'observation De La Tâche !\n";
    }

    if(!$('#dateing').val()){
        good = false;
        message+="Veuillez Renseigner La Date D'échéance De La Tâche !\n";
    }else{
        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
        let date_saisi = parseInt($('#dateing').val().replaceAll("-", ""));
        if(date_saisi < today){
            good = false;
            message +="Veuillez Renseigner Une Date D\'échéance Qui Est Supérieur Où Egale A La Date D'aujourd'huit ! \n";
        }
    }

    if(!$('#degree_realis').val()){
        good = false;
        message+="Veuillez Choisir Le Dégré De Résolution De La Tâche !\n";
    }

    if(!$('select[name="deepartes_edit"]').val()){
        good = false;
        message += "Veuillez Choisir Un Site ! \n";        
    }

    if(!good){
        good = false;
        $('#modal_edit_task').modal('hide');
        $('#validation_edin').val(message);
        $('#tache_error_edit').attr('data-backdrop', 'static');
        $('#tache_error_edit').attr('data-keyboard', false);
        $('#tache_error_edit').modal('show');
    }else{
        $.ajax({
            type: 'PUT',
            url: 'editTask',
            data: $('#frmedittasks').serialize(),
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


$(document).on('click', '#set_echeance_time', function(){
    $('#nibi').replaceWith(`<strong id="nibi">${parseInt($(this).attr('data-key'))+1}</strong>`);
    $('#echeance_btn_inc').attr('data-task', $(this).attr('data-task'));
});


$(document).on('click', '#echeance_btn_inc', function(){
    if($('#date_maturity').val()){
        if(parseInt($('#date_maturity').val().replaceAll("-", "")) >= parseInt((new Date().toISOString().split('T')[0]).replaceAll("-", ""))){
            $.ajax({
                type: 'PUT',
                url: 'set_echeance_date_task',
                data: {
                    id: JSON.parse($(this).attr('data-task')).id,
                    maturity_date: $('#date_maturity').val(),
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
            $('#define_dat_echean').modal('hide');
            $('#validation_due_date').val("Veuillez Renseigner Une Date D\'échéance Qui Est Supérieur Où Egale A La Date D\'aujourd\'huit ! \n");
            $('#echedate').attr('data-backdrop', 'static');
            $('#echedate').attr('data-keyboard', false);
            $('#echedate').modal('show');    
        }
    }else{
        $('#define_dat_echean').modal('hide');
        $('#validation_due_date').val("Veuillez Renseigner Une Date D'échéance !");
        $('#echedate').attr('data-backdrop', 'static');
        $('#echedate').attr('data-keyboard', false);
        $('#echedate').modal('show');
    }
});


$(document).on('click', '#dismiss_btn_ude', function(){
    $('#echedate').modal('hide');
    $('#define_dat_echean').attr('data-backdrop', 'static');
    $('#define_dat_echean').attr('data-keyboard', false);
    $('#define_dat_echean').modal('show');
});


$(document).on('click', '#btn_tachedinok', function(){
    $('#tache_error_edit').modal('hide');
    $('#modal_edit_task').attr('data-backdrop', 'static');
    $('#modal_edit_task').attr('data-keyboard', false);
    $('#modal_edit_task').modal('show');
});


$(document).on('click', '#btnStas', function(){
    $('#stat_task').modal('hide');
    $('#change_status').attr('data-backdrop', 'static');
    $('#change_status').attr('data-keyboard', false);
    $('#change_status').modal('show');
});


$(document).on('click', '#btn_degree', function(){
    $('#degreerealisation_error').modal('hide');
    $('#update_degree').attr('data-backdrop', 'static');
    $('#update_degree').attr('data-keyboard', false);
    $('#update_degree').modal('show');
});


$(document).on('change', 'select[name="deepartes_edit"]', function(){

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

                $('#nino_edit').remove();
                $('#devdocs_edit').append(`
                    <div id="nino_edit" class="form-group my-4">
                        <label for="sity"><span class="fe fe-navigation-2 mr-2"></span>Site Chargé De Resoudre L'incident<span style="color:red;"> *</span></label>
                        <select style="font-size: 1.2em;" class="form-control custom-select border-primary" id="sity_edit" name="sity_edit">
                            <option value="">Choisissez...</option>
                        </select>
                    </div>
                `);
                for (let i = 0; i < allSites.length; i++) {
                    const sit = allSites[i];
                    $('#sity_edit').append(`<option value="${sit.id}">${sit.name}</option>`);
                }

            }else{

                $('#nino_edit').remove();
                $('#devdocs_edit').append(`
                    <div id="nino_edit" class="form-group my-4">
                        <label for="sity_edit"><span class="fe fe-navigation-2 mr-2"></span>Site Chargé De Resoudre L'incident<span style="color:red;"> *</span></label>
                        <select style="font-size: 1.2em;" class="form-control custom-select border-primary" id="sity_edit" name="sity_edit">
                            <option value="">Choisissez...</option>
                        </select>
                    </div>
                `);

                $('#sity_edit').empty().append(`<option value="">AUCUNE OPTION DISPONIBLE</option>`);
            } 

        }else{
            $('#nino_edit').remove();
        }
        
    }else{
        $('#nino_edit').remove();
    }
});

