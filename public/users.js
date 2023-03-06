
$(document).on('click', '#btnAddUser', function(){

    let regExe =  /^[^a-z\^A-Z\^`~!@#$%^&*()_+={}\[\]|\\:;“’<,>.?๐฿]+$/;
    let reg =  /^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[!"#$%&'()*+,-./:;<=>?@[\]^_`{|}~])/;
    let regex = /^(?=.*[@])/;

    let good = true;
    let message = "";

    let tab = $('#conf_save_user').attr('data-utilisateurs');

    let utilisateurs = JSON.parse(tab);

    if(!$('#fullname').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Nom Complèt !\n";
    }

    if(!$('input[name="ag"]').prop("checked")){
        if(!$('input[name="st"]').prop("checked")){
            if(!$('input[name="se"]').prop("checked")){
                good = false;
                message+="Veuillez Cochez Un Lieu De Travail !\n";
            }
        }
    }

    if($('input[name="ag"]').prop("checked") == true){
        if(!$('#site_id').val()){
            good = false;
            message+="Veuillez Choisir Une Agence !\n";
        }
    }

    if($('input[name="st"]').prop("checked") == true){
        if(!$('#magasin_id').val()){
            good = false;
            message+="Veuillez Choisir Un Magasin !\n";
        }
    }

    if($('input[name="se"]').prop("checked") == true){
        if(!$('#departement_id').val()){
            good = false;
            message+="Veuillez Choisir Un Département !\n";
        }
    }

    if(!$('#email').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Email !\n";
    }
    else{
        if(!$('#email').val().trim().match(regex)){
            good = false;
            message+="Le Format De Votre Email Est Incorrect !\n";
        }
    }   

    if(!$('#login').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Nom D'utilisateur !\n";
    }else{
        let Qte = 0;
        let array = [];
        
        utilisateurs.forEach(utilisateur =>{
            if(parseInt(utilisateur.id) != parseInt($('#idEditUser').val())){
                array.push(utilisateur);
            }
        });
        array.forEach(utilisateur => {
            if(utilisateur.login.trim().toLowerCase() == $('#login').val().trim().toLowerCase()){
                Qte +=1;
            }
        });

        if(Qte > 0){
            good = false;
            message+="Veuillez Changer De Nom D'utilisateur Car Déja Existant !\n"; 
        }
    }      

    if(!$('#password').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Mot De Passe !\n";
    }else{
            if(!$('#confirm-password').val().trim()){
                good = false;
                message+="Veuillez Confirmer Votre Mot De Passe !\n"; 
            }else{
                if(!($('#password').val().trim() == $('#confirm-password').val().trim())){
                    good = false;
                    message+="Veuillez Renseigner Des Mot De Passe Identique !\n";        
                }else{
                    if($('#password').val().trim().length < 6){
                        good = false;
                        message+="Votre Mot De Passe Doit Contenir Au Moins 6 Caractères !\n"; 
                    }
                    // else{
                    //     if(!$('#password').val().trim().match(reg)){
                    //         good = false;
                    //         message+="Le Format De Votre Mot De Passe Est Incorrect !\n";     
                    //     }
                    // }
                }
            }
    }     

    if(!$('#role').val().trim()){
        good = false;
        message+="Veuillez Choisir Un Role !\n";
    }       
    if(!good){
        good = false;
        $('#modalUser').modal('hide');
        $('#validation').val(message);
        $('#errorvalidationsModals').attr('data-backdrop', 'static');
        $('#errorvalidationsModals').attr('data-keyboard', false);
        $('#errorvalidationsModals').modal('show');
    }else{

        $('#fullname_conf').replaceWith(`<span style="font-size: 15px;" id="fullname_conf">${$('#fullname').val()}</span>`);
        $('#username_conf').replaceWith(`<span style="font-size: 15px;" id="username_conf">${$("#login").val()}</span>`);
        $('#em_conf').replaceWith(`<span style="font-size: 15px;" id="em_conf">${$("#email").val()}</span>`);
        $('#d_conf').replaceWith(`<span style="font-size: 15px;" id="d_conf">${$("#departement_id option:selected").text() != 'Choisissez...' ? $("#departement_id option:selected").text() : ''}</span>`);
        $('#sit_conf').replaceWith(`<span style="font-size: 15px;" id="sit_conf">${$("#site_id option:selected").text() != 'Choisissez...' ? $("#site_id option:selected").text() : ''}</span>`);
        $('#role_conf').replaceWith(`<span style="font-size: 15px;" id="role_conf">${$("#role option:selected").text() != 'Choisissez...' ? $("#role option:selected").text() : ''}</span>`);
        $('#modalUser').modal('hide');
        $('#modalconfirm_user').attr('data-backdrop', 'static');
        $('#modalconfirm_user').attr('data-keyboard', false);
        $('#modalconfirm_user').modal('show');
    }   
});

