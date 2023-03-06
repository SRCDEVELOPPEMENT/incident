$(document).on('click', '#vues', function(){
    let nbr_taches = 0;
    let tasks = JSON.parse($(this).attr('data-tasks'));
    let ids = JSON.parse($(this).attr('data-ids'));
    let dates = JSON.parse($(this).attr('data-created'));
    let incident = JSON.parse($(this).attr('data-incident'));
    let users_incidents = JSON.parse($(this).attr('data-users_incidents'));
    let departements = JSON.parse($(this).attr('data-departements'));
    let sites = JSON.parse($(this).attr('data-sites'));
    
    if(incident.deja_pris_en_compte === "1"){
        $('.deja_pris_encompte').replaceWith(`<span class="text-xl text-danger deja_pris_encompte">${incident.comment ? incident.comment : ""}</span>`)
    }else if(!incident.deja_pris_en_compte){
        if(incident.observation_rex){
            $('.deja_pris_encompte').replaceWith(`<span class="text-xl text-success deja_pris_encompte">Incident Assigné Avec Succèss !</span>`)
        }else{
            $('.deja_pris_encompte').replaceWith(`<span class="text-xl text-warning deja_pris_encompte">Incident Pas Encore Assigné !</span>`)  
        }
    }

    $('.no').replaceWith(`<i class="badge badge-success text-xl no ml-2">${incident.number}</i>`);
    $('.desc').replaceWith(`<span class="text-xl desc">${incident.description}</span>`);
    $('.cose').replaceWith(`<span class="text-xl desc">${incident.cause}</span>`);
    $('.perim').replaceWith(`<span class="text-xl perim">${incident.perimeter ? incident.perimeter : ''}</span>`);
    $('.actions_do').replaceWith(`<span class="text-xl actions_do">${incident.battles ? incident.battles : ''}</span>`);
    $('.due_dat').replaceWith(`<span class="text-danger text-xl due_dat">${incident.due_date ? incident.due_date : ''}</span>`);
    $('.closur_dat').replaceWith(`<span class="text-danger text-xl closur_dat">${incident.closure_date ? incident.closure_date : ''}</span>`);
    $('.kate').replaceWith(`<span class="text-xl kate">${incident.categories ? incident.categories.name : ""}</span>`);
    
    let index_declaration = -1;
    for (let y = 0; y < ids.length; y++) {
        const number = ids[y];
        if(number == incident.number){
            index_declaration = y;
        }
    }
    $('.creat_dat').replaceWith(`<span class="text-xl text-white creat_dat">${dates[index_declaration]}</span>`);

    for (let index = 0; index < tasks.length; index++) {
        const task = tasks[index];
        if(task.incident_number == incident.number){
            nbr_taches +=1;
        }
    }

    $('.tac').replaceWith(`<span class="text-xl tac">${nbr_taches < 10 ? 0 +""+ nbr_taches : nbr_taches}</span>`);

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


$(document).ready(function(){

    $("#searchDepartement").on("change", function() {
      var value = $(this).val().toLowerCase();
      $("#moncard .winner").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    $(document).on('mouseover', '#maison', function(){
        $(this).css("color", "black");
    });
    $(document).on('mouseleave', '#maison', function(){
        $(this).css("color", "blue");
    });
    
    $('#search_incidant').on('input', function(){
        var value = $(this).val().toLowerCase();
        $("#shaw tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });  
    });

    $("#searchDate").on("change", function() {
        var filter = $(this).val();
        var table = document.getElementById("dataTable_incident");
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
    })

    $("#searchMonthDash").on("change", function() {
        var filter = $(this).val();
        var table = document.getElementById("dataTable_incident");
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
    })

});
  

$(document).on('click', '#infos_incident', function(){

    $('#modal_liste_incident').modal('hide');

    let index_declarations = -1;
    let number = $(this).attr('data-number');
    let tasks = $(this).attr('data-task');
    let numbers = JSON.parse($('#citadelle').attr('data-ids'));
    let dates = JSON.parse($('#citadelle').attr('data-created'));
    let incidents = JSON.parse($('#citadelle').attr('data-incidents'));
    let users = JSON.parse($('#citadelle').attr('data-users'));
    let sites = JSON.parse($('#citadelle').attr('data-sites'));
    let departements = JSON.parse($('#citadelle').attr('data-departements'));
    let users_incidents = JSON.parse($('#citadelle').attr('data-users_incidents'));

    let incident = incidents.find(i => i.number == number);

    for (let l = 0; l < numbers.length; l++) {
        const number = numbers[l];
        if(number == incident.number){
            index_declarations = l;
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


    $('.observation_coordos').replaceWith(`<span class="observation_coordos">${incident.observation_rex ? incident.observation_rex : ""}</span>`);
    $('.processus_impacter').replaceWith(`<span class="text-xl processus_impacter">${incident.processus.name}</span>`);
    $('.no').replaceWith(`<i class="badge badge-pill badge-success text-xs no ml-2">${incident.number}</i>`);
    $('.desc').replaceWith(`<span class="text-xl desc">${incident.description}</span>`);
    $('.cose').replaceWith(`<span class="text-xl desc">${incident.cause}</span>`);

    if(incident.status == "ENCOURS"){
        $('.stat_inci').replaceWith(`<span class="text-xl text-primary stat_inci">${incident.status}</span>`);
    }else if(incident.status == "CLÔTURÉ"){
        $('.stat_inci').replaceWith(`<span class="text-xl text-success stat_inci">${incident.status}</span>`);
    }else{
        $('.stat_inci').replaceWith(`<span class="text-xl text-muted stat_inci">${incident.status}</span>`);
    }
    $('.perim').replaceWith(`<span class="text-xl perim">${incident.perimeter ? incident.perimeter : ''}</span>`);
    $('.actions_do').replaceWith(`<span class="text-xl actions_do">${incident.battles ? incident.battles : ''}</span>`);
    $('.kate').replaceWith(`<span class="text-xl kate">${incident.categories ? incident.categories.name : ""}</span>`);
    
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
    $('.creat_dat').replaceWith(`<span class="text-xl creat_dat">${dates[index_declarations]}</span>`);
    $('.closur_dat').replaceWith(`<span class="text-xl closur_dat">${incident.closure_date ? incident.closure_date : ''}</span>`);
    $('.tac').replaceWith(`<span class="text-xl tac">${tasks < 10 ? 0 +""+ tasks : tasks}</span>`);

    //Entité Emetteur Et Récèpteur
    $('.site_emeter').replaceWith(`<span class="site_emeter"></span>`);
    $('.syte_receppt').replaceWith('<span class="syte_receppt"></span>');

    let mon_user_inci_recepteur = users_incidents.find(u => u.incident_number == incident.number && u.isTrigger === '1' && u.isCoordo === '1' && u.isTriggerPlus === '1');

    for (let bi = 0; bi < users_incidents.length; bi++) {
        const u = users_incidents[bi];
        if((u.incident_number == number) && (u.isDeclar === "1")){
            var id_utili = u.user_id;
        }

    }

    
    let Utilisateur = users.find(u => u.id == id_utili);
    if(Utilisateur){
        var dept = departements.find(d => d.id == Utilisateur.departement_id);
        var sit = sites.find(s => s.id == Utilisateur.site_id);
    }

    if(mon_user_inci_recepteur){
        let user = users.find(u => u.id == mon_user_inci_recepteur.user_id);

        if(user){
            var dept_recepteur = departements.find(d => d.id == user.departement_id);
            var sit_recepteur = sites.find(s => s.id == user.site_id);
        }
    }

    $('.syte_receppt').replaceWith(`<span class="syte_receppt">${dept_recepteur ? dept_recepteur.name : sit_recepteur ? sit_recepteur.name : ""}</span>`);
    $('.site_emeter').replaceWith(`<span class="site_emeter">${sit ? sit.name : dept ? dept.name : ""}</span>`);

});

$(document).on('click', '#floder_encour', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();

    if($('#citadelle').val()){
        $('#name_of_hight').replaceWith(`<span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">Site</span>
        ${$('#citadelle option:selected').text()}</span>`);
    }else if($('#departes').val()){
        $('#name_of_hight').replaceWith(`<span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">Département</span>
        ${$('#departes option:selected').text()}</span>`);
    }else if($('#regionnn').val()){
        $('#name_of_hight').replaceWith(`<span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">Région</span>
        ${$('#regionnn option:selected').text()}</span>`);
    }else{

        if($('#DateDebut').val() && $('#DateFin').val()){
            $('#name_of_hight').replaceWith(`
            <span class="text-xl ml-3" id="name_of_hight">
                <span class="badge badge-pill badge-success mr-2">INCIDENT(S) ENCOURS DU</span>
                ${$('#DateDebut').val()}
                <span class="badge badge-pill badge-success ml-4 mr-2">AU</span>
                ${$('#DateFin').val()}
            </span>`);    
        }else if($('#DateDebut').val()){
            $('#name_of_hight').replaceWith(`
            <span class="text-xl ml-3" id="name_of_hight">
                <span class="badge badge-pill badge-success mr-2">INCIDENT(S) ENCOURS DU</span>
                ${$('#DateDebut').val()}
            </span>`);    
        }else{
            $('#name_of_hight').replaceWith(`
            <span class="text-xl ml-3" id="name_of_hight">
                <span class="badge badge-pill badge-success mr-2">INCIDENT(S) ENCOURS</span>
            </span>`);    
        }
    }

    let incidents = JSON.parse($(this).attr('data-encours'));
    let numbers = JSON.parse($('#citadelle').attr('data-ids'));
    let created = JSON.parse($('#citadelle').attr('data-created'));
    let tasks = JSON.parse($('#citadelle').attr('data-tasks'));

    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];
        var id_taches = [];
        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                id_taches.push(task.id);
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td>${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#!"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1"
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false"
                    data-toggle="modal"
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a
                    id="liste_taches"
                    data-number="${incident.number}"
                    data-tasks="${id_taches}"
                    class="dropdown-item"
                    href="#!"
                    data-backdrop="static" 
                    data-keyboard="false"
                    data-toggle="modal" 
                    data-target="#modall_tasks_incidents">
                    <span class="fe fe-list mr-4"></span> Liste Des Tâches
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
        `);
    }
});

$(document).on('click', '#floder_cloture', function(){

    $('#shaw tr').remove();
    $('#cloturation').show();

    if($('#citadelle').val()){
        $('#name_of_hight').replaceWith(`<span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">Site</span>
        ${$('#citadelle option:selected').text()}</span>`);
    }else if($('#departes').val()){
        $('#name_of_hight').replaceWith(`<span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">Département</span>
        ${$('#departes option:selected').text()}</span>`);
    }else if($('#regionnn').val()){
        $('#name_of_hight').replaceWith(`<span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">Région</span>
        ${$('#regionnn option:selected').text()}</span>`);
    }else{

        if($('#DateDebut').val() && $('#DateFin').val()){
            $('#name_of_hight').replaceWith(`
            <span class="text-xl ml-3" id="name_of_hight">
                <span class="badge badge-pill badge-success mr-2">INCIDENT(S) CLÔTURÉ DU</span>
                ${$('#DateDebut').val()}
                <span class="badge badge-pill badge-success ml-4 mr-2">AU</span>
                ${$('#DateFin').val()}
            </span>`);    
        }else if($('#DateDebut').val()){
            $('#name_of_hight').replaceWith(`
            <span class="text-xl ml-3" id="name_of_hight">
                <span class="badge badge-pill badge-success mr-2">INCIDENT(S) CLÔTURÉ DU</span>
                ${$('#DateDebut').val()}
            </span>`);    
        }else{
            $('#name_of_hight').replaceWith(`
            <span class="text-xl ml-3" id="name_of_hight">
                <span class="badge badge-pill badge-success mr-2">INCIDENT(S) CLÔTURÉ</span>
            </span>`);
        }
    }

    let incidents = JSON.parse($(this).attr('data-clotures'));
    let numbers = JSON.parse($('#citadelle').attr('data-ids'));
    let created = JSON.parse($('#citadelle').attr('data-created'));
    let tasks = JSON.parse($('#citadelle').attr('data-tasks'));
    let nombre_enretard = 0;
    let nombre_a_temps = 0;

    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];
        
        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];
        var id_taches = [];

        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                id_taches.push(task.id);
                taches_incident.push(task);
            }
        }

        if(incident.due_date && incident.closure_date){
            if(parseInt(incident.closure_date.replaceAll("-", "")) > parseInt(incident.due_date.replaceAll("-", ""))){
                nombre_enretard +=1;
            }else{
                nombre_a_temps +=1;
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td>${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#!"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1" 
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false" 
                    data-toggle="modal" 
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a
                    id="liste_taches"
                    data-number="${incident.number}"
                    data-tasks="${id_taches}"
                    class="dropdown-item"
                    href="#!"
                    data-backdrop="static" 
                    data-keyboard="false"
                    data-toggle="modal" 
                    data-target="#modall_tasks_incidents">
                    <span class="fe fe-list mr-4"></span> Liste Des Tâches
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
        `);
        
    }

    $('#en_ret').replaceWith(`<strong id="en_ret" class="text-danger text-xl">${nombre_enretard < 10 ? 0 +""+ nombre_enretard : nombre_enretard}</strong>`);
    $('#a_temps').replaceWith(`<strong id="a_temps" class="text-success text-xl">${nombre_a_temps < 10 ? 0 +""+ nombre_a_temps : nombre_a_temps}</strong>`);

});

$(document).on('click', '#floder_annuler', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();

    if($('#citadelle').val()){
        $('#name_of_hight').replaceWith(`<span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">Site</span>
        ${$('#citadelle option:selected').text()}</span>`);
    }else if($('#departes').val()){
        $('#name_of_hight').replaceWith(`<span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">Département</span>
        ${$('#departes option:selected').text()}</span>`);
    }else if($('#regionnn').val()){
        $('#name_of_hight').replaceWith(`<span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">Région</span>
        ${$('#regionnn option:selected').text()}</span>`);
    }else{

        if($('#DateDebut').val() && $('#DateFin').val()){
            $('#name_of_hight').replaceWith(`
            <span class="text-xl ml-3" id="name_of_hight">
                <span class="badge badge-pill badge-success mr-2">INCIDENT(S)  ANNULÉ DU</span>
                ${$('#DateDebut').val()}
                <span class="badge badge-pill badge-success ml-4 mr-2">AU</span>
                ${$('#DateFin').val()}
            </span>`);    
        }else if($('#DateDebut').val()){
            $('#name_of_hight').replaceWith(`
            <span class="text-xl ml-3" id="name_of_hight">
                <span class="badge badge-pill badge-success mr-2">INCIDENT(S)  ANNULÉ DU</span>
                ${$('#DateDebut').val()}
            </span>`);    
        }else{
            $('#name_of_hight').replaceWith(`
            <span class="text-xl ml-3" id="name_of_hight">
                <span class="badge badge-pill badge-success mr-2">INCIDENT(S) ANNULÉ</span>
            </span>`);
        }
    }

    let incidents = JSON.parse($(this).attr('data-annules'));
    let numbers = JSON.parse($('#citadelle').attr('data-ids'));
    let created = JSON.parse($('#citadelle').attr('data-created'));
    let tasks = JSON.parse($('#citadelle').attr('data-tasks'));

    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];
        var id_taches = [];

        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                id_taches.push(task.id);
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td>${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#!"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1" 
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false" 
                    data-toggle="modal" 
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a
                    id="liste_taches"
                    data-number="${incident.number}"
                    data-tasks="${id_taches}"
                    class="dropdown-item"
                    href="#!"
                    data-backdrop="static" 
                    data-keyboard="false"
                    data-toggle="modal" 
                    data-target="#modall_tasks_incidents">
                    <span class="fe fe-list mr-4"></span> Liste Des Tâches
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
    `);

    }
});


$('#citadelle').change(function(){

    let incidentSiteSelectionne = [];
    let ids = JSON.parse($(this).attr('data-ids'));
    let sites = JSON.parse($(this).attr('data-sites'));
    let due_dates = JSON.parse($(this).attr('data-exited'));
    let regions = JSON.parse($(this).attr('data-regions'));
    let departements = JSON.parse($(this).attr('data-departements'));
    let dates = JSON.parse($(this).attr('data-created'));
    let incidents = JSON.parse($(this).attr('data-incidents'));
    //let user_connecter = JSON.parse($(this).attr('data-user_conneter'));
    let incident_direction_generale = [];
    let incidentAgences = [];

    $('#DateDebut').val('');
    $('#DateFin').val('');
    $('#DateFin').prop('disabled', true);

    $('#departes option').remove();
    $('#departes').append(`<option selected value="">Choisissez Un Département...</option>`);
    for (let v = 0; v < departements.length; v++) {
        const departement = departements[v];
        $('#departes').append(`<option value="${departement.id}">${departement.name}</option>`);
    }

    $('#regionnn option').remove();
    $('#regionnn').append(`<option selected value="">Choisissez Une Région...</option>`);
    for (let f = 0; f < regions.length; f++) {
        const region = regions[f];
        $('#regionnn').append(`<option value="${region}">${region}</option>`);
    }

    if($(this).val()){
        if($(this).val() == "dg"){
            $('#namels').replaceWith(`<span id="namels">Nombre D'Incidents</span>`);
            $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement">DIRECTON GENERALE</span>`)
            
            let ens = 0;
            let cls = 0;
            let ann = 0;
            let a_temps = 0;
            let enretard = 0;
            let incidant_encours = [];
            let incidant_enretard = [];
            let incidant_cloturer = [];
            let incidant_annuller = [];
            let nombre_cloture_enretard = 0;
            let nombre_cloture_a_temps = 0;
            let annee_selectionne = new Date().getFullYear();

            for (let k = 0; k < incidents.length; k++) {
                const monincident = incidents[k];
                let annee = dates[k].substring(0, 4);
                
                if(parseInt(annee) == annee_selectionne){

                    if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                    if(!monincident.site_id){
                        incidentSiteSelectionne.push(monincident);
                        incident_direction_generale.push(monincident);
                    }else{
                        incidentAgences.push(monincident);
                    }}
                }
            }
            

            for (let ot = 0; ot < sites.length; ot++) {
                const site = sites[ot];
    
                $(`#identi${ot}`).replaceWith(`
                    <span style="margin-right: -5em; position: relative;" id="identi${ot}">
                        0%
                    </span>        
                `);
    
                $(`#adenti${ot}`).replaceWith(`
                    <div class="my-4" id="adenti${ot}">
                        <div class="barcontainer">
                        <div 
                                class="bar bg-primary font-weight-bold text-sm"
                                style="height:0%;
                                text-align:center;
                                ">
                        </div>
                        </div>
                        <span style="writing-mode:vertical-rl; font-size:0.9em; margin-right: 2em; margin-top:3em;">${site.name}</span>
                    </div>      
                `)
            }
    
            
            for (let fe = 0; fe < departements.length; fe++) {
                const departement = departements[fe];
                
                let incident_dep_courant = [];

                for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                    const iic = incident_direction_generale[vt];
                    
                    if(iic.categories){
                    if(iic.categories.departement_id){
                        if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                            incident_dep_courant.push(iic);
                        }
                    }}
                }


                $(`#depi${fe}`).replaceWith(`
                    <div
                        id="depi${fe}"
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                        aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >
                        ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                    </div>
                `)
            }


            for (let o = 0; o < incidentSiteSelectionne.length; o++) {
                const incid = incidentSiteSelectionne[o];
                
                if(incid.status == "ENCOURS"){
                    ens +=1;
                    incidant_encours.push(incid);

                    let indes = -1;

                    if(incid.due_date){

                        for (let q = 0; q < ids.length; q++) {
                            const number = ids[q];
                            if(number == incid.number){
                                indes = q;
                            }
                        }
    
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                        if(dateEcheance < today){
                            enretard +=1;
                            incidant_enretard.push(incid);              
                        }else{
                            a_temps +=1;
                        } 
                    }
                    
                }else if(incid.status == "CLÔTURÉ"){
                    cls +=1;
                    incidant_cloturer.push(incid);

                    if(incid.due_date && incid.closure_date){
                        if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                            nombre_cloture_enretard +=1;
                        }else{
                            nombre_cloture_a_temps +=1;
                        }
                    }

                }else{
                    ann +=1;
                    incidant_annuller.push(incid);
                }
            }

            $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
            $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
            $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));

            $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
            $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);

            $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);
            $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
            $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
            $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
            $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);
            $('#tot').replaceWith(`<span class="h2" id="tot">${incidentSiteSelectionne.length < 10 ? 0 +""+ incidentSiteSelectionne.length : incidentSiteSelectionne.length}</span>`);


            $('#progress_cloture').replaceWith(`
                <div
                    id="progress_cloture" 
                    class="progress-bar bg-success" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? (cls/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? (cls/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_encours').replaceWith(`
                <div 
                    id="progress_encours" 
                    class="progress-bar bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? (ens/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? (ens/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_annule').replaceWith(`
                <div  
                    id="progress_annule" 
                    class="progress-bar bg-light" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? (ann/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? (ann/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" aria-valuemax="100"
                    > ${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentSiteSelectionne.length) * 100) : 0 : 0}% 
                </div>
            `);

            $('#progress_enretard').replaceWith(`
                <div 
                    id="progress_enretard"
                    class="progress-bar bg-warning" 
                    role="progressbar" 
                    style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                    aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
                </div>
            `);

            $('#progress_non_annuler').replaceWith(`
                <div 
                    id="progress_non_annuler" 
                    class="progress-bar progress-bar-striped bg-light" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentSiteSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_encours').replaceWith(`
                <div 
                    id="progress_non_encours" 
                    class="progress-bar progress-bar-striped bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentSiteSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $("#progress_non_cloture").replaceWith(`
                <div 
                    id="progress_non_cloture"
                    class="progress-bar progress-bar-striped bg-success"
                    role="progressbar"
                    style="width: ${incidentSiteSelectionne.length > 0 ? 
                        (((ens + ann)/incidentSiteSelectionne.length) * 100) > 0 ? 
                        (((ens + ann)/incidentSiteSelectionne.length) * 100) : 3 : 3}%"
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? ((ens + ann)/incidentSiteSelectionne.length) * 100 > 0 ? (((ens + ann)/incidentSiteSelectionne.length) * 100) : 3 : 3}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    ${incidentSiteSelectionne.length > 0 ? ((ens + ann)/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor(((ens + ann)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_enretard').replaceWith(`
                <div 
                    id="progress_non_enretard" 
                    class="progress-bar progress-bar-striped bg-warning"
                    role="progressbar" 
                    style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                    aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
                </div>
            `);

        }else{
        let site_selectionner = sites.find(s => s.id == $(this).val());
        $('#date_du').replaceWith(`<span id="date_du"></span>`);
        $('#namels').replaceWith(`<span id="namels">Nombre D'Incidents</span>`);
        $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement">${site_selectionner.name}</span>`)
        
        let ens = 0;
        let cls = 0;
        let ann = 0;
        let enretard = 0;
        let a_temps = 0;
        let incidant_encours = [];
        let incidant_enretard = [];
        let incidant_cloturer = [];
        let incidant_annuller = [];
        let nombre_cloture_enretard = 0;
        let nombre_cloture_a_temps = 0;
        let annee_selectionne = new Date().getFullYear();

        for (let k = 0; k < incidents.length; k++) {
            const monincident = incidents[k];
            let annee = dates[k].substring(0, 4);
            
            if(parseInt(annee) == parseInt(annee_selectionne)){

                if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                    if(monincident.site_id){

                        if(parseInt(monincident.site_id) == parseInt($(this).val())){
                            incidentSiteSelectionne.push(monincident);
                        }

                        incidentAgences.push(monincident);

                    }else{
                        incident_direction_generale.push(monincident);
                    }
                }
            }
        }


        for (let fe = 0; fe < departements.length; fe++) {
                        
            $(`#depi${fe}`).replaceWith(`
                <div
                    id="depi${fe}"
                    class="progress-bar bg-success" 
                    role="progressbar" 
                    style="width: 2%" 
                    aria-valuenow="2%" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >
                    0%
                </div>
            `);
        }


        for (let o = 0; o < incidentSiteSelectionne.length; o++) {
            const incid = incidentSiteSelectionne[o];
            
            if(incid.status == "ENCOURS"){
                ens +=1;
                incidant_encours.push(incid);

                let indes = -1;

                if(incid.due_date){

                    for (let q = 0; q < ids.length; q++) {
                        const number = ids[q];
                        if(number == incid.number){
                            indes = q;
                        }
                    }

                    let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                    let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                    if(dateEcheance < today){
                        enretard +=1;
                        incidant_enretard.push(incid);                   
                    }else{
                        a_temps +=1;
                    }  
                }
                
            }else if(incid.status == "CLÔTURÉ"){
                cls +=1;
                incidant_cloturer.push(incid);

                if(incid.due_date && incid.closure_date){
                    if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                        nombre_cloture_enretard +=1;
                    }else{
                        nombre_cloture_a_temps +=1;
                    }
                }

            }else{
                ann +=1;
                incidant_annuller.push(incid);
            }

        }


        for (let ot = 0; ot < sites.length; ot++) {
            const site = sites[ot];

            if(parseInt(site.id) == parseInt($(this).val())){
                $(`#identi${ot}`).replaceWith(`
                    <span style="margin-right: -5em; position: relative;" id="identi${ot}">
                        ${ incidentAgences.length > 0 ? (incidentSiteSelectionne.length/incidentAgences.length) * 100  > 0 ? Math.floor((incidentSiteSelectionne.length/incidentAgences.length) * 100) : 0 : 0 }%
                    </span>        
                `);

                $(`#adenti${ot}`).replaceWith(`
                    <div class="my-4" id="adenti${ot}">
                        <div class="barcontainer">
                        <div 
                                class="bar bg-primary font-weight-bold text-sm" 
                                style="height:${ incidentAgences.length > 0 ? (incidentSiteSelectionne.length/incidentAgences.length) * 100  > 0 ? (incidentSiteSelectionne.length/incidentAgences.length) * 100 : 0 : 0 }%; 
                                text-align:center;
                                ">
                        </div>
                        </div>
                        <span style="writing-mode:vertical-rl; font-size:0.9em; margin-right: 2em; margin-top:3em;">${site.name}</span>
                    </div>      
                `)
            }else{
                $(`#identi${ot}`).replaceWith(`
                    <span style="margin-right: -5em; position: relative;" id="identi${ot}">
                        0%
                    </span>        
                `);

                $(`#adenti${ot}`).replaceWith(`
                    <div class="my-4" id="adenti${ot}">
                        <div class="barcontainer">
                        <div 
                                class="bar bg-primary font-weight-bold text-sm" 
                                style="height:0%;
                                text-align:center;
                                ">
                        </div>
                        </div>
                        <span style="writing-mode:vertical-rl; font-size:0.9em; margin-right: 2em; margin-top:3em;">${site.name}</span>
                    </div>      
                `);
            }

        }

        $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
        $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
        $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));

        $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
        $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);

        $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

        $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
        $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
        $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
        $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);
        $('#tot').replaceWith(`<span class="h2" id="tot">${incidentSiteSelectionne.length < 10 ? 0 +""+ incidentSiteSelectionne.length : incidentSiteSelectionne.length}</span>`);


        $('#progress_cloture').replaceWith(`
            <div
                id="progress_cloture" 
                class="progress-bar bg-success" 
                role="progressbar" 
                style="width: ${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? (cls/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                aria-valuenow="${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? (cls/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100"
                >${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentSiteSelectionne.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_encours').replaceWith(`
            <div 
                id="progress_encours" 
                class="progress-bar bg-primary" 
                role="progressbar" 
                style="width: ${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? (ens/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                aria-valuenow="${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? (ens/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100"
                >${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentSiteSelectionne.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_annule').replaceWith(`
            <div  
                id="progress_annule" 
                class="progress-bar bg-light" 
                role="progressbar" 
                style="width: ${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? (ann/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                aria-valuenow="${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? (ann/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                aria-valuemin="0" aria-valuemax="100"
                > ${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentSiteSelectionne.length) * 100) : 0 : 0}% 
            </div>
        `);

        $('#progress_enretard').replaceWith(`
            <div 
                id="progress_enretard"
                class="progress-bar bg-warning" 
                role="progressbar" 
                style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                aria-valuemin="0"
                aria-valuemax="100"
                >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
            </div>
        `);

        $('#progress_non_encours').replaceWith(`
            <div 
                id="progress_non_encours" 
                class="progress-bar progress-bar-striped bg-primary" 
                role="progressbar" 
                style="width: ${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentSiteSelectionne.length) * 100 : 3 : 3}%" 
                aria-valuenow="${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
            </div>
        `);

        $("#progress_non_cloture").replaceWith(`
            <div 
                id="progress_non_cloture"
                class="progress-bar progress-bar-striped bg-success"
                role="progressbar"
                style="width: ${incidentSiteSelectionne.length > 0 ? 
                    (((ens + ann)/incidentSiteSelectionne.length) * 100) > 0 ? 
                    (((ens + ann)/incidentSiteSelectionne.length) * 100) : 3 : 3}%"
                aria-valuenow="${incidentSiteSelectionne.length > 0 ? ((ens + ann)/incidentSiteSelectionne.length) * 100 > 0 ? (((ens + ann)/incidentSiteSelectionne.length) * 100) : 3 : 3}"
                aria-valuemin="0"
                aria-valuemax="100">
                ${incidentSiteSelectionne.length > 0 ? ((ens + ann)/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor(((ens + ann)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_non_annuler').replaceWith(`
            <div 
                id="progress_non_annuler" 
                class="progress-bar progress-bar-striped bg-light" 
                role="progressbar" 
                style="width: ${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentSiteSelectionne.length) * 100 : 3 : 3}%" 
                aria-valuenow="${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_non_enretard').replaceWith(`
            <div 
                id="progress_non_enretard" 
                class="progress-bar progress-bar-striped bg-warning"
                role="progressbar" 
                style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
            </div>
        `);

        }
    }else{
        let tab = [];
        let ids = JSON.parse($(this).attr('data-ids'));
        let due_dates = JSON.parse($(this).attr('data-exited'));
        let dates = JSON.parse($(this).attr('data-created'));
        let incidents = JSON.parse($(this).attr('data-incidents'));
 
        let ens = 0;
        let cls = 0;
        let ann = 0;
        let enretard = 0;
        let a_temps = 0;
        let incidant_encours = [];
        let incidant_enretard = [];
        let incidant_cloturer = [];
        let incidant_annuller = [];
        let annee_selectionne = new Date().getFullYear();
        let nombre_cloture_enretard = 0;
        let nombre_cloture_a_temps = 0;

        for (let k = 0; k < incidents.length; k++) {
            const monincident = incidents[k];

            let annee = dates[k].substring(0, 4);

            if(parseInt(annee) == annee_selectionne){
                if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                    tab.push(monincident);
                }
            }
        }

        $('#namels').replaceWith(`<span id="namels"></span>`);
        $('#date_du').replaceWith(`<span id="date_du"></span>`);
        $('#tot').replaceWith(`<span class="h2" id="tot">${tab.length < 10 ? 0 +""+ tab.length : tab.length}</span>`);
        $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement"> Nombre D'Incidents Total</span>`);

        for (let o = 0; o < tab.length; o++) {
            const incid = tab[o];
            
            if(incid.status == "ENCOURS"){
                ens +=1;
                incidant_encours.push(incid);

                let indes = -1;

                if(incid.due_date){

                    for (let q = 0; q < ids.length; q++) {
                        const number = ids[q];
                        if(number == incid.number){
                            indes = q;
                        }
                    }

                    let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                    let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                    if(dateEcheance < today){
                        enretard +=1;
                        incidant_enretard.push(incid);                   
                    }    
                }
                
            }else if(incid.status == "CLÔTURÉ"){
                cls +=1;
                incidant_cloturer.push(incid);

                if(incid.due_date && incid.closure_date){
                    if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                        nombre_cloture_enretard +=1;
                    }else{
                        nombre_cloture_a_temps +=1;
                    }
                }

            }else{
                ann +=1;
                incidant_annuller.push(incid);
            }

            if(!incid.site_id){

                incident_direction_generale.push(incid);

            }else{
                incidentAgences.push(incid);
            }
        }


        for (let fe = 0; fe < departements.length; fe++) {
            const departement = departements[fe];
            
            let incident_dep_courant = [];

            for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                const iic = incident_direction_generale[vt];
                
                if(iic.categories.departement_id){
                    if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                        incident_dep_courant.push(iic);
                    }
                }
            }


            $(`#depi${fe}`).replaceWith(`
                <div
                    id="depi${fe}"
                    class="progress-bar bg-success" 
                    role="progressbar" 
                    style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                    aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >
                    ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                </div>
            `)
        }

        for (let ot = 0; ot < sites.length; ot++) {
            const site = sites[ot];
            
            let monincidentSite = [];

            for (let rt = 0; rt < incidentAgences.length; rt++) {
                const icident = incidentAgences[rt];
                
                if(icident.site_id == site.id){
                    monincidentSite.push(icident);
                }
            }

            $(`#identi${ot}`).replaceWith(`
                <span style="margin-right: -5em; position: relative;" id="identi${ot}">
                    ${ incidentAgences.length > 0 ? (monincidentSite.length/incidentAgences.length) * 100  > 0 ? Math.floor((monincidentSite.length/incidentAgences.length) * 100) : 0 : 0 }%
                </span>        
            `);

            $(`#adenti${ot}`).replaceWith(`
                <div class="my-4" id="adenti${ot}">
                    <div class="barcontainer">
                    <div 
                            class="bar bg-primary font-weight-bold text-sm" 
                            style="height:${ incidentAgences.length > 0 ? (monincidentSite.length/incidentAgences.length) * 100  > 0 ? (monincidentSite.length/incidentAgences.length) * 100 : 0 : 0 }%; 
                            text-align:center;
                            ">
                    </div>
                    </div>
                    <span style="writing-mode:vertical-rl; font-size:0.9em; margin-right: 2em; margin-top:3em;">${site.name}</span>
                </div>      
            `)
        }


        $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
        $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
        $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));

        $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
        $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
        $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

        $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
        $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
        $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
        $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);


        $('#progress_cloture').replaceWith(`
            <div
                id="progress_cloture" 
                class="progress-bar bg-success" 
                role="progressbar" 
                style="width: ${tab.length > 0 ? (cls/tab.length) * 100 > 0 ? (cls/tab.length) * 100 : 3 : 3}%;" 
                aria-valuenow="${tab.length > 0 ? (cls/tab.length) * 100 > 0 ? (cls/tab.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100"
                >${tab.length > 0 ? (cls/tab.length) * 100 > 0 ? Math.floor((cls/tab.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_encours').replaceWith(`
            <div 
                id="progress_encours" 
                class="progress-bar bg-primary" 
                role="progressbar" 
                style="width: ${tab.length > 0 ? (ens/tab.length) * 100 > 0 ? (ens/tab.length) * 100 : 3 : 3}%;" 
                aria-valuenow="${tab.length > 0 ? (ens/tab.length) * 100 > 0 ? (ens/tab.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100"
                >${tab.length > 0 ? (ens/tab.length) * 100 > 0 ? Math.floor((ens/tab.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_annule').replaceWith(`
            <div  
                id="progress_annule" 
                class="progress-bar bg-light" 
                role="progressbar" 
                style="width: ${tab.length > 0 ? (ann/tab.length) * 100 > 0 ? (ann/tab.length) * 100 : 3 : 3}%;" 
                aria-valuenow="${tab.length > 0 ? (ann/tab.length) * 100 > 0 ? (ann/tab.length) * 100 : 3 : 3}" 
                aria-valuemin="0" aria-valuemax="100"
                > ${tab.length > 0 ? (ann/tab.length) * 100 > 0 ? Math.floor((ann/tab.length) * 100) : 0 : 0}% 
            </div>
        `);

        $('#progress_enretard').replaceWith(`
            <div 
                id="progress_enretard"
                class="progress-bar bg-warning" 
                role="progressbar" 
                style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                aria-valuemin="0"
                aria-valuemax="100"
                >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
            </div>
        `);

        $('#progress_non_encours').replaceWith(`
            <div 
                id="progress_non_encours" 
                class="progress-bar progress-bar-striped bg-primary" 
                role="progressbar" 
                style="width: ${tab.length > 0 ? (((cls+ann)/tab.length) * 100) > 0 ? ((cls+ann)/tab.length) * 100 : 3 : 3}%" 
                aria-valuenow="${tab.length > 0 ? (((cls+ann)/tab.length) * 100) > 0 ? ((cls+ann)/tab.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${tab.length > 0 ? (((cls+ann)/tab.length) * 100) > 0 ? Math.floor(((cls+ann)/tab.length) * 100) : 0 : 0}%
            </div>
        `);

        $("#progress_non_cloture").replaceWith(`
            <div 
                id="progress_non_cloture"
                class="progress-bar progress-bar-striped bg-success"
                role="progressbar"
                style="width: ${tab.length > 0 ? 
                    (((ens + ann)/tab.length) * 100) > 0 ? 
                    (((ens + ann)/tab.length) * 100) : 3 : 3}%"
                aria-valuenow="${tab.length > 0 ? (((ens + ann)/tab.length) * 100) > 0 ? (((ens + ann)/tab.length) * 100) : 3 : 3}"
                aria-valuemin="0"
                aria-valuemax="100">
                ${tab.length > 0 ? (((ens + ann)/tab.length) * 100) > 0 ? Math.floor(((ens + ann)/tab.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_non_annuler').replaceWith(`
            <div 
                id="progress_non_annuler" 
                class="progress-bar progress-bar-striped bg-light" 
                role="progressbar" 
                style="width: ${tab.length > 0 ? (((cls+ens)/tab.length) * 100) > 0 ? ((cls+ens)/tab.length) * 100 : 3 : 3}%" 
                aria-valuenow="${tab.length > 0 ? (((cls+ens)/tab.length) * 100) > 0 ? ((cls+ens)/tab.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${tab.length > 0 ? (((cls+ens)/tab.length) * 100) > 0 ? Math.floor(((cls+ens)/tab.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_non_enretard').replaceWith(`
            <div 
                id="progress_non_enretard" 
                class="progress-bar progress-bar-striped bg-warning"
                role="progressbar" 
                style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
            </div>
        `);

    }
});

$('#departes').change(function(){

    let incidentDepartementSelectionne = [];
    let ids = JSON.parse($(this).attr('data-ids'));
    let sites = JSON.parse($(this).attr('data-sites'));
    let due_dates = JSON.parse($(this).attr('data-exited'));
    let dates = JSON.parse($(this).attr('data-created'));
    let regions = JSON.parse($(this).attr('data-regions'));
    let incidents = JSON.parse($(this).attr('data-incidents'));
    let departements = JSON.parse($(this).attr('data-departements'));
    let incident_direction_generale = [];
    let incidentAgences = [];

    $('#DateDebut').val('');
    $('#DateFin').val('');
    $('#DateFin').prop('disabled', true);

    $('#citadelle option').remove();
    $('#citadelle').append(`<option selected value="">Choisissez Un Site...</option>`);
    $('#citadelle').append(`<option value="dg">DIRECTION GENERALE</option>`);
    for (let v = 0; v < sites.length; v++) {
        const site = sites[v];
        $('#citadelle').append(`<option value="${site.id}">${site.name}</option>`);
    }

    $('#regionnn option').remove();
    $('#regionnn').append(`<option selected value="">Choisissez Une Région...</option>`);
    for (let f = 0; f < regions.length; f++) {
        const region = regions[f];
        $('#regionnn').append(`<option value="${region}">${region}</option>`);
    }

    if($(this).val()){
        let departement_selectionner = departements.find(d => d.id == $(this).val());

        $('#date_du').replaceWith(`<span id="date_du"></span>`);
        $('#namels').replaceWith(`<span id="namels">Nombre D'Incidents Du Département</span>`);
        $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement">${departement_selectionner.name}</span>`);
        
        let ens = 0;
        let cls = 0;
        let ann = 0;
        let enretard = 0;
        let a_temps = 0;
        let incidant_encours = [];
        let incidant_enretard = [];
        let incidant_cloturer = [];
        let incidant_annuller = [];
        let annee_selectionne = new Date().getFullYear();
        let nombre_cloture_enretard = 0;
        let nombre_cloture_a_temps = 0;

        for (let k = 0; k < incidents.length; k++) {
            const monincident = incidents[k];

            let annee = dates[k].substring(0, 4);

            if(parseInt(annee) == annee_selectionne){

                if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                    if(monincident.categories){
                    if(monincident.categories.departement_id){
                        if(monincident.categories.departement_id == $('#departes').val()){
                            incidentDepartementSelectionne.push(monincident);
                        }
                    }}
        
                    if(!monincident.site_id){
                        incident_direction_generale.push(monincident);
                    }
                }
            }
        }

        for (let ot = 0; ot < sites.length; ot++) {
            const site = sites[ot];

            $(`#identi${ot}`).replaceWith(`
                <span style="margin-right: -5em; position: relative;" id="identi${ot}">
                    0%
                </span>        
            `);

            $(`#adenti${ot}`).replaceWith(`
                <div class="my-4" id="adenti${ot}">
                    <div class="barcontainer">
                    <div 
                            class="bar bg-primary font-weight-bold text-sm"
                            style="height:0%;
                            text-align:center;
                            ">
                    </div>
                    </div>
                    <span style="writing-mode:vertical-rl; font-size:0.9em; margin-right: 2em; margin-top:3em;">${site.name}</span>
                </div>      
            `)
        }

                    
        let incident_dep_courant = [];

        for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                const iic = incident_direction_generale[vt];
                
                if(iic.categories){
                if(iic.categories.departement_id){
                    if(parseInt(iic.categories.departements.id) == parseInt($(this).val())){
                        incident_dep_courant.push(iic);
                    }
                }}
        }

        for (let fe = 0; fe < departements.length; fe++) {
                const departement = departements[fe];
                
                if(parseInt(departement.id) == parseInt($(this).val())){
                    $(`#depi${fe}`).replaceWith(`
                    <div
                        id="depi${fe}"
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: ${ incident_direction_generale.length > 0 ? ((incident_dep_courant.length/incident_direction_generale.length) * 100) > 0 ? ((incident_dep_courant.length/incident_direction_generale.length) * 100) : 2 : 2 }%" 
                        aria-valuenow="${ incident_direction_generale.length > 0 ? ((incident_dep_courant.length/incident_direction_generale.length) * 100) > 0 ? ((incident_dep_courant.length/incident_direction_generale.length) * 100) : 2 : 2 }%" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >
                        ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                    </div>
                    `)
                }else{
                    $(`#depi${fe}`).replaceWith(`
                    <div
                        id="depi${fe}"
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: 2%" 
                        aria-valuenow="2%" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >
                        0%
                    </div>
                    `);
                }
        }

        $('#tot').replaceWith(`<span class="h2" id="tot">${incidentDepartementSelectionne.length < 10 ? 0 +""+ incidentDepartementSelectionne.length : incidentDepartementSelectionne.length}</span>`);

        for (let o = 0; o < incidentDepartementSelectionne.length; o++) {
            const incid = incidentDepartementSelectionne[o];
            
            if(incid.status == "ENCOURS"){
                ens +=1;
                incidant_encours.push(incid);

                let indes = -1;

                if(incid.due_date){

                    for (let q = 0; q < ids.length; q++) {
                        const number = ids[q];
                        if(number == incid.number){
                            indes = q;
                        }
                    }

                    let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                    let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                    if(dateEcheance < today){
                        enretard +=1;
                        incidant_enretard.push(incid);                   
                    }else{
                        a_temps +=1;
                    }    
                }
                
            }else if(incid.status == "CLÔTURÉ"){
                cls +=1;
                incidant_cloturer.push(incid);

                if(incid.due_date && incid.closure_date){
                    if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                        nombre_cloture_enretard +=1;
                    }else{
                        nombre_cloture_a_temps +=1;
                    }
                }

            }else{
                ann +=1;
                incidant_annuller.push(incid);
            }

        }

        $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
        //$('#floder_retard').attr('data-retards', JSON.stringify(incidant_enretard));
        $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
        $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));

        $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
        $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);

        $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

        $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
        $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
        $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
        $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);


        $('#progress_cloture').replaceWith(`
            <div
                id="progress_cloture" 
                class="progress-bar bg-success" 
                role="progressbar" 
                style="width: ${incidentDepartementSelectionne.length > 0 ? (cls/incidentDepartementSelectionne.length) * 100 > 0 ? (cls/incidentDepartementSelectionne.length) * 100 : 3 : 3}%;" 
                aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (cls/incidentDepartementSelectionne.length) * 100 > 0 ? (cls/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100"
                >${incidentDepartementSelectionne.length > 0 ? (cls/incidentDepartementSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_encours').replaceWith(`
            <div 
                id="progress_encours" 
                class="progress-bar bg-primary" 
                role="progressbar" 
                style="width: ${incidentDepartementSelectionne.length > 0 ? (ens/incidentDepartementSelectionne.length) * 100 > 0 ? (ens/incidentDepartementSelectionne.length) * 100 : 3 : 3}%;" 
                aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (ens/incidentDepartementSelectionne.length) * 100 > 0 ? (ens/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100"
                >${incidentDepartementSelectionne.length > 0 ? (ens/incidentDepartementSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_annule').replaceWith(`
            <div  
                id="progress_annule" 
                class="progress-bar bg-light" 
                role="progressbar" 
                style="width: ${incidentDepartementSelectionne.length > 0 ? (ann/incidentDepartementSelectionne.length) * 100 > 0 ? (ann/incidentDepartementSelectionne.length) * 100 : 3 : 3}%;" 
                aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (ann/incidentDepartementSelectionne.length) * 100 > 0 ? (ann/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                aria-valuemin="0" aria-valuemax="100"
                > ${incidentDepartementSelectionne.length > 0 ? (ann/incidentDepartementSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentDepartementSelectionne.length) * 100) : 0 : 0}% 
            </div>
        `);

        $('#progress_enretard').replaceWith(`
            <div 
                id="progress_enretard"
                class="progress-bar bg-warning" 
                role="progressbar" 
                style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                aria-valuemin="0"
                aria-valuemax="100"
                >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
            </div>
        `);

        $('#progress_non_encours').replaceWith(`
            <div 
                id="progress_non_encours" 
                class="progress-bar progress-bar-striped bg-primary" 
                role="progressbar" 
                style="width: ${incidentDepartementSelectionne.length > 0 ? (((cls+ann)/incidentDepartementSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentDepartementSelectionne.length) * 100 : 3 : 3}%" 
                aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (((cls+ann)/incidentDepartementSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${incidentDepartementSelectionne.length > 0 ? (((cls+ann)/incidentDepartementSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
            </div>
        `);

        $("#progress_non_cloture").replaceWith(`
            <div 
                id="progress_non_cloture"
                class="progress-bar progress-bar-striped bg-success"
                role="progressbar"
                style="width: ${incidentDepartementSelectionne.length > 0 ? 
                    (((ens + ann)/incidentDepartementSelectionne.length) * 100) > 0 ? 
                    (((ens + ann)/incidentDepartementSelectionne.length) * 100) : 3 : 3}%"
                aria-valuenow="${incidentDepartementSelectionne.length > 0 ? ((ens + ann)/incidentDepartementSelectionne.length) * 100 > 0 ? (((ens + ann)/incidentDepartementSelectionne.length) * 100) : 3 : 3}"
                aria-valuemin="0"
                aria-valuemax="100">
                ${incidentDepartementSelectionne.length > 0 ? ((ens + ann)/incidentDepartementSelectionne.length) * 100 > 0 ? Math.floor(((ens + ann)/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_non_annuler').replaceWith(`
            <div 
                id="progress_non_annuler" 
                class="progress-bar progress-bar-striped bg-light" 
                role="progressbar" 
                style="width: ${incidentDepartementSelectionne.length > 0 ? (((cls+ens)/incidentDepartementSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentDepartementSelectionne.length) * 100 : 3 : 3}%" 
                aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (((cls+ens)/incidentDepartementSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${incidentDepartementSelectionne.length > 0 ? (((cls+ens)/incidentDepartementSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_non_enretard').replaceWith(`
            <div 
                id="progress_non_enretard" 
                class="progress-bar progress-bar-striped bg-warning"
                role="progressbar" 
                style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
            </div>
        `);

    }else{
        let tab = [];
        let ids = JSON.parse($(this).attr('data-ids'));
        let due_dates = JSON.parse($(this).attr('data-exited'));
        let dates = JSON.parse($(this).attr('data-created'));
        let incidents = JSON.parse($(this).attr('data-incidents'));
 
        let ens = 0;
        let cls = 0;
        let ann = 0;
        let enretard = 0;
        let a_temps = 0;
        let incidant_encours = [];
        let incidant_enretard = [];
        let incidant_cloturer = [];
        let incidant_annuller = [];
        let annee_selectionne = new Date().getFullYear();
        let nombre_cloture_enretard = 0;
        let nombre_cloture_a_temps = 0;

        for (let k = 0; k < incidents.length; k++) {
            const monincident = incidents[k];

            let annee = dates[k].substring(0, 4);

            if(parseInt(annee) == parseInt(annee_selectionne)){
                if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                    tab.push(monincident);
                }
            }
        }

        $('#namels').replaceWith(`<span id="namels"></span>`);
        $('#date_du').replaceWith(`<span id="date_du"></span>`);
        $('#tot').replaceWith(`<span class="h2" id="tot">${tab.length < 10 ? 0 +""+ tab.length : tab.length}</span>`);
        $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement"> Nombre D'Incidents Total</span>`);


        for (let o = 0; o < tab.length; o++) {
            const incid = tab[o];
            
            if(incid.status == "ENCOURS"){
                ens +=1;
                incidant_encours.push(incid);

                let indes = -1;

                if(incid.due_date){

                    for (let q = 0; q < ids.length; q++) {
                        const number = ids[q];
                        if(number == incid.number){
                            indes = q;
                        }
                    }

                    let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                    let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                    if(dateEcheance < today){
                        enretard +=1;
                        incidant_enretard.push(incid);                   
                    }else{
                        a_temps +=1;
                    }    
                }
                
            }else if(incid.status == "CLÔTURÉ"){
                cls +=1;
                incidant_cloturer.push(incid);

                if(incid.due_date && incid.closure_date){
                    if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                        nombre_cloture_enretard +=1;
                    }else{
                        nombre_cloture_a_temps +=1;
                    }
                }

            }else{
                ann +=1;
                incidant_annuller.push(incid);
            }

            if(incid.site_id){
                incidentAgences.push(incid);
            }
        }


        for (let ot = 0; ot < sites.length; ot++) {
            const site = sites[ot];
            
            let monincidentSite = [];

            for (let rt = 0; rt < incidentAgences.length; rt++) {
                const icident = incidentAgences[rt];
                
                if(icident.site_id == site.id){
                    monincidentSite.push(icident);
                }
            }

            $(`#identi${ot}`).replaceWith(`
                <span style="margin-right: -5em; position: relative;" id="identi${ot}">
                    ${ incidentAgences.length > 0 ? (monincidentSite.length/incidentAgences.length) * 100  > 0 ? Math.floor((monincidentSite.length/incidentAgences.length) * 100) : 0 : 0 }%
                </span>        
            `);

            $(`#adenti${ot}`).replaceWith(`
                <div class="my-4" id="adenti${ot}">
                    <div class="barcontainer">
                    <div 
                            class="bar bg-primary font-weight-bold text-sm" 
                            style="height:${ incidentAgences.length > 0 ? (monincidentSite.length/incidentAgences.length) * 100  > 0 ? (monincidentSite.length/incidentAgences.length) * 100 : 0 : 0 }%; 
                            text-align:center;
                            ">
                    </div>
                    </div>
                    <span style="writing-mode:vertical-rl; font-size:0.9em; margin-right: 2em; margin-top:3em;">${site.name}</span>
                </div>      
            `)
        }

        
        $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
        $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
        $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));

        $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
        $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
        $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

        $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
        $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
        $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
        $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);


        $('#progress_cloture').replaceWith(`
            <div
                id="progress_cloture" 
                class="progress-bar bg-success" 
                role="progressbar" 
                style="width: ${tab.length > 0 ? (cls/tab.length) * 100 > 0 ? (cls/tab.length) * 100 : 3 : 3}%;" 
                aria-valuenow="${tab.length > 0 ? (cls/tab.length) * 100 > 0 ? (cls/tab.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100"
                >${tab.length > 0 ? (cls/tab.length) * 100 > 0 ? Math.floor((cls/tab.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_encours').replaceWith(`
            <div 
                id="progress_encours" 
                class="progress-bar bg-primary" 
                role="progressbar" 
                style="width: ${tab.length > 0 ? (ens/tab.length) * 100 > 0 ? (ens/tab.length) * 100 : 3 : 3}%;" 
                aria-valuenow="${tab.length > 0 ? (ens/tab.length) * 100 > 0 ? (ens/tab.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100"
                >${tab.length > 0 ? (ens/tab.length) * 100 > 0 ? Math.floor((ens/tab.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_annule').replaceWith(`
            <div  
                id="progress_annule" 
                class="progress-bar bg-light" 
                role="progressbar" 
                style="width: ${tab.length > 0 ? (ann/tab.length) * 100 > 0 ? (ann/tab.length) * 100 : 3 : 3}%;" 
                aria-valuenow="${tab.length > 0 ? (ann/tab.length) * 100 > 0 ? (ann/tab.length) * 100 : 3 : 3}" 
                aria-valuemin="0" aria-valuemax="100"
                > ${tab.length > 0 ? (ann/tab.length) * 100 > 0 ? Math.floor((ann/tab.length) * 100) : 0 : 0}% 
            </div>
        `);

        $('#progress_enretard').replaceWith(`
            <div 
                id="progress_enretard"
                class="progress-bar bg-warning" 
                role="progressbar" 
                style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                aria-valuemin="0"
                aria-valuemax="100"
                >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
            </div>
        `);

        $('#progress_non_encours').replaceWith(`
            <div 
                id="progress_non_encours" 
                class="progress-bar progress-bar-striped bg-primary" 
                role="progressbar" 
                style="width: ${tab.length > 0 ? (((cls+ann)/tab.length) * 100) > 0 ? ((cls+ann)/tab.length) * 100 : 3 : 3}%" 
                aria-valuenow="${tab.length > 0 ? (((cls+ann)/tab.length) * 100) > 0 ? ((cls+ann)/tab.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${tab.length > 0 ? (((cls+ann)/tab.length) * 100) > 0 ? Math.floor(((cls+ann)/tab.length) * 100) : 0 : 0}%
            </div>
        `);

        $("#progress_non_cloture").replaceWith(`
            <div 
                id="progress_non_cloture"
                class="progress-bar progress-bar-striped bg-success"
                role="progressbar"
                style="width: ${tab.length > 0 ? 
                    (((ens + ann)/tab.length) * 100) > 0 ? 
                    (((ens + ann)/tab.length) * 100) : 3 : 3}%"
                aria-valuenow="${tab.length > 0 ? (((ens + ann)/tab.length) * 100) > 0 ? (((ens + ann)/tab.length) * 100) : 3 : 3}"
                aria-valuemin="0"
                aria-valuemax="100">
                ${tab.length > 0 ? (((ens + ann)/tab.length) * 100) > 0 ? Math.floor(((ens + ann)/tab.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_non_annuler').replaceWith(`
            <div 
                id="progress_non_annuler" 
                class="progress-bar progress-bar-striped bg-light" 
                role="progressbar" 
                style="width: ${tab.length > 0 ? (((cls+ens)/tab.length) * 100) > 0 ? ((cls+ens)/tab.length) * 100 : 3 : 3}%" 
                aria-valuenow="${tab.length > 0 ? (((cls+ens)/tab.length) * 100) > 0 ? ((cls+ens)/tab.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${tab.length > 0 ? (((cls+ens)/tab.length) * 100) > 0 ? Math.floor(((cls+ens)/tab.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_non_enretard').replaceWith(`
            <div 
                id="progress_non_enretard" 
                class="progress-bar progress-bar-striped bg-warning"
                role="progressbar" 
                style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
            </div>
        `);

    }

}
);

$('#regionnn').change(function(){

    let incidentRegionSelectionne = [];
    let ids = JSON.parse($(this).attr('data-ids'));
    let due_dates = JSON.parse($(this).attr('data-exited'));
    let dates = JSON.parse($(this).attr('data-created'));
    let incidents = JSON.parse($(this).attr('data-incidents'));
    let sites = JSON.parse($(this).attr('data-sites'));
    let departements = JSON.parse($(this).attr('data-departements'));
    let incident_direction_generale = [];
    let incidentAgences = [];
    
    $('#DateDebut').val('');
    $('#DateFin').val('');
    $('#DateFin').prop('disabled', true);

    //Reset Site
    $('#citadelle option').remove();
    $('#citadelle').append(`<option selected value="">Choisissez Un Site...</option>`);
    $('#citadelle').append(`<option value="dg">DIRECTION GENERALE</option>`);
    for (let v = 0; v < sites.length; v++) {
        const site = sites[v];
        $('#citadelle').append(`<option value="${site.id}">${site.name}</option>`);
    }

    //Reset Departement
    $('#departes option').remove();
    $('#departes').append(`<option selected value="">Choisissez Un Département...</option>`);
    for (let v = 0; v < departements.length; v++) {
        const departement = departements[v];
        $('#departes').append(`<option value="${departement.id}">${departement.name}</option>`);
    }

    if($(this).val()){
        let region = $(this).val();

        $('#date_du').replaceWith(`<span id="date_du"></span>`);
        $('#namels').replaceWith(`<span id="namels">Nombre D'Incidents De La Région</span>`);
        $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement">${region}</span>`);

        let ens = 0;
        let cls = 0;
        let ann = 0;
        let enretard = 0;
        let a_temps = 0;
        let incidant_encours = [];
        let incidant_enretard = [];
        let incidant_cloturer = [];
        let incidant_annuller = [];
        let annee_selectionne = new Date().getFullYear();
        let incidentAgences = [];
        let nombre_cloture_enretard = 0;
        let nombre_cloture_a_temps = 0;

        for (let k = 0; k < incidents.length; k++) {
            const monincident = incidents[k];
            let annee = dates[k].substring(0, 4);
            
            if(parseInt(annee) == annee_selectionne){

                if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                    if(monincident.site_id){

                        if(monincident.sites.region == $(this).val()){
                            incidentRegionSelectionne.push(monincident);
                        }

                        incidentAgences.push(monincident);

                    }else{

                        incident_direction_generale.push(monincident);

                        if($(this).val() == "LITTORAL"){
                            if(!monincident.site_id){
                                incidentRegionSelectionne.push(monincident);
                            }
                        }
                    }
                }
            }
        }

        for (let ot = 0; ot < sites.length; ot++) {
            const site = sites[ot];

            $(`#identi${ot}`).replaceWith(`
                <span style="margin-right: -5em; position: relative;" id="identi${ot}">
                    0%
                </span>        
            `);

            $(`#adenti${ot}`).replaceWith(`
                <div class="my-4" id="adenti${ot}">
                    <div class="barcontainer">
                    <div 
                            class="bar bg-primary font-weight-bold text-sm"
                            style="height:0%;
                            text-align:center;
                            ">
                    </div>
                    </div>
                    <span style="writing-mode:vertical-rl; font-size:0.9em; margin-right: 2em; margin-top:3em;">${site.name}</span>
                </div>      
            `)
        }


        for (let fe = 0; fe < departements.length; fe++) {

            $(`#depi${fe}`).replaceWith(`
                <div
                    id="depi${fe}"
                    class="progress-bar bg-success" 
                    role="progressbar" 
                    style="width: 2%" 
                    aria-valuenow="2%" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >
                    0%
                </div>
            `)
        }


        for (let o = 0; o < incidentRegionSelectionne.length; o++) {
            const incid = incidentRegionSelectionne[o];
            
            if(incid.status == "ENCOURS"){
                ens +=1;
                incidant_encours.push(incid);

                let indes = -1;

                if(incid.due_date){

                    for (let q = 0; q < ids.length; q++) {
                        const number = ids[q];
                        if(number == incid.number){
                            indes = q;
                        }
                    }

                    let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                    let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                    if(dateEcheance < today){
                        enretard +=1;
                        incidant_enretard.push(incid);                
                    }else{
                        a_temps +=1;
                    }  
                }
                
            }else if(incid.status == "CLÔTURÉ"){
                cls +=1;
                incidant_cloturer.push(incid);

                if(incid.due_date && incid.closure_date){
                    if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                        nombre_cloture_enretard +=1;
                    }else{
                        nombre_cloture_a_temps +=1;
                    }
                }

            }else{
                ann +=1;
                incidant_annuller.push(incid);
            }

        }

        $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
        $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
        $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));

        $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
        $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);

        $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

        $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
        $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
        $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
        $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);
        $('#tot').replaceWith(`<span class="h2" id="tot">${incidentRegionSelectionne.length < 10 ? 0 +""+ incidentRegionSelectionne.length : incidentRegionSelectionne.length}</span>`);


        $('#progress_cloture').replaceWith(`
            <div
                id="progress_cloture" 
                class="progress-bar bg-success" 
                role="progressbar" 
                style="width: ${incidentRegionSelectionne.length > 0 ? (cls/incidentRegionSelectionne.length) * 100 > 0 ? (cls/incidentRegionSelectionne.length) * 100 : 3 : 3}%;" 
                aria-valuenow="${incidentRegionSelectionne.length > 0 ? (cls/incidentRegionSelectionne.length) * 100 > 0 ? (cls/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100"
                >${incidentRegionSelectionne.length > 0 ? (cls/incidentRegionSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentRegionSelectionne.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_encours').replaceWith(`
            <div 
                id="progress_encours" 
                class="progress-bar bg-primary" 
                role="progressbar" 
                style="width: ${incidentRegionSelectionne.length > 0 ? (ens/incidentRegionSelectionne.length) * 100 > 0 ? (ens/incidentRegionSelectionne.length) * 100 : 3 : 3}%;" 
                aria-valuenow="${incidentRegionSelectionne.length > 0 ? (ens/incidentRegionSelectionne.length) * 100 > 0 ? (ens/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100"
                >${incidentRegionSelectionne.length > 0 ? (ens/incidentRegionSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentRegionSelectionne.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_annule').replaceWith(`
            <div  
                id="progress_annule" 
                class="progress-bar bg-light" 
                role="progressbar" 
                style="width: ${incidentRegionSelectionne.length > 0 ? (ann/incidentRegionSelectionne.length) * 100 > 0 ? (ann/incidentRegionSelectionne.length) * 100 : 3 : 3}%;" 
                aria-valuenow="${incidentRegionSelectionne.length > 0 ? (ann/incidentRegionSelectionne.length) * 100 > 0 ? (ann/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                aria-valuemin="0" aria-valuemax="100"
                > ${incidentRegionSelectionne.length > 0 ? (ann/incidentRegionSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentRegionSelectionne.length) * 100) : 0 : 0}% 
            </div>
        `);

        $('#progress_enretard').replaceWith(`
            <div 
                id="progress_enretard"
                class="progress-bar bg-warning" 
                role="progressbar" 
                style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                aria-valuemin="0"
                aria-valuemax="100"
                >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
            </div>
        `);

        $('#progress_non_encours').replaceWith(`
            <div 
                id="progress_non_encours" 
                class="progress-bar progress-bar-striped bg-primary" 
                role="progressbar" 
                style="width: ${incidentRegionSelectionne.length > 0 ? (((cls+ann)/incidentRegionSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentRegionSelectionne.length) * 100 : 3 : 3}%" 
                aria-valuenow="${incidentRegionSelectionne.length > 0 ? (((cls+ann)/incidentRegionSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${incidentRegionSelectionne.length > 0 ? (((cls+ann)/incidentRegionSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentRegionSelectionne.length) * 100) : 0 : 0}%
            </div>
        `);

        $("#progress_non_cloture").replaceWith(`
            <div 
                id="progress_non_cloture"
                class="progress-bar progress-bar-striped bg-success"
                role="progressbar"
                style="width: ${incidentRegionSelectionne.length > 0 ? 
                    (((ens + ann)/incidentRegionSelectionne.length) * 100) > 0 ? 
                    (((ens + ann)/incidentRegionSelectionne.length) * 100) : 3 : 3}%"
                aria-valuenow="${incidentRegionSelectionne.length > 0 ? (((ens + ann)/incidentRegionSelectionne.length) * 100) > 0 ? (((ens + ann)/incidentRegionSelectionne.length) * 100) : 3 : 3}"
                aria-valuemin="0"
                aria-valuemax="100">
                ${incidentRegionSelectionne.length > 0 ? (((ens + ann)/incidentRegionSelectionne.length) * 100) > 0 ? Math.floor(((ens + ann)/incidentRegionSelectionne.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_non_annuler').replaceWith(`
            <div 
                id="progress_non_annuler" 
                class="progress-bar progress-bar-striped bg-light" 
                role="progressbar" 
                style="width: ${incidentRegionSelectionne.length > 0 ? (((cls+ens)/incidentRegionSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentRegionSelectionne.length) * 100 : 3 : 3}%" 
                aria-valuenow="${incidentRegionSelectionne.length > 0 ? (((cls+ens)/incidentRegionSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${incidentRegionSelectionne.length > 0 ? (((cls+ens)/incidentRegionSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentRegionSelectionne.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_non_enretard').replaceWith(`
            <div 
                id="progress_non_enretard" 
                class="progress-bar progress-bar-striped bg-warning"
                role="progressbar" 
                style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
            </div>
        `);

    }else{
        let tab = [];
        let ids = JSON.parse($(this).attr('data-ids'));
        let due_dates = JSON.parse($(this).attr('data-exited'));
        let dates = JSON.parse($(this).attr('data-created'));
        let incidents = JSON.parse($(this).attr('data-incidents'));
 
        let ens = 0;
        let cls = 0;
        let ann = 0;
        let enretard = 0;
        let a_temps = 0;
        let incidant_encours = [];
        let incidant_enretard = [];
        let incidant_cloturer = [];
        let incidant_annuller = [];
        let annee_selectionne = new Date().getFullYear();
        let nombre_cloture_enretard = 0;
        let nombre_cloture_a_temps = 0;

        for (let k = 0; k < incidents.length; k++) {
            const monincident = incidents[k];

            let annee = dates[k].substring(0, 4);

            if(parseInt(annee) == parseInt(annee_selectionne)){
                if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                    tab.push(monincident);
                }
            }
        }

        $('#namels').replaceWith(`<span id="namels"></span>`);
        $('#date_du').replaceWith(`<span id="date_du"></span>`);
        $('#tot').replaceWith(`<span class="h2" id="tot">${tab.length < 10 ? 0 +""+ tab.length : tab.length}</span>`);
        $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement"> Nombre D'Incidents Total</span>`);


        for (let o = 0; o < tab.length; o++) {
            const incid = tab[o];
            
            if(incid.status == "ENCOURS"){
                ens +=1;
                incidant_encours.push(incid);

                let indes = -1;

                if(incid.due_date){

                    for (let q = 0; q < ids.length; q++) {
                        const number = ids[q];
                        if(number == incid.number){
                            indes = q;
                        }
                    }

                    let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                    let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                    if(dateEcheance < today){
                        enretard +=1;
                        incidant_enretard.push(incid);                   
                    }else{
                        a_temps +=1;
                    }    
                }
                
            }else if(incid.status == "CLÔTURÉ"){
                cls +=1;
                incidant_cloturer.push(incid);

                if(incid.due_date && incid.closure_date){
                    if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                        nombre_cloture_enretard +=1;
                    }else{
                        nombre_cloture_a_temps +=1;
                    }
                }

            }else{
                ann +=1;
                incidant_annuller.push(incid);
            }

            if(!incid.site_id){
                incident_direction_generale.push(incid);
            }else{
                incidentAgences.push(incid);
            }
        }


        for (let fe = 0; fe < departements.length; fe++) {
            const departement = departements[fe];
            
            let incident_dep_courant = [];

            for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                const iic = incident_direction_generale[vt];
                
                if(iic.categories.departement_id){
                    if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                        incident_dep_courant.push(iic);
                    }
                }
            }


            $(`#depi${fe}`).replaceWith(`
                <div
                    id="depi${fe}"
                    class="progress-bar bg-success" 
                    role="progressbar" 
                    style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                    aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >
                    ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                </div>
            `)
        }


        for (let ot = 0; ot < sites.length; ot++) {
            const site = sites[ot];
            
            let monincidentSite = [];

            for (let rt = 0; rt < incidentAgences.length; rt++) {
                const icident = incidentAgences[rt];
                
                if(icident.site_id == site.id){
                    monincidentSite.push(icident);
                }
            }

            $(`#identi${ot}`).replaceWith(`
                <span style="margin-right: -5em; position: relative;" id="identi${ot}">
                    ${ incidentAgences.length > 0 ? (monincidentSite.length/incidentAgences.length) * 100  > 0 ? Math.floor((monincidentSite.length/incidentAgences.length) * 100) : 0 : 0 }%
                </span>        
            `);

            $(`#adenti${ot}`).replaceWith(`
                <div class="my-4" id="adenti${ot}">
                    <div class="barcontainer">
                    <div 
                            class="bar bg-primary font-weight-bold text-sm" 
                            style="height:${ incidentAgences.length > 0 ? (monincidentSite.length/incidentAgences.length) * 100  > 0 ? (monincidentSite.length/incidentAgences.length) * 100 : 0 : 0 }%; 
                            text-align:center;
                            ">
                    </div>
                    </div>
                    <span style="writing-mode:vertical-rl; font-size:0.9em; margin-right: 2em; margin-top:3em;">${site.name}</span>
                </div>      
            `)
        }



        $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
        $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
        $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));

        $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
        $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
        $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

        $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
        $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
        $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
        $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);


        $('#progress_cloture').replaceWith(`
            <div
                id="progress_cloture" 
                class="progress-bar bg-success" 
                role="progressbar" 
                style="width: ${tab.length > 0 ? (cls/tab.length) * 100 > 0 ? (cls/tab.length) * 100 : 3 : 3}%;" 
                aria-valuenow="${tab.length > 0 ? (cls/tab.length) * 100 > 0 ? (cls/tab.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100"
                >${tab.length > 0 ? (cls/tab.length) * 100 > 0 ? Math.floor((cls/tab.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_encours').replaceWith(`
            <div 
                id="progress_encours" 
                class="progress-bar bg-primary" 
                role="progressbar" 
                style="width: ${tab.length > 0 ? (ens/tab.length) * 100 > 0 ? (ens/tab.length) * 100 : 3 : 3}%;" 
                aria-valuenow="${tab.length > 0 ? (ens/tab.length) * 100 > 0 ? (ens/tab.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100"
                >${tab.length > 0 ? (ens/tab.length) * 100 > 0 ? Math.floor((ens/tab.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_annule').replaceWith(`
            <div  
                id="progress_annule" 
                class="progress-bar bg-light" 
                role="progressbar" 
                style="width: ${tab.length > 0 ? (ann/tab.length) * 100 > 0 ? (ann/tab.length) * 100 : 3 : 3}%;" 
                aria-valuenow="${tab.length > 0 ? (ann/tab.length) * 100 > 0 ? (ann/tab.length) * 100 : 3 : 3}" 
                aria-valuemin="0" aria-valuemax="100"
                > ${tab.length > 0 ? (ann/tab.length) * 100 > 0 ? Math.floor((ann/tab.length) * 100) : 0 : 0}% 
            </div>
        `);

        $('#progress_enretard').replaceWith(`
            <div 
                id="progress_enretard"
                class="progress-bar bg-warning" 
                role="progressbar" 
                style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                aria-valuemin="0"
                aria-valuemax="100"
                >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
            </div>
        `);

        $('#progress_non_encours').replaceWith(`
            <div 
                id="progress_non_encours" 
                class="progress-bar progress-bar-striped bg-primary" 
                role="progressbar" 
                style="width: ${tab.length > 0 ? (((cls+ann)/tab.length) * 100) > 0 ? ((cls+ann)/tab.length) * 100 : 3 : 3}%" 
                aria-valuenow="${tab.length > 0 ? (((cls+ann)/tab.length) * 100) > 0 ? ((cls+ann)/tab.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${tab.length > 0 ? (((cls+ann)/tab.length) * 100) > 0 ? ((cls+ann)/tab.length) * 100 : 0 : 0}%
            </div>
        `);

        $("#progress_non_cloture").replaceWith(`
            <div 
                id="progress_non_cloture"
                class="progress-bar progress-bar-striped bg-success"
                role="progressbar"
                style="width: ${tab.length > 0 ? 
                    (((ens + ann)/tab.length) * 100) > 0 ? 
                    (((ens + ann)/tab.length) * 100) : 3 : 3}%"
                aria-valuenow="${tab.length > 0 ? (((ens + ann)/tab.length) * 100) > 0 ? (((ens + ann)/tab.length) * 100) : 3 : 3}"
                aria-valuemin="0"
                aria-valuemax="100">
                ${tab.length > 0 ? (((ens + ann)/tab.length) * 100) > 0 ? Math.floor(((ens + ann)/tab.length) * 100) : 0 : 0}%
            </div>
        `);

        $('#progress_non_annuler').replaceWith(`
            <div 
                id="progress_non_annuler" 
                class="progress-bar progress-bar-striped bg-light" 
                role="progressbar" 
                style="width: ${tab.length > 0 ? (((cls+ens)/tab.length) * 100) > 0 ? ((cls+ens)/tab.length) * 100 : 3 : 3}%" 
                aria-valuenow="${tab.length > 0 ? (((cls+ens)/tab.length) * 100) > 0 ? ((cls+ens)/tab.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${tab.length > 0 ? (((cls+ens)/tab.length) * 100) > 0 ? ((cls+ens)/tab.length) * 100 : 0 : 0}%
            </div>
        `);

        $('#progress_non_enretard').replaceWith(`
            <div 
                id="progress_non_enretard" 
                class="progress-bar progress-bar-striped bg-warning"
                role="progressbar" 
                style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 0 : 0}%
            </div>
        `);

    }

});


$(document).on("change", "#DateDebut", function(){
    if($(this).val()){

        //Changement Statut Autre Champs
        $('#DateFin').val('');
        $('#DateFin').prop('disabled', false);
        //Fin Changement Statut Autre Champs

        let ids = JSON.parse($(this).attr('data-ids'));
        let sites = JSON.parse($(this).attr('data-sites'));
        let due_dates = JSON.parse($(this).attr('data-exited'));
        let dates = JSON.parse($(this).attr('data-created'));
        let incidents = JSON.parse($(this).attr('data-incidents'));
        let departements = JSON.parse($(this).attr('data-departements'));

        let ens = 0;
        let cls = 0;
        let ann = 0;
        let enretard = 0;
        let a_temps = 0;
        let incidant_encours = [];
        let incidant_enretard = [];
        let incidant_cloturer = [];
        let incidant_annuller = [];
        let incident_direction_generale = [];
        let incidentAgences = [];
        let nombre_cloture_enretard = 0;
        let nombre_cloture_a_temps = 0;

        let annee_selectionne = $('#DateDebut').val().replaceAll("-", "");

        for (let vt = 0; vt < incidents.length; vt++) {
            const iir = incidents[vt];
            
            let annee = dates[vt].replaceAll("-", "");

            if(parseInt(annee) == parseInt(annee_selectionne)){
                if(iir.site_id){
                    if((iir.observation_rex) && (!iir.deja_pris_en_compte)){
                    incidentAgences.push(iir);
                }}
            }
        }

        for (let ot = 0; ot < sites.length; ot++) {
            const site = sites[ot];
            
            let monincidentSite = [];

            for (let rt = 0; rt < incidentAgences.length; rt++) {
                const icident = incidentAgences[rt];
                
                if(icident.site_id == site.id){
                    monincidentSite.push(icident);
                }
            }

            $(`#identi${ot}`).replaceWith(`
                <span style="margin-right: -5em; position: relative;" id="identi${ot}">
                    ${ incidentAgences.length > 0 ? (monincidentSite.length/incidentAgences.length) * 100  > 0 ? Math.floor((monincidentSite.length/incidentAgences.length) * 100) : 0 : 0 }%
                </span>        
            `);

            $(`#adenti${ot}`).replaceWith(`
                <div class="my-4" id="adenti${ot}">
                    <div class="barcontainer">
                    <div 
                            class="bar bg-primary font-weight-bold text-sm" 
                            style="height:${ incidentAgences.length > 0 ? (monincidentSite.length/incidentAgences.length) * 100  > 0 ? (monincidentSite.length/incidentAgences.length) * 100 : 0 : 0 }%; 
                            text-align:center;
                            ">
                    </div>
                    </div>
                    <span style="writing-mode:vertical-rl; font-size:0.9em; margin-right: 2em; margin-top:3em;">${site.name}</span>
                </div>      
            `)
        }


        if($('#citadelle').val()){
            let incidentSiteSelectionne = [];

            if($('#citadelle').val() == "dg"){
                        
                for (let k = 0; k < incidents.length; k++) {
                    const monincident = incidents[k];
                    let annee = dates[k].replaceAll("-", "");
                    
                    if(parseInt(annee) == parseInt(annee_selectionne)){

                        if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                            incidentSiteSelectionne.push(monincident);

                            if(!monincident.site_id){
                                incident_direction_generale.push(monincident);
                            }    
                        }
                    }
                }
                

                for (let fe = 0; fe < departements.length; fe++) {
                    const departement = departements[fe];
                    
                    let incident_dep_courant = [];
    
                    for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                        const iic = incident_direction_generale[vt];
                        
                        if(iic.categories.departement_id){
                            if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                                incident_dep_courant.push(iic);
                            }
                        }
                    }
    
    
                    $(`#depi${fe}`).replaceWith(`
                        <div
                            id="depi${fe}"
                            class="progress-bar bg-success" 
                            role="progressbar" 
                            style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                            aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                            aria-valuemin="0" 
                            aria-valuemax="100"
                            >
                            ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                        </div>
                    `)
                }
    
                for (let o = 0; o < incidentSiteSelectionne.length; o++) {
                    const incid = incidentSiteSelectionne[o];
                    
                    if(incid.status == "ENCOURS"){
                        ens +=1;
                        incidant_encours.push(incid);
    
                        let indes = -1;
    
                        if(incid.due_date){
    
                            for (let q = 0; q < ids.length; q++) {
                                const number = ids[q];
                                if(number == incid.number){
                                    indes = q;
                                }
                            }
        
                            let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                            let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                            if(dateEcheance < today){
                                enretard +=1;
                                incidant_enretard.push(incid);                   
                            }else{
                                a_temps +=1;
                            }   
                        }
                        
                    }else if(incid.status == "CLÔTURÉ"){
                        cls +=1;
                        incidant_cloturer.push(incid);

                        if(incid.due_date && incid.closure_date){
                            if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                                nombre_cloture_enretard +=1;
                            }else{
                                nombre_cloture_a_temps +=1;
                            }
                        }
        
                    }else{
                        ann +=1;
                        incidant_annuller.push(incid);
                    }
    
                }

                $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
                $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
                $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));
    
                $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
                $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
                $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);
        
                $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
                $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
                $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
                $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);
                $('#tot').replaceWith(`<span class="h2" id="tot">${incidentSiteSelectionne.length < 10 ? 0 +""+ incidentSiteSelectionne.length : incidentSiteSelectionne.length}</span>`);
                                    
                $('#namels').replaceWith(`<span id="namels">Nombre D'Incidents</span>`);
                $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement">DIRECTION GENERALE</span>`)
                $('#date_du').replaceWith(`<span id="date_du">Du ${$(this).val()}</span>`);
    
                $('#progress_cloture').replaceWith(`
                    <div
                        id="progress_cloture" 
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: ${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? (cls/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                        aria-valuenow="${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? (cls/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);
    
                $('#progress_encours').replaceWith(`
                    <div 
                        id="progress_encours" 
                        class="progress-bar bg-primary" 
                        role="progressbar" 
                        style="width: ${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? (ens/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                        aria-valuenow="${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? (ens/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);
    
                $('#progress_annule').replaceWith(`
                    <div  
                        id="progress_annule" 
                        class="progress-bar bg-light" 
                        role="progressbar" 
                        style="width: ${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? (ann/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                        aria-valuenow="${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? (ann/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" aria-valuemax="100"
                        > ${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentSiteSelectionne.length) * 100) : 0 : 0}% 
                    </div>
                `);
    
                $('#progress_enretard').replaceWith(`
                    <div 
                        id="progress_enretard"
                        class="progress-bar bg-warning" 
                        role="progressbar" 
                        style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                        aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
                    </div>
                `);
    
                $('#progress_non_annuler').replaceWith(`
                <div 
                    id="progress_non_annuler" 
                    class="progress-bar progress-bar-striped bg-light" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentSiteSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
                `);

                $('#progress_non_encours').replaceWith(`
                    <div 
                        id="progress_non_encours" 
                        class="progress-bar progress-bar-striped bg-primary" 
                        role="progressbar" 
                        style="width: ${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentSiteSelectionne.length) * 100 : 3 : 3}%" 
                        aria-valuenow="${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100">
                        ${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);

                $("#progress_non_cloture").replaceWith(`
                    <div 
                        id="progress_non_cloture"
                        class="progress-bar progress-bar-striped bg-success"
                        role="progressbar"
                        style="width: ${incidentSiteSelectionne.length > 0 ? 
                            (((ens + ann)/incidentSiteSelectionne.length) * 100) > 0 ? 
                            (((ens + ann)/incidentSiteSelectionne.length) * 100) : 3 : 3}%"
                        aria-valuenow="${incidentSiteSelectionne.length > 0 ? ((ens + ann)/incidentSiteSelectionne.length) * 100 > 0 ? (((ens + ann)/incidentSiteSelectionne.length) * 100) : 3 : 3}"
                        aria-valuemin="0"
                        aria-valuemax="100">
                        ${incidentSiteSelectionne.length > 0 ? ((ens + ann)/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor(((ens + ann)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);

                $('#progress_non_enretard').replaceWith(`
                    <div 
                        id="progress_non_enretard" 
                        class="progress-bar progress-bar-striped bg-warning"
                        role="progressbar" 
                        style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                        aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100">
                        ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
                    </div>
                `);

            }else{
                
            for (let k = 0; k < incidents.length; k++) {
                const monincident = incidents[k];
                let annee = dates[k].replaceAll("-", "");
                
                if(parseInt(annee) == parseInt(annee_selectionne)){

                    if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                        if(monincident.site_id){
                            if(parseInt(monincident.site_id) == parseInt($('#citadelle').val())){
                                incidentSiteSelectionne.push(monincident);
                            }
                        }else{
                            incident_direction_generale.push(monincident);
                        }    
                    }
                }
            }


            for (let fe = 0; fe < departements.length; fe++) {
                const departement = departements[fe];
                
                let incident_dep_courant = [];

                for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                    const iic = incident_direction_generale[vt];
                    
                    if(iic.categories.departement_id){
                        if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                            incident_dep_courant.push(iic);
                        }
                    }
                }


                $(`#depi${fe}`).replaceWith(`
                    <div
                        id="depi${fe}"
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%"
                        aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%"
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >
                        ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                    </div>
                `)
            }


            for (let o = 0; o < incidentSiteSelectionne.length; o++) {
                const incid = incidentSiteSelectionne[o];
                
                if(incid.status == "ENCOURS"){
                    ens +=1;
                    incidant_encours.push(incid);

                    let indes = -1;

                    if(incid.due_date){

                        for (let q = 0; q < ids.length; q++) {
                            const number = ids[q];
                            if(number == incid.number){
                                indes = q;
                            }
                        }
    
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                        if(dateEcheance < today){
                            enretard +=1;
                            incidant_enretard.push(incid);                   
                        }else{
                            a_temps +=1;
                        }    
                    }
                    
                }else if(incid.status == "CLÔTURÉ"){
                    cls +=1;
                    incidant_cloturer.push(incid);

                    if(incid.due_date && incid.closure_date){
                        if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                            nombre_cloture_enretard +=1;
                        }else{
                            nombre_cloture_a_temps +=1;
                        }
                    }

                }else{
                    ann +=1;
                    incidant_annuller.push(incid);
                }

            }

            $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
            $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
            $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));

            $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
            $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
            $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

            $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
            $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
            $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
            $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);
            $('#tot').replaceWith(`<span class="h2" id="tot">${incidentSiteSelectionne.length < 10 ? 0 +""+ incidentSiteSelectionne.length : incidentSiteSelectionne.length}</span>`);
            

            let site_selectionner = sites.find(s => s.id == $('#citadelle').val());
            $('#namels').replaceWith(`<span id="namels">Nombre D'Incidents</span>`);
            $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement">${site_selectionner.name}</span>`);
            $('#date_du').replaceWith(`<span id="date_du">Du ${$(this).val()}</span>`);


            $('#progress_cloture').replaceWith(`
                <div
                    id="progress_cloture" 
                    class="progress-bar bg-success" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? (cls/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? (cls/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_encours').replaceWith(`
                <div 
                    id="progress_encours" 
                    class="progress-bar bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? (ens/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? (ens/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_annule').replaceWith(`
                <div  
                    id="progress_annule" 
                    class="progress-bar bg-light" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? (ann/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? (ann/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" aria-valuemax="100"
                    > ${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentSiteSelectionne.length) * 100) : 0 : 0}% 
                </div>
            `);

            $('#progress_enretard').replaceWith(`
                <div 
                    id="progress_enretard"
                    class="progress-bar bg-warning" 
                    role="progressbar" 
                    style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                    aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
                </div>
            `);

            $('#progress_non_annuler').replaceWith(`
                <div 
                    id="progress_non_annuler" 
                    class="progress-bar progress-bar-striped bg-light" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentSiteSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_encours').replaceWith(`
                <div 
                    id="progress_non_encours" 
                    class="progress-bar progress-bar-striped bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentSiteSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $("#progress_non_cloture").replaceWith(`
                <div 
                    id="progress_non_cloture"
                    class="progress-bar progress-bar-striped bg-success"
                    role="progressbar"
                    style="width: ${incidentSiteSelectionne.length > 0 ? 
                        (((ens + ann)/incidentSiteSelectionne.length) * 100) > 0 ? 
                        (((ens + ann)/incidentSiteSelectionne.length) * 100) : 3 : 3}%"
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? ((ens + ann)/incidentSiteSelectionne.length) * 100 > 0 ? (((ens + ann)/incidentSiteSelectionne.length) * 100) : 3 : 3}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    ${incidentSiteSelectionne.length > 0 ? ((ens + ann)/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor(((ens + ann)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_enretard').replaceWith(`
                <div 
                    id="progress_non_enretard" 
                    class="progress-bar progress-bar-striped bg-warning"
                    role="progressbar" 
                    style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                    aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
                </div>
            `);
          }
        }else if($('#departes').val()){
            let incidentDepartementSelectionne = [];

            for (let k = 0; k < incidents.length; k++) {
                const monincident = incidents[k];
                let annee = dates[k].replaceAll("-", "");
                
                if(parseInt(annee) == parseInt(annee_selectionne)){

                    if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){

                        if(monincident.categories.departement_id){
                            if(monincident.categories.departement_id == $('#departes').val()){
                                incidentDepartementSelectionne.push(monincident);
                            }
                        }
        
                        if(!monincident.site_id){
                            incident_direction_generale.push(monincident);
                        }
                    }

                }
            }

            
            for (let fe = 0; fe < departements.length; fe++) {
                const departement = departements[fe];
                
                let incident_dep_courant = [];

                for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                    const iic = incident_direction_generale[vt];
                    
                    if(iic.categories.departement_id){
                        if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                            incident_dep_courant.push(iic);
                        }
                    }
                }


                $(`#depi${fe}`).replaceWith(`
                    <div
                        id="depi${fe}"
                        class="progress-bar bg-success"
                        role="progressbar" 
                        style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%"
                        aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%"
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >
                        ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                    </div>
                `)
            }


            for (let o = 0; o < incidentDepartementSelectionne.length; o++) {
                const incid = incidentDepartementSelectionne[o];
                
                if(incid.status == "ENCOURS"){
                    ens +=1;
                    incidant_encours.push(incid);

                    let indes = -1;

                    if(incid.due_date){

                        for (let q = 0; q < ids.length; q++) {
                            const number = ids[q];
                            if(number == incid.number){
                                indes = q;
                            }
                        }
    
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                        if(dateEcheance < today){
                            enretard +=1;
                            incidant_enretard.push(incid);               
                        }else{
                            a_temps +=1;
                        } 
                    }
                    
                }else if(incid.status == "CLÔTURÉ"){
                    cls +=1;
                    incidant_cloturer.push(incid);

                    if(incid.due_date && incid.closure_date){
                        if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                            nombre_cloture_enretard +=1;
                        }else{
                            nombre_cloture_a_temps +=1;
                        }
                    }

                }else{
                    ann +=1;
                    incidant_annuller.push(incid);
                }

            }

            $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
            $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
            $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));

            $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
            $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
            $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

            $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
            $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
            $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
            $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);
            $('#tot').replaceWith(`<span class="h2" id="tot">${incidentDepartementSelectionne.length < 10 ? 0 +""+ incidentDepartementSelectionne.length : incidentDepartementSelectionne.length}</span>`);
            
            $('#date_du').replaceWith(`<span id="date_du">Du ${$(this).val()}</span>`);

            $('#progress_cloture').replaceWith(`
                <div
                    id="progress_cloture" 
                    class="progress-bar bg-success" 
                    role="progressbar" 
                    style="width: ${incidentDepartementSelectionne.length > 0 ? (cls/incidentDepartementSelectionne.length) * 100 > 0 ? (cls/incidentDepartementSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (cls/incidentDepartementSelectionne.length) * 100 > 0 ? (cls/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentDepartementSelectionne.length > 0 ? (cls/incidentDepartementSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_encours').replaceWith(`
                <div 
                    id="progress_encours" 
                    class="progress-bar bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentDepartementSelectionne.length > 0 ? (ens/incidentDepartementSelectionne.length) * 100 > 0 ? (ens/incidentDepartementSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (ens/incidentDepartementSelectionne.length) * 100 > 0 ? (ens/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentDepartementSelectionne.length > 0 ? (ens/incidentDepartementSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_annule').replaceWith(`
                <div  
                    id="progress_annule" 
                    class="progress-bar bg-light" 
                    role="progressbar" 
                    style="width: ${incidentDepartementSelectionne.length > 0 ? (ann/incidentDepartementSelectionne.length) * 100 > 0 ? (ann/incidentDepartementSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (ann/incidentDepartementSelectionne.length) * 100 > 0 ? (ann/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" aria-valuemax="100"
                    > ${incidentDepartementSelectionne.length > 0 ? (ann/incidentDepartementSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentDepartementSelectionne.length) * 100) : 0 : 0}% 
                </div>
            `);

            $('#progress_enretard').replaceWith(`
                <div 
                    id="progress_enretard"
                    class="progress-bar bg-warning" 
                    role="progressbar" 
                    style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                    aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
                </div>
            `);

            $('#progress_non_encours').replaceWith(`
            <div 
                id="progress_non_encours" 
                class="progress-bar progress-bar-striped bg-primary" 
                role="progressbar" 
                style="width: ${incidentDepartementSelectionne.length > 0 ? (((cls+ann)/incidentDepartementSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentDepartementSelectionne.length) * 100 : 3 : 3}%" 
                aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (((cls+ann)/incidentDepartementSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${incidentDepartementSelectionne.length > 0 ? (((cls+ann)/incidentDepartementSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
            </div>
            `);

            $("#progress_non_cloture").replaceWith(`
                <div 
                    id="progress_non_cloture"
                    class="progress-bar progress-bar-striped bg-success"
                    role="progressbar"
                    style="width: ${incidentDepartementSelectionne.length > 0 ? 
                        (((ens + ann)/incidentDepartementSelectionne.length) * 100) > 0 ? 
                        (((ens + ann)/incidentDepartementSelectionne.length) * 100) : 3 : 3}%"
                    aria-valuenow="${incidentDepartementSelectionne.length > 0 ? ((ens + ann)/incidentDepartementSelectionne.length) * 100 > 0 ? (((ens + ann)/incidentDepartementSelectionne.length) * 100) : 3 : 3}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    ${incidentDepartementSelectionne.length > 0 ? ((ens + ann)/incidentDepartementSelectionne.length) * 100 > 0 ? Math.floor(((ens + ann)/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_annuler').replaceWith(`
                <div 
                    id="progress_non_annuler" 
                    class="progress-bar progress-bar-striped bg-light" 
                    role="progressbar" 
                    style="width: ${incidentDepartementSelectionne.length > 0 ? (((cls+ens)/incidentDepartementSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentDepartementSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (((cls+ens)/incidentDepartementSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentDepartementSelectionne.length > 0 ? (((cls+ens)/incidentDepartementSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_enretard').replaceWith(`
                <div 
                    id="progress_non_enretard" 
                    class="progress-bar progress-bar-striped bg-warning"
                    role="progressbar" 
                    style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                    aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
                </div>
            `);

        }else if($('#regionnn').val()){
            let incidentRegionSelectionne = [];

            for (let k = 0; k < incidents.length; k++) {
                const monincident = incidents[k];
                let annee = dates[k].replaceAll("-", "");
                
                if(parseInt(annee) == parseInt(annee_selectionne)){

                    if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                    if(monincident.site_id){
                        if(monincident.sites.region == $('#regionnn').val()){
                            incidentRegionSelectionne.push(monincident);
                        }
                    }else{

                        incident_direction_generale.push(monincident);

                        if($('#regionnn').val() == "LITTORAL"){
                            if(!monincident.site_id){
                                incidentRegionSelectionne.push(monincident);
                            }
                        }
                    }}
    
                }
            }


            for (let fe = 0; fe < departements.length; fe++) {
                const departement = departements[fe];
                
                let incident_dep_courant = [];

                for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                    const iic = incident_direction_generale[vt];
                    
                    if(iic.categories.departement_id){
                        if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                            incident_dep_courant.push(iic);
                        }
                    }
                }


                $(`#depi${fe}`).replaceWith(`
                    <div
                        id="depi${fe}"
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%"
                        aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%"
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >
                        ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                    </div>
                `)
            }


            for (let o = 0; o < incidentRegionSelectionne.length; o++) {
                const incid = incidentRegionSelectionne[o];
                
                if(incid.status == "ENCOURS"){
                    ens +=1;
                    incidant_encours.push(incid);

                    let indes = -1;

                    if(incid.due_date){

                        for (let q = 0; q < ids.length; q++) {
                            const number = ids[q];
                            if(number == incid.number){
                                indes = q;
                            }
                        }
    
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                        if(dateEcheance < today){
                            enretard +=1;
                            incidant_enretard.push(incid);                   
                        }else{
                            a_temps +=1;
                        }    
                    }
                    
                }else if(incid.status == "CLÔTURÉ"){
                    cls +=1;
                    incidant_cloturer.push(incid);

                    if(incid.due_date && incid.closure_date){
                        if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                            nombre_cloture_enretard +=1;
                        }else{
                            nombre_cloture_a_temps +=1;
                        }
                    }

                }else{
                    ann +=1;
                    incidant_annuller.push(incid);
                }

            }

            $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
            $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
            $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));

            $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
            $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
            $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

            $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
            $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
            $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
            $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);
            $('#tot').replaceWith(`<span class="h2" id="tot">${incidentRegionSelectionne.length < 10 ? 0 +""+ incidentRegionSelectionne.length : incidentRegionSelectionne.length}</span>`);
            
            $('#date_du').replaceWith(`<span id="date_du">Du ${$(this).val()}</span>`);

            $('#progress_cloture').replaceWith(`
                <div
                    id="progress_cloture" 
                    class="progress-bar bg-success" 
                    role="progressbar" 
                    style="width: ${incidentRegionSelectionne.length > 0 ? (cls/incidentRegionSelectionne.length) * 100 > 0 ? (cls/incidentRegionSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentRegionSelectionne.length > 0 ? (cls/incidentRegionSelectionne.length) * 100 > 0 ? (cls/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentRegionSelectionne.length > 0 ? (cls/incidentRegionSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentRegionSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_encours').replaceWith(`
                <div 
                    id="progress_encours" 
                    class="progress-bar bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentRegionSelectionne.length > 0 ? (ens/incidentRegionSelectionne.length) * 100 > 0 ? (ens/incidentRegionSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentRegionSelectionne.length > 0 ? (ens/incidentRegionSelectionne.length) * 100 > 0 ? (ens/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentRegionSelectionne.length > 0 ? (ens/incidentRegionSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentRegionSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_annule').replaceWith(`
                <div  
                    id="progress_annule" 
                    class="progress-bar bg-light" 
                    role="progressbar" 
                    style="width: ${incidentRegionSelectionne.length > 0 ? (ann/incidentRegionSelectionne.length) * 100 > 0 ? (ann/incidentRegionSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentRegionSelectionne.length > 0 ? (ann/incidentRegionSelectionne.length) * 100 > 0 ? (ann/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" aria-valuemax="100"
                    > ${incidentRegionSelectionne.length > 0 ? (ann/incidentRegionSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentRegionSelectionne.length) * 100) : 0 : 0}% 
                </div>
            `);

            $('#progress_enretard').replaceWith(`
                <div 
                    id="progress_enretard"
                    class="progress-bar bg-warning" 
                    role="progressbar" 
                    style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                    aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
                </div>
            `);

            $('#progress_non_encours').replaceWith(`
            <div 
                id="progress_non_encours" 
                class="progress-bar progress-bar-striped bg-primary" 
                role="progressbar" 
                style="width: ${incidentRegionSelectionne.length > 0 ? (((cls+ann)/incidentRegionSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentRegionSelectionne.length) * 100 : 3 : 3}%" 
                aria-valuenow="${incidentRegionSelectionne.length > 0 ? (((cls+ann)/incidentRegionSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${incidentRegionSelectionne.length > 0 ? (((cls+ann)/incidentRegionSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentRegionSelectionne.length) * 100) : 0 : 0}%
            </div>
            `);

            $("#progress_non_cloture").replaceWith(`
                <div 
                    id="progress_non_cloture"
                    class="progress-bar progress-bar-striped bg-success"
                    role="progressbar"
                    style="width: ${incidentRegionSelectionne.length > 0 ? 
                        (((ens + ann)/incidentRegionSelectionne.length) * 100) > 0 ? 
                        (((ens + ann)/incidentRegionSelectionne.length) * 100) : 3 : 3}%"
                    aria-valuenow="${incidentRegionSelectionne.length > 0 ? (((ens + ann)/incidentRegionSelectionne.length) * 100) > 0 ? (((ens + ann)/incidentRegionSelectionne.length) * 100) : 3 : 3}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    ${incidentRegionSelectionne.length > 0 ? (((ens + ann)/incidentRegionSelectionne.length) * 100) > 0 ? Math.floor(((ens + ann)/incidentRegionSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_annuler').replaceWith(`
                <div 
                    id="progress_non_annuler" 
                    class="progress-bar progress-bar-striped bg-light" 
                    role="progressbar" 
                    style="width: ${incidentRegionSelectionne.length > 0 ? (((cls+ens)/incidentRegionSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentRegionSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentRegionSelectionne.length > 0 ? (((cls+ens)/incidentRegionSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentRegionSelectionne.length > 0 ? (((cls+ens)/incidentRegionSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentRegionSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_enretard').replaceWith(`
                <div 
                    id="progress_non_enretard" 
                    class="progress-bar progress-bar-striped bg-warning"
                    role="progressbar" 
                    style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                    aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
                </div>
            `);


        }else{
            
            let incidentDateSelectionne = [];

            for (let k = 0; k < incidents.length; k++) {
                const monincident = incidents[k];
                let annee = dates[k].replaceAll("-", "");
                
                if(parseInt(annee) == parseInt(annee_selectionne)){
                    if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                        if(!monincident.site_id){
                            incident_direction_generale.push(monincident);
                        }

                        incidentDateSelectionne.push(monincident);
                    }
                }
            }


            for (let o = 0; o < incidentDateSelectionne.length; o++) {
                const incid = incidentDateSelectionne[o];
                
                if(incid.status == "ENCOURS"){
                    ens +=1;
                    incidant_encours.push(incid);

                    let indes = -1;

                    if(incid.due_date){

                        for (let q = 0; q < ids.length; q++) {
                            const number = ids[q];
                            if(number == incid.number){
                                indes = q;
                            }
                        }
    
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                        if(dateEcheance < today){
                            enretard +=1;
                            incidant_enretard.push(incid);                   
                        }else{
                            a_temps +=1;
                        }    
                    }
                    
                }else if(incid.status == "CLÔTURÉ"){
                    cls +=1;
                    incidant_cloturer.push(incid);

                    if(incid.due_date && incid.closure_date){
                        if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                            nombre_cloture_enretard +=1;
                        }else{
                            nombre_cloture_a_temps +=1;
                        }
                    }

                }else{
                    ann +=1;
                    incidant_annuller.push(incid);
                }

            }

            for (let fe = 0; fe < departements.length; fe++) {
                const departement = departements[fe];
                
                let incident_dep_courant = [];

                for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                    const iic = incident_direction_generale[vt];
                    
                    if(iic.categories.departement_id){
                        if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                            incident_dep_courant.push(iic);
                        }
                    }
                }


                $(`#depi${fe}`).replaceWith(`
                    <div
                        id="depi${fe}"
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                        aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >
                        ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                    </div>
                `)
            }

            $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
            $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
            $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));

            $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
            $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
            $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

            $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
            $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
            $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
            $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);
            $('#tot').replaceWith(`<span class="h2" id="tot">${incidentDateSelectionne.length < 10 ? 0 +""+ incidentDateSelectionne.length : incidentDateSelectionne.length}</span>`);
            
            $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement">Nombre D'Incidents</span>`);
            $('#date_du').replaceWith(`<span id="date_du">Du ${$(this).val()}</span>`);



            $('#progress_cloture').replaceWith(`
                <div
                    id="progress_cloture" 
                    class="progress-bar bg-success" 
                    role="progressbar" 
                    style="width: ${incidentDateSelectionne.length > 0 ? (cls/incidentDateSelectionne.length) * 100 > 0 ? (cls/incidentDateSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentDateSelectionne.length > 0 ? (cls/incidentDateSelectionne.length) * 100 > 0 ? (cls/incidentDateSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentDateSelectionne.length > 0 ? (cls/incidentDateSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentDateSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_encours').replaceWith(`
                <div 
                    id="progress_encours" 
                    class="progress-bar bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentDateSelectionne.length > 0 ? (ens/incidentDateSelectionne.length) * 100 > 0 ? (ens/incidentDateSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentDateSelectionne.length > 0 ? (ens/incidentDateSelectionne.length) * 100 > 0 ? (ens/incidentDateSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentDateSelectionne.length > 0 ? (ens/incidentDateSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentDateSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_annule').replaceWith(`
                <div  
                    id="progress_annule" 
                    class="progress-bar bg-light" 
                    role="progressbar" 
                    style="width: ${incidentDateSelectionne.length > 0 ? (ann/incidentDateSelectionne.length) * 100 > 0 ? (ann/incidentDateSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentDateSelectionne.length > 0 ? (ann/incidentDateSelectionne.length) * 100 > 0 ? (ann/incidentDateSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" aria-valuemax="100"
                    > ${incidentDateSelectionne.length > 0 ? (ann/incidentDateSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentDateSelectionne.length) * 100) : 0 : 0}% 
                </div>
            `);

            $('#progress_enretard').replaceWith(`
                <div 
                    id="progress_enretard"
                    class="progress-bar bg-warning" 
                    role="progressbar" 
                    style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                    aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
                </div>
            `);

            $('#progress_non_encours').replaceWith(`
                <div 
                    id="progress_non_encours" 
                    class="progress-bar progress-bar-striped bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentDateSelectionne.length > 0 ? (((cls+ann)/incidentDateSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentDateSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentDateSelectionne.length > 0 ? (((cls+ann)/incidentDateSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentDateSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentDateSelectionne.length > 0 ? (((cls+ann)/incidentDateSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentDateSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $("#progress_non_cloture").replaceWith(`
                <div 
                    id="progress_non_cloture"
                    class="progress-bar progress-bar-striped bg-success"
                    role="progressbar"
                    style="width: ${incidentDateSelectionne.length > 0 ? 
                        (((ens + ann)/incidentDateSelectionne.length) * 100) > 0 ? 
                        (((ens + ann)/incidentDateSelectionne.length) * 100) : 3 : 3}%"
                    aria-valuenow="${incidentDateSelectionne.length > 0 ? (((ens + ann)/incidentDateSelectionne.length) * 100) > 0 ? (((ens + ann)/incidentDateSelectionne.length) * 100) : 3 : 3}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    ${incidentDateSelectionne.length > 0 ? (((ens + ann)/incidentDateSelectionne.length) * 100) > 0 ? Math.floor(((ens + ann)/incidentDateSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_annuler').replaceWith(`
                <div 
                    id="progress_non_annuler" 
                    class="progress-bar progress-bar-striped bg-light" 
                    role="progressbar" 
                    style="width: ${incidentDateSelectionne.length > 0 ? (((cls+ens)/incidentDateSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentDateSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentDateSelectionne.length > 0 ? (((cls+ens)/incidentDateSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentDateSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentDateSelectionne.length > 0 ? (((cls+ens)/incidentDateSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentDateSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_enretard').replaceWith(`
                <div 
                    id="progress_non_enretard" 
                    class="progress-bar progress-bar-striped bg-warning"
                    role="progressbar" 
                    style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                    aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
                </div>
            `);

        }
    }else{
        $('#DateFin').val('');
        $('#DateFin').prop('disabled', true);

        let incidentSiteSelectionne = [];
        let incidentRegionSelectionne = [];
        let incidentDepartementSelectionne = [];
        let ids = JSON.parse($(this).attr('data-ids'));
        let sites = JSON.parse($(this).attr('data-sites'));
        let due_dates = JSON.parse($(this).attr('data-exited'));
        let departements = JSON.parse($(this).attr('data-departements'));
        let dates = JSON.parse($(this).attr('data-created'));
        let incidents = JSON.parse($(this).attr('data-incidents'));
        let incident_direction_generale = [];

        let ens = 0;
        let cls = 0;
        let ann = 0;
        let enretard = 0;
        let a_temps = 0;
        let incidant_encours = [];
        let incidant_enretard = [];
        let incidant_cloturer = [];
        let incidant_annuller = [];
        let incidentAgences = [];
        let annee_selectionne = new Date().getFullYear();
        let nombre_cloture_enretard = 0;
        let nombre_cloture_a_temps = 0;

        for (let k = 0; k < incidents.length; k++) {
            const monincident = incidents[k];
            let annee = dates[k].substring(0, 4);
            
            if(parseInt(annee) == annee_selectionne){

                if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                    if(monincident.site_id){
                        incidentAgences.push(monincident);
                    }
                }
            }
        }

        for (let ot = 0; ot < sites.length; ot++) {
            const site = sites[ot];
            
            let monincidentSite = [];

            for (let rt = 0; rt < incidentAgences.length; rt++) {
                const icident = incidentAgences[rt];
                
                if(icident.site_id == site.id){
                    monincidentSite.push(icident);
                }
            }

            $(`#identi${ot}`).replaceWith(`
                <span style="margin-right: -5em; position: relative;" id="identi${ot}">
                    ${ incidentAgences.length > 0 ? (monincidentSite.length/incidentAgences.length) * 100  > 0 ? Math.floor((monincidentSite.length/incidentAgences.length) * 100) : 0 : 0 }%
                </span>        
            `);

            $(`#adenti${ot}`).replaceWith(`
                <div class="my-4" id="adenti${ot}">
                    <div class="barcontainer">
                    <div 
                            class="bar bg-primary font-weight-bold text-sm" 
                            style="height:${ incidentAgences.length > 0 ? (monincidentSite.length/incidentAgences.length) * 100  > 0 ? (monincidentSite.length/incidentAgences.length) * 100 : 0 : 0 }%; 
                            text-align:center;
                            ">
                    </div>
                    </div>
                    <span style="writing-mode:vertical-rl; font-size:0.9em; margin-right: 2em; margin-top:3em;">${site.name}</span>
                </div>      
            `)
        }


        if($('#citadelle').val()){
            if($('#citadelle').val() == "dg"){

                $('#date_du').replaceWith(`<span id="date_du"></span>`);
                $('#namels').replaceWith(`<span id="namels">Nombre D'Incidents</span>`);
                $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement">DIRECTON GENERALE</span>`)
                
    
                for (let k = 0; k < incidents.length; k++) {
                    const monincident = incidents[k];
                    let annee = dates[k].substring(0, 4);
                    
                    if(parseInt(annee) == parseInt(annee_selectionne)){

                        if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                            if(!monincident.site_id){
                                incidentSiteSelectionne.push(monincident);
                                incident_direction_generale.push(monincident);
                            }
                        }

                    }
                }
        
                for (let fe = 0; fe < departements.length; fe++) {
                    const departement = departements[fe];
                    
                    let incident_dep_courant = [];
    
                    for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                        const iic = incident_direction_generale[vt];
                        
                        if(iic.categories.departement_id){
                            if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                                incident_dep_courant.push(iic);
                            }
                        }
                    }
    
    
                    $(`#depi${fe}`).replaceWith(`
                        <div
                            id="depi${fe}"
                            class="progress-bar bg-success" 
                            role="progressbar" 
                            style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                            aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                            aria-valuemin="0" 
                            aria-valuemax="100"
                            >
                            ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                        </div>
                    `)
                }

                
                for (let o = 0; o < incidentSiteSelectionne.length; o++) {
                    const incid = incidentSiteSelectionne[o];
                    
                    if(incid.status == "ENCOURS"){
                        ens +=1;
                        incidant_encours.push(incid);
    
                        let indes = -1;
    
                        if(incid.due_date){
    
                            for (let q = 0; q < ids.length; q++) {
                                const number = ids[q];
                                if(number == incid.number){
                                    indes = q;
                                }
                            }
        
                            let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                            let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                            if(dateEcheance < today){
                                enretard +=1;
                                incidant_enretard.push(incid);                   
                            }else{
                                a_temps +=1;
                            }
                        }
                        
                    }else if(incid.status == "CLÔTURÉ"){
                        cls +=1;
                        incidant_cloturer.push(incid);

                        if(incid.due_date && incid.closure_date){
                            if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                                nombre_cloture_enretard +=1;
                            }else{
                                nombre_cloture_a_temps +=1;
                            }
                        }
    
                    }else{
                        ann +=1;
                        incidant_annuller.push(incid);
                    }
    
                }

                $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
                $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
                $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));
    
                $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
                $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
                $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);
        
                $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
                $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
                $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
                $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);
                $('#tot').replaceWith(`<span class="h2" id="tot">${incidentSiteSelectionne.length < 10 ? 0 +""+ incidentSiteSelectionne.length : incidentSiteSelectionne.length}</span>`);
    
    
                $('#progress_cloture').replaceWith(`
                    <div
                        id="progress_cloture" 
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: ${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? (cls/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                        aria-valuenow="${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? (cls/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);
    
                $('#progress_encours').replaceWith(`
                    <div 
                        id="progress_encours" 
                        class="progress-bar bg-primary" 
                        role="progressbar" 
                        style="width: ${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? (ens/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                        aria-valuenow="${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? (ens/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);
    
                $('#progress_annule').replaceWith(`
                    <div  
                        id="progress_annule" 
                        class="progress-bar bg-light" 
                        role="progressbar" 
                        style="width: ${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? (ann/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                        aria-valuenow="${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? (ann/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" aria-valuemax="100"
                        > ${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentSiteSelectionne.length) * 100) : 0 : 0}% 
                    </div>
                `);
    
                $('#progress_enretard').replaceWith(`
                    <div 
                        id="progress_enretard"
                        class="progress-bar bg-warning" 
                        role="progressbar" 
                        style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                        aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
                    </div>
                `);
    
                $('#progress_non_annuler').replaceWith(`
                <div 
                    id="progress_non_annuler" 
                    class="progress-bar progress-bar-striped bg-light" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentSiteSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
                `);

                $('#progress_non_encours').replaceWith(`
                    <div 
                        id="progress_non_encours" 
                        class="progress-bar progress-bar-striped bg-primary" 
                        role="progressbar" 
                        style="width: ${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentSiteSelectionne.length) * 100 : 3 : 3}%" 
                        aria-valuenow="${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100">
                        ${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);

                $("#progress_non_cloture").replaceWith(`
                    <div 
                        id="progress_non_cloture"
                        class="progress-bar progress-bar-striped bg-success"
                        role="progressbar"
                        style="width: ${incidentSiteSelectionne.length > 0 ? 
                            (((ens + ann)/incidentSiteSelectionne.length) * 100) > 0 ? 
                            (((ens + ann)/incidentSiteSelectionne.length) * 100) : 3 : 3}%"
                        aria-valuenow="${incidentSiteSelectionne.length > 0 ? ((ens + ann)/incidentSiteSelectionne.length) * 100 > 0 ? (((ens + ann)/incidentSiteSelectionne.length) * 100) : 3 : 3}"
                        aria-valuemin="0"
                        aria-valuemax="100">
                        ${incidentSiteSelectionne.length > 0 ? ((ens + ann)/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor(((ens + ann)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);

                $('#progress_non_enretard').replaceWith(`
                    <div 
                        id="progress_non_enretard" 
                        class="progress-bar progress-bar-striped bg-warning"
                        role="progressbar" 
                        style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                        aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100">
                        ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
                    </div>
                `);

            }else{

            let site_selectionner = sites.find(s => s.id == $('#citadelle').val());

            $('#date_du').replaceWith(`<span id="date_du"></span>`);
            $('#namels').replaceWith(`<span id="namels">Nombre D'Incidents</span>`);
            $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement">${site_selectionner.name}</span>`)
            
            for (let k = 0; k < incidents.length; k++) {
                const monincident = incidents[k];
                let annee = dates[k].substring(0, 4);
                
                if(parseInt(annee) == parseInt(annee_selectionne)){

                    if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                        if(monincident.site_id){
                            if(parseInt(monincident.site_id) == parseInt($('#citadelle').val())){
                                incidentSiteSelectionne.push(monincident);
                            }
                        }else{
                            incident_direction_generale.push(monincident); 
                        }
                    }  
                }
            }

            for (let fe = 0; fe < departements.length; fe++) {
                const departement = departements[fe];
                
                let incident_dep_courant = [];

                for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                    const iic = incident_direction_generale[vt];
                    
                    if(iic.categories.departement_id){
                        if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                            incident_dep_courant.push(iic);
                        }
                    }
                }


                $(`#depi${fe}`).replaceWith(`
                    <div
                        id="depi${fe}"
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                        aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >
                        ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                    </div>
                `)
            }


            for (let o = 0; o < incidentSiteSelectionne.length; o++) {
                const incid = incidentSiteSelectionne[o];
                
                if(incid.status == "ENCOURS"){
                    ens +=1;
                    incidant_encours.push(incid);

                    let indes = -1;

                    if(incid.due_date){

                        for (let q = 0; q < ids.length; q++) {
                            const number = ids[q];
                            if(number == incid.number){
                                indes = q;
                            }
                        }
    
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                        if(dateEcheance < today){
                            enretard +=1;
                            incidant_enretard.push(incid);                   
                        }else{
                            a_temps +=1;
                        }  
                    }
                    
                }else if(incid.status == "CLÔTURÉ"){
                    cls +=1;
                    incidant_cloturer.push(incid);

                    if(incid.due_date && incid.closure_date){
                        if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                            nombre_cloture_enretard +=1;
                        }else{
                            nombre_cloture_a_temps +=1;
                        }
                    }

                }else{
                    ann +=1;
                    incidant_annuller.push(incid);
                }
            }

            $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
            $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
            $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));

            $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
            $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
            $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

            $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
            $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
            $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
            $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);
            $('#tot').replaceWith(`<span class="h2" id="tot">${incidentSiteSelectionne.length < 10 ? 0 +""+ incidentSiteSelectionne.length : incidentSiteSelectionne.length}</span>`);


            $('#progress_cloture').replaceWith(`
                <div
                    id="progress_cloture" 
                    class="progress-bar bg-success" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? (cls/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? (cls/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_encours').replaceWith(`
                <div 
                    id="progress_encours" 
                    class="progress-bar bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? (ens/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? (ens/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_annule').replaceWith(`
                <div  
                    id="progress_annule" 
                    class="progress-bar bg-light" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? (ann/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? (ann/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" aria-valuemax="100"
                    > ${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentSiteSelectionne.length) * 100) : 0 : 0}% 
                </div>
            `);

            $('#progress_enretard').replaceWith(`
                <div 
                    id="progress_enretard"
                    class="progress-bar bg-warning" 
                    role="progressbar" 
                    style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                    aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
                </div>
            `);

            $('#progress_non_annuler').replaceWith(`
            <div 
                id="progress_non_annuler" 
                class="progress-bar progress-bar-striped bg-light" 
                role="progressbar" 
                style="width: ${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentSiteSelectionne.length) * 100 : 3 : 3}%" 
                aria-valuenow="${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
            </div>
            `);

            $('#progress_non_encours').replaceWith(`
                <div 
                    id="progress_non_encours" 
                    class="progress-bar progress-bar-striped bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentSiteSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $("#progress_non_cloture").replaceWith(`
                <div 
                    id="progress_non_cloture"
                    class="progress-bar progress-bar-striped bg-success"
                    role="progressbar"
                    style="width: ${incidentSiteSelectionne.length > 0 ? 
                        (((ens + ann)/incidentSiteSelectionne.length) * 100) > 0 ? 
                        (((ens + ann)/incidentSiteSelectionne.length) * 100) : 3 : 3}%"
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? ((ens + ann)/incidentSiteSelectionne.length) * 100 > 0 ? (((ens + ann)/incidentSiteSelectionne.length) * 100) : 3 : 3}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    ${incidentSiteSelectionne.length > 0 ? ((ens + ann)/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor(((ens + ann)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_enretard').replaceWith(`
                <div 
                    id="progress_non_enretard" 
                    class="progress-bar progress-bar-striped bg-warning"
                    role="progressbar" 
                    style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                    aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
                </div>
            `);

            }

        }else if($('#departes').val()){
            let departement_selectionner = departements.find(d => d.id == $('#departes').val());

            $('#date_du').replaceWith(`<span id="date_du"></span>`);
            $('#namels').replaceWith(`<span id="namels">Nombre D'Incidents Du Département</span>`);
            $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement">${departement_selectionner.name}</span>`);
                
            for (let k = 0; k < incidents.length; k++) {
                const monincident = incidents[k];

                let annee = dates[k].substring(0, 4);

                if(parseInt(annee) == parseInt(annee_selectionne)){

                    if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                        if(monincident.categories.departement_id){
                            if(monincident.categories.departement_id == $('#departes').val()){
                                incidentDepartementSelectionne.push(monincident);
                            }
                        }

                        if(!monincident.site_id){
                            incident_direction_generale.push(monincident);
                        }
                    }
                    
                }
            }

            for (let fe = 0; fe < departements.length; fe++) {
                const departement = departements[fe];
                
                let incident_dep_courant = [];

                for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                    const iic = incident_direction_generale[vt];
                    
                    if(iic.categories.departement_id){
                        if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                            incident_dep_courant.push(iic);
                        }
                    }
                }


                $(`#depi${fe}`).replaceWith(`
                    <div
                        id="depi${fe}"
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                        aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >
                        ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                    </div>
                `)
            }


            $('#tot').replaceWith(`<span class="h2" id="tot">${incidentDepartementSelectionne.length < 10 ? 0 +""+ incidentDepartementSelectionne.length : incidentDepartementSelectionne.length}</span>`);

            for (let o = 0; o < incidentDepartementSelectionne.length; o++) {
                const incid = incidentDepartementSelectionne[o];
                
                if(incid.status == "ENCOURS"){
                    ens +=1;
                    incidant_encours.push(incid);

                    let indes = -1;

                    if(incid.due_date){

                        for (let q = 0; q < ids.length; q++) {
                            const number = ids[q];
                            if(number == incid.number){
                                indes = q;
                            }
                        }
    
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                        if(dateEcheance < today){
                            enretard +=1;
                            incidant_enretard.push(incid);                   
                        }else{
                            a_temps +=1;
                        }
                    }
                    
                }else if(incid.status == "CLÔTURÉ"){
                    cls +=1;
                    incidant_cloturer.push(incid);

                    if(incid.due_date && incid.closure_date){
                        if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                            nombre_cloture_enretard +=1;
                        }else{
                            nombre_cloture_a_temps +=1;
                        }
                    }

                }else{
                    ann +=1;
                    incidant_annuller.push(incid);
                }

            }

            $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
            //$('#floder_retard').attr('data-retards', JSON.stringify(incidant_enretard));
            $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
            $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));

            $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
            $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
            $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

            $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
            $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
            $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
            $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);


            $('#progress_cloture').replaceWith(`
                <div
                    id="progress_cloture" 
                    class="progress-bar bg-success" 
                    role="progressbar" 
                    style="width: ${incidentDepartementSelectionne.length > 0 ? (cls/incidentDepartementSelectionne.length) * 100 > 0 ? (cls/incidentDepartementSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (cls/incidentDepartementSelectionne.length) * 100 > 0 ? (cls/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentDepartementSelectionne.length > 0 ? (cls/incidentDepartementSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_encours').replaceWith(`
                <div 
                    id="progress_encours" 
                    class="progress-bar bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentDepartementSelectionne.length > 0 ? (ens/incidentDepartementSelectionne.length) * 100 > 0 ? (ens/incidentDepartementSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (ens/incidentDepartementSelectionne.length) * 100 > 0 ? (ens/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentDepartementSelectionne.length > 0 ? (ens/incidentDepartementSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_annule').replaceWith(`
                <div  
                    id="progress_annule" 
                    class="progress-bar bg-light" 
                    role="progressbar" 
                    style="width: ${incidentDepartementSelectionne.length > 0 ? (ann/incidentDepartementSelectionne.length) * 100 > 0 ? (ann/incidentDepartementSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (ann/incidentDepartementSelectionne.length) * 100 > 0 ? (ann/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" aria-valuemax="100"
                    > ${incidentDepartementSelectionne.length > 0 ? (ann/incidentDepartementSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentDepartementSelectionne.length) * 100) : 0 : 0}% 
                </div>
            `);

            $('#progress_enretard').replaceWith(`
                <div 
                    id="progress_enretard"
                    class="progress-bar bg-warning" 
                    role="progressbar" 
                    style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                    aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
                </div>
            `);

            $('#progress_non_encours').replaceWith(`
                <div 
                    id="progress_non_encours" 
                    class="progress-bar progress-bar-striped bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentDepartementSelectionne.length > 0 ? (((cls+ann)/incidentDepartementSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentDepartementSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (((cls+ann)/incidentDepartementSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentDepartementSelectionne.length > 0 ? (((cls+ann)/incidentDepartementSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $("#progress_non_cloture").replaceWith(`
                <div 
                    id="progress_non_cloture"
                    class="progress-bar progress-bar-striped bg-success"
                    role="progressbar"
                    style="width: ${incidentDepartementSelectionne.length > 0 ? 
                        (((ens + ann)/incidentDepartementSelectionne.length) * 100) > 0 ? 
                        (((ens + ann)/incidentDepartementSelectionne.length) * 100) : 3 : 3}%"
                    aria-valuenow="${incidentDepartementSelectionne.length > 0 ? ((ens + ann)/incidentDepartementSelectionne.length) * 100 > 0 ? (((ens + ann)/incidentDepartementSelectionne.length) * 100) : 3 : 3}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    ${incidentDepartementSelectionne.length > 0 ? ((ens + ann)/incidentDepartementSelectionne.length) * 100 > 0 ? Math.floor(((ens + ann)/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_annuler').replaceWith(`
                <div 
                    id="progress_non_annuler" 
                    class="progress-bar progress-bar-striped bg-light" 
                    role="progressbar" 
                    style="width: ${incidentDepartementSelectionne.length > 0 ? (((cls+ens)/incidentDepartementSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentDepartementSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (((cls+ens)/incidentDepartementSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentDepartementSelectionne.length > 0 ? (((cls+ens)/incidentDepartementSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_enretard').replaceWith(`
                <div 
                    id="progress_non_enretard" 
                    class="progress-bar progress-bar-striped bg-warning"
                    role="progressbar" 
                    style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                    aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
                </div>
            `);

        }else if($('#regionnn').val()){
            let region = $('#regionnn').val();

            $('#date_du').replaceWith(`<span id="date_du"></span>`);
            $('#namels').replaceWith(`<span id="namels">Nombre D'Incidents De La Région</span>`);
            $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement">${region}</span>`);

            for (let k = 0; k < incidents.length; k++) {
                const monincident = incidents[k];
                let annee = dates[k].substring(0, 4);
                
                if(parseInt(annee) == parseInt(annee_selectionne)){

                    if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                        if(monincident.site_id){
                            if(monincident.sites.region == region){
                                incidentRegionSelectionne.push(monincident);
                            }
                        }else{

                            incident_direction_generale.push(monincident);

                            if(region == "LITTORAL"){
                                if(!monincident.site_id){
                                    incidentRegionSelectionne.push(monincident);
                                }
                            }
                        }
                    }
    
                }
            }


            for (let fe = 0; fe < departements.length; fe++) {
                const departement = departements[fe];
                
                let incident_dep_courant = [];

                for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                    const iic = incident_direction_generale[vt];
                    
                    if(iic.categories.departement_id){
                        if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                            incident_dep_courant.push(iic);
                        }
                    }
                }


                $(`#depi${fe}`).replaceWith(`
                    <div
                        id="depi${fe}"
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                        aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >
                        ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                    </div>
                `)
            }


            for (let o = 0; o < incidentRegionSelectionne.length; o++) {
                const incid = incidentRegionSelectionne[o];
                
                if(incid.status == "ENCOURS"){
                    ens +=1;
                    incidant_encours.push(incid);

                    let indes = -1;

                    if(incid.due_date){

                        for (let q = 0; q < ids.length; q++) {
                            const number = ids[q];
                            if(number == incid.number){
                                indes = q;
                            }
                        }
    
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                        if(dateEcheance < today){
                            enretard +=1;
                            incidant_enretard.push(incid);                   
                        }else{
                            a_temps +=1;
                        }
                    }
                    
                }else if(incid.status == "CLÔTURÉ"){
                    cls +=1;
                    incidant_cloturer.push(incid);

                    if(incid.due_date && incid.closure_date){
                        if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                            nombre_cloture_enretard +=1;
                        }else{
                            nombre_cloture_a_temps +=1;
                        }
                    }

                }else{
                    ann +=1;
                    incidant_annuller.push(incid);
                }

            }

            $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
            $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
            $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));

            $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
            $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
            $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

            $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
            $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
            $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
            $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);
            $('#tot').replaceWith(`<span class="h2" id="tot">${incidentRegionSelectionne.length < 10 ? 0 +""+ incidentRegionSelectionne.length : incidentRegionSelectionne.length}</span>`);


            $('#progress_cloture').replaceWith(`
                <div
                    id="progress_cloture" 
                    class="progress-bar bg-success" 
                    role="progressbar" 
                    style="width: ${incidentRegionSelectionne.length > 0 ? (cls/incidentRegionSelectionne.length) * 100 > 0 ? (cls/incidentRegionSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentRegionSelectionne.length > 0 ? (cls/incidentRegionSelectionne.length) * 100 > 0 ? (cls/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentRegionSelectionne.length > 0 ? (cls/incidentRegionSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentRegionSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_encours').replaceWith(`
                <div 
                    id="progress_encours" 
                    class="progress-bar bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentRegionSelectionne.length > 0 ? (ens/incidentRegionSelectionne.length) * 100 > 0 ? (ens/incidentRegionSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentRegionSelectionne.length > 0 ? (ens/incidentRegionSelectionne.length) * 100 > 0 ? (ens/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentRegionSelectionne.length > 0 ? (ens/incidentRegionSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentRegionSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_annule').replaceWith(`
                <div  
                    id="progress_annule" 
                    class="progress-bar bg-light" 
                    role="progressbar" 
                    style="width: ${incidentRegionSelectionne.length > 0 ? (ann/incidentRegionSelectionne.length) * 100 > 0 ? (ann/incidentRegionSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentRegionSelectionne.length > 0 ? (ann/incidentRegionSelectionne.length) * 100 > 0 ? (ann/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" aria-valuemax="100"
                    > ${incidentRegionSelectionne.length > 0 ? (ann/incidentRegionSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentRegionSelectionne.length) * 100) : 0 : 0}% 
                </div>
            `);

            $('#progress_enretard').replaceWith(`
                <div 
                    id="progress_enretard"
                    class="progress-bar bg-warning" 
                    role="progressbar" 
                    style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                    aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
                </div>
            `);

            $('#progress_non_encours').replaceWith(`
                <div 
                    id="progress_non_encours" 
                    class="progress-bar progress-bar-striped bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentRegionSelectionne.length > 0 ? (((cls+ann)/incidentRegionSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentRegionSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentRegionSelectionne.length > 0 ? (((cls+ann)/incidentRegionSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentRegionSelectionne.length > 0 ? (((cls+ann)/incidentRegionSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentRegionSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $("#progress_non_cloture").replaceWith(`
                <div 
                    id="progress_non_cloture"
                    class="progress-bar progress-bar-striped bg-success"
                    role="progressbar"
                    style="width: ${incidentRegionSelectionne.length > 0 ? 
                        (((ens + ann)/incidentRegionSelectionne.length) * 100) > 0 ? 
                        (((ens + ann)/incidentRegionSelectionne.length) * 100) : 3 : 3}%"
                    aria-valuenow="${incidentRegionSelectionne.length > 0 ? (((ens + ann)/incidentRegionSelectionne.length) * 100) > 0 ? (((ens + ann)/incidentRegionSelectionne.length) * 100) : 3 : 3}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    ${incidentRegionSelectionne.length > 0 ? (((ens + ann)/incidentRegionSelectionne.length) * 100) > 0 ? Math.floor(((ens + ann)/incidentRegionSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_annuler').replaceWith(`
                <div 
                    id="progress_non_annuler" 
                    class="progress-bar progress-bar-striped bg-light" 
                    role="progressbar" 
                    style="width: ${incidentRegionSelectionne.length > 0 ? (((cls+ens)/incidentRegionSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentRegionSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentRegionSelectionne.length > 0 ? (((cls+ens)/incidentRegionSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentRegionSelectionne.length > 0 ? (((cls+ens)/incidentRegionSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentRegionSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_enretard').replaceWith(`
                <div 
                    id="progress_non_enretard" 
                    class="progress-bar progress-bar-striped bg-warning"
                    role="progressbar" 
                    style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                    aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
                </div>
            `);

        }else{
            let tab = [];
            let ids = JSON.parse($(this).attr('data-ids'));
            let due_dates = JSON.parse($(this).attr('data-exited'));
            let dates = JSON.parse($(this).attr('data-created'));
            let incidents = JSON.parse($(this).attr('data-incidents'));
     
            let ens = 0;
            let cls = 0;
            let ann = 0;
            let enretard = 0;
            let incidant_encours = [];
            let incidant_enretard = [];
            let incidant_cloturer = [];
            let incidant_annuller = [];
            let annee_selectionne = new Date().getFullYear();

            for (let k = 0; k < incidents.length; k++) {
                const monincident = incidents[k];

                let annee = dates[k].substring(0, 4);

                if(parseInt(annee) == parseInt(annee_selectionne)){
                    tab.push(monincident);

                    if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                    if(!monincident.site_id){
                        incident_direction_generale.push(monincident);
                    }}
                }
            }

            for (let fe = 0; fe < departements.length; fe++) {
                const departement = departements[fe];
                
                let incident_dep_courant = [];

                for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                    const iic = incident_direction_generale[vt];
                    
                    if(iic.categories.departement_id){
                        if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                            incident_dep_courant.push(iic);
                        }
                    }
                }


                $(`#depi${fe}`).replaceWith(`
                    <div
                        id="depi${fe}"
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                        aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >
                        ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                    </div>
                `)
            }

            $('#namels').replaceWith(`<span id="namels"></span>`);
            $('#date_du').replaceWith(`<span id="date_du"></span>`);
            $('#tot').replaceWith(`<span class="h2" id="tot">${tab.length < 10 ? 0 +""+ tab.length : tab.length}</span>`);
            $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement"> Nombre D'Incidents Total</span>`);


            for (let o = 0; o < tab.length; o++) {
                const incid = tab[o];
                
                if(incid.status == "ENCOURS"){
                    ens +=1;
                    incidant_encours.push(incid);

                    let indes = -1;

                    if(incid.due_date){

                        for (let q = 0; q < ids.length; q++) {
                            const number = ids[q];
                            if(number == incid.number){
                                indes = q;
                            }
                        }
    
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                        if(dateEcheance < today){
                            enretard +=1;
                            incidant_enretard.push(incid);                   
                        }else{
                            a_temps +=1;
                        }
                    }
                    
                }else if(incid.status == "CLÔTURÉ"){
                    cls +=1;
                    incidant_cloturer.push(incid);

                    if(incid.due_date && incid.closure_date){
                        if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                            nombre_cloture_enretard +=1;
                        }else{
                            nombre_cloture_a_temps +=1;
                        }
                    }

                }else{
                    ann +=1;
                    incidant_annuller.push(incid);
                }

            }

            $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
            $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
            $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));

            $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
            $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
            $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

            $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
            $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
            $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
            $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);


            $('#progress_cloture').replaceWith(`
                <div
                    id="progress_cloture" 
                    class="progress-bar bg-success" 
                    role="progressbar" 
                    style="width: ${tab.length > 0 ? (cls/tab.length) * 100 > 0 ? (cls/tab.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${tab.length > 0 ? (cls/tab.length) * 100 > 0 ? (cls/tab.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${tab.length > 0 ? (cls/tab.length) * 100 > 0 ? Math.floor((cls/tab.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_encours').replaceWith(`
                <div 
                    id="progress_encours" 
                    class="progress-bar bg-primary" 
                    role="progressbar" 
                    style="width: ${tab.length > 0 ? (ens/tab.length) * 100 > 0 ? (ens/tab.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${tab.length > 0 ? (ens/tab.length) * 100 > 0 ? (ens/tab.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${tab.length > 0 ? (ens/tab.length) * 100 > 0 ? Math.floor((ens/tab.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_annule').replaceWith(`
                <div  
                    id="progress_annule" 
                    class="progress-bar bg-light" 
                    role="progressbar" 
                    style="width: ${tab.length > 0 ? (ann/tab.length) * 100 > 0 ? (ann/tab.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${tab.length > 0 ? (ann/tab.length) * 100 > 0 ? (ann/tab.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" aria-valuemax="100"
                    > ${tab.length > 0 ? (ann/tab.length) * 100 > 0 ? Math.floor((ann/tab.length) * 100) : 0 : 0}% 
                </div>
            `);

            $('#progress_enretard').replaceWith(`
                <div 
                    id="progress_enretard"
                    class="progress-bar bg-warning" 
                    role="progressbar" 
                    style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                    aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
                </div>
            `);

            $('#progress_non_encours').replaceWith(`
                <div 
                    id="progress_non_encours" 
                    class="progress-bar progress-bar-striped bg-primary" 
                    role="progressbar" 
                    style="width: ${tab.length > 0 ? (((cls+ann)/tab.length) * 100) > 0 ? ((cls+ann)/tab.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${tab.length > 0 ? (((cls+ann)/tab.length) * 100) > 0 ? ((cls+ann)/tab.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${tab.length > 0 ? (((cls+ann)/tab.length) * 100) > 0 ? Math.floor(((cls+ann)/tab.length) * 100) : 0 : 0}%
                </div>
            `);

            $("#progress_non_cloture").replaceWith(`
                <div 
                    id="progress_non_cloture"
                    class="progress-bar progress-bar-striped bg-success"
                    role="progressbar"
                    style="width: ${tab.length > 0 ? 
                        (((ens + ann)/tab.length) * 100) > 0 ? 
                        (((ens + ann)/tab.length) * 100) : 3 : 3}%"
                    aria-valuenow="${tab.length > 0 ? (((ens + ann)/tab.length) * 100) > 0 ? (((ens + ann)/tab.length) * 100) : 3 : 3}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    ${tab.length > 0 ? (((ens + ann)/tab.length) * 100) > 0 ? Math.floor(((ens + ann)/tab.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_annuler').replaceWith(`
                <div 
                    id="progress_non_annuler" 
                    class="progress-bar progress-bar-striped bg-light" 
                    role="progressbar" 
                    style="width: ${tab.length > 0 ? (((cls+ens)/tab.length) * 100) > 0 ? ((cls+ens)/tab.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${tab.length > 0 ? (((cls+ens)/tab.length) * 100) > 0 ? ((cls+ens)/tab.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${tab.length > 0 ? (((cls+ens)/tab.length) * 100) > 0 ? Math.floor(((cls+ens)/tab.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_enretard').replaceWith(`
                <div 
                    id="progress_non_enretard" 
                    class="progress-bar progress-bar-striped bg-warning"
                    role="progressbar" 
                    style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                    aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
                </div>
            `);

        }

    }
});

$(document).on('change', '#DateFin', function(){
    if($(this).val()){

        if(parseInt($('#DateDebut').val().replaceAll("-", "")) > parseInt($(this).val().replaceAll("-", ""))){
            $('#validation_due_date').text("Veuillez Renseignez Une Date Supérieur A La Date De Début !");
            $('#DateFin').val('');
            $('#duedi').modal('show');
        }else{

            let ids = JSON.parse($(this).attr('data-ids'));
            let sites = JSON.parse($(this).attr('data-sites'));
            let due_dates = JSON.parse($(this).attr('data-exited'));
            let dates = JSON.parse($(this).attr('data-created'));
            let incidents = JSON.parse($(this).attr('data-incidents'));
            let departements = JSON.parse($(this).attr('data-departements'));

            let ens = 0;
            let cls = 0;
            let ann = 0;
            let enretard = 0;
            let incidant_encours = [];
            let incidant_enretard = [];
            let incidant_cloturer = [];
            let incidant_annuller = [];
            let incident_direction_generale = [];
            let incidentAgences = [];
            let a_temps = 0;
            let nombre_cloture_a_temps = 0;
            let nombre_cloture_enretard = 0;

            for (let vt = 0; vt < incidents.length; vt++) {
                const iir = incidents[vt];

                let date_declaration = parseInt(dates[vt].replaceAll("-", ""));
                let debut = parseInt($('#DateDebut').val().replaceAll("-", ""));
                let fin = parseInt($('#DateFin').val().replaceAll("-", ""));

                if(
                    ((date_declaration == debut) && (date_declaration < fin)) ||
                    ((date_declaration > debut) && (date_declaration < fin)) ||
                    ((date_declaration > debut) && (date_declaration == fin)) || 
                    ((date_declaration == debut) && (date_declaration == fin))
                  )
                    {
                        if(iir.site_id){
                            if((iir.observation_rex) && (!iir.deja_pris_en_compte)){
                                incidentAgences.push(iir);
                            }
                        }
                    }

            }
    
            for (let ot = 0; ot < sites.length; ot++) {
                const site = sites[ot];
                
                let monincidentSite = [];
    
                for (let rt = 0; rt < incidentAgences.length; rt++) {
                    const icident = incidentAgences[rt];
                    
                    if(icident.site_id == site.id){
                        monincidentSite.push(icident);
                    }
                }
    
                $(`#identi${ot}`).replaceWith(`
                    <span style="margin-right: -5em; position: relative;" id="identi${ot}">
                        ${ incidentAgences.length > 0 ? (monincidentSite.length/incidentAgences.length) * 100  > 0 ? Math.floor((monincidentSite.length/incidentAgences.length) * 100) : 0 : 0 }%
                    </span>        
                `);
    
                $(`#adenti${ot}`).replaceWith(`
                    <div class="my-4" id="adenti${ot}">
                        <div class="barcontainer">
                        <div 
                                class="bar bg-primary font-weight-bold text-sm" 
                                style="height:${ incidentAgences.length > 0 ? (monincidentSite.length/incidentAgences.length) * 100  > 0 ? (monincidentSite.length/incidentAgences.length) * 100 : 0 : 0 }%; 
                                text-align:center;
                                ">
                        </div>
                        </div>
                        <span style="writing-mode:vertical-rl; font-size:0.9em; margin-right: 2em; margin-top:3em;">${site.name}</span>
                    </div>      
                `)
            }
    

            if($('#citadelle').val()){

                let incidentSiteSelectionne = [];

                if($('#citadelle').val() == "dg"){
                            
                    for (let k = 0; k < incidents.length; k++) {
                        const monincident = incidents[k];

                        let date_declaration = parseInt(dates[k].replaceAll("-", ""));
                        let debut = parseInt($('#DateDebut').val().replaceAll("-", ""));
                        let fin = parseInt($('#DateFin').val().replaceAll("-", ""));

                        if(
                            ((date_declaration == debut) && (date_declaration < fin)) ||
                            ((date_declaration > debut) && (date_declaration < fin)) ||
                            ((date_declaration > debut) && (date_declaration == fin)) || 
                            ((date_declaration == debut) && (date_declaration == fin))
                          )
                            {
                                if(!monincident.site_id){
                                    if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                                        incidentSiteSelectionne.push(monincident);
                                        incident_direction_generale.push(monincident);
                                    }
                                }
                            }
                    }

                    for (let fe = 0; fe < departements.length; fe++) {
                        const departement = departements[fe];
                        
                        let incident_dep_courant = [];
        
                        for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                            const iic = incident_direction_generale[vt];
                            
                            if(iic.categories.departement_id){
                                if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                                    incident_dep_courant.push(iic);
                                }
                            }
                        }
        
        
                        $(`#depi${fe}`).replaceWith(`
                            <div
                                id="depi${fe}"
                                class="progress-bar bg-success" 
                                role="progressbar" 
                                style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                                aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                                aria-valuemin="0" 
                                aria-valuemax="100"
                                >
                                ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                            </div>
                        `)
                    }

                    
                    for (let o = 0; o < incidentSiteSelectionne.length; o++) {
                        const incid = incidentSiteSelectionne[o];
                        
                        if(incid.status == "ENCOURS"){
                            ens +=1;
                            incidant_encours.push(incid);
        
                            let indes = -1;
        
                            if(incid.due_date){
        
                                for (let q = 0; q < ids.length; q++) {
                                    const number = ids[q];
                                    if(number == incid.number){
                                        indes = q;
                                    }
                                }
            
                                let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                                let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                                if(dateEcheance < today){
                                    enretard +=1;
                                    incidant_enretard.push(incid);                   
                                }else{
                                    a_temps +=1;
                                }   
                            }
                            
                        }else if(incid.status == "CLÔTURÉ"){
                            cls +=1;
                            incidant_cloturer.push(incid);

                            if(incid.due_date && incid.closure_date){
                                if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                                    nombre_cloture_enretard +=1;
                                }else{
                                    nombre_cloture_a_temps +=1;
                                }
                            }
        
                        }else{
                            ann +=1;
                            incidant_annuller.push(incid);
                        }
                    }
    
                    $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
                    $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
                    $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));
        
                    $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
                    $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
                    $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);
        
                    $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
                    $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
                    $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
                    $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);
                    $('#tot').replaceWith(`<span class="h2" id="tot">${incidentSiteSelectionne.length < 10 ? 0 +""+ incidentSiteSelectionne.length : incidentSiteSelectionne.length}</span>`);
                                        
                    $('#namels').replaceWith(`<span id="namels">Nombre D'Incidents</span>`);
                    $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement">DIRECTION GENERALE</span>`)
                    
                    $('#date_du').replaceWith(`<span id="date_du">Du ${$('#DateDebut').val()} </br> Au ${$(this).val()}</span>`);
        
                    $('#progress_cloture').replaceWith(`
                        <div
                            id="progress_cloture" 
                            class="progress-bar bg-success" 
                            role="progressbar" 
                            style="width: ${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? (cls/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                            aria-valuenow="${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? (cls/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                            aria-valuemin="0" 
                            aria-valuemax="100"
                            >${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                        </div>
                    `);
        
                    $('#progress_encours').replaceWith(`
                        <div 
                            id="progress_encours" 
                            class="progress-bar bg-primary" 
                            role="progressbar" 
                            style="width: ${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? (ens/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                            aria-valuenow="${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? (ens/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                            aria-valuemin="0" 
                            aria-valuemax="100"
                            >${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                        </div>
                    `);
        
                    $('#progress_annule').replaceWith(`
                        <div  
                            id="progress_annule" 
                            class="progress-bar bg-light" 
                            role="progressbar" 
                            style="width: ${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? (ann/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                            aria-valuenow="${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? (ann/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                            aria-valuemin="0" aria-valuemax="100"
                            > ${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentSiteSelectionne.length) * 100) : 0 : 0}% 
                        </div>
                    `);
        
                    $('#progress_enretard').replaceWith(`
                        <div 
                            id="progress_enretard"
                            class="progress-bar bg-warning" 
                            role="progressbar" 
                            style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                            aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                            aria-valuemin="0"
                            aria-valuemax="100"
                            >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
                        </div>
                    `);
        
                    $('#progress_non_annuler').replaceWith(`
                    <div 
                        id="progress_non_annuler" 
                        class="progress-bar progress-bar-striped bg-light" 
                        role="progressbar" 
                        style="width: ${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentSiteSelectionne.length) * 100 : 3 : 3}%" 
                        aria-valuenow="${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100">
                        ${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                    </div>
                    `);
        
                    $('#progress_non_encours').replaceWith(`
                        <div 
                            id="progress_non_encours" 
                            class="progress-bar progress-bar-striped bg-primary" 
                            role="progressbar" 
                            style="width: ${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentSiteSelectionne.length) * 100 : 3 : 3}%" 
                            aria-valuenow="${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                            aria-valuemin="0" 
                            aria-valuemax="100">
                            ${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                        </div>
                    `);
        
                    $("#progress_non_cloture").replaceWith(`
                        <div 
                            id="progress_non_cloture"
                            class="progress-bar progress-bar-striped bg-success"
                            role="progressbar"
                            style="width: ${incidentSiteSelectionne.length > 0 ? 
                                (((ens + ann)/incidentSiteSelectionne.length) * 100) > 0 ? 
                                (((ens + ann)/incidentSiteSelectionne.length) * 100) : 3 : 3}%"
                            aria-valuenow="${incidentSiteSelectionne.length > 0 ? ((ens + ann)/incidentSiteSelectionne.length) * 100 > 0 ? (((ens + ann)/incidentSiteSelectionne.length) * 100) : 3 : 3}"
                            aria-valuemin="0"
                            aria-valuemax="100">
                            ${incidentSiteSelectionne.length > 0 ? ((ens + ann)/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor(((ens + ann)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                        </div>
                    `);
        
                    $('#progress_non_enretard').replaceWith(`
                        <div 
                            id="progress_non_enretard" 
                            class="progress-bar progress-bar-striped bg-warning"
                            role="progressbar" 
                            style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                            aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                            aria-valuemin="0" 
                            aria-valuemax="100">
                            ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
                        </div>
                    `);
        
                }else{
                    
                for (let k = 0; k < incidents.length; k++) {
                    const monincident = incidents[k];
                    
                    let date_declaration = parseInt(dates[k].replaceAll("-", ""));
                    let debut = parseInt($('#DateDebut').val().replaceAll("-", ""));
                    let fin = parseInt($('#DateFin').val().replaceAll("-", ""));

                    if(((date_declaration == debut) && (date_declaration < fin)) ||
                        ((date_declaration > debut) && (date_declaration < fin)) ||
                        ((date_declaration > debut) && (date_declaration == fin)) ||
                        ((date_declaration == debut) && (date_declaration == fin))
                      )
                        {
                            if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                                if(monincident.site_id){
                                    if(parseInt(monincident.site_id) == parseInt($('#citadelle').val())){
                                        incidentSiteSelectionne.push(monincident);
                                    }
                                }else{
                                    incident_direction_generale.push(monincident);
                                }
                            }
                        }
                }
                    

                for (let fe = 0; fe < departements.length; fe++) {
                    const departement = departements[fe];
                    
                    let incident_dep_courant = [];
    
                    for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                        const iic = incident_direction_generale[vt];
                        
                        if(iic.categories.departement_id){
                            if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                                incident_dep_courant.push(iic);
                            }
                        }
                    }
    
    
                    $(`#depi${fe}`).replaceWith(`
                        <div
                            id="depi${fe}"
                            class="progress-bar bg-success" 
                            role="progressbar" 
                            style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                            aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                            aria-valuemin="0" 
                            aria-valuemax="100"
                            >
                            ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                        </div>
                    `)
                }


                for (let o = 0; o < incidentSiteSelectionne.length; o++) {
                    const incid = incidentSiteSelectionne[o];
                    
                    if(incid.status == "ENCOURS"){
                        ens +=1;
                        incidant_encours.push(incid);
    
                        let indes = -1;
    
                        if(incid.due_date){
    
                            for (let q = 0; q < ids.length; q++) {
                                const number = ids[q];
                                if(number == incid.number){
                                    indes = q;
                                }
                            }
        
                            let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                            let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                            if(dateEcheance < today){
                                enretard +=1;
                                incidant_enretard.push(incid);                   
                            }else{
                                a_temps +=1;
                            }    
                        }
                        
                    }else if(incid.status == "CLÔTURÉ"){
                        cls +=1;
                        incidant_cloturer.push(incid);

                        if(incid.due_date && incid.closure_date){
                            if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                                nombre_cloture_enretard +=1;
                            }else{
                                nombre_cloture_a_temps +=1;
                            }
                        }
                        
                    }else{
                        ann +=1;
                        incidant_annuller.push(incid);
                    }
    
                }
    
                $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
                $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
                $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));
    
                $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
                $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
                $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

                $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
                $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
                $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
                $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);
                $('#tot').replaceWith(`<span class="h2" id="tot">${incidentSiteSelectionne.length < 10 ? 0 +""+ incidentSiteSelectionne.length : incidentSiteSelectionne.length}</span>`);
                

                let site_selectionner = sites.find(s => s.id == $('#citadelle').val());
                $('#namels').replaceWith(`<span id="namels">Nombre D'Incidents</span>`);
                $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement">${site_selectionner.name}</span>`);
                
                $('#date_du').replaceWith(`<span id="date_du">Du ${$('#DateDebut').val()} </br> Au ${$(this).val()}</span>`);


                $('#progress_cloture').replaceWith(`
                    <div
                        id="progress_cloture" 
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: ${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? (cls/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                        aria-valuenow="${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? (cls/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);
    
                $('#progress_encours').replaceWith(`
                    <div 
                        id="progress_encours" 
                        class="progress-bar bg-primary" 
                        role="progressbar" 
                        style="width: ${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? (ens/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                        aria-valuenow="${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? (ens/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);
    
                $('#progress_annule').replaceWith(`
                    <div  
                        id="progress_annule" 
                        class="progress-bar bg-light" 
                        role="progressbar" 
                        style="width: ${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? (ann/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                        aria-valuenow="${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? (ann/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" aria-valuemax="100"
                        > ${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentSiteSelectionne.length) * 100) : 0 : 0}% 
                    </div>
                `);
    
                $('#progress_enretard').replaceWith(`
                    <div 
                        id="progress_enretard"
                        class="progress-bar bg-warning" 
                        role="progressbar" 
                        style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                        aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
                    </div>
                `);

                $('#progress_non_annuler').replaceWith(`
                <div 
                    id="progress_non_annuler" 
                    class="progress-bar progress-bar-striped bg-light" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentSiteSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
                `);
    
                $('#progress_non_encours').replaceWith(`
                    <div 
                        id="progress_non_encours" 
                        class="progress-bar progress-bar-striped bg-primary" 
                        role="progressbar" 
                        style="width: ${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentSiteSelectionne.length) * 100 : 3 : 3}%" 
                        aria-valuenow="${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100">
                        ${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);
    
                $("#progress_non_cloture").replaceWith(`
                    <div 
                        id="progress_non_cloture"
                        class="progress-bar progress-bar-striped bg-success"
                        role="progressbar"
                        style="width: ${incidentSiteSelectionne.length > 0 ? 
                            (((ens + ann)/incidentSiteSelectionne.length) * 100) > 0 ? 
                            (((ens + ann)/incidentSiteSelectionne.length) * 100) : 3 : 3}%"
                        aria-valuenow="${incidentSiteSelectionne.length > 0 ? ((ens + ann)/incidentSiteSelectionne.length) * 100 > 0 ? (((ens + ann)/incidentSiteSelectionne.length) * 100) : 3 : 3}"
                        aria-valuemin="0"
                        aria-valuemax="100">
                        ${incidentSiteSelectionne.length > 0 ? ((ens + ann)/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor(((ens + ann)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);
    
                $('#progress_non_enretard').replaceWith(`
                    <div 
                        id="progress_non_enretard" 
                        class="progress-bar progress-bar-striped bg-warning"
                        role="progressbar" 
                        style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                        aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100">
                        ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
                    </div>
                `);
    
                }

            }else if($('#departes').val()){

                let incidentDepartementSelectionne = [];

                for (let k = 0; k < incidents.length; k++) {
                    const monincident = incidents[k];
    
                    let date_declaration = parseInt(dates[k].replaceAll("-", ""));
                    let debut = parseInt($('#DateDebut').val().replaceAll("-", ""));
                    let fin = parseInt($('#DateFin').val().replaceAll("-", ""));

                    if(((date_declaration == debut) && (date_declaration < fin)) ||
                    ((date_declaration > debut) && (date_declaration < fin)) ||
                    ((date_declaration > debut) && (date_declaration == fin)) ||
                    ((date_declaration == debut) && (date_declaration == fin))
                  ){

                    if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                        if(monincident.categories.departement_id){
                            if(monincident.categories.departement_id == $('#departes').val()){
                                incidentDepartementSelectionne.push(monincident);
                            }
                        }

                        if(!monincident.site_id){
                            incident_direction_generale.push(monincident);
                        }
                    }
                  }                
                }
    
                for (let fe = 0; fe < departements.length; fe++) {
                    const departement = departements[fe];
                    
                    let incident_dep_courant = [];
    
                    for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                        const iic = incident_direction_generale[vt];
                        
                        if(iic.categories.departement_id){
                            if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                                incident_dep_courant.push(iic);
                            }
                        }
                    }
    
    
                    $(`#depi${fe}`).replaceWith(`
                        <div
                            id="depi${fe}"
                            class="progress-bar bg-success" 
                            role="progressbar" 
                            style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                            aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                            aria-valuemin="0" 
                            aria-valuemax="100"
                            >
                            ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                        </div>
                    `)
                }


                $('#tot').replaceWith(`<span class="h2" id="tot">${incidentDepartementSelectionne.length < 10 ? 0 +""+ incidentDepartementSelectionne.length : incidentDepartementSelectionne.length}</span>`);
    
                for (let o = 0; o < incidentDepartementSelectionne.length; o++) {
                    const incid = incidentDepartementSelectionne[o];
                    
                    if(incid.status == "ENCOURS"){
                        ens +=1;
                        incidant_encours.push(incid);
    
                        let indes = -1;
    
                        if(incid.due_date){
    
                            for (let q = 0; q < ids.length; q++) {
                                const number = ids[q];
                                if(number == incid.number){
                                    indes = q;
                                }
                            }
        
                            let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                            let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                            if(dateEcheance < today){
                                enretard +=1;
                                incidant_enretard.push(incid);                   
                            }else{
                                a_temps +=1;
                            }   
                        }
                        
                    }else if(incid.status == "CLÔTURÉ"){
                        cls +=1;
                        incidant_cloturer.push(incid);

                        if(incid.due_date && incid.closure_date){
                            if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                                nombre_cloture_enretard +=1;
                            }else{
                                nombre_cloture_a_temps +=1;
                            }
                        }

                    }else{
                        ann +=1;
                        incidant_annuller.push(incid);
                    }
    
                }
    
                $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
                $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
                $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));
    
                $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
                $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
                $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

                $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
                $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
                $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
                $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);
    
                $('#date_du').replaceWith(`<span id="date_du">Du ${$('#DateDebut').val()} </br> Au ${$(this).val()}</span>`);

                $('#progress_cloture').replaceWith(`
                    <div
                        id="progress_cloture" 
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: ${incidentDepartementSelectionne.length > 0 ? (cls/incidentDepartementSelectionne.length) * 100 > 0 ? (cls/incidentDepartementSelectionne.length) * 100 : 3 : 3}%;" 
                        aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (cls/incidentDepartementSelectionne.length) * 100 > 0 ? (cls/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >${incidentDepartementSelectionne.length > 0 ? (cls/incidentDepartementSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);
    
                $('#progress_encours').replaceWith(`
                    <div 
                        id="progress_encours" 
                        class="progress-bar bg-primary" 
                        role="progressbar" 
                        style="width: ${incidentDepartementSelectionne.length > 0 ? (ens/incidentDepartementSelectionne.length) * 100 > 0 ? (ens/incidentDepartementSelectionne.length) * 100 : 3 : 3}%;" 
                        aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (ens/incidentDepartementSelectionne.length) * 100 > 0 ? (ens/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >${incidentDepartementSelectionne.length > 0 ? (ens/incidentDepartementSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);
    
                $('#progress_annule').replaceWith(`
                    <div  
                        id="progress_annule" 
                        class="progress-bar bg-light" 
                        role="progressbar" 
                        style="width: ${incidentDepartementSelectionne.length > 0 ? (ann/incidentDepartementSelectionne.length) * 100 > 0 ? (ann/incidentDepartementSelectionne.length) * 100 : 3 : 3}%;" 
                        aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (ann/incidentDepartementSelectionne.length) * 100 > 0 ? (ann/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" aria-valuemax="100"
                        > ${incidentDepartementSelectionne.length > 0 ? (ann/incidentDepartementSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentDepartementSelectionne.length) * 100) : 0 : 0}% 
                    </div>
                `);
    
                $('#progress_enretard').replaceWith(`
                    <div 
                        id="progress_enretard"
                        class="progress-bar bg-warning" 
                        role="progressbar" 
                        style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                        aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
                    </div>
                `);
    
                $('#progress_non_encours').replaceWith(`
                <div 
                    id="progress_non_encours" 
                    class="progress-bar progress-bar-striped bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentDepartementSelectionne.length > 0 ? (((cls+ann)/incidentDepartementSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentDepartementSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (((cls+ann)/incidentDepartementSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0"
                    aria-valuemax="100">
                    ${incidentDepartementSelectionne.length > 0 ? (((cls+ann)/incidentDepartementSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $("#progress_non_cloture").replaceWith(`
                <div 
                    id="progress_non_cloture"
                    class="progress-bar progress-bar-striped bg-success"
                    role="progressbar"
                    style="width: ${incidentDepartementSelectionne.length > 0 ? 
                        (((ens + ann)/incidentDepartementSelectionne.length) * 100) > 0 ? 
                        (((ens + ann)/incidentDepartementSelectionne.length) * 100) : 3 : 3}%"
                    aria-valuenow="${incidentDepartementSelectionne.length > 0 ? ((ens + ann)/incidentDepartementSelectionne.length) * 100 > 0 ? (((ens + ann)/incidentDepartementSelectionne.length) * 100) : 3 : 3}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    ${incidentDepartementSelectionne.length > 0 ? ((ens + ann)/incidentDepartementSelectionne.length) * 100 > 0 ? Math.floor(((ens + ann)/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_annuler').replaceWith(`
                <div 
                    id="progress_non_annuler" 
                    class="progress-bar progress-bar-striped bg-light" 
                    role="progressbar" 
                    style="width: ${incidentDepartementSelectionne.length > 0 ? (((cls+ens)/incidentDepartementSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentDepartementSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (((cls+ens)/incidentDepartementSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentDepartementSelectionne.length > 0 ? (((cls+ens)/incidentDepartementSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_enretard').replaceWith(`
                <div 
                    id="progress_non_enretard" 
                    class="progress-bar progress-bar-striped bg-warning"
                    role="progressbar" 
                    style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                    aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
                </div>
            `);

            }else if($('#regionnn').val()){

                let incidentRegionSelectionne = [];

                for (let k = 0; k < incidents.length; k++) {

                    const monincident = incidents[k];
                    
                    let date_declaration = parseInt(dates[k].replaceAll("-", ""));
                    let debut = parseInt($('#DateDebut').val().replaceAll("-", ""));
                    let fin = parseInt($('#DateFin').val().replaceAll("-", ""));

                    if(((date_declaration == debut) && (date_declaration < fin)) ||
                    ((date_declaration > debut) && (date_declaration < fin)) ||
                    ((date_declaration > debut) && (date_declaration == fin)) ||
                    ((date_declaration == debut) && (date_declaration == fin))
                  ){

                    if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                        if(monincident.site_id){
                            if(monincident.sites.region == $('#regionnn').val()){
                                incidentRegionSelectionne.push(monincident);
                            }
                        }else{

                            incident_direction_generale.push(monincident);

                            if($('#regionnn').val() == "LITTORAL"){
                                if(!monincident.site_id){
                                    incidentRegionSelectionne.push(monincident);
                                }
                            }
                        }
                    }
                  }
                }
    
                for (let fe = 0; fe < departements.length; fe++) {
                    const departement = departements[fe];
                    
                    let incident_dep_courant = [];
    
                    for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                        const iic = incident_direction_generale[vt];
                        
                        if(iic.categories.departement_id){
                            if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                                incident_dep_courant.push(iic);
                            }
                        }
                    }
    
    
                    $(`#depi${fe}`).replaceWith(`
                        <div
                            id="depi${fe}"
                            class="progress-bar bg-success" 
                            role="progressbar" 
                            style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                            aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                            aria-valuemin="0" 
                            aria-valuemax="100"
                            >
                            ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                        </div>
                    `)
                }


                for (let o = 0; o < incidentRegionSelectionne.length; o++) {
                    const incid = incidentRegionSelectionne[o];
                    
                    if(incid.status == "ENCOURS"){
                        ens +=1;
                        incidant_encours.push(incid);
    
                        let indes = -1;
    
                        if(incid.due_date){
    
                            for (let q = 0; q < ids.length; q++) {
                                const number = ids[q];
                                if(number == incid.number){
                                    indes = q;
                                }
                            }
        
                            let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                            let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                            if(dateEcheance < today){
                                enretard +=1;
                                incidant_enretard.push(incid);                   
                            }else{
                                a_temps +=1;
                            }
                        }
                        
                    }else if(incid.status == "CLÔTURÉ"){
                        cls +=1;
                        incidant_cloturer.push(incid);

                        if(incid.due_date && incid.closure_date){
                            if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                                nombre_cloture_enretard +=1;
                            }else{
                                nombre_cloture_a_temps +=1;
                            }
                        }

                    }else{
                        ann +=1;
                        incidant_annuller.push(incid);
                    }
    
                }
    
                $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
                $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
                $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));
    
                $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
                $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
                $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

                $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
                $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
                $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
                $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);
                $('#tot').replaceWith(`<span class="h2" id="tot">${incidentRegionSelectionne.length < 10 ? 0 +""+ incidentRegionSelectionne.length : incidentRegionSelectionne.length}</span>`);
    
                $('#date_du').replaceWith(`<span id="date_du">Du ${$('#DateDebut').val()} </br> Au ${$(this).val()}</span>`);
    
                $('#progress_cloture').replaceWith(`
                    <div
                        id="progress_cloture" 
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: ${incidentRegionSelectionne.length > 0 ? (cls/incidentRegionSelectionne.length) * 100 > 0 ? (cls/incidentRegionSelectionne.length) * 100 : 3 : 3}%;" 
                        aria-valuenow="${incidentRegionSelectionne.length > 0 ? (cls/incidentRegionSelectionne.length) * 100 > 0 ? (cls/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >${incidentRegionSelectionne.length > 0 ? (cls/incidentRegionSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentRegionSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);
    
                $('#progress_encours').replaceWith(`
                    <div 
                        id="progress_encours" 
                        class="progress-bar bg-primary" 
                        role="progressbar" 
                        style="width: ${incidentRegionSelectionne.length > 0 ? (ens/incidentRegionSelectionne.length) * 100 > 0 ? (ens/incidentRegionSelectionne.length) * 100 : 3 : 3}%;" 
                        aria-valuenow="${incidentRegionSelectionne.length > 0 ? (ens/incidentRegionSelectionne.length) * 100 > 0 ? (ens/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >${incidentRegionSelectionne.length > 0 ? (ens/incidentRegionSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentRegionSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);
    
                $('#progress_annule').replaceWith(`
                    <div  
                        id="progress_annule" 
                        class="progress-bar bg-light" 
                        role="progressbar" 
                        style="width: ${incidentRegionSelectionne.length > 0 ? (ann/incidentRegionSelectionne.length) * 100 > 0 ? (ann/incidentRegionSelectionne.length) * 100 : 3 : 3}%;" 
                        aria-valuenow="${incidentRegionSelectionne.length > 0 ? (ann/incidentRegionSelectionne.length) * 100 > 0 ? (ann/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" aria-valuemax="100"
                        > ${incidentRegionSelectionne.length > 0 ? (ann/incidentRegionSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentRegionSelectionne.length) * 100) : 0 : 0}% 
                    </div>
                `);
    
                $('#progress_enretard').replaceWith(`
                    <div 
                        id="progress_enretard"
                        class="progress-bar bg-warning" 
                        role="progressbar" 
                        style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                        aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
                    </div>
                `);
    
                $('#progress_non_encours').replaceWith(`
                <div 
                    id="progress_non_encours" 
                    class="progress-bar progress-bar-striped bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentRegionSelectionne.length > 0 ? (((cls+ann)/incidentRegionSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentRegionSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentRegionSelectionne.length > 0 ? (((cls+ann)/incidentRegionSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentRegionSelectionne.length > 0 ? (((cls+ann)/incidentRegionSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentRegionSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $("#progress_non_cloture").replaceWith(`
                <div 
                    id="progress_non_cloture"
                    class="progress-bar progress-bar-striped bg-success"
                    role="progressbar"
                    style="width: ${incidentRegionSelectionne.length > 0 ? 
                        (((ens + ann)/incidentRegionSelectionne.length) * 100) > 0 ? 
                        (((ens + ann)/incidentRegionSelectionne.length) * 100) : 3 : 3}%"
                    aria-valuenow="${incidentRegionSelectionne.length > 0 ? (((ens + ann)/incidentRegionSelectionne.length) * 100) > 0 ? (((ens + ann)/incidentRegionSelectionne.length) * 100) : 3 : 3}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    ${incidentRegionSelectionne.length > 0 ? (((ens + ann)/incidentRegionSelectionne.length) * 100) > 0 ? Math.floor(((ens + ann)/incidentRegionSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_annuler').replaceWith(`
                <div 
                    id="progress_non_annuler" 
                    class="progress-bar progress-bar-striped bg-light" 
                    role="progressbar" 
                    style="width: ${incidentRegionSelectionne.length > 0 ? (((cls+ens)/incidentRegionSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentRegionSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentRegionSelectionne.length > 0 ? (((cls+ens)/incidentRegionSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentRegionSelectionne.length > 0 ? (((cls+ens)/incidentRegionSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentRegionSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_enretard').replaceWith(`
                <div 
                    id="progress_non_enretard" 
                    class="progress-bar progress-bar-striped bg-warning"
                    role="progressbar" 
                    style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                    aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
                </div>
            `);

            }else{

                let incidentDateSelectionne = [];


                for (let k = 0; k < incidents.length; k++) {

                    const monincident = incidents[k];

                    let date_incident = parseInt(dates[k].replaceAll("-", ""));
                    let debut = parseInt($('#DateDebut').val().replaceAll("-", ""));
                    let fin = parseInt($('#DateFin').val().replaceAll("-", ""));
                    if(
                        ((date_incident == debut) && (date_incident < fin)) ||
                        ((date_incident > debut) && (date_incident < fin)) ||
                        ((date_incident > debut) && (date_incident == fin)) ||
                        ((date_incident == debut) && (date_incident == fin))
                    ){
                        if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                            incidentDateSelectionne.push(monincident);

                            if(!monincident.site_id){
                                incident_direction_generale.push(monincident);
                            }
                        }
                    }
                }

                for (let fe = 0; fe < departements.length; fe++) {
                    const departement = departements[fe];
                    
                    let incident_dep_courant = [];
    
                    for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                        const iic = incident_direction_generale[vt];
                        
                        if(iic.categories.departement_id){
                            if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                                incident_dep_courant.push(iic);
                            }
                        }
                    }
    
    
                    $(`#depi${fe}`).replaceWith(`
                        <div
                            id="depi${fe}"
                            class="progress-bar bg-success" 
                            role="progressbar" 
                            style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                            aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                            aria-valuemin="0" 
                            aria-valuemax="100"
                            >
                            ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                        </div>
                    `)
                }


                for (let o = 0; o < incidentDateSelectionne.length; o++) {
                    const incid = incidentDateSelectionne[o];
                    
                    if(incid.status == "ENCOURS"){
                        ens +=1;
                        incidant_encours.push(incid);
    
                        let indes = -1;
    
                        if(incid.due_date){
    
                            for (let q = 0; q < ids.length; q++) {
                                const number = ids[q];
                                if(number == incid.number){
                                    indes = q;
                                }
                            }
        
                            let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                            let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                            if(dateEcheance < today){
                                enretard +=1;
                                incidant_enretard.push(incid);                   
                            }else{
                                a_temps +=1;
                            }    
                        }
                        
                    }else if(incid.status == "CLÔTURÉ"){
                        cls +=1;
                        incidant_cloturer.push(incid);

                        if(incid.due_date && incid.closure_date){
                            if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                                nombre_cloture_enretard +=1;
                            }else{
                                nombre_cloture_a_temps +=1;
                            }
                        }

                    }else{
                        ann +=1;
                        incidant_annuller.push(incid);
                    }
    
                }
    
    
                $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
                $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
                $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));

                $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
                $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
                $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

                $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
                $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
                $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
                $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);
                $('#tot').replaceWith(`<span class="h2" id="tot">${incidentDateSelectionne.length < 10 ? 0 +""+ incidentDateSelectionne.length : incidentDateSelectionne.length}</span>`);
                
                $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement">Nombre D'Incidents</span>`);
                $('#date_du').replaceWith(`<span id="date_du">Du ${$('#DateDebut').val()} </br> Au ${$(this).val()}</span>`);

    
                $('#progress_cloture').replaceWith(`
                    <div
                        id="progress_cloture" 
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: ${incidentDateSelectionne.length > 0 ? (cls/incidentDateSelectionne.length) * 100 > 0 ? (cls/incidentDateSelectionne.length) * 100 : 3 : 3}%;" 
                        aria-valuenow="${incidentDateSelectionne.length > 0 ? (cls/incidentDateSelectionne.length) * 100 > 0 ? (cls/incidentDateSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >${incidentDateSelectionne.length > 0 ? (cls/incidentDateSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentDateSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);
    
                $('#progress_encours').replaceWith(`
                    <div 
                        id="progress_encours" 
                        class="progress-bar bg-primary" 
                        role="progressbar" 
                        style="width: ${incidentDateSelectionne.length > 0 ? (ens/incidentDateSelectionne.length) * 100 > 0 ? (ens/incidentDateSelectionne.length) * 100 : 3 : 3}%;" 
                        aria-valuenow="${incidentDateSelectionne.length > 0 ? (ens/incidentDateSelectionne.length) * 100 > 0 ? (ens/incidentDateSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >${incidentDateSelectionne.length > 0 ? (ens/incidentDateSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentDateSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);
    
                $('#progress_annule').replaceWith(`
                    <div  
                        id="progress_annule" 
                        class="progress-bar bg-light" 
                        role="progressbar" 
                        style="width: ${incidentDateSelectionne.length > 0 ? (ann/incidentDateSelectionne.length) * 100 > 0 ? (ann/incidentDateSelectionne.length) * 100 : 3 : 3}%;" 
                        aria-valuenow="${incidentDateSelectionne.length > 0 ? (ann/incidentDateSelectionne.length) * 100 > 0 ? (ann/incidentDateSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" aria-valuemax="100"
                        > ${incidentDateSelectionne.length > 0 ? (ann/incidentDateSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentDateSelectionne.length) * 100) : 0 : 0}% 
                    </div>
                `);
    
                $('#progress_enretard').replaceWith(`
                    <div 
                        id="progress_enretard"
                        class="progress-bar bg-warning" 
                        role="progressbar" 
                        style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                        aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
                    </div>
                `);

                $('#progress_non_encours').replaceWith(`
                    <div 
                        id="progress_non_encours" 
                        class="progress-bar progress-bar-striped bg-primary" 
                        role="progressbar" 
                        style="width: ${incidentDateSelectionne.length > 0 ? (((cls+ann)/incidentDateSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentDateSelectionne.length) * 100 : 3 : 3}%" 
                        aria-valuenow="${incidentDateSelectionne.length > 0 ? (((cls+ann)/incidentDateSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentDateSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100">
                        ${incidentDateSelectionne.length > 0 ? (((cls+ann)/incidentDateSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentDateSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);

                $("#progress_non_cloture").replaceWith(`
                    <div 
                        id="progress_non_cloture"
                        class="progress-bar progress-bar-striped bg-success"
                        role="progressbar"
                        style="width: ${incidentDateSelectionne.length > 0 ? 
                            (((ens + ann)/incidentDateSelectionne.length) * 100) > 0 ? 
                            (((ens + ann)/incidentDateSelectionne.length) * 100) : 3 : 3}%"
                        aria-valuenow="${incidentDateSelectionne.length > 0 ? (((ens + ann)/incidentDateSelectionne.length) * 100) > 0 ? (((ens + ann)/incidentDateSelectionne.length) * 100) : 3 : 3}"
                        aria-valuemin="0"
                        aria-valuemax="100">
                        ${incidentDateSelectionne.length > 0 ? (((ens + ann)/incidentDateSelectionne.length) * 100) > 0 ? Math.floor(((ens + ann)/incidentDateSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);

                $('#progress_non_annuler').replaceWith(`
                    <div 
                        id="progress_non_annuler" 
                        class="progress-bar progress-bar-striped bg-light" 
                        role="progressbar" 
                        style="width: ${incidentDateSelectionne.length > 0 ? (((cls+ens)/incidentDateSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentDateSelectionne.length) * 100 : 3 : 3}%" 
                        aria-valuenow="${incidentDateSelectionne.length > 0 ? (((cls+ens)/incidentDateSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentDateSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100">
                        ${incidentDateSelectionne.length > 0 ? (((cls+ens)/incidentDateSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentDateSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);

                $('#progress_non_enretard').replaceWith(`
                    <div 
                        id="progress_non_enretard" 
                        class="progress-bar progress-bar-striped bg-warning"
                        role="progressbar" 
                        style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                        aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100">
                        ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
                    </div>
                `);

            }
        }
    }else{

        let ids = JSON.parse($(this).attr('data-ids'));
        let sites = JSON.parse($(this).attr('data-sites'));
        let due_dates = JSON.parse($(this).attr('data-exited'));
        let dates = JSON.parse($(this).attr('data-created'));
        let incidents = JSON.parse($(this).attr('data-incidents'));
        let departements = JSON.parse($(this).attr('data-departements'));
        let nombre_cloture_enretard = 0;
        let nombre_cloture_a_temps = 0;
        let a_temps = 0;

        let ens = 0;
        let cls = 0;
        let ann = 0;
        let enretard = 0;
        let incidant_encours = [];
        let incidant_enretard = [];
        let incidant_cloturer = [];
        let incidant_annuller = [];
        let annee_selectionne = $('#DateDebut').val().replaceAll("-", "");
        let incident_direction_generale = [];
        let incidentAgences = [];

        for (let vt = 0; vt < incidents.length; vt++) {
            const iir = incidents[vt];
            
            let annee = dates[vt].replaceAll("-", "");

            if(parseInt(annee) == parseInt(annee_selectionne)){

                if(iir.site_id){
                    if((iir.observation_rex) && (!iir.deja_pris_en_compte)){
                        incidentAgences.push(iir);
                    }
                }
            }
        }


        for (let ot = 0; ot < sites.length; ot++) {
            const site = sites[ot];
            
            let monincidentSite = [];

            for (let rt = 0; rt < incidentAgences.length; rt++) {
                const icident = incidentAgences[rt];
                
                if(icident.site_id == site.id){
                    monincidentSite.push(icident);
                }
            }

            $(`#identi${ot}`).replaceWith(`
                <span style="margin-right: -5em; position: relative;" id="identi${ot}">
                    ${ incidentAgences.length > 0 ? (monincidentSite.length/incidentAgences.length) * 100  > 0 ? Math.floor((monincidentSite.length/incidentAgences.length) * 100) : 0 : 0 }%
                </span>        
            `);

            $(`#adenti${ot}`).replaceWith(`
                <div class="my-4" id="adenti${ot}">
                    <div class="barcontainer">
                    <div 
                            class="bar bg-primary font-weight-bold text-sm" 
                            style="height:${ incidentAgences.length > 0 ? (monincidentSite.length/incidentAgences.length) * 100  > 0 ? (monincidentSite.length/incidentAgences.length) * 100 : 0 : 0 }%; 
                            text-align:center;
                            ">
                    </div>
                    </div>
                    <span style="writing-mode:vertical-rl; font-size:0.9em; margin-right: 2em; margin-top:3em;">${site.name}</span>
                </div>      
            `)
        }


        if($('#citadelle').val()){
            let incidentSiteSelectionne = [];

            if($('#citadelle').val() == "dg"){
                        
                for (let k = 0; k < incidents.length; k++) {
                    const monincident = incidents[k];
                    let annee = dates[k].replaceAll("-", "");
                    
                    if(parseInt(annee) == parseInt(annee_selectionne)){

                        if(!monincident.site_id){
                            if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                                incidentSiteSelectionne.push(monincident);
                                incident_direction_generale.push(monincident);
                            }
                        }
    
                    }
                }
                    
                for (let fe = 0; fe < departements.length; fe++) {
                    const departement = departements[fe];
                    
                    let incident_dep_courant = [];
    
                    for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                        const iic = incident_direction_generale[vt];
                        
                        if(iic.categories.departement_id){
                            if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                                incident_dep_courant.push(iic);
                            }
                        }
                    }
    
    
                    $(`#depi${fe}`).replaceWith(`
                        <div
                            id="depi${fe}"
                            class="progress-bar bg-success" 
                            role="progressbar" 
                            style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                            aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                            aria-valuemin="0" 
                            aria-valuemax="100"
                            >
                            ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                        </div>
                    `)
                }


                for (let o = 0; o < incidentSiteSelectionne.length; o++) {
                    const incid = incidentSiteSelectionne[o];
                    
                    if(incid.status == "ENCOURS"){
                        ens +=1;
                        incidant_encours.push(incid);
    
                        let indes = -1;
    
                        if(incid.due_date){
    
                            for (let q = 0; q < ids.length; q++) {
                                const number = ids[q];
                                if(number == incid.number){
                                    indes = q;
                                }
                            }
        
                            let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                            let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                            if(dateEcheance < today){
                                enretard +=1;
                                incidant_enretard.push(incid);                   
                            }else{
                                a_temps +=1;
                            }   
                        }
                        
                    }else if(incid.status == "CLÔTURÉ"){
                        cls +=1;
                        incidant_cloturer.push(incid);

                        if(incid.status == "CLÔTURÉ"){
                            if(incid.due_date && incid.closure_date){
                                if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                                    nombre_cloture_enretard +=1;
                                }else{
                                    nombre_cloture_a_temps +=1;
                                }
                            }
                        }
                    }else{
                        ann +=1;
                        incidant_annuller.push(incid);
                    }
    
                }

                $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
                $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
                $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));
            
                $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
                $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
                $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);
    
                $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
                $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
                $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
                $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);
                $('#tot').replaceWith(`<span class="h2" id="tot">${incidentSiteSelectionne.length < 10 ? 0 +""+ incidentSiteSelectionne.length : incidentSiteSelectionne.length}</span>`);
                                    
                $('#namels').replaceWith(`<span id="namels">Nombre D'Incidents</span>`);
                $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement">DIRECTION GENERALE</span>`)
                $('#date_du').replaceWith(`<span id="date_du">Du ${$('#DateDebut').val()}</span>`);
    
                $('#progress_cloture').replaceWith(`
                    <div
                        id="progress_cloture" 
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: ${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? (cls/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                        aria-valuenow="${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? (cls/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);
    
                $('#progress_encours').replaceWith(`
                    <div 
                        id="progress_encours" 
                        class="progress-bar bg-primary" 
                        role="progressbar" 
                        style="width: ${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? (ens/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                        aria-valuenow="${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? (ens/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);
    
                $('#progress_annule').replaceWith(`
                    <div  
                        id="progress_annule" 
                        class="progress-bar bg-light" 
                        role="progressbar" 
                        style="width: ${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? (ann/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                        aria-valuenow="${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? (ann/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" aria-valuemax="100"
                        > ${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentSiteSelectionne.length) * 100) : 0 : 0}% 
                    </div>
                `);
    
                $('#progress_enretard').replaceWith(`
                    <div 
                        id="progress_enretard"
                        class="progress-bar bg-warning" 
                        role="progressbar" 
                        style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                        aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
                    </div>
                `);
    
                $('#progress_non_annuler').replaceWith(`
                <div 
                    id="progress_non_annuler" 
                    class="progress-bar progress-bar-striped bg-light" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentSiteSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
                `);

                $('#progress_non_encours').replaceWith(`
                    <div 
                        id="progress_non_encours" 
                        class="progress-bar progress-bar-striped bg-primary" 
                        role="progressbar" 
                        style="width: ${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentSiteSelectionne.length) * 100 : 3 : 3}%" 
                        aria-valuenow="${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                        aria-valuemin="0" 
                        aria-valuemax="100">
                        ${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);

                $("#progress_non_cloture").replaceWith(`
                    <div 
                        id="progress_non_cloture"
                        class="progress-bar progress-bar-striped bg-success"
                        role="progressbar"
                        style="width: ${incidentSiteSelectionne.length > 0 ? 
                            (((ens + ann)/incidentSiteSelectionne.length) * 100) > 0 ? 
                            (((ens + ann)/incidentSiteSelectionne.length) * 100) : 3 : 3}%"
                        aria-valuenow="${incidentSiteSelectionne.length > 0 ? ((ens + ann)/incidentSiteSelectionne.length) * 100 > 0 ? (((ens + ann)/incidentSiteSelectionne.length) * 100) : 3 : 3}"
                        aria-valuemin="0"
                        aria-valuemax="100">
                        ${incidentSiteSelectionne.length > 0 ? ((ens + ann)/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor(((ens + ann)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                    </div>
                `);

                $('#progress_non_enretard').replaceWith(`
                    <div 
                        id="progress_non_enretard" 
                        class="progress-bar progress-bar-striped bg-warning"
                        role="progressbar" 
                        style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%"
                        aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}"
                        aria-valuemin="0" 
                        aria-valuemax="100">
                        ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
                    </div>
                `);

            }else{
                
            for (let k = 0; k < incidents.length; k++) {
                const monincident = incidents[k];
                let annee = dates[k].replaceAll("-", "");
                
                if(parseInt(annee) == parseInt(annee_selectionne)){

                    if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                        if(monincident.site_id){
                            if(parseInt(monincident.site_id) == parseInt($('#citadelle').val())){
                                incidentSiteSelectionne.push(monincident);
                            }
                        }else{
                            incident_direction_generale.push(monincident);
                        } 
                    }
                }
            }
            

            for (let fe = 0; fe < departements.length; fe++) {
                const departement = departements[fe];
                
                let incident_dep_courant = [];

                for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                    const iic = incident_direction_generale[vt];
                    
                    if(iic.categories.departement_id){
                        if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                            incident_dep_courant.push(iic);
                        }
                    }
                }


                $(`#depi${fe}`).replaceWith(`
                    <div
                        id="depi${fe}"
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                        aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >
                        ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                    </div>
                `)
            }


            for (let o = 0; o < incidentSiteSelectionne.length; o++) {
                const incid = incidentSiteSelectionne[o];
                
                if(incid.status == "ENCOURS"){
                    ens +=1;
                    incidant_encours.push(incid);

                    let indes = -1;

                    if(incid.due_date){

                        for (let q = 0; q < ids.length; q++) {
                            const number = ids[q];
                            if(number == incid.number){
                                indes = q;
                            }
                        }
    
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                        if(dateEcheance < today){
                            enretard +=1;
                            incidant_enretard.push(incid);                   
                        }else{
                            a_temps +=1;
                        }
                    }
                    
                }else if(incid.status == "CLÔTURÉ"){
                    cls +=1;
                    incidant_cloturer.push(incid);

                    if(incid.status == "CLÔTURÉ"){
                        if(incid.due_date && incid.closure_date){
                            if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                                nombre_cloture_enretard +=1;
                            }else{
                                nombre_cloture_a_temps +=1;
                            }
                        }
                    }

                }else{
                    ann +=1;
                    incidant_annuller.push(incid);
                }

            }

            $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
            //$('#floder_retard').attr('data-retards', JSON.stringify(incidant_enretard));
            $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
            $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));

            $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
            $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
            $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

            $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
            $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
            $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
            $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);
            $('#tot').replaceWith(`<span class="h2" id="tot">${incidentSiteSelectionne.length < 10 ? 0 +""+ incidentSiteSelectionne.length : incidentSiteSelectionne.length}</span>`);
            

            let site_selectionner = sites.find(s => s.id == $('#citadelle').val());
            $('#namels').replaceWith(`<span id="namels">Nombre D'Incidents</span>`);
            $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement">${site_selectionner.name}</span>`);
            $('#date_du').replaceWith(`<span id="date_du">Du ${$('#DateDebut').val()}</span>`);


            $('#progress_cloture').replaceWith(`
                <div
                    id="progress_cloture" 
                    class="progress-bar bg-success" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? (cls/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? (cls/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentSiteSelectionne.length > 0 ? (cls/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_encours').replaceWith(`
                <div 
                    id="progress_encours" 
                    class="progress-bar bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? (ens/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? (ens/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentSiteSelectionne.length > 0 ? (ens/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_annule').replaceWith(`
                <div  
                    id="progress_annule" 
                    class="progress-bar bg-light" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? (ann/incidentSiteSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? (ann/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" aria-valuemax="100"
                    > ${incidentSiteSelectionne.length > 0 ? (ann/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentSiteSelectionne.length) * 100) : 0 : 0}% 
                </div>
            `);

            $('#progress_enretard').replaceWith(`
                <div 
                    id="progress_enretard"
                    class="progress-bar bg-warning" 
                    role="progressbar" 
                    style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                    aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
                </div>
            `);

            $('#progress_non_annuler').replaceWith(`
                <div 
                    id="progress_non_annuler" 
                    class="progress-bar progress-bar-striped bg-light" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentSiteSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentSiteSelectionne.length > 0 ? (((cls+ens)/incidentSiteSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_encours').replaceWith(`
                <div 
                    id="progress_non_encours" 
                    class="progress-bar progress-bar-striped bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentSiteSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentSiteSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentSiteSelectionne.length > 0 ? (((cls+ann)/incidentSiteSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $("#progress_non_cloture").replaceWith(`
                <div 
                    id="progress_non_cloture"
                    class="progress-bar progress-bar-striped bg-success"
                    role="progressbar"
                    style="width: ${incidentSiteSelectionne.length > 0 ? 
                        (((ens + ann)/incidentSiteSelectionne.length) * 100) > 0 ? 
                        (((ens + ann)/incidentSiteSelectionne.length) * 100) : 3 : 3}%"
                    aria-valuenow="${incidentSiteSelectionne.length > 0 ? ((ens + ann)/incidentSiteSelectionne.length) * 100 > 0 ? (((ens + ann)/incidentSiteSelectionne.length) * 100) : 3 : 3}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    ${incidentSiteSelectionne.length > 0 ? ((ens + ann)/incidentSiteSelectionne.length) * 100 > 0 ? Math.floor(((ens + ann)/incidentSiteSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_enretard').replaceWith(`
                <div 
                    id="progress_non_enretard" 
                    class="progress-bar progress-bar-striped bg-warning"
                    role="progressbar" 
                    style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                    aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
                </div>
            `);

            }

        }else if($('#departes').val()){
            let incidentDepartementSelectionne = [];

            for (let k = 0; k < incidents.length; k++) {
                const monincident = incidents[k];
                let annee = dates[k].replaceAll("-", "");
                
                if(parseInt(annee) == parseInt(annee_selectionne)){

                    if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                        if(monincident.categories.departement_id){
                            if(monincident.categories.departement_id == $('#departes').val()){
                                incidentDepartementSelectionne.push(monincident);
                            }
                        }

                        if(!monincident.site_id){
                            incident_direction_generale.push(monincident);
                        }
                    }
                }
            }


            for (let fe = 0; fe < departements.length; fe++) {
                const departement = departements[fe];
                
                let incident_dep_courant = [];

                for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                    const iic = incident_direction_generale[vt];
                    
                    if(iic.categories.departement_id){
                        if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                            incident_dep_courant.push(iic);
                        }
                    }
                }


                $(`#depi${fe}`).replaceWith(`
                    <div
                        id="depi${fe}"
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                        aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >
                        ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                    </div>
                `)
            }


            for (let o = 0; o < incidentDepartementSelectionne.length; o++) {
                const incid = incidentDepartementSelectionne[o];
                
                if(incid.status == "ENCOURS"){
                    ens +=1;
                    incidant_encours.push(incid);

                    let indes = -1;

                    if(incid.due_date){

                        for (let q = 0; q < ids.length; q++) {
                            const number = ids[q];
                            if(number == incid.number){
                                indes = q;
                            }
                        }
    
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                        if(dateEcheance < today){
                            enretard +=1;
                            incidant_enretard.push(incid);                   
                        }else{
                            a_temps +=1;
                        }  
                    }
                    
                }else if(incid.status == "CLÔTURÉ"){
                    cls +=1;
                    incidant_cloturer.push(incid);

                    if(incid.status == "CLÔTURÉ"){
                        if(incid.due_date && incid.closure_date){
                            if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                                nombre_cloture_enretard +=1;
                            }else{
                                nombre_cloture_a_temps +=1;
                            }
                        }
                    }

                }else{
                    ann +=1;
                    incidant_annuller.push(incid);
                }

            }

            $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
            $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
            $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));

            $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
            $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
            $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

            $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
            $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
            $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
            $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);
            $('#tot').replaceWith(`<span class="h2" id="tot">${incidentDepartementSelectionne.length < 10 ? 0 +""+ incidentDepartementSelectionne.length : incidentDepartementSelectionne.length}</span>`);
            
            $('#date_du').replaceWith(`<span id="date_du">Du ${$('#DateDebut').val()}</span>`);

            $('#progress_cloture').replaceWith(`
                <div
                    id="progress_cloture" 
                    class="progress-bar bg-success" 
                    role="progressbar" 
                    style="width: ${incidentDepartementSelectionne.length > 0 ? (cls/incidentDepartementSelectionne.length) * 100 > 0 ? (cls/incidentDepartementSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (cls/incidentDepartementSelectionne.length) * 100 > 0 ? (cls/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentDepartementSelectionne.length > 0 ? (cls/incidentDepartementSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_encours').replaceWith(`
                <div 
                    id="progress_encours" 
                    class="progress-bar bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentDepartementSelectionne.length > 0 ? (ens/incidentDepartementSelectionne.length) * 100 > 0 ? (ens/incidentDepartementSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (ens/incidentDepartementSelectionne.length) * 100 > 0 ? (ens/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentDepartementSelectionne.length > 0 ? (ens/incidentDepartementSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_annule').replaceWith(`
                <div  
                    id="progress_annule" 
                    class="progress-bar bg-light" 
                    role="progressbar" 
                    style="width: ${incidentDepartementSelectionne.length > 0 ? (ann/incidentDepartementSelectionne.length) * 100 > 0 ? (ann/incidentDepartementSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (ann/incidentDepartementSelectionne.length) * 100 > 0 ? (ann/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" aria-valuemax="100"
                    > ${incidentDepartementSelectionne.length > 0 ? (ann/incidentDepartementSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentDepartementSelectionne.length) * 100) : 0 : 0}% 
                </div>
            `);

            $('#progress_enretard').replaceWith(`
                <div 
                    id="progress_enretard"
                    class="progress-bar bg-warning" 
                    role="progressbar" 
                    style="width: ${incidentDepartementSelectionne.length > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                    aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
                </div>
            `);

            $('#progress_non_encours').replaceWith(`
            <div 
                id="progress_non_encours" 
                class="progress-bar progress-bar-striped bg-primary" 
                role="progressbar" 
                style="width: ${incidentDepartementSelectionne.length > 0 ? (((cls+ann)/incidentDepartementSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentDepartementSelectionne.length) * 100 : 3 : 3}%" 
                aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (((cls+ann)/incidentDepartementSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                ${incidentDepartementSelectionne.length > 0 ? (((cls+ann)/incidentDepartementSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
            </div>
            `);

            $("#progress_non_cloture").replaceWith(`
                <div 
                    id="progress_non_cloture"
                    class="progress-bar progress-bar-striped bg-success"
                    role="progressbar"
                    style="width: ${incidentDepartementSelectionne.length > 0 ? 
                        (((ens + ann)/incidentDepartementSelectionne.length) * 100) > 0 ? 
                        (((ens + ann)/incidentDepartementSelectionne.length) * 100) : 3 : 3}%"
                    aria-valuenow="${incidentDepartementSelectionne.length > 0 ? ((ens + ann)/incidentDepartementSelectionne.length) * 100 > 0 ? (((ens + ann)/incidentDepartementSelectionne.length) * 100) : 3 : 3}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    ${incidentDepartementSelectionne.length > 0 ? ((ens + ann)/incidentDepartementSelectionne.length) * 100 > 0 ? Math.floor(((ens + ann)/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_annuler').replaceWith(`
                <div 
                    id="progress_non_annuler" 
                    class="progress-bar progress-bar-striped bg-light" 
                    role="progressbar" 
                    style="width: ${incidentDepartementSelectionne.length > 0 ? (((cls+ens)/incidentDepartementSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentDepartementSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentDepartementSelectionne.length > 0 ? (((cls+ens)/incidentDepartementSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentDepartementSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentDepartementSelectionne.length > 0 ? (((cls+ens)/incidentDepartementSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentDepartementSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_enretard').replaceWith(`
                <div 
                    id="progress_non_enretard" 
                    class="progress-bar progress-bar-striped bg-warning"
                    role="progressbar" 
                    style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                    aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
                </div>
            `);

        }else if($('#regionnn').val()){
            let incidentRegionSelectionne = [];

            for (let k = 0; k < incidents.length; k++) {
                const monincident = incidents[k];
                let annee = dates[k].replaceAll("-", "");
                
                if(parseInt(annee) == parseInt(annee_selectionne)){

                    if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                        if(monincident.site_id){
                            if(monincident.sites.region == $('#regionnn').val()){
                                incidentRegionSelectionne.push(monincident);
                            }
                        }else{

                            incident_direction_generale.push(monincident);

                            if($('#regionnn').val() == "LITTORAL"){
                                if(!monincident.site_id){
                                    incidentRegionSelectionne.push(monincident);
                                }
                            }
                        }
                    }
                }
            }


            for (let fe = 0; fe < departements.length; fe++) {
                const departement = departements[fe];
                
                let incident_dep_courant = [];

                for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                    const iic = incident_direction_generale[vt];
                    
                    if(iic.categories.departement_id){
                        if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                            incident_dep_courant.push(iic);
                        }
                    }
                }


                $(`#depi${fe}`).replaceWith(`
                    <div
                        id="depi${fe}"
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                        aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >
                        ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                    </div>
                `)
            }


            for (let o = 0; o < incidentRegionSelectionne.length; o++) {
                const incid = incidentRegionSelectionne[o];
                
                if(incid.status == "ENCOURS"){
                    ens +=1;
                    incidant_encours.push(incid);

                    let indes = -1;

                    if(incid.due_date){

                        for (let q = 0; q < ids.length; q++) {
                            const number = ids[q];
                            if(number == incid.number){
                                indes = q;
                            }
                        }
    
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                        if(dateEcheance < today){
                            enretard +=1;
                            incidant_enretard.push(incid);                   
                        }else{
                            a_temps +=1;
                        }  
                    }
                    
                }else if(incid.status == "CLÔTURÉ"){
                    cls +=1;
                    incidant_cloturer.push(incid);

                    if(incid.status == "CLÔTURÉ"){
                        if(incid.due_date && incid.closure_date){
                            if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                                nombre_cloture_enretard +=1;
                            }else{
                                nombre_cloture_a_temps +=1;
                            }
                        }
                    }

                }else{
                    ann +=1;
                    incidant_annuller.push(incid);
                }

            }

            $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
            //$('#floder_retard').attr('data-retards', JSON.stringify(incidant_enretard));
            $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
            $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));

            $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
            $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
            $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

            $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
            $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
            $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
            $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);
            $('#tot').replaceWith(`<span class="h2" id="tot">${incidentRegionSelectionne.length < 10 ? 0 +""+ incidentRegionSelectionne.length : incidentRegionSelectionne.length}</span>`);
            
            $('#date_du').replaceWith(`<span id="date_du">Du ${$('#DateDebut').val()}</span>`);

            $('#progress_cloture').replaceWith(`
                <div
                    id="progress_cloture" 
                    class="progress-bar bg-success" 
                    role="progressbar" 
                    style="width: ${incidentRegionSelectionne.length > 0 ? (cls/incidentRegionSelectionne.length) * 100 > 0 ? (cls/incidentRegionSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentRegionSelectionne.length > 0 ? (cls/incidentRegionSelectionne.length) * 100 > 0 ? (cls/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentRegionSelectionne.length > 0 ? (cls/incidentRegionSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentRegionSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_encours').replaceWith(`
                <div 
                    id="progress_encours" 
                    class="progress-bar bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentRegionSelectionne.length > 0 ? (ens/incidentRegionSelectionne.length) * 100 > 0 ? (ens/incidentRegionSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentRegionSelectionne.length > 0 ? (ens/incidentRegionSelectionne.length) * 100 > 0 ? (ens/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentRegionSelectionne.length > 0 ? (ens/incidentRegionSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentRegionSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_annule').replaceWith(`
                <div  
                    id="progress_annule" 
                    class="progress-bar bg-light" 
                    role="progressbar" 
                    style="width: ${incidentRegionSelectionne.length > 0 ? (ann/incidentRegionSelectionne.length) * 100 > 0 ? (ann/incidentRegionSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentRegionSelectionne.length > 0 ? (ann/incidentRegionSelectionne.length) * 100 > 0 ? (ann/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" aria-valuemax="100"
                    > ${incidentRegionSelectionne.length > 0 ? (ann/incidentRegionSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentRegionSelectionne.length) * 100) : 0 : 0}% 
                </div>
            `);

            $('#progress_enretard').replaceWith(`
                <div 
                    id="progress_enretard"
                    class="progress-bar bg-warning" 
                    role="progressbar" 
                    style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                    aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
                </div>
            `);

            $('#progress_non_encours').replaceWith(`
                <div 
                    id="progress_non_encours" 
                    class="progress-bar progress-bar-striped bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentRegionSelectionne.length > 0 ? (((cls+ann)/incidentRegionSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentRegionSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentRegionSelectionne.length > 0 ? (((cls+ann)/incidentRegionSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentRegionSelectionne.length > 0 ? (((cls+ann)/incidentRegionSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentRegionSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $("#progress_non_cloture").replaceWith(`
                <div 
                    id="progress_non_cloture"
                    class="progress-bar progress-bar-striped bg-success"
                    role="progressbar"
                    style="width: ${incidentRegionSelectionne.length > 0 ? 
                        (((ens + ann)/incidentRegionSelectionne.length) * 100) > 0 ? 
                        (((ens + ann)/incidentRegionSelectionne.length) * 100) : 3 : 3}%"
                    aria-valuenow="${incidentRegionSelectionne.length > 0 ? (((ens + ann)/incidentRegionSelectionne.length) * 100) > 0 ? (((ens + ann)/incidentRegionSelectionne.length) * 100) : 3 : 3}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    ${incidentRegionSelectionne.length > 0 ? (((ens + ann)/incidentRegionSelectionne.length) * 100) > 0 ? Math.floor(((ens + ann)/incidentRegionSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_annuler').replaceWith(`
                <div 
                    id="progress_non_annuler" 
                    class="progress-bar progress-bar-striped bg-light" 
                    role="progressbar" 
                    style="width: ${incidentRegionSelectionne.length > 0 ? (((cls+ens)/incidentRegionSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentRegionSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentRegionSelectionne.length > 0 ? (((cls+ens)/incidentRegionSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentRegionSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentRegionSelectionne.length > 0 ? (((cls+ens)/incidentRegionSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentRegionSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_enretard').replaceWith(`
                <div
                    id="progress_non_enretard"
                    class="progress-bar progress-bar-striped bg-warning"
                    role="progressbar"
                    style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%"
                    aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
                </div>
            `);

        }else{

            let incidentDateSelectionne = [];

            for (let k = 0; k < incidents.length; k++) {
                const monincident = incidents[k];
                let annee = dates[k].replaceAll("-", "");
                
                if(parseInt(annee) == parseInt(annee_selectionne)){

                    if((monincident.observation_rex) && (!monincident.deja_pris_en_compte)){
                        incidentDateSelectionne.push(monincident);

                        if(!monincident.site_id){
                            incident_direction_generale.push(monincident);
                        }
                    }
                }
            }


            for (let fe = 0; fe < departements.length; fe++) {
                const departement = departements[fe];
                
                let incident_dep_courant = [];

                for (let vt = 0; vt < incident_direction_generale.length; vt++) {
                    const iic = incident_direction_generale[vt];
                    
                    if(iic.categories.departement_id){
                        if(parseInt(iic.categories.departements.id) == parseInt(departement.id)){
                            incident_dep_courant.push(iic);
                        }
                    }
                }


                $(`#depi${fe}`).replaceWith(`
                    <div
                        id="depi${fe}"
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                        aria-valuenow="${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 : 2 : 2 }%" 
                        aria-valuemin="0" 
                        aria-valuemax="100"
                        >
                        ${ incident_direction_generale.length > 0 ? (incident_dep_courant.length/incident_direction_generale.length) * 100 > 0 ? parseInt((incident_dep_courant.length/incident_direction_generale.length) * 100) : 0 : 0 }%
                    </div>
                `)
            }


            for (let o = 0; o < incidentDateSelectionne.length; o++) {
                const incid = incidentDateSelectionne[o];
                
                if(incid.status == "ENCOURS"){
                    ens +=1;
                    incidant_encours.push(incid);

                    let indes = -1;

                    if(incid.due_date){

                        for (let q = 0; q < ids.length; q++) {
                            const number = ids[q];
                            if(number == incid.number){
                                indes = q;
                            }
                        }
    
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                        if(dateEcheance < today){
                            enretard +=1;
                            incidant_enretard.push(incid);                   
                        }else{
                            a_temps +=1;
                        }
                    }
                    
                }else if(incid.status == "CLÔTURÉ"){
                    cls +=1;
                    incidant_cloturer.push(incid);

                    if(incid.status == "CLÔTURÉ"){
                        if(incid.due_date && incid.closure_date){
                            if(parseInt(incid.closure_date.replaceAll("-", "")) > parseInt(incid.due_date.replaceAll("-", ""))){
                                nombre_cloture_enretard +=1;
                            }else{
                                nombre_cloture_a_temps +=1;
                            }
                        }
                    }

                }else{
                    ann +=1;
                    incidant_annuller.push(incid);
                }

            }

            $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
            $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
            $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));

            $('#clot_a_temp').replaceWith(`<span id="clot_a_temp" class="text-lg">${nombre_cloture_a_temps < 10 ? 0 +""+ nombre_cloture_a_temps : nombre_cloture_a_temps}</span>`);
            $('#clot_hors_delai').replaceWith(`<span id="clot_hors_delai" class="text-lg">${nombre_cloture_enretard < 10 ? 0 +""+ nombre_cloture_enretard : nombre_cloture_enretard}</span>`);
            $('#encour_a_temps').replaceWith(`<span id="encour_a_temps" class="text-lg">${a_temps < 10 ? 0 +""+ a_temps : a_temps}</span>`);

            $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
            $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
            $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
            $('#en_retar').replaceWith(`<span class="text-lg" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);
            $('#tot').replaceWith(`<span class="h2" id="tot">${incidentDateSelectionne.length < 10 ? 0 +""+ incidentDateSelectionne.length : incidentDateSelectionne.length}</span>`);
            
            $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement">Nombre D'Incidents</span>`);
            $('#date_du').replaceWith(`<span id="date_du">Du ${$('#DateDebut').val()}</span>`);


            $('#progress_cloture').replaceWith(`
                <div
                    id="progress_cloture" 
                    class="progress-bar bg-success" 
                    role="progressbar" 
                    style="width: ${incidentDateSelectionne.length > 0 ? (cls/incidentDateSelectionne.length) * 100 > 0 ? (cls/incidentDateSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentDateSelectionne.length > 0 ? (cls/incidentDateSelectionne.length) * 100 > 0 ? (cls/incidentDateSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentDateSelectionne.length > 0 ? (cls/incidentDateSelectionne.length) * 100 > 0 ? Math.floor((cls/incidentDateSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_encours').replaceWith(`
                <div 
                    id="progress_encours" 
                    class="progress-bar bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentDateSelectionne.length > 0 ? (ens/incidentDateSelectionne.length) * 100 > 0 ? (ens/incidentDateSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentDateSelectionne.length > 0 ? (ens/incidentDateSelectionne.length) * 100 > 0 ? (ens/incidentDateSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >${incidentDateSelectionne.length > 0 ? (ens/incidentDateSelectionne.length) * 100 > 0 ? Math.floor((ens/incidentDateSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_annule').replaceWith(`
                <div  
                    id="progress_annule" 
                    class="progress-bar bg-light" 
                    role="progressbar" 
                    style="width: ${incidentDateSelectionne.length > 0 ? (ann/incidentDateSelectionne.length) * 100 > 0 ? (ann/incidentDateSelectionne.length) * 100 : 3 : 3}%;" 
                    aria-valuenow="${incidentDateSelectionne.length > 0 ? (ann/incidentDateSelectionne.length) * 100 > 0 ? (ann/incidentDateSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" aria-valuemax="100"
                    > ${incidentDateSelectionne.length > 0 ? (ann/incidentDateSelectionne.length) * 100 > 0 ? Math.floor((ann/incidentDateSelectionne.length) * 100) : 0 : 0}% 
                </div>
            `);

            $('#progress_enretard').replaceWith(`
                <div 
                    id="progress_enretard"
                    class="progress-bar bg-warning" 
                    role="progressbar" 
                    style="width: ${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }%;"
                    aria-valuenow="${ens > 0 ? (enretard/ens) * 100 > 0 ? (enretard/ens) * 100 : 3 : 3 }"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    >${ens > 0 ? (enretard/ens) * 100 > 0 ? Math.floor((enretard/ens) * 100) : 0 : 0 }%
                </div>
            `);

            $('#progress_non_encours').replaceWith(`
                <div 
                    id="progress_non_encours" 
                    class="progress-bar progress-bar-striped bg-primary" 
                    role="progressbar" 
                    style="width: ${incidentDateSelectionne.length > 0 ? (((cls+ann)/incidentDateSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentDateSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentDateSelectionne.length > 0 ? (((cls+ann)/incidentDateSelectionne.length) * 100) > 0 ? ((cls+ann)/incidentDateSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentDateSelectionne.length > 0 ? (((cls+ann)/incidentDateSelectionne.length) * 100) > 0 ? Math.floor(((cls+ann)/incidentDateSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $("#progress_non_cloture").replaceWith(`
                <div 
                    id="progress_non_cloture"
                    class="progress-bar progress-bar-striped bg-success"
                    role="progressbar"
                    style="width: ${incidentDateSelectionne.length > 0 ? 
                        (((ens + ann)/incidentDateSelectionne.length) * 100) > 0 ? 
                        (((ens + ann)/incidentDateSelectionne.length) * 100) : 3 : 3}%"
                    aria-valuenow="${incidentDateSelectionne.length > 0 ? (((ens + ann)/incidentDateSelectionne.length) * 100) > 0 ? (((ens + ann)/incidentDateSelectionne.length) * 100) : 3 : 3}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    ${incidentDateSelectionne.length > 0 ? (((ens + ann)/incidentDateSelectionne.length) * 100) > 0 ? Math.floor(((ens + ann)/incidentDateSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_annuler').replaceWith(`
                <div 
                    id="progress_non_annuler" 
                    class="progress-bar progress-bar-striped bg-light" 
                    role="progressbar" 
                    style="width: ${incidentDateSelectionne.length > 0 ? (((cls+ens)/incidentDateSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentDateSelectionne.length) * 100 : 3 : 3}%" 
                    aria-valuenow="${incidentDateSelectionne.length > 0 ? (((cls+ens)/incidentDateSelectionne.length) * 100) > 0 ? ((cls+ens)/incidentDateSelectionne.length) * 100 : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${incidentDateSelectionne.length > 0 ? (((cls+ens)/incidentDateSelectionne.length) * 100) > 0 ? Math.floor(((cls+ens)/incidentDateSelectionne.length) * 100) : 0 : 0}%
                </div>
            `);

            $('#progress_non_enretard').replaceWith(`
                <div 
                    id="progress_non_enretard" 
                    class="progress-bar progress-bar-striped bg-warning"
                    role="progressbar" 
                    style="width: ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}%" 
                    aria-valuenow="${ens > 0 ? ((a_temps/ens) * 100) > 0 ? ((a_temps/ens) * 100) : 3 : 3}" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    ${ens > 0 ? ((a_temps/ens) * 100) > 0 ? Math.floor((a_temps/ens) * 100) : 0 : 0}%
                </div>
            `);

        }
    }
});



$(document).on('change', '#grik_date', function(){
    
    let userConnecter = JSON.parse($(this).attr('data-user_connecte'));
    let dates = JSON.parse($(this).attr('data-created'));
    let incidents = JSON.parse($(this).attr('data-incidents'));
    let tasks = JSON.parse($(this).attr('data-tasks'));
    let users_incidents = JSON.parse($(this).attr('data-users_incidents'));

    let tab = [];
    let encours = 0;
    let cloturer = 0;
    let annuler = 0;
    let encour_tache = 0;
    let realise_tache = 0;
    let enAttenta_tache = 0;
    let annule_tache = 0;
    let incident_emis = 0;
    let incident_recus = 0;
    let nbr_taches_total = 0;
    let nbr_taches_recues = 0;
    let nbr_taches_emises = 0;
    let width_emis_inci = 0;
    let width_recu_inci = 0;
    let width_encou_inci = 0;
    let width_clot_inci = 0;
    let width_annu_inci = 0;
    let width_tache_emise = 0;
    let width_tache_recues = 0;
    let width_tache_encour = 0;
    let width_tache_realise = 0;
    let width_tache_enAttente = 0;
    let width_tache_annul = 0;
    let taches_tous_incidents = [];

    if($(this).val()){

        // DEBUT BLOCK INCIDENT
        $('#krik_date').val('');
        $('#krik_date').prop('disabled', false);

        let annee_selectionne = $(this).val().replaceAll("-", "");

        for (let vt = 0; vt < incidents.length; vt++) {
            const iir = incidents[vt];
            
            let annee = dates[vt].replaceAll("-", "");

            if(parseInt(annee) == parseInt(annee_selectionne)){

                if((iir.observation_rex) && (!iir.deja_pris_en_compte)){
                    for (let a = 0; a < users_incidents.length; a++){
                        const ui = users_incidents[a];
                        if(ui.incident_number == iir.number){

                            if(parseInt(ui.user_id) == parseInt(userConnecter.id)){

                                tab.push(iir);

                                if(ui.isCoordo === "1"){
                                    incident_emis +=1;
                                }else{
                                    incident_recus +=1;
                                }
                            }
                        }
                    }
                }
                
            }
        }

        for (let vb = 0; vb < tab.length; vb++) {
            const incident = tab[vb];
            
            for (let ay = 0; ay < tasks.length; ay++) {
                const task = tasks[ay];

                if(task.incident_number == incident.number){

                    if(task.site_id){
                        if(userConnecter.site_id){
                            if(parseInt(task.site_id) == parseInt(userConnecter.site_id)){
                                nbr_taches_total +=1;
                                taches_tous_incidents.push(task);
                            }else{
                                for (let pw = 0; pw < users_incidents.length; pw++) {
                                    const uc = users_incidents[pw];
                                    
                                    if(userConnecter.id == uc.user_id){
                                        if(uc.incident_number == incident.number){
                                            if(uc.isCoordo === "1"){
                                                nbr_taches_total +=1;
                                                taches_tous_incidents.push(task);
                                            }
                                        }
                                    }
                                }
                            }
                        }else if(userConnecter.departement_id){
                            if(parseInt(task.departement_id) == parseInt(userConnecter.departement_id)){
                                nbr_taches_total +=1;
                                taches_tous_incidents.push(task);
                            }else{
                                for (let pw = 0; pw < users_incidents.length; pw++) {
                                    const uc = users_incidents[pw];
                                    
                                    if(userConnecter.id == uc.user_id){
                                        if(uc.incident_number == incident.number){
                                            if(uc.isCoordo === "1"){
                                                nbr_taches_total +=1;
                                                taches_tous_incidents.push(task);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }else if(task.departement_id){
                        if(userConnecter.departement_id){

                            if(parseInt(task.departement_id) == parseInt(userConnecter.departement_id)){
                                nbr_taches_total +=1;
                                taches_tous_incidents.push(task);
                            }else{
                                for (let pw = 0; pw < users_incidents.length; pw++) {
                                    const uc = users_incidents[pw];
                                    
                                    if(userConnecter.id == uc.user_id){
                                        if(uc.incident_number == incident.number){
                                            if(uc.isCoordo === "1"){
                                                nbr_taches_total +=1;
                                                taches_tous_incidents.push(task);
                                            }
                                        }
                                    }
                                }
                            }
    
                        }else if(userConnecter.site_id){
                            for (let pw = 0; pw < users_incidents.length; pw++) {
                                const uc = users_incidents[pw];
                                
                                if(userConnecter.id == uc.user_id){
                                    if(uc.incident_number == incident.number){
                                        if(uc.isCoordo === "1"){
                                            nbr_taches_total +=1;
                                            taches_tous_incidents.push(task);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            if(incident.status == "ENCOURS"){
                encours +=1;
            }else if(incident.status == "CLÔTURÉ"){
                cloturer +=1;
            }else if(incident.status == "ANNULÉ"){
                annuler +=1;
            }
        }
       
        for (let gh = 0; gh < taches_tous_incidents.length; gh++) {

            const tache = taches_tous_incidents[gh];

            if (tache.site_id) {
                if(userConnecter.site_id){
                    if(parseInt(userConnecter.site_id) == parseInt(tache.site_id)){
                        nbr_taches_recues +=1;
                    }else{
                        nbr_taches_emises +=1;
                    }
                }else if(userConnecter.departement_id){

                    for (let jx = 0; jx < users_incidents.length; jx++) {
                        const ui = users_incidents[jx];

                        if(parseInt(ui.user_id) == parseInt(userConnecter.id)){
                            if(ui.incident_number == tache.incident_number){
                                if(ui.isCoordo === "1"){
                                        nbr_taches_emises +=1;
                                }else{
                                        nbr_taches_recues +=1;
                                }
                            }    
                        }
                    }
                }
            } else if(tache.departement_id) {
                if(userConnecter.departement_id){
                    if(parseInt(userConnecter.departement_id) == parseInt(tache.departement_id)){
                        nbr_taches_recues +=1;
                    }else{
                        nbr_taches_emises +=1;
                    }
                }else if(userConnecter.site_id){
                    for (let jx = 0; jx < users_incidents.length; jx++) {
                        const ui = users_incidents[jx];

                        if(parseInt(ui.user_id) == parseInt(userConnecter.id)){
                            if(ui.incident_number == tache.incident_number){
                                if(ui.isCoordo === "1"){
                                    nbr_taches_emises +=1;
                                }else{
                                    nbr_taches_recues +=1;
                                }
                            }
                        }
                    }
                }
            }

            if(tache.status == "ENCOURS"){
                encour_tache +=1;
            }else if(tache.status == "RÉALISÉE"){
                realise_tache +=1;
            }else if(tache.status == "EN-ATTENTE"){
                enAttenta_tache +=1;
            }else if(tache.status == "ANNULÉE"){
                annule_tache +=1;
            }
        }

        $('.encours_Inci').replaceWith(`<span class="text-primary encours_Inci">${encours < 10 ? 0 +""+ encours : encours}</span>`);
        $('.cloture_Inci').replaceWith(`<span class="text-success cloture_Inci">${cloturer < 10 ? 0 +""+ cloturer : cloturer}</span>`)
        $('.annule_Inci').replaceWith(`<span class="text-gray-400 annule_Inci">${annuler < 10 ? 0 +""+ annuler : annuler}</span>`)

        $('.alters').replaceWith(`<span style="font-size:3em;" class="alters mb-0">${tab.length < 10 ? 0 +""+ tab.length : tab.length}</span>`)
        $('.encour_gros').replaceWith(`<span style="font-size:3em;" class="text-success mb-0 encour_gros">${encours < 10 ? 0 +""+ encours : encours}</span>`);
        $('.cloture_gros').replaceWith(`<span style="font-size:3em;" class="text-success mb-0 cloture_gros">${cloturer < 10 ? 0 +""+ cloturer : cloturer}</span>`);
        $('.annule_gros').replaceWith(`<span style="font-size:3em;" class="text-success mb-0 annule_gros">${annuler < 10 ? 0 +""+ annuler : annuler}</span>`);

        $('.emis_Inci').replaceWith(`<span class="emis_Inci">${incident_emis < 10 ? 0 +""+ incident_emis : incident_emis}</span>`);
        $('.recu_Inci').replaceWith(`<span class="text-info recu_Inci">${incident_recus < 10 ? 0 +""+ incident_recus : incident_recus}</span>`);
        $('.onesmore').replaceWith(`<span class="h2 onesmore">${tab.length < 10 ? 0 +""+ tab.length : tab.length}</span>`);
        $('.nomInci').replaceWith(`<span class="nomInci"> Nombre D'Incidents </span>`);
        $('.setDate').replaceWith(`<span class="setDate">DU <strong> ${$(this).val()} </strong> </span>`);

        $('.name_t').replaceWith(`<span class="name_t">Nombre De Tâche</span>`);
        $('.setDate_taskss').replaceWith(`<span class="setDate_taskss">DU <strong> ${$(this).val()} </strong> </span>`);
        $('.nombre_tache_totals').replaceWith(`<span class="h2 nombre_tache_totals">${nbr_taches_total < 10 ? 0 +""+ nbr_taches_total : nbr_taches_total}</span>`);
        $('.tach_enc_to').replaceWith(`<span class="text-primary tach_enc_to">${encour_tache < 10 ? 0 +""+ encour_tache : encour_tache}</span>`);
        $('.tach_real_to').replaceWith(`<span class="text-success tach_real_to">${realise_tache < 10 ? 0 +""+ realise_tache : realise_tache}</span>`);
        $('.tach_enA_to').replaceWith(`<span class="text-warning tach_enA_to">${enAttenta_tache < 10 ? 0 +""+ enAttenta_tache : enAttenta_tache}</span>`);
        $('.tach_an_to').replaceWith(`<span class="text-light tach_an_to">${annule_tache < 10 ? 0 +""+ annule_tache : annule_tache}</span>`);

        $('.nb_ta_emi').replaceWith(`<span class="nb_ta_emi">${nbr_taches_emises < 10 ? 0 +""+ nbr_taches_emises : nbr_taches_emises}</span>`);
        $('.nb_ta_rec').replaceWith(`<span class="text-info nb_ta_rec">${nbr_taches_recues < 10 ? 0 +""+ nbr_taches_recues : nbr_taches_recues}</span>`);

        if(tab.length > 0){
            width_emis_inci = parseInt((incident_emis/tab.length) * 100);
            width_recu_inci = parseInt((incident_recus/tab.length) * 100);
            width_encou_inci = parseInt((encours/tab.length) * 100);
            width_clot_inci = parseInt((cloturer/tab.length) * 100);
            width_annu_inci = parseInt((annuler/tab.length) * 100);
        }

        if(taches_tous_incidents.length > 0){
            width_tache_emise = parseInt((nbr_taches_emises/taches_tous_incidents.length)*100);
            width_tache_recues = parseInt((nbr_taches_recues/taches_tous_incidents.length)*100);

            width_tache_encour = parseInt((encour_tache/taches_tous_incidents.length)*100);
            width_tache_realise = parseInt((realise_tache/taches_tous_incidents.length)*100);
            width_tache_enAttente = parseInt((enAttenta_tache/taches_tous_incidents.length)*100);
            width_tache_annul = parseInt((annule_tache/taches_tous_incidents.length)*100);

        }

        $('.pg_emis_inci').replaceWith(`
            <div class="progress-bar bg-secondary pg_emis_inci" role="progressbar" style="width: ${width_emis_inci == 0 ? 3 : width_emis_inci}%;" aria-valuenow="${width_emis_inci == 0 ? 3 : width_emis_inci}" aria-valuemin="0" aria-valuemax="100">${width_emis_inci}%</div>
        `);
        
        $('.pg_recu_inci').replaceWith(`
            <div class="progress-bar bg-info pg_recu_inci" role="progressbar" style="width: ${width_recu_inci == 0 ? 3 : width_recu_inci}%;" aria-valuenow="${width_recu_inci == 0 ? 3 : width_recu_inci}" aria-valuemin="0" aria-valuemax="100">${width_recu_inci}%</div>
        `);

        $('.pg_encou_inci').replaceWith(`
            <div class="progress-bar bg-primary pg_encou_inci" role="progressbar" style="width: ${width_encou_inci == 0 ? 3 : width_encou_inci}%;" aria-valuenow="${width_encou_inci == 0 ? 3 : width_encou_inci}" aria-valuemin="0" aria-valuemax="100">${width_encou_inci}%</div>
        `);

        $('.pg_clot_inci').replaceWith(`
            <div class="progress-bar bg-success pg_clot_inci" role="progressbar" style="width: ${width_clot_inci == 0 ? 3 : width_clot_inci}%;" aria-valuenow="${width_clot_inci == 0 ? 3 : width_clot_inci}" aria-valuemin="0" aria-valuemax="100">${width_clot_inci}%</div>
        `);

        $('.pg_anne_inci').replaceWith(`
            <div class="progress-bar bg-light pg_anne_inci" role="progressbar" style="width: ${width_annu_inci == 0 ? 3 : width_annu_inci}%;" aria-valuenow="${width_annu_inci == 0 ? 3 : width_annu_inci}" aria-valuemin="0" aria-valuemax="100">${width_annu_inci}%</div>
        `);
        // FIN BLOCK INCIDENT

        
        $('.pg_tache_emis').replaceWith(`
            <div class="progress-bar bg-secondary pg_tache_emis" role="progressbar" style="width: ${width_tache_emise == 0 ? 3 : width_tache_emise}%;" aria-valuenow="${width_tache_emise == 0 ? 3 : width_tache_emise}" aria-valuemin="0" aria-valuemax="100">${width_tache_emise}%</div>
        `);

        $('.pg_tache_recues').replaceWith(`
            <div class="progress-bar bg-info pg_tache_recues" role="progressbar" style="width: ${width_tache_recues == 0 ? 3 : width_tache_recues}%;" aria-valuenow="${width_tache_recues == 0 ? 3 : width_tache_recues}" aria-valuemin="0" aria-valuemax="100">${width_tache_recues}%</div>
        `);

        $('.pg_tache_encous').replaceWith(`
            <div class="progress-bar bg-primary pg_tache_encous" role="progressbar" style="width: ${width_tache_encour == 0 ? 3 : width_tache_encour}%;" aria-valuenow="${width_tache_encour == 0 ? 3 : width_tache_encour}" aria-valuemin="0" aria-valuemax="100">${width_tache_encour}%</div>
        `);

        $('.pg_tache_realis').replaceWith(`
            <div class="progress-bar bg-success pg_tache_realis" role="progressbar" style="width: ${width_tache_realise == 0 ? 3 : width_tache_realise}%;" aria-valuenow="${width_tache_realise == 0 ? 3 : width_tache_realise}" aria-valuemin="0" aria-valuemax="100">${width_tache_realise}%</div>
        `);

        $('.pg_tache_enatten').replaceWith(`
            <div class="progress-bar bg-warning pg_tache_enatten" role="progressbar" style="width: ${width_tache_enAttente == 0 ? 3 : width_tache_enAttente}%;" aria-valuenow="${width_tache_enAttente == 0 ? 3 : width_tache_enAttente}" aria-valuemin="0" aria-valuemax="100">${width_tache_enAttente}%</div>
        `);

        $('.pg_tache_annils').replaceWith(`
            <div class="progress-bar bg-light pg_tache_annils" role="progressbar" style="width: ${width_tache_annul == 0 ? 3 : width_tache_annul}%;" aria-valuenow="${width_tache_annul == 0 ? 3 : width_tache_annul}" aria-valuemin="0" aria-valuemax="100">${width_tache_annul}%</div>
        `);

    }else{

        $('#krik_date').val('');
        $('#krik_date').prop('disabled', true);

        let problemes = JSON.parse($(this).attr('data-incident_annee_encours'));

        for (let xd = 0; xd < problemes.length; xd++) {
            const incident = problemes[xd];

            for (let a = 0; a < users_incidents.length; a++){
                const ui = users_incidents[a];
                if(ui.incident_number == incident.number){
                    if(parseInt(ui.user_id) == parseInt(userConnecter.id)){

                        tab.push(incident);

                        if(ui.isCoordo === "1"){
                            incident_emis +=1;
                        }else{
                            incident_recus +=1;
                        }
                    }
                }
            }
        }


        for (let vb = 0; vb < tab.length; vb++) {
            const incident = tab[vb];
            
            if(incident.status == "ENCOURS"){
                encours +=1;
            }else if(incident.status == "CLÔTURÉ"){
                cloturer +=1;
            }else if(incident.status == "ANNULÉ"){
                annuler +=1;
            }


            for (let ay = 0; ay < tasks.length; ay++) {
                const task = tasks[ay];

                if(task.incident_number == incident.number){

                    if(task.site_id){
                        if(userConnecter.site_id){
                            if(parseInt(task.site_id) == parseInt(userConnecter.site_id)){
                                nbr_taches_total +=1;
                                taches_tous_incidents.push(task);
                            }else{
                                for (let pw = 0; pw < users_incidents.length; pw++) {
                                    const uc = users_incidents[pw];
                                    
                                    if(parseInt(userConnecter.id) == parseInt(uc.user_id)){
                                        if(uc.incident_number == incident.number){
                                            if(uc.isCoordo === "1"){
                                                nbr_taches_total +=1;
                                                taches_tous_incidents.push(task);
                                            }
                                        }
                                    }
                                }
                            }
                        }else if(userConnecter.departement_id){
                            if(parseInt(task.departement_id) == parseInt(userConnecter.departement_id)){
                                nbr_taches_total +=1;
                                taches_tous_incidents.push(task);
                            }else{
                                for (let pw = 0; pw < users_incidents.length; pw++) {
                                    const uc = users_incidents[pw];
                                    
                                    if(parseInt(userConnecter.id) == parseInt(uc.user_id)){
                                        if(uc.incident_number == incident.number){
                                            if(uc.isCoordo === "1"){
                                                nbr_taches_total +=1;
                                                taches_tous_incidents.push(task);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }else if(task.departement_id){
                        if(userConnecter.departement_id){

                            if(parseInt(task.departement_id) == parseInt(userConnecter.departement_id)){
                                nbr_taches_total +=1;
                                taches_tous_incidents.push(task);
                            }else{
                                for (let pw = 0; pw < users_incidents.length; pw++) {
                                    const uc = users_incidents[pw];
                                    
                                    if(parseInt(userConnecter.id) == parseInt(uc.user_id)){
                                        if(uc.incident_number == incident.number){
                                            if(uc.isCoordo === "1"){
                                                nbr_taches_total +=1;
                                                taches_tous_incidents.push(task);
                                            }
                                        }
                                    }
                                }
                            }
    
                        }else if(userConnecter.site_id){
                            for (let pw = 0; pw < users_incidents.length; pw++) {
                                const uc = users_incidents[pw];
                                
                                if(parseInt(userConnecter.id) == parseInt(uc.user_id)){
                                    if(uc.incident_number == incident.number){
                                        if(uc.isCoordo === "1"){
                                            nbr_taches_total +=1;
                                            taches_tous_incidents.push(task);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

        }

        for (let gh = 0; gh < taches_tous_incidents.length; gh++) {

            const tache = taches_tous_incidents[gh];

            if (tache.site_id) {
                if(userConnecter.site_id){
                    if(userConnecter.site_id == tache.site_id){
                        nbr_taches_recues +=1;
                    }else{
                        nbr_taches_emises +=1;
                    }
                }else if(userConnecter.departement_id){

                    for (let jx = 0; jx < users_incidents.length; jx++) {
                        const ui = users_incidents[jx];
                        if(ui.incident_number == tache.incident_number){
                            if(ui.user_id == userConnecter.id){
                                if(ui.isCoordo === "1"){
                                    nbr_taches_emises +=1;
                                }else{
                                    nbr_taches_recues +=1;
                                }
                            }
                        }
                    }
                }
            } else if(tache.departement_id) {
                if(userConnecter.departement_id){
                    if(userConnecter.departement_id == tache.departement_id){
                        nbr_taches_recues +=1;
                    }else{
                        nbr_taches_emises +=1;
                    }
                }else if(userConnecter.site_id){
                    for (let jx = 0; jx < users_incidents.length; jx++) {
                        const ui = users_incidents[jx];
                        if(ui.incident_number == tache.incident_number){
                            if(ui.user_id == userConnecter.id){
                                if(ui.isCoordo === "1"){
                                    nbr_taches_emises +=1;
                                }else{
                                    nbr_taches_recues +=1;
                                }
                            }
                        }
                    }
                }
            }

            if(tache.status == "ENCOURS"){
                encour_tache +=1;
            }else if(tache.status == "RÉALISÉE"){
                realise_tache +=1;
            }else if(tache.status == "EN-ATTENTE"){
                enAttenta_tache +=1;
            }else if(tache.status == "ANNULÉE"){
                annule_tache +=1;
            }
        }


        $('.encours_Inci').replaceWith(`<span class="text-primary encours_Inci">${encours < 10 ? 0 +""+ encours : encours}</span>`);
        $('.cloture_Inci').replaceWith(`<span class="text-success cloture_Inci">${cloturer < 10 ? 0 +""+ cloturer : cloturer}</span>`)
        $('.annule_Inci').replaceWith(`<span class="text-gray-400 annule_Inci">${annuler < 10 ? 0 +""+ annuler : annuler}</span>`)

        $('.alters').replaceWith(`<span style="font-size:3em;" class="alters mb-0">${tab.length < 10 ? 0 +""+ tab.length : tab.length}</span>`)
        $('.encour_gros').replaceWith(`<span style="font-size:3em;" class="text-success mb-0 encour_gros">${encours < 10 ? 0 +""+ encours : encours}</span>`);
        $('.cloture_gros').replaceWith(`<span style="font-size:3em;" class="text-success mb-0 cloture_gros">${cloturer < 10 ? 0 +""+ cloturer : cloturer}</span>`);
        $('.annule_gros').replaceWith(`<span style="font-size:3em;" class="text-success mb-0 annule_gros">${annuler < 10 ? 0 +""+ annuler : annuler}</span>`);


        $('.emis_Inci').replaceWith(`<span class="text-white emis_Inci">${incident_emis < 10 ? 0 +""+ incident_emis : incident_emis}</span>`);
        $('.recu_Inci').replaceWith(`<span class="text-white recu_Inci">${incident_recus < 10 ? 0 +""+ incident_recus : incident_recus}</span>`);
        $('.onesmore').replaceWith(`<span class="h2 onesmore">${tab.length < 10 ? 0 +""+ tab.length : tab.length}</span>`);
        $('.nomInci').replaceWith(`<span class="nomInci"> Nombre D'Incidents Total </span>`);
        $('.setDate').replaceWith(`<span class="setDate"> </span>`);

        $('.name_t').replaceWith(`<span class="name_t">Nombre De Tâche Total</span>`);
        $('.setDate_taskss').replaceWith(`<span class="setDate_taskss"></span>`);
        $('.nombre_tache_totals').replaceWith(`<span class="h2 nombre_tache_totals">${nbr_taches_total < 10 ? 0 +""+ nbr_taches_total : nbr_taches_total}</span>`);
        $('.tach_enc_to').replaceWith(`<span class="text-primary tach_enc_to">${encour_tache < 10 ? 0 +""+ encour_tache : encour_tache}</span>`);
        $('.tach_real_to').replaceWith(`<span class="text-success tach_real_to">${realise_tache < 10 ? 0 +""+ realise_tache : realise_tache}</span>`);
        $('.tach_enA_to').replaceWith(`<span class="text-warning tach_enA_to">${enAttenta_tache < 10 ? 0 +""+ enAttenta_tache : enAttenta_tache}</span>`);
        $('.tach_an_to').replaceWith(`<span class="text-light tach_an_to">${annule_tache < 10 ? 0 +""+ annule_tache : annule_tache}</span>`);

        $('.nb_ta_emi').replaceWith(`<span class="text-white nb_ta_emi">${nbr_taches_emises < 10 ? 0 +""+ nbr_taches_emises : nbr_taches_emises}</span>`);
        $('.nb_ta_rec').replaceWith(`<span class="text-info nb_ta_rec">${nbr_taches_recues < 10 ? 0 +""+ nbr_taches_recues : nbr_taches_recues}</span>`);


        if(tab.length > 0){
            width_emis_inci = parseInt((incident_emis/tab.length) * 100);
            width_recu_inci = parseInt((incident_recus/tab.length) * 100);
            width_encou_inci = parseInt((encours/tab.length) * 100);
            width_clot_inci = parseInt((cloturer/tab.length) * 100);
            width_annu_inci = parseInt((annuler/tab.length) * 100);
        }

        if(taches_tous_incidents.length > 0){
            width_tache_emise = parseInt((nbr_taches_emises/taches_tous_incidents.length)*100);
            width_tache_recues = parseInt((nbr_taches_recues/taches_tous_incidents.length)*100);

            width_tache_encour = parseInt((encour_tache/taches_tous_incidents.length)*100);
            width_tache_realise = parseInt((realise_tache/taches_tous_incidents.length)*100);
            width_tache_enAttente = parseInt((enAttenta_tache/taches_tous_incidents.length)*100);
            width_tache_annul = parseInt((annule_tache/taches_tous_incidents.length)*100);
        }

        $('.pg_emis_inci').replaceWith(`
            <div class="progress-bar bg-secondary pg_emis_inci" role="progressbar" style="width: ${width_emis_inci == 0 ? 3 : width_emis_inci}%;" aria-valuenow="${width_emis_inci == 0 ? 3 : width_emis_inci}" aria-valuemin="0" aria-valuemax="100">${width_emis_inci}%</div>
        `);
        
        $('.pg_recu_inci').replaceWith(`
            <div class="progress-bar bg-info pg_recu_inci" role="progressbar" style="width: ${width_recu_inci == 0 ? 3 : width_recu_inci}%;" aria-valuenow="${width_recu_inci == 0 ? 3 : width_recu_inci}" aria-valuemin="0" aria-valuemax="100">${width_recu_inci}%</div>
        `);

        $('.pg_encou_inci').replaceWith(`
            <div class="progress-bar bg-primary pg_encou_inci" role="progressbar" style="width: ${width_encou_inci == 0 ? 3 : width_encou_inci}%;" aria-valuenow="${width_encou_inci == 0 ? 3 : width_encou_inci}" aria-valuemin="0" aria-valuemax="100">${width_encou_inci}%</div>
        `);

        $('.pg_clot_inci').replaceWith(`
            <div class="progress-bar bg-success pg_clot_inci" role="progressbar" style="width: ${width_clot_inci == 0 ? 3 : width_clot_inci}%;" aria-valuenow="${width_clot_inci == 0 ? 3 : width_clot_inci}" aria-valuemin="0" aria-valuemax="100">${width_clot_inci}%</div>
        `);

        $('.pg_anne_inci').replaceWith(`
            <div class="progress-bar bg-light pg_anne_inci" role="progressbar" style="width: ${width_annu_inci == 0 ? 3 : width_annu_inci}%;" aria-valuenow="${width_annu_inci == 0 ? 3 : width_annu_inci}" aria-valuemin="0" aria-valuemax="100">${width_annu_inci}%</div>
        `);

        // TACHES
        $('.pg_tache_emis').replaceWith(`
            <div class="progress-bar bg-secondary pg_tache_emis" role="progressbar" style="width: ${width_tache_emise == 0 ? 3 : width_tache_emise}%;" aria-valuenow="${width_tache_emise == 0 ? 3 : width_tache_emise}" aria-valuemin="0" aria-valuemax="100">${width_tache_emise}%</div>
        `);

        $('.pg_tache_recues').replaceWith(`
            <div class="progress-bar bg-info pg_tache_recues" role="progressbar" style="width: ${width_tache_recues == 0 ? 3 : width_tache_recues}%;" aria-valuenow="${width_tache_recues == 0 ? 3 : width_tache_recues}" aria-valuemin="0" aria-valuemax="100">${width_tache_recues}%</div>
        `);

        $('.pg_tache_encous').replaceWith(`
            <div class="progress-bar bg-primary pg_tache_encous" role="progressbar" style="width: ${width_tache_encour == 0 ? 3 : width_tache_encour}%;" aria-valuenow="${width_tache_encour == 0 ? 3 : width_tache_encour}" aria-valuemin="0" aria-valuemax="100">${width_tache_encour}%</div>
        `);

        $('.pg_tache_realis').replaceWith(`
            <div class="progress-bar bg-success pg_tache_realis" role="progressbar" style="width: ${width_tache_realise == 0 ? 3 : width_tache_realise}%;" aria-valuenow="${width_tache_realise == 0 ? 3 : width_tache_realise}" aria-valuemin="0" aria-valuemax="100">${width_tache_realise}%</div>
        `);

        $('.pg_tache_enatten').replaceWith(`
            <div class="progress-bar bg-warning pg_tache_enatten" role="progressbar" style="width: ${width_tache_enAttente == 0 ? 3 : width_tache_enAttente}%;" aria-valuenow="${width_tache_enAttente == 0 ? 3 : width_tache_enAttente}" aria-valuemin="0" aria-valuemax="100">${width_tache_enAttente}%</div>
        `);

        $('.pg_tache_annils').replaceWith(`
            <div class="progress-bar bg-light pg_tache_annils" role="progressbar" style="width: ${width_tache_annul == 0 ? 3 : width_tache_annul}%;" aria-valuenow="${width_tache_annul == 0 ? 3 : width_tache_annul}" aria-valuemin="0" aria-valuemax="100">${width_tache_annul}%</div>
        `);

    }
});


$(document).on('change', '#krik_date', function(){

    let userConnecter = JSON.parse($(this).attr('data-user_connecte'));
    let dates = JSON.parse($(this).attr('data-created'));
    let incidents = JSON.parse($(this).attr('data-incidents'));
    let tasks = JSON.parse($(this).attr('data-tasks'));
    let users_incidents = JSON.parse($(this).attr('data-users_incidents'));

    let encours = 0;
    let cloturer = 0;
    let annuler = 0;
    let encour_tache = 0;
    let realise_tache = 0;
    let enAttenta_tache = 0;
    let annule_tache = 0;
    let incident_emis = 0;
    let incident_recus = 0;
    let nbr_taches_total = 0;
    let nbr_taches_recues = 0;
    let nbr_taches_emises = 0;
    let width_emis_inci = 0;
    let width_recu_inci = 0;
    let width_encou_inci = 0;
    let width_clot_inci = 0;
    let width_annu_inci = 0;
    let width_tache_emise = 0;
    let width_tache_recues = 0;
    let width_tache_encour = 0;
    let width_tache_realise = 0;
    let width_tache_enAttente = 0;
    let width_tache_annul = 0;
    let taches_tous_incidents = [];
    let incident_periode_choisis = [];
    let incident_concernant_user_login = [];
    let ui_concernant_user_login = [];

    let date_debut = parseInt($('#grik_date').val().replaceAll("-", ""));
    let date_fin = parseInt($(this).val().replaceAll("-", ""));

    
        if($(this).val()){
        if((date_fin > date_debut) || (date_fin == date_debut)){
            for (let it = 0; it < incidents.length; it++) {
                const incident = incidents[it];
                
                let date_creation = parseInt(dates[it].replaceAll("-", ""));

                if(
                    ((date_creation == date_debut) && (date_creation < date_fin)) ||
                    ((date_creation > date_debut) && (date_creation < date_fin)) ||
                    ((date_creation > date_debut) && (date_creation == date_fin)) ||
                    ((date_creation == date_debut) && (date_creation == date_fin))
                ){
                    if((incident.observation_rex) && (!incident.deja_pris_en_compte)){
                        incident_periode_choisis.push(incident);
                    }
                }
            }

            
            for (let ua = 0; ua < incident_periode_choisis.length; ua++) {
                const incidant = incident_periode_choisis[ua];
                
                for (let ii = 0; ii < users_incidents.length; ii++) {
                    const ui = users_incidents[ii];
                    
                    if(ui.incident_number == incidant.number){
                        if(parseInt(ui.user_id) == parseInt(userConnecter.id)){
                            incident_concernant_user_login.push(incidant);
                            ui_concernant_user_login.push(ui);
                        }
                    }
                }

            }

            for (let be = 0; be < incident_concernant_user_login.length; be++) {
                const incidi = incident_concernant_user_login[be];
                let uis = ui_concernant_user_login[be];

                if(incidi.status == "ENCOURS"){
                    encours +=1;
                }else if(incidi.status == "CLÔTURÉ"){
                    cloturer +=1;
                }else if(incidi.status == "ANNULÉ"){
                    annuler +=1;
                }


                if(uis.isCoordo === "1"){
                    incident_emis +=1;
                }else{
                    incident_recus +=1;
                }


                for (let ay = 0; ay < tasks.length; ay++) {
                    const task = tasks[ay];

                    if(task.incident_number == incidi.number){

                        if(task.site_id){
                            if(userConnecter.site_id){
                                if(parseInt(task.site_id) == parseInt(userConnecter.site_id)){
                                    nbr_taches_total +=1;
                                    taches_tous_incidents.push(task);
                                }else{
                                    for (let pw = 0; pw < users_incidents.length; pw++) {
                                        const uc = users_incidents[pw];
                                        
                                        if(userConnecter.id == uc.user_id){
                                            if(uc.incident_number == incidi.number){
                                                if(uc.isCoordo === "1"){
                                                    nbr_taches_total +=1;
                                                    taches_tous_incidents.push(task);
                                                }
                                            }
                                        }
                                    }
                                }
                            }else if(userConnecter.departement_id){
                                if(parseInt(task.departement_id) == parseInt(userConnecter.departement_id)){
                                    nbr_taches_total +=1;
                                    taches_tous_incidents.push(task);
                                }else{
                                    for (let pw = 0; pw < users_incidents.length; pw++) {
                                        const uc = users_incidents[pw];
                                        
                                        if(userConnecter.id == uc.user_id){
                                            if(uc.incident_number == incidi.number){
                                                if(uc.isCoordo === "1"){
                                                    nbr_taches_total +=1;
                                                    taches_tous_incidents.push(task);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }else if(task.departement_id){
                            if(userConnecter.departement_id){

                                if(parseInt(task.departement_id) == parseInt(userConnecter.departement_id)){
                                    nbr_taches_total +=1;
                                    taches_tous_incidents.push(task);
                                }else{
                                    for (let pw = 0; pw < users_incidents.length; pw++) {
                                        const uc = users_incidents[pw];
                                        
                                        if(userConnecter.id == uc.user_id){
                                            if(uc.incident_number == incidi.number){
                                                if(uc.isCoordo === "1"){
                                                    nbr_taches_total +=1;
                                                    taches_tous_incidents.push(task);
                                                }
                                            }
                                        }
                                    }
                                }
        
                            }else if(userConnecter.site_id){
                                for (let pw = 0; pw < users_incidents.length; pw++) {
                                    const uc = users_incidents[pw];
                                    
                                    if(userConnecter.id == uc.user_id){
                                        if(uc.incident_number == incidi.number){
                                            if(uc.isCoordo === "1"){
                                                nbr_taches_total +=1;
                                                taches_tous_incidents.push(task);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

            }

            for (let gh = 0; gh < taches_tous_incidents.length; gh++) {

                const tache = taches_tous_incidents[gh];

                if (tache.site_id) {
                    if(userConnecter.site_id){
                        if(userConnecter.site_id == tache.site_id){
                            nbr_taches_recues +=1;
                        }else{
                            nbr_taches_emises +=1;
                        }
                    }else if(userConnecter.departement_id){

                        for (let jx = 0; jx < users_incidents.length; jx++) {
                            const ui = users_incidents[jx];
                            if(ui.incident_number == tache.incident_number){
                                if(ui.user_id == userConnecter.id){
                                    if(ui.isCoordo === "1"){
                                        nbr_taches_emises +=1;
                                    }else{
                                        nbr_taches_recues +=1;
                                    }
                                }
                            }
                        }
                    }
                } else if(tache.departement_id) {
                    if(userConnecter.departement_id){
                        if(userConnecter.departement_id == tache.departement_id){
                            nbr_taches_recues +=1;
                        }else{
                            nbr_taches_emises +=1;
                        }
                    }else if(userConnecter.site_id){
                        for (let jx = 0; jx < users_incidents.length; jx++) {
                            const ui = users_incidents[jx];
                            if(ui.incident_number == tache.incident_number){
                                if(ui.user_id == userConnecter.id){
                                    if(ui.isCoordo === "1"){
                                        nbr_taches_emises +=1;
                                    }else{
                                        nbr_taches_recues +=1;
                                    }
                                }
                            }
                        }
                    }
                }

                if(tache.status == "ENCOURS"){
                    encour_tache +=1;
                }else if(tache.status == "RÉALISÉE"){
                    realise_tache +=1;
                }else if(tache.status == "EN-ATTENTE"){
                    enAttenta_tache +=1;
                }else if(tache.status == "ANNULÉE"){
                    annule_tache +=1;
                }
            }

            $('.encours_Inci').replaceWith(`<span class="text-primary encours_Inci">${encours < 10 ? 0 +""+ encours : encours}</span>`);
            $('.cloture_Inci').replaceWith(`<span class="text-success cloture_Inci">${cloturer < 10 ? 0 +""+ cloturer : cloturer}</span>`)
            $('.annule_Inci').replaceWith(`<span class="text-gray-400 annule_Inci">${annuler < 10 ? 0 +""+ annuler : annuler}</span>`)


            $('.alters').replaceWith(`<span style="font-size:3em;" class="alters mb-0">${incident_concernant_user_login.length < 10 ? 0 +""+ incident_concernant_user_login.length : incident_concernant_user_login.length}</span>`)
            $('.encour_gros').replaceWith(`<span style="font-size:3em;" class="text-success mb-0 encour_gros">${encours < 10 ? 0 +""+ encours : encours}</span>`);
            $('.cloture_gros').replaceWith(`<span style="font-size:3em;" class="text-success mb-0 cloture_gros">${cloturer < 10 ? 0 +""+ cloturer : cloturer}</span>`);
            $('.annule_gros').replaceWith(`<span style="font-size:3em;" class="text-success mb-0 annule_gros">${annuler < 10 ? 0 +""+ annuler : annuler}</span>`);
    

            $('.emis_Inci').replaceWith(`<span class="text-white emis_Inci">${incident_emis < 10 ? 0 +""+ incident_emis : incident_emis}</span>`);
            $('.recu_Inci').replaceWith(`<span class="text-info recu_Inci">${incident_recus < 10 ? 0 +""+ incident_recus : incident_recus}</span>`);
            $('.onesmore').replaceWith(`<span class="h2 onesmore">${incident_concernant_user_login.length < 10 ? 0 +""+ incident_concernant_user_login.length : incident_concernant_user_login.length}</span>`);
            $('.nomInci').replaceWith(`<span class="nomInci"> Nombre D'Incidents </span>`);
            $('.setDate').replaceWith(`<span class="setDate">DU <strong> ${$('#grik_date').val()} </strong> </span>`);
            $('.getDate').replaceWith(`<span class="getDate">AU <strong> ${$(this).val()} </strong> </span>`);

            $('.name_t').replaceWith(`<span class="name_t">Nombre De Tâche</span>`);
            $('.setDate_taskss').replaceWith(`<span class="setDate_taskss">DU <strong> ${$('#grik_date').val()} </strong> </span>`);
            $('.getDate_taskss').replaceWith(`<span class="getDate_taskss">AU <strong> ${$(this).val()} </strong> </span>`);

            $('.nombre_tache_totals').replaceWith(`<span class="h2 nombre_tache_totals">${nbr_taches_total < 10 ? 0 +""+ nbr_taches_total : nbr_taches_total}</span>`);
            $('.tach_enc_to').replaceWith(`<span class="text-primary tach_enc_to">${encour_tache < 10 ? 0 +""+ encour_tache : encour_tache}</span>`);
            $('.tach_real_to').replaceWith(`<span class="text-success tach_real_to">${realise_tache < 10 ? 0 +""+ realise_tache : realise_tache}</span>`);
            $('.tach_enA_to').replaceWith(`<span class="text-warning tach_enA_to">${enAttenta_tache < 10 ? 0 +""+ enAttenta_tache : enAttenta_tache}</span>`);
            $('.tach_an_to').replaceWith(`<span class="text-light tach_an_to">${annule_tache < 10 ? 0 +""+ annule_tache : annule_tache}</span>`);

            $('.nb_ta_emi').replaceWith(`<span class="text-white nb_ta_emi">${nbr_taches_emises < 10 ? 0 +""+ nbr_taches_emises : nbr_taches_emises}</span>`);
            $('.nb_ta_rec').replaceWith(`<span class="text-info nb_ta_rec">${nbr_taches_recues < 10 ? 0 +""+ nbr_taches_recues : nbr_taches_recues}</span>`);

            if(incident_concernant_user_login.length > 0){
                width_emis_inci = parseInt((incident_emis/incident_concernant_user_login.length) * 100);
                width_recu_inci = parseInt((incident_recus/incident_concernant_user_login.length) * 100);
                width_encou_inci = parseInt((encours/incident_concernant_user_login.length) * 100);
                width_clot_inci = parseInt((cloturer/incident_concernant_user_login.length) * 100);
                width_annu_inci = parseInt((annuler/incident_concernant_user_login.length) * 100);
            }

            if(taches_tous_incidents.length > 0){
                width_tache_emise = parseInt((nbr_taches_emises/taches_tous_incidents.length)*100);
                width_tache_recues = parseInt((nbr_taches_recues/taches_tous_incidents.length)*100);

                width_tache_encour = parseInt((encour_tache/taches_tous_incidents.length)*100);
                width_tache_realise = parseInt((realise_tache/taches_tous_incidents.length)*100);
                width_tache_enAttente = parseInt((enAttenta_tache/taches_tous_incidents.length)*100);
                width_tache_annul = parseInt((annule_tache/taches_tous_incidents.length)*100);

            }

            $('.pg_emis_inci').replaceWith(`
                <div class="progress-bar bg-secondary pg_emis_inci" role="progressbar" style="width: ${width_emis_inci == 0 ? 3 : width_emis_inci}%;" aria-valuenow="${width_emis_inci == 0 ? 3 : width_emis_inci}" aria-valuemin="0" aria-valuemax="100">${width_emis_inci}%</div>
            `);
            
            $('.pg_recu_inci').replaceWith(`
                <div class="progress-bar bg-info pg_recu_inci" role="progressbar" style="width: ${width_recu_inci == 0 ? 3 : width_recu_inci}%;" aria-valuenow="${width_recu_inci == 0 ? 3 : width_recu_inci}" aria-valuemin="0" aria-valuemax="100">${width_recu_inci}%</div>
            `);

            $('.pg_encou_inci').replaceWith(`
                <div class="progress-bar bg-primary pg_encou_inci" role="progressbar" style="width: ${width_encou_inci == 0 ? 3 : width_encou_inci}%;" aria-valuenow="${width_encou_inci == 0 ? 3 : width_encou_inci}" aria-valuemin="0" aria-valuemax="100">${width_encou_inci}%</div>
            `);

            $('.pg_clot_inci').replaceWith(`
                <div class="progress-bar bg-success pg_clot_inci" role="progressbar" style="width: ${width_clot_inci == 0 ? 3 : width_clot_inci}%;" aria-valuenow="${width_clot_inci == 0 ? 3 : width_clot_inci}" aria-valuemin="0" aria-valuemax="100">${width_clot_inci}%</div>
            `);

            $('.pg_anne_inci').replaceWith(`
                <div class="progress-bar bg-light pg_anne_inci" role="progressbar" style="width: ${width_annu_inci == 0 ? 3 : width_annu_inci}%;" aria-valuenow="${width_annu_inci == 0 ? 3 : width_annu_inci}" aria-valuemin="0" aria-valuemax="100">${width_annu_inci}%</div>
            `);

            // FIN BLOCK INCIDENT

            
            $('.pg_tache_emis').replaceWith(`
                <div class="progress-bar bg-secondary pg_tache_emis" role="progressbar" style="width: ${width_tache_emise == 0 ? 3 : width_tache_emise}%;" aria-valuenow="${width_tache_emise == 0 ? 3 : width_tache_emise}" aria-valuemin="0" aria-valuemax="100">${width_tache_emise}%</div>
            `);

            $('.pg_tache_recues').replaceWith(`
                <div class="progress-bar bg-info pg_tache_recues" role="progressbar" style="width: ${width_tache_recues == 0 ? 3 : width_tache_recues}%;" aria-valuenow="${width_tache_recues == 0 ? 3 : width_tache_recues}" aria-valuemin="0" aria-valuemax="100">${width_tache_recues}%</div>
            `);

            $('.pg_tache_encous').replaceWith(`
                <div class="progress-bar bg-primary pg_tache_encous" role="progressbar" style="width: ${width_tache_encour == 0 ? 3 : width_tache_encour}%;" aria-valuenow="${width_tache_encour == 0 ? 3 : width_tache_encour}" aria-valuemin="0" aria-valuemax="100">${width_tache_encour}%</div>
            `);

            $('.pg_tache_realis').replaceWith(`
                <div class="progress-bar bg-success pg_tache_realis" role="progressbar" style="width: ${width_tache_realise == 0 ? 3 : width_tache_realise}%;" aria-valuenow="${width_tache_realise == 0 ? 3 : width_tache_realise}" aria-valuemin="0" aria-valuemax="100">${width_tache_realise}%</div>
            `);

            $('.pg_tache_enatten').replaceWith(`
                <div class="progress-bar bg-warning pg_tache_enatten" role="progressbar" style="width: ${width_tache_enAttente == 0 ? 3 : width_tache_enAttente}%;" aria-valuenow="${width_tache_enAttente == 0 ? 3 : width_tache_enAttente}" aria-valuemin="0" aria-valuemax="100">${width_tache_enAttente}%</div>
            `);

            $('.pg_tache_annils').replaceWith(`
                <div class="progress-bar bg-light pg_tache_annils" role="progressbar" style="width: ${width_tache_annul == 0 ? 3 : width_tache_annul}%;" aria-valuenow="${width_tache_annul == 0 ? 3 : width_tache_annul}" aria-valuemin="0" aria-valuemax="100">${width_tache_annul}%</div>
            `);
        }else{
            $(this).val('');
            $('#validation_due_date').val("Veuillez Renseignez Une Date Supérieur A La Date De Début !");
            $('#duedi').modal('show');
        }
        }else{

            let annee_selectionne = $('#grik_date').val().replaceAll("-", "");

            for (let vt = 0; vt < incidents.length; vt++) {
                const iir = incidents[vt];
                
                let annee = dates[vt].replaceAll("-", "");

                if(parseInt(annee) == parseInt(annee_selectionne)){

                    if((iir.observation_rex) && (!iir.deja_pris_en_compte)){
                        for (let a = 0; a < users_incidents.length; a++){
                            const ui = users_incidents[a];
                            if(ui.incident_number == iir.number){

                                if(parseInt(ui.user_id) == parseInt(userConnecter.id)){

                                    incident_concernant_user_login.push(iir);

                                    if(ui.isCoordo === "1"){
                                        incident_emis +=1;
                                    }else{
                                        incident_recus +=1;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            

            for (let vb = 0; vb < incident_concernant_user_login.length; vb++) {
                const incident = incident_concernant_user_login[vb];
                
                if(incident.status == "ENCOURS"){
                    encours +=1;
                }else if(incident.status == "CLÔTURÉ"){
                    cloturer +=1;
                }else if(incident.status == "ANNULÉ"){
                    annuler +=1;
                }

                for (let ay = 0; ay < tasks.length; ay++) {
                    const task = tasks[ay];
        
                    if(task.incident_number == incident.number){
        
                        if(task.site_id){
                            if(userConnecter.site_id){
                                if(parseInt(task.site_id) == parseInt(userConnecter.site_id)){
                                    nbr_taches_total +=1;
                                    taches_tous_incidents.push(task);
                                }else{
                                    for (let pw = 0; pw < users_incidents.length; pw++) {
                                        const uc = users_incidents[pw];
                                        
                                        if(userConnecter.id == uc.user_id){
                                            if(uc.incident_number == incident.number){
                                                if(uc.isCoordo === "1"){
                                                    nbr_taches_total +=1;
                                                    taches_tous_incidents.push(task);
                                                }
                                            }
                                        }
                                    }
                                }
                            }else if(userConnecter.departement_id){
                                if(parseInt(task.departement_id) == parseInt(userConnecter.departement_id)){
                                    nbr_taches_total +=1;
                                    taches_tous_incidents.push(task);
                                }else{
                                    for (let pw = 0; pw < users_incidents.length; pw++) {
                                        const uc = users_incidents[pw];
                                        
                                        if(userConnecter.id == uc.user_id){
                                            if(uc.incident_number == incident.number){
                                                if(uc.isCoordo === "1"){
                                                    nbr_taches_total +=1;
                                                    taches_tous_incidents.push(task);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }else if(task.departement_id){
                            if(userConnecter.departement_id){
        
                                if(parseInt(task.departement_id) == parseInt(userConnecter.departement_id)){
                                    nbr_taches_total +=1;
                                    taches_tous_incidents.push(task);
                                }else{
                                    for (let pw = 0; pw < users_incidents.length; pw++) {
                                        const uc = users_incidents[pw];
                                        
                                        if(userConnecter.id == uc.user_id){
                                            if(uc.incident_number == incident.number){
                                                if(uc.isCoordo === "1"){
                                                    nbr_taches_total +=1;
                                                    taches_tous_incidents.push(task);
                                                }
                                            }
                                        }
                                    }
                                }
        
                            }else if(userConnecter.site_id){
                                for (let pw = 0; pw < users_incidents.length; pw++) {
                                    const uc = users_incidents[pw];
                                    
                                    if(userConnecter.id == uc.user_id){
                                        if(uc.incident_number == incident.number){
                                            if(uc.isCoordo === "1"){
                                                nbr_taches_total +=1;
                                                taches_tous_incidents.push(task);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
        
            }

            for (let gh = 0; gh < taches_tous_incidents.length; gh++) {

                const tache = taches_tous_incidents[gh];

                if (tache.site_id) {
                    if(userConnecter.site_id){
                        if(parseInt(userConnecter.site_id) == parseInt(tache.site_id)){
                            nbr_taches_recues +=1;
                        }else{
                            nbr_taches_emises +=1;
                        }
                    }else if(userConnecter.departement_id){

                        for (let jx = 0; jx < users_incidents.length; jx++) {
                            const ui = users_incidents[jx];

                            if(parseInt(ui.user_id) == parseInt(userConnecter.id)){
                                if(ui.incident_number == tache.incident_number){
                                    if(ui.isCoordo === "1"){
                                            nbr_taches_emises +=1;
                                    }else{
                                            nbr_taches_recues +=1;
                                    }
                                }    
                            }
                        }
                    }
                } else if(tache.departement_id) {
                    if(userConnecter.departement_id){
                        if(parseInt(userConnecter.departement_id) == parseInt(tache.departement_id)){
                            nbr_taches_recues +=1;
                        }else{
                            nbr_taches_emises +=1;
                        }
                    }else if(userConnecter.site_id){
                        for (let jx = 0; jx < users_incidents.length; jx++) {
                            const ui = users_incidents[jx];

                            if(parseInt(ui.user_id) == parseInt(userConnecter.id)){
                                if(ui.incident_number == tache.incident_number){
                                    if(ui.isCoordo === "1"){
                                        nbr_taches_emises +=1;
                                    }else{
                                        nbr_taches_recues +=1;
                                    }
                                }
                            }
                        }
                    }
                }

                if(tache.status == "ENCOURS"){
                    encour_tache +=1;
                }else if(tache.status == "RÉALISÉE"){
                    realise_tache +=1;
                }else if(tache.status == "EN-ATTENTE"){
                    enAttenta_tache +=1;
                }else if(tache.status == "ANNULÉE"){
                    annule_tache +=1;
                }
            }


            $('.encours_Inci').replaceWith(`<span class="text-primary encours_Inci">${encours < 10 ? 0 +""+ encours : encours}</span>`);
            $('.cloture_Inci').replaceWith(`<span class="text-success cloture_Inci">${cloturer < 10 ? 0 +""+ cloturer : cloturer}</span>`)
            $('.annule_Inci').replaceWith(`<span class="text-gray-400 annule_Inci">${annuler < 10 ? 0 +""+ annuler : annuler}</span>`)

            $('.alters').replaceWith(`<span style="font-size:3em;" class="alters mb-0">${incident_concernant_user_login.length < 10 ? 0 +""+ incident_concernant_user_login.length : incident_concernant_user_login.length}</span>`)
            $('.encour_gros').replaceWith(`<span style="font-size:3em;" class="text-success mb-0 encour_gros">${encours < 10 ? 0 +""+ encours : encours}</span>`);
            $('.cloture_gros').replaceWith(`<span style="font-size:3em;" class="text-success mb-0 cloture_gros">${cloturer < 10 ? 0 +""+ cloturer : cloturer}</span>`);
            $('.annule_gros').replaceWith(`<span style="font-size:3em;" class="text-success mb-0 annule_gros">${annuler < 10 ? 0 +""+ annuler : annuler}</span>`);

            $('.emis_Inci').replaceWith(`<span class="text-white emis_Inci">${incident_emis < 10 ? 0 +""+ incident_emis : incident_emis}</span>`);
            $('.recu_Inci').replaceWith(`<span class="text-info recu_Inci">${incident_recus < 10 ? 0 +""+ incident_recus : incident_recus}</span>`);
            $('.onesmore').replaceWith(`<span class="h2 onesmore">${incident_concernant_user_login.length < 10 ? 0 +""+ incident_concernant_user_login.length : incident_concernant_user_login.length}</span>`);
            $('.nomInci').replaceWith(`<span class="nomInci"> Nombre D'Incidents </span>`);
            $('.getDate').replaceWith(`<span class="getDate"></span>`);

            $('.name_t').replaceWith(`<span class="name_t">Nombre De Tâche</span>`);
            $('.getDate_taskss').replaceWith(`<span class="getDate_taskss"></span>`);
            $('.nombre_tache_totals').replaceWith(`<span class="h2 nombre_tache_totals">${nbr_taches_total < 10 ? 0 +""+ nbr_taches_total : nbr_taches_total}</span>`);
            $('.tach_enc_to').replaceWith(`<span class="text-primary tach_enc_to">${encour_tache < 10 ? 0 +""+ encour_tache : encour_tache}</span>`);
            $('.tach_real_to').replaceWith(`<span class="text-success tach_real_to">${realise_tache < 10 ? 0 +""+ realise_tache : realise_tache}</span>`);
            $('.tach_enA_to').replaceWith(`<span class="text-warning tach_enA_to">${enAttenta_tache < 10 ? 0 +""+ enAttenta_tache : enAttenta_tache}</span>`);
            $('.tach_an_to').replaceWith(`<span class="text-light tach_an_to">${annule_tache < 10 ? 0 +""+ annule_tache : annule_tache}</span>`);

            $('.nb_ta_emi').replaceWith(`<span class="text-white nb_ta_emi">${nbr_taches_emises < 10 ? 0 +""+ nbr_taches_emises : nbr_taches_emises}</span>`);
            $('.nb_ta_rec').replaceWith(`<span class="text-info nb_ta_rec">${nbr_taches_recues < 10 ? 0 +""+ nbr_taches_recues : nbr_taches_recues}</span>`);

            if(incident_concernant_user_login.length > 0){
                width_emis_inci = parseInt((incident_emis/incident_concernant_user_login.length) * 100);
                width_recu_inci = parseInt((incident_recus/incident_concernant_user_login.length) * 100);
                width_encou_inci = parseInt((encours/incident_concernant_user_login.length) * 100);
                width_clot_inci = parseInt((cloturer/incident_concernant_user_login.length) * 100);
                width_annu_inci = parseInt((annuler/incident_concernant_user_login.length) * 100);
            }

            if(taches_tous_incidents.length > 0){
                width_tache_emise = parseInt((nbr_taches_emises/taches_tous_incidents.length)*100);
                width_tache_recues = parseInt((nbr_taches_recues/taches_tous_incidents.length)*100);

                width_tache_encour = parseInt((encour_tache/taches_tous_incidents.length)*100);
                width_tache_realise = parseInt((realise_tache/taches_tous_incidents.length)*100);
                width_tache_enAttente = parseInt((enAttenta_tache/taches_tous_incidents.length)*100);
                width_tache_annul = parseInt((annule_tache/taches_tous_incidents.length)*100);

            }

            $('.pg_emis_inci').replaceWith(`
                <div class="progress-bar bg-secondary pg_emis_inci" role="progressbar" style="width: ${width_emis_inci == 0 ? 3 : width_emis_inci}%;" aria-valuenow="${width_emis_inci == 0 ? 3 : width_emis_inci}" aria-valuemin="0" aria-valuemax="100">${width_emis_inci}%</div>
            `);
            
            $('.pg_recu_inci').replaceWith(`
                <div class="progress-bar bg-info pg_recu_inci" role="progressbar" style="width: ${width_recu_inci == 0 ? 3 : width_recu_inci}%;" aria-valuenow="${width_recu_inci == 0 ? 3 : width_recu_inci}" aria-valuemin="0" aria-valuemax="100">${width_recu_inci}%</div>
            `);

            $('.pg_encou_inci').replaceWith(`
                <div class="progress-bar bg-primary pg_encou_inci" role="progressbar" style="width: ${width_encou_inci == 0 ? 3 : width_encou_inci}%;" aria-valuenow="${width_encou_inci == 0 ? 3 : width_encou_inci}" aria-valuemin="0" aria-valuemax="100">${width_encou_inci}%</div>
            `);

            $('.pg_clot_inci').replaceWith(`
                <div class="progress-bar bg-success pg_clot_inci" role="progressbar" style="width: ${width_clot_inci == 0 ? 3 : width_clot_inci}%;" aria-valuenow="${width_clot_inci == 0 ? 3 : width_clot_inci}" aria-valuemin="0" aria-valuemax="100">${width_clot_inci}%</div>
            `);

            $('.pg_anne_inci').replaceWith(`
                <div class="progress-bar bg-light pg_anne_inci" role="progressbar" style="width: ${width_annu_inci == 0 ? 3 : width_annu_inci}%;" aria-valuenow="${width_annu_inci == 0 ? 3 : width_annu_inci}" aria-valuemin="0" aria-valuemax="100">${width_annu_inci}%</div>
            `);
            // FIN BLOCK INCIDENT

            
            $('.pg_tache_emis').replaceWith(`
                <div class="progress-bar bg-secondary pg_tache_emis" role="progressbar" style="width: ${width_tache_emise == 0 ? 3 : width_tache_emise}%;" aria-valuenow="${width_tache_emise == 0 ? 3 : width_tache_emise}" aria-valuemin="0" aria-valuemax="100">${width_tache_emise}%</div>
            `);

            $('.pg_tache_recues').replaceWith(`
                <div class="progress-bar bg-info pg_tache_recues" role="progressbar" style="width: ${width_tache_recues == 0 ? 3 : width_tache_recues}%;" aria-valuenow="${width_tache_recues == 0 ? 3 : width_tache_recues}" aria-valuemin="0" aria-valuemax="100">${width_tache_recues}%</div>
            `);

            $('.pg_tache_encous').replaceWith(`
                <div class="progress-bar bg-primary pg_tache_encous" role="progressbar" style="width: ${width_tache_encour == 0 ? 3 : width_tache_encour}%;" aria-valuenow="${width_tache_encour == 0 ? 3 : width_tache_encour}" aria-valuemin="0" aria-valuemax="100">${width_tache_encour}%</div>
            `);

            $('.pg_tache_realis').replaceWith(`
                <div class="progress-bar bg-success pg_tache_realis" role="progressbar" style="width: ${width_tache_realise == 0 ? 3 : width_tache_realise}%;" aria-valuenow="${width_tache_realise == 0 ? 3 : width_tache_realise}" aria-valuemin="0" aria-valuemax="100">${width_tache_realise}%</div>
            `);

            $('.pg_tache_enatten').replaceWith(`
                <div class="progress-bar bg-warning pg_tache_enatten" role="progressbar" style="width: ${width_tache_enAttente == 0 ? 3 : width_tache_enAttente}%;" aria-valuenow="${width_tache_enAttente == 0 ? 3 : width_tache_enAttente}" aria-valuemin="0" aria-valuemax="100">${width_tache_enAttente}%</div>
            `);

            $('.pg_tache_annils').replaceWith(`
                <div class="progress-bar bg-light pg_tache_annils" role="progressbar" style="width: ${width_tache_annul == 0 ? 3 : width_tache_annul}%;" aria-valuenow="${width_tache_annul == 0 ? 3 : width_tache_annul}" aria-valuemin="0" aria-valuemax="100">${width_tache_annul}%</div>
            `);

        }
});

$(document).on('click', '#close_fight, #btnTaskListExte', function(){
    $('#modal_liste_incident').modal('show');
});

// var today = new Date();
// var dd = String(today.getDate()).padStart(2, '0');
// var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
// var yyyy = today.getFullYear();