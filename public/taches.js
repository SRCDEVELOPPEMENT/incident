$(document).on('click', '#btnExitModalTask', function(){
    location.reload();
});

$(document).on('click', '#btn_clear_fields', function(){
    $('#frmtasks')[0].reset();
});


$(document).on('click', '#btn_tach_err_ok', function(){
    $('#tache_error_validations').modal('hide');
    $('#modal_task').attr('data-backdrop', 'static');
    $('#modal_task').attr('data-keyboard', false);
    $('#modal_task').modal('show');
});


$(document).on('click', '#btn_add_unique_task', function(){
    let good = true;
    let message = "";

    if(!$('#desc_unique').val().trim()){
        good = false;
        message+="Veuillez Renseigner La Description Où Le But De La Tâche !\n";
    }
    if(!$('#date_echeance_unique').val()){
        good = false;
        message+="Veuillez Renseigner La Date D'échéance De La Tâche !\n";
    }
    if(!$('#user_task_unique').val()){
        good = false;
        message+="Veuillez Assigner Un Département A La Tâche !\n";
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
        data: $('#frmtasks').serialize(),
         headers:{
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         success: function(data){
            if(data.length > 0){
                let task = data[0];

                $('#dataTable-task .tachsx').prepend(`
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input">
                                <label class="custom-control-label"></label>
                            </div>
                        </td>
                        <td><p class="mb-0 text-muted">${task.description}</p></td>
                        <td>
                                    @if(${task.status} == 'RÉALISÉ')
                                    <a
                                    ${task.status} == 'EN-RÉALISATION' ? style="color: #EEA303; text-decoration:none;":${task.status} == 'RÉALISÉ' ? style="color: #3ABF71; text-decoration:none;":style="color: #1B68FF; text-decoration:none;"
                                    href="#">
                                    ${task.status}
                                    </a>
                                    @else
                                    <a
                                    id="modif_stay_tach"
                                    data-key=""
                                    ${task.status} == 'EN-RÉALISATION' ? style="color: #EEA303; text-decoration:none;":${task.status} == 'RÉALISÉ' ? style="color: #3ABF71; text-decoration:none;":style="color: #1B68FF; text-decoration:none;"
                                    href="#"
                                    data-backdrop="static"
                                    data-keyboard="false" 
                                    data-toggle="modal"
                                    data-target="#change_status">
                                    ${task.status}
                                    </a>
                                    @endif
                        </td>
                        <td>${task.maturity_date}</td>
                        <td>${task.usdepartementsers ? task.departements.name : ''}</td>
                        <td>
                            <a
                                id="set_priority_degr"
                                href="#"
                                style="text-decoration:none;"
                                data-backdrop="static"
                                data-keyboard="false"
                                data-toggle="modal"
                                data-target="#update_degree">
                                DÉFINISSEZ UNE RÉALISATION
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
                                    class="fe fe-upload-cloud fe-32 files_id"></a>
                        </td>
                        <td><a 
                                    style="text-decoration:none; color:white;"
                                    data-backdrop="static"
                                    data-keyboard="false" 
                                    data-toggle="modal" 
                                    data-target="#downloadModal"
                                    href="/" 
                                    title="Télécharger Le Fichier De La Tâche"
                                    class="fe fe-download-cloud fe-32 down_id"></a>
                        </td>
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
            }
         }
    })
});

$(document).ready(function() {
    $("#validationCustom04").on("change", function() {
      var value = $(this).val().toLowerCase();
      $(".tachsx tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    $("#searchDate").on("change", function() {
        var value = $(this).val().toLowerCase();
        $(".tachsx tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });  
});

$(document).on('click', '.files_id', function(){
    let task = JSON.parse($(this).attr('data-task'));
    $('#id_task').val(task.id);
});

$(document).on('click', '.down_id', function(){
    let task = JSON.parse($(this).attr('data-task'));
    let files = JSON.parse($(this).attr('data-files'));
    let files_task = [];

    $('#idtach').val(task.id);

    for (let index = 0; index < files.length; index++) {
        const file = files[index];
        if(parseInt(file.tache_id) == parseInt(task.id)){
            files_task.push(file);
        }
    }

    if(files_task.length == 0){
        $('#span_info').replaceWith(`<span id="span_info" style="font-size: 1.1em; text-align: center; margin-bottom:1em;"><i class="fe fe-file fe-32"></i><i class="fe fe-x fe-16 mr-2"></i> Aucun Fichier Charger Pour Cette Tâche</span>`);
    }else{
        $('#span_info').replaceWith(`<span id="span_info" style="font-size: 1em; text-align: center; margin-bottom:1em;"><i class="fe fe-file fe-32 mr-2"></i> TéléCharger Le(s) Fichier(s) De Réalisation De La Tâche</span>`);
    }

    for (let index = 0; index < files_task.length; index++) {
        const file = files_task[index];

        $('#bakugo').append(`
            <button data-file_id="${file.id}" class="squircle bg-primary border-primary justify-content-center" name="submit_download" type="submit">
                <span class="fe fe-download fe-32 align-self-center text-white"></span>
            </button>
            <button style="margin:0;" type="button" class="fe fe-trash fe-32 align-self-center text-white"></button>
        `);
    }
});


$(document).on('click', 'button[name="submit_download"]', function(){
    $('#midoriya').val($(this).attr('data-file_id'));
});


$(document).on('click', '#exit_modal_down', function(){
    $('#bakugo').empty();
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
    $('#tachi').replaceWith(`<span id="tachi">${$(this).attr('data-key')}</span>`);
    $('#tasch_m').attr('data-task', $(this).attr('data-task'));
});

$(document).on('click', '#tasch_m', function(){
    let task = JSON.parse($(this).attr('data-task'));
    let fichiers = JSON.parse($(this).attr('data-fichiers'));
    let elements = [];
    for (let index = 0; index < fichiers.length; index++) {
        const fichier = fichiers[index];
        if(parseInt(fichier.tache_id) == parseInt(task.id)){
            elements.push(fichier);
        }
    }
    console.log(elements)
    if($('#statut_e').val()){
        console.log($('#statut_e').val())
        if($('#statut_e').val() == "RÉALISÉ"){
            if(elements.length > 0){
                $.ajax({
                    type: 'PUT',
                    url: "updateStatusTask",
                    data: {
                        status: $('#statut_e').val(),
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
                alert('Veuillez D\'abord Charger Le(s) Document(s) De Livraison !');
            }
        }else{
            $.ajax({
                type: 'PUT',
                url: "updateStatusTask",
                data: {
                    status: $('#statut_e').val(),
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
        };  
    }else{
        alert('Veuillez Sélèctionner Un Statut !');
    }
});


$(document).on('click', '#set_priority_degr', function(){
    $('#ttach').replaceWith(`<span id="ttach">${$(this).attr('data-key')}</span>`);
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
        alert('Veuillez Sélèctionner Un Dégré De Réalisation De La Tâche !');
    }
});

$(document).on('input', '#inputfile', function(){
    if($(this).val()){
        $('#btn_uploads').prop('disabled', false);
    }else{
        $('#btn_uploads').prop('disabled', true);
    }
})

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
})

$(document).on('click', '#edin', function(){
    let task = JSON.parse($(this).attr('data-task'));
    console.log(task)
    $('#id_edit').val(task.id);
    $('.form-group #desc_uniques').val(task.description);
    $('.form-group input[id="dateing"]').val(task.maturity_date);
    $('.form-group #user_task_uniques').val(task.departement_solving_id);
});

$(document).on('click', '#btn_edit_unique_task', function(){
    let good = true;
    let message = "";

    if(!$('#desc_uniques').val().trim()){
        good = false;
        message+="Veuillez Renseigner La Description Où Le But De La Tâche !\n";
    }
    if(!$('#dateing').val()){
        good = false;
        message+="Veuillez Renseigner La Date D'échéance De La Tâche !\n";
    }
    if(!$('#user_task_uniques').val()){
        good = false;
        message+="Veuillez Assigner Un Département A La Tâche !\n";
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

$(document).on('click', '#btn_tachedinok', function(){
    $('#tache_error_edit').modal('hide');
    $('#modal_edit_task').attr('data-backdrop', 'static');
    $('#modal_edit_task').attr('data-keyboard', false);
    $('#modal_edit_task').modal('show');
});