$(document).on('click', '#dismiss_user', function(){
    $('#errorvalidationsModals').modal('hide');
    $('#modalUser').attr('data-backdrop', 'static');
    $('#modalUser').attr('data-keyboard', false);
    $('#modalUser').modal('show');
});

$(document).on('click', '#non_confirmation_saveU', function(){
    $('#modalconfirm_user').modal('hide');
    $('#modalUser').attr('data-backdrop', 'static');
    $('#modalUser').attr('data-keyboard', false);
    $('#modalUser').modal('show');
});

$(document).on('click', '#conf_save_user', function(){
    $.ajax({
        type: 'POST',
        url: "createUser",
        data: $('#userFormInsert').serialize(),
         headers:{
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
        success: function(data){
            if(data.length == 2){

                $(this).attr('data-utilisateurs', JSON.stringify(data[1]))
            
                let user = data[0];
                if(user){
                    $('#dataTable-1').prepend(`
                    <tr style="font-size:15px;">
                    <td><label> ${user.login} </label></span></td>
                    <td><label> ${user.fullname} </label></span></td>
                    <td><label> ${user.departements ? user.departements.name : ''}</label></td>
                    <td>
                        
                    </td>                                                      
                    <td>
                        <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="text-muted sr-only">Action</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            @can('editer-utilisateur')
                                <a 
                                    class="dropdown-item" 
                                    id="btnEdit" 
                                    data-user="${user}"
                                    data-password="${user.password}"
                                    data-toggle="modal" 
                                    data-target="#modalEditUser" 
                                    data-backdrop="static"
                                    data-keyboard="false">
                                    Editer
                                </a>
                            @endcan

                            @can('supprimer-utilisateur')
                                <a
                                    class="dropdown-item"
                                    href="#"
                                    id="btnDelete"
                                    data-fullname="${user.fullname}"
                                    data-id="${user.id}">
                                    Supprimer
                                </a>
                            @endcan

                            @can('voir-utilisateur')
                                <a
                                    class="dropdown-item"
                                    href="#"
                                    data-toggle="modal"
                                    data-target="#viewUser"
                                    data-backdrop="static"
                                    data-keyboard="false"
                                    id="btnViewUser"
                                    data-password="${user.password}"
                                    data-fullname="${user.fullname}" 
                                    data-user="${user}">
                                    Voir
                                </a>
                            @endcan
                        </div>
                    </td>

                </tr>
                    `)
                    $("#userFormInsert")[0].reset();
                    $('#modalconfirm_user').modal('toggle');
                    $('#modalUser').modal('show');
                }
            }else{
                $('#validation').val(data[0]);
                $('#errorvalidationsModals').attr('data-backdrop', 'static');
                $('#errorvalidationsModals').attr('data-keyboard', false);
                $('#errorvalidationsModals').modal('show');                
            }
        } 
    });
});

$(document).on('click', '#btnDelete', function(){
        if(confirm("Voulez-Vous Vraiment Supprimer Cette Utilisateur : "+ $(this).attr('data-fullname') +" ?") == true){
                $.ajax({
                    type: 'GET',
                    url: 'deleteUser',
                    data: { id: $(this).attr('data-id')},
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(){
                        location.reload();
                    }
            })
        }
    }
)

$(document).on('click', '#btnEdit', function(){
    let user = JSON.parse($(this).attr('data-user'));
    let sites = JSON.parse($(this).attr('data-sites'));
    let departements = JSON.parse($(this).attr('data-departements'));

    $('#idEditUser').val(user.id);
    $('#fullnames').val(user.fullname);
    $('#logins').val(user.login);
    $('#passwords').val(user.see_password);
    $('#confirm-passwords').val(user.see_password);
    $('#roles').val(user.roles.length > 0 ? user.roles[0].name : '');
    $('#emails').val(user.email);

    if(user.site_id){
        if(user.sites.types.name == "AGENCE"){
            $('input[name="ags"]').prop('checked', true);
            $('input[name="sts"]').prop('checked', false);
            $('input[name="ses"]').prop("checked", false);

            $('.magis').remove();
            $('.depis').remove();

            $('.camer_edit').append(`
                <div class="form-group agis">
                    <label for="site_ids"><i class="fe fe-home mr-2"></i> L'Agence Où Travaille L'utilisateur <span style="color:red;"> *</span></label>
                        <select style="font-size:20px;" class="form-control" id="site_ids" name="site_id">
                            <option value="">Choisissez...</option>
                        </select>
                </div>
            `)
    
            for (let index = 0; index < sites.length; index++) {
                const site = sites[index];
                $('#site_ids').append(`
                    <option value="${site.id}">${site.name}</option>
                `);
            }
            $('#site_ids').val(user.site_id);

        }else if(user.sites.types.name == "MAGASIN"){
            $('input[name="sts"]').prop('checked', true);
            $('input[name="ags"]').prop('checked', false);
            $('input[name="ses"]').prop("checked", false);

            $('.agis').remove();
            $('.depis').remove();

            $('.camer_edit').append(`
                <div class="form-group magis">
                    <label for="magasin_ids"><i class="fe fe-map mr-2"></i>Magasin Où Travail L'utilisateur <span style="color:red;"> *</span></label>
                    <select style="font-size:20px;" class="custom-select" id="magasin_ids" name="magasin_id">
                            <option value="">Choisissez...</option>
                    </select>
                </div>
            `)

            for (let index = 0; index < sites.length; index++) {
                const site = sites[index];
                $('#magasin_ids').append(`
                        <option value="${site.id}">${site.name}</option>
                `)
            }

            $('#magasin_ids').val(user.site_id);
        }
    }

    if(user.departement_id){
        $('input[name="ses"]').prop("checked", true);
        $('input[name="ags"]').prop('checked', false);
        $('input[name="sts"]').prop("checked", false);

        $('.magis').remove();
        $('.agis').remove();
        
        $('.camer_edit').append(`
            <div class="form-group depis">
                <label for="departement_ids"><i class="fe fe-home mr-2"></i> Département Au Sein De La Direction Générale <span style="color:red;"> *</span></label>
                <select style="font-size:20px;" class="custom-select" id="departement_ids" name="departement_id">
                        <option value="">Choisissez...</option>
                </select>
            </div>
        `)

        for (let index = 0; index < departements.length; index++) {
            const departement = departements[index];
            $('#departement_ids').append(`
                    <option value="${departement.id}">${departement.name}</option>
            `)
        }

        $('#departement_ids').val(user.departement_id);
    }
});

$(document).on('click', '#btnEditUser', function(){

    let regExe =  /^[^a-z\^A-Z\^`~!@#$%^&*()_+={}\[\]|\\:;“’<,>.?๐฿]+$/;
    let reg =  /^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[!"#$%&'()*+,-./:;<=>?@[\]^_`{|}~])/;
    let regex = /^(?=.*[@])/;

    let good = true;
    let message = "";

    let tab = $('#conf_save_user').attr('data-utilisateurs');

    let utilisateurs = JSON.parse(tab);
    

    if(!$('#fullnames').val().trim()){
    good = false;
    message+="Veuillez Renseigner Une Nom Complèt !\n";
    }

    if(!$('input[name="ags"]').prop("checked")){
        if(!$('input[name="sts"]').prop("checked")){
            if(!$('input[name="ses"]').prop("checked")){
                good = false;
                message+="Veuillez Cochez Un Lieu De Travail !\n";
            }
        }
    }

    if($('input[name="ags"]').prop("checked") == true){
        if(!$('#site_ids').val()){
            good = false;
            message+="Veuillez Choisir Une Agence !\n";
        }
    }

    if($('input[name="sts"]').prop("checked") == true){
        if(!$('#magasin_ids').val()){
            good = false;
            message+="Veuillez Choisir Un Magasin !\n";
        }
    }

    if($('input[name="ses"]').prop("checked") == true){
        if(!$('#departement_ids').val()){
            good = false;
            message+="Veuillez Choisir Un Département !\n";
        }
    }

    if(!$('#emails').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Email !\n";
    }else{
        if(!$('#emails').val().trim().match(regex)){
            good = false;
            message+="Le Format De Votre Email Est Incorrect !\n";
        }
    }   

    if(!$('#logins').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Nom D'utilisateur !\n";
    }else{
            let Qte = 0;
            let array = [];
            
            utilisateurs.forEach(utilisateur =>{
                if(parseInt(utilisateur.id) != parseInt($('#idEditUser').val())){
                    array.push(utilisateur);
                }
            });
            array.forEach(utilisateur => {
                if(utilisateur.login.trim().toLowerCase() == $('#logins').val().trim().toLowerCase()){
                    Qte +=1;
                }
            });

            if(Qte > 0){
                good = false;
                message+="Veuillez Changer De Nom D'utilisateur Car Déja Existant !\n"; 
            }
    }

    if(!$('#passwords').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Mot De Passe !\n";
    }else{
            if(!$('#confirm-passwords').val().trim()){
                good = false;
                message+="Veuillez Confirmer Votre Mot De Passe !\n";
            }else{
                if(!($('#passwords').val().trim() == $('#confirm-passwords').val().trim())){
                    good = false;
                    message+="Veuillez Renseigner Des Mot De Passe Identique !\n";     
                }else{
                    if($('#passwords').val().trim().length < 6){
                        good = false;
                        message+="Votre Mot De Passe Doit Contenir Au Moins 6 Caractères !\n"; 
                    }
                    // else{
                    //     if(!$('#passwords').val().trim().match(reg)){
                    //         good = false;
                    //         message+="Le Format De Votre Mot De Passe Est Incorrect !\n";     
                    //     }
                    // }
                }
            }
    }   

    if(!$('#roles').val().trim()){
        good = false;
        message+="Veuillez Choisir Un Rôle !\n";
    }

    if(!good){
        good = false;
        $('#modalEditUser').modal('hide');
        $('#validation_edit').val(message);
        $('#error_edit').attr('data-backdrop', 'static');
        $('#error_edit').attr('data-keyboard', false);
        $('#error_edit').modal('show');           
    }else{
        $.ajax({
            type: 'PUT',
            url: "editUser",
            data: $('#userFormEdit').serialize(),
             headers:{
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            success: function(){
                    location.reload();
                } 
        });  
    }      
});

$(document).on('click', '#roleUser', function(){
    $('#update_role').attr('data-user', $(this).attr('data-user'));
    $('#nibiru').replaceWith(`<strong id="nibiru">${JSON.parse($(this).attr('data-user')).login}</strong>`);
});


$(document).on('click', '#update_role', function(){
    if($('#role_utilisateur').val()){
        let user = JSON.parse($(this).attr('data-user'));
        $.ajax({
            type: 'PUT',
            url: "updateRole",
            data: {
                roles: $('#role_utilisateur').val(),
                id: user.id,
            },
             headers:{
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            success: function(){
                    location.reload();
                } 
        }); 
    }else{
        $('#modif_role_user').modal('hide');
        $('#valiRole').val('Veuillez Choisir Un Rôle !');
        $('#update_rol').attr('data-backdrop', 'static');
        $('#update_rol').attr('data-keyboard', false);
        $('#update_rol').modal('show');    
    }
});

$(document).on('click', '#dismiss_riless', function(){
    $('#update_rol').modal('hide');
    $('#modif_role_user').attr('data-backdrop', 'static');
    $('#modif_role_user').attr('data-keyboard', false);
    $('#modif_role_user').modal('show');
});


$(document).on('click', '#dismiss_user_edit', function(){
    $('#error_edit').modal('hide');
    $('#modalEditUser').attr('data-backdrop', 'static');
    $('#modalEditUser').attr('data-keyboard', false);
    $('#modalEditUser').modal('show');
});


$(document).on('click', '#btnViewUser', function(){

    let user = JSON.parse($(this).attr('data-user'));

    $('#use_name').replaceWith(`<span class="badge badge-success text-lg ml-4" id="use_name">${user.login}</span>`)
    $('.form-group #name_user').val(user.fullname);
    $('.form-group #site_user').val(user.sites ? user.sites.site_name : user.departements ? user.departements.name : '');
    $('.form-group #username').val(user.login ? user.login : '');
    $('.form-group #email_user').val(user.email);

    if(user.roles.length > 1){
        let conc = "";
        for (let index = 0; index < user.roles.length; index++) {
            const elt = user.roles[index];
            conc += elt.name + "\n";
        }
        $('.form-group #role_user').val(conc);
    }else{
        $('.form-group #role_user').val(user.roles[0].name);
    }

})

$(document).on('click', '#btnAnnulEditUser', function(){
    $('#userFormEdit')[0].reset();
    $('.magis').remove();
    $('.depis').remove();
    $('.agis').remove();
});

$(document).on('click', '#btnAnnulAddForm', function(){
    $('#userFormInsert')[0].reset();
    $('#agency').prop("checked", false);
    $('.magi').remove();
    $('.depi').remove();
    $('.agi').remove();
});

$(document).on('click', '#btnCloseAddUser', function(){
    location.reload();
});

$(document).ready(function(){

    let sites = JSON.parse($('.camer').attr('data-sites'));
    let departements = JSON.parse($('.camer').attr('data-departements'));


    $('input[name="ag"]').click(function(){

        if($(this).prop("checked") == true){
            $('#store').prop('checked', false);
            $('#service').prop('checked', false);
                        
            $('.magi').remove();
            $('.depi').remove();

            $('.camer').append(`
                <div class="form-group agi">
                    <label for="site_id"><i class="fe fe-home mr-2"></i> L'Agence Où Travaille L'utilisateur <span style="color:red;"> *</span></label>
                        <select style="font-size:20px;" class="form-control" id="site_id" name="site_id">
                            <option selected value="">Choisissez...</option>
                        </select>
                </div>
            `)
    
            for (let index = 0; index < sites.length; index++) {
                const site = sites[index];
                if(site.types.name == "AGENCE"){
                    $('#site_id').append(`
                    <option value="${site.id}">${site.name}</option>
                `);
                }
            }
    
        }else{
            $('.agi').remove();
            $("#site_id").prop('selectedIndex', -1)
        }
    });

    $('input[name="st"]').click(function(){

        if($(this).prop("checked") == true){
            $('#agency').prop('checked', false);
            $('#service').prop('checked', false);
            $('.agi').remove();
            $('.depi').remove();

            $('.camer').append(`
                <div class="form-group magi">
                    <label for="magasin_id"><i class="fe fe-map mr-2"></i>Magasin Où Travail L'utilisateur <span style="color:red;"> *</span></label>
                    <select style="font-size:20px;" class="custom-select" id="magasin_id" name="magasin_id">
                            <option selected value="">Choisissez...</option>
                    </select>
                </div>
            `)

            for (let index = 0; index < sites.length; index++) {
                const site = sites[index];
                if(site.types.name == "MAGASIN"){
                    $('#magasin_id').append(`
                        <option value="${site.id}">${site.name}</option>
                    `)
                }
            }
        }else{
            $('.magi').remove();
            $("#magasin_id").prop('selectedIndex', -1)
        }
    });

    $('input[name="se"]').click(function(){

        if($(this).prop("checked") == true){
            $('#store').prop('checked', false);
            $('#agency').prop('checked', false);
            $('.magi').remove();
            $('.agi').remove();

            $('.camer').append(`
                <div class="form-group depi">
                    <label for="departement_id"><i class="fe fe-home mr-2"></i> Département Au Sein De La Direction Générale <span style="color:red;"> *</span></label>
                    <select style="font-size:20px;" class="custom-select" id="departement_id" name="departement_id">
                            <option selected value="">Choisissez...</option>
                    </select>
                </div>
            `)

            for (let index = 0; index < departements.length; index++) {
                const departement = departements[index];
                $('#departement_id').append(`
                    <option value="${departement.id}">${departement.name}</option>
                `)
            }
        }else{
            $('.depi').remove();
            $("#departement_id").prop('selectedIndex', -1)
        }
    });


    if($('input[name="ag"]').prop("checked") == true){

        $('.camer').append(`
        <div class="form-group agi">
            <label for="site_id"><i class="fe fe-home mr-2"></i> L'Agence Où Travail L'utilisateur</label>
                <select style="font-size:20px;" class="form-control" id="site_id" name="site_id">
                    <option selected value="">Choisissez...</option>
                </select>
        </div>
        `)

        for (let index = 0; index < sites.length; index++) {
            const site = sites[index];
            if(site.types.name == "AGENCE"){
                $('#site_id').append(`
                <option value="${site.id}">${site.name}</option>
            `);
            }
        }
        
    }


    // edition user

    $('input[name="ags"]').click(function(){

        if($(this).prop("checked") == true){
            $('#stores').prop('checked', false);
            $('#services').prop('checked', false);
                        
            $('.magis').remove();
            $('.depis').remove();

            $('.camer_edit').append(`
                <div class="form-group agis">
                    <label for="site_ids"><i class="fe fe-home mr-2"></i> L'Agence Où Travaille L'utilisateur <span style="color:red;"> *</span></label>
                        <select style="font-size:20px;" class="form-control" id="site_ids" name="site_id">
                            <option selected value="">Choisissez...</option>
                        </select>
                </div>
            `)
    
            for (let index = 0; index < sites.length; index++) {
                const site = sites[index];
                if(site.types.name == "AGENCE"){
                    $('#site_ids').append(`
                    <option value="${site.id}">${site.name}</option>
                `);
                }
            }
    
        }else{
            $('.agis').remove();
            $("#site_ids").prop('selectedIndex', -1);
        }
    });

    $('input[name="sts"]').click(function(){

        if($(this).prop("checked") == true){
            $('#agencys').prop('checked', false);
            $('#services').prop('checked', false);

            $('.agis').remove();
            $('.depis').remove();

            $('.camer_edit').append(`
                <div class="form-group magis">
                    <label for="magasin_ids"><i class="fe fe-map mr-2"></i>Magasin Où Travail L'utilisateur <span style="color:red;"> *</span></label>
                    <select style="font-size:20px;" class="custom-select" id="magasin_ids" name="magasin_id">
                            <option selected value="">Choisissez...</option>
                    </select>
                </div>
            `)

            for (let index = 0; index < sites.length; index++) {
                const site = sites[index];
                if(site.types.name == "MAGASIN"){
                    $('#magasin_ids').append(`
                        <option value="${site.id}">${site.name}</option>
                    `)
                }
            }
        }else{
            $('.magis').remove();
            $("#magasin_ids").prop('selectedIndex', -1);
        }
    });

    $('input[name="ses"]').click(function(){

        if($(this).prop("checked") == true){
            $('#stores').prop('checked', false);
            $('#agencys').prop('checked', false);
            $('.magis').remove();
            $('.agis').remove();

            $('.camer_edit').append(`
                <div class="form-group depis">
                    <label for="departement_ids"><i class="fe fe-home mr-2"></i> Département Au Sein De La Direction Générale <span style="color:red;"> *</span></label>
                    <select style="font-size:20px;" class="custom-select" id="departement_ids" name="departement_id">
                            <option selected value="">Choisissez...</option>
                    </select>
                </div>
            `)

            for (let index = 0; index < departements.length; index++) {
                const departement = departements[index];
                $('#departement_ids').append(`
                    <option value="${departement.id}">${departement.name}</option>
                `)
            }
        }else{
            $('.depis').remove();
            $("#departement_ids").prop('selectedIndex', -1);
        }
    });

})