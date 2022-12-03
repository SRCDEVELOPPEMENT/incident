
$(document).on('click', '#btnAddUser', function(){

    let regExe =  /^[^a-z\^A-Z\^`~!@#$%^&*()_+={}\[\]|\\:;“’<,>.?๐฿]+$/;
    let reg =  /^(?=.*[0-9])(?=.*[a-z])(?=.*[!"#$%&'()*+,-./:;<=>?@[\]^_`{|}~])/;
    let regex = new RegExp('[a-z0-9]+@[a-z]+\.[a-z]{2,3}');

    let good = true;
    let message = "";

    let tab = $('#conf_save_user').attr('data-utilisateurs');

    let utilisateurs = JSON.parse(tab);

    if(!$('#fullname').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Nom Complèt !\n";
    }
    if(!$('#departement_id').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Département !\n";
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
                    }else{
                        if(!$('#password').val().trim().match(reg)){
                            good = false;
                            message+="Le Format De Votre Mot De Passe Est Incorrect !\n";     
                        }
                    }
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
        $('#fullname_conf').replaceWith(`<span style="color: white; font-size: 15px;" id="fullname_conf">${$('#fullname').val()}</span>`);
        $('#username_conf').replaceWith(`<span style="color: white; font-size: 15px;" id="username_conf">${$("#login").val()}</span>`);
        $('#pass_conf').replaceWith(`<span style="color: white; font-size: 15px;" id="pass_conf">${$("#password").val()}</span>`);
        $('#role_conf').replaceWith(`<span style="color: white; font-size: 15px;" id="role_conf">${$("#roles option:selected").text()}</span>`);
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
                    <tr style="font-size:15px; color:black;">
                        <td><label> ${user.login ? user.login : ''} </label></td>
                        <td><label> ${user.fullname ? user.fullname : ''} </label></td>
                        <td><label> ${user.departements ? user.departements.name : ''} </label></td>
                        <td><label> </label></td>
                        <td><label></label></td>
                        <td> 
                            <button class="btn btn-sm btn-info mr-2" id="btnEdit" data-id=${user.id} data-fullname=${user.fullname}><span class="icon text-white-80"><i class="fas fa-edit"></i></span>Editer</button>
                            <button class="btn btn-sm btn-danger mr-2" id="btnDelete" data-id=${user.id}><span class="icon text-white-80"><i class="fas fa-trash"></i></span>Suprrimer</button>
                            <button class="btn btn-sm btn-primary" id="btnView"><span class="icon text-white-80"><i class="fas fa-eye"></i></span>Vue</button>
                        </td>
                    </tr>
                    `)
                    $("#userFormInsert")[0].reset();
                    $('#modalconfirm_user').modal('toggle');
                }
            }else{
                $('#validation').val(data[0]);
                $('#errorvalidationsModals').attr('data-backdrop', 'static');
                $('#errorvalidationsModals').attr('data-keyboard', false);
                $('#errorvalidationsModals').modal('show');                
            }
         } 
        })
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

    $('#idEditUser').val(user.id);
    $('#fullnames').val(user.fullname);
    $('#logins').val(user.login);
    $('#passwords').val(user.see_password);
    $('#confirm-passwords').val(user.see_password);
    $('#departement_ids').val(user.departement_id);
    $('#roles').val(user.roles.length > 0 ? user.roles[0].name : '');
});

$(document).on('click', '#btnEditUser', function(){

    let regExe =  /^[^a-z\^A-Z\^`~!@#$%^&*()_+={}\[\]|\\:;“’<,>.?๐฿]+$/;
    let reg =  /^(?=.*[0-9])(?=.*[a-z])(?=.*[!"#$%&'()*+,-./:;<=>?@[\]^_`{|}~])/;

    let good = true;
    let message = "";

    let tab = $('#conf_save_user').attr('data-utilisateurs');

    let utilisateurs = JSON.parse(tab);
    

    if(!$('#fullnames').val().trim()){
    good = false;
    message+="Veuillez Renseigner Une Nom Complèt !\n";
    }
    if(!$('#departement_ids').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Département !\n";
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
                    }else{
                        if(!$('#passwords').val().trim().match(reg)){
                            good = false;
                            message+="Le Format De Votre Mot De Passe Est Incorrect !\n";     
                        }
                    }
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

$(document).on('click', '#dismiss_user_edit', function(){
    $('#error_edit').modal('hide');
    $('#modalEditUser').attr('data-backdrop', 'static');
    $('#modalEditUser').attr('data-keyboard', false);
    $('#modalEditUser').modal('show');
});


$(document).on('click', '#btnViewUser', function(){

    let user = JSON.parse($(this).attr('data-user'));

    $('#use_name').replaceWith(`<span class="badge badge-success" id="use_name">${user.login}</span>`)
    $('.form-group #name_user').val(user.fullname);
    $('.form-group #vehicule_user').val(user.vehicules ? user.vehicules.Immatriculation : '');
    $('.form-group #phone_user').val(user.telephone);
    $('.form-group #site_user').val(user.sites ? user.sites.site_name : '');
    $('.form-group #username').val(user.login ? user.login : '');
    $('.form-group #password_user').val($(this).attr('data-password'));
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

$(document).on('click', '#btnExitEditUser', function(){
    $('#userFormEdit')[0].reset();
})

$(document).on('click', '#btnExitAddForm', function(){
    $('#userFormInsert')[0].reset();
});

$(document).on('click', '#btnCloseAddUser', function(){
    location.reload();
});