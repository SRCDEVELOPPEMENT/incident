$('#btnSaveSite').on('click', function(){

    let reg =  /^[^a-z\^A-Z\^`~!@#$%^&*()_+={}\[\]|\\:;“’<,>.?๐฿]+$/;

    let good = true;
    let message = "";

    if(!$('#site_region').val()){
        good = false;
        message += "Veuillez Choisir La Région Du Site !\n";
    }

    if(!$('#site_type').val()){
        good = false;
        message += "Veuillez Choisir Un Type De Site !\n";
    }
    
    if(!$('#site').val().trim()){
        good = false;
        message += "Veuillez Renseigner Un Site !\n";
    }

    if(!good){
        good = false;
        $('#modalSite').modal('hide');
        $('#validation').val(message);
        $('#errorvalidationsModals').attr('data-backdrop', 'static');
        $('#errorvalidationsModals').attr('data-keyboard', false);
        $('#errorvalidationsModals').modal('show');
    }else{
        $.ajax({
            type: 'POST',
            url: 'createSite',
            data: $('#siteFormInsert').serialize(),
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(data){
              if(data.length == 1){
    
                let site = data[0];
                if(site){
                    $('#dataTable-1').prepend(`
                    <tr style="font-size:15px;">
                        <td><label>${site.name}</label></td>
                        <td><label>${site.types ? site.types.name : ''}</label></td>
                        <td><label>${site.region}</label></td>
                        <td>
                            <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted sr-only">Action</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                    <a 
                                        id="btn_edi" 
                                        data-site="${site}"
                                        class="dropdown-item" 
                                        href="#"
                                        data-backdrop="static"
                                        data-keyboard="false"
                                        data-toggle="modal"
                                        data-target="#modalEditSite">
                                        Edit
                                    </a>
                                    <a id="btnDelete" data-site="${site}" class="dropdown-item" href="#">Supprimer</a>
                            </div>
                        </td>
                    </tr>
                    `);
                   $('#siteFormInsert')[0].reset();
                }
              }else{
                $('#validation').val('Veuillez Modifier Votre Site Car Déja Existant !');
                $('#errorvalidationsModals').attr('data-backdrop', 'static');
                $('#errorvalidationsModals').attr('data-keyboard', false);
                $('#errorvalidationsModals').modal('show');    
              }
            }
        })
    
    }
});

$(document).on('click', '#dismiss_btn', function(){
    $('#errorvalidationsModals').modal('hide');
    $('#modalSite').attr('data-backdrop', 'static');
    $('#modalSite').attr('data-keyboard', false);
    $('#modalSite').modal('show');
});

$(document).on('click', '#dismiss_bouton', function(){
    $('#error_edit').modal('hide');
    $('#modalEditSite').attr('data-backdrop', 'static');
    $('#modalEditSite').attr('data-keyboard', false);
    $('#modalEditSite').modal('show');
});


$(document).on('click', '#btn_edi', function(){

    let newSite = JSON.parse($(this).attr('data-site'));

    $("#siteFormEdit")[0].reset();
    $('.form-group #id').val(newSite.id);
    $('.form-group #site_regions').val(newSite.region);
    $('.form-group #sites').val(newSite.name);
    $('.form-group #site_types').val(newSite.type_id);
});


$(document).on('click', '#btnDelete', function(){
    let users = JSON.parse($(this).attr('data-users'));
    let site = JSON.parse($(this).attr('data-site'));
    let incidents = JSON.parse($(this).attr('data-incidents'));

    let good = true;
    let bon = true;

    users.forEach(user => {
        if(user.site_id == site.id){
            good = false;
        }
    });

    incidents.forEach(incident => {
        if(incident.site_id == site.id){
            bon = false;
        }
    });

    if(good && bon){
        if(confirm("Voulez-Vous Vraiment Supprimer Ce Site "+ site.name +" ?") == true){
                $.ajax({
                    type: 'DELETE',
                    url: 'deleteSite',
                    data: { id: site.id},
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(){
                        location.reload();
                    }
            })
        }
    }else{
        $('#validation_del').val("Vous Ne Pouvez Pas Supprimer Ce Site "+ site.name +" Car Il Est Associé A Des Utilisateurs Et Ou A Des Incidents !");
        $('#errordel').attr('data-backdrop', 'static');
        $('#errordel').attr('data-keyboard', false);
        $('#errordel').modal('show');    
    }
});



$('#btnEditSite').on('click', function(){

    let good = true;
    let message = "";

    if(!$('#site_regions').val()){
        good = false;
        message += "Veuillez Choisir La Région Du Site !\n";
    }

    if(!$('#site_types').val()){
        good = false;
        message += "Veuillez Choisir Un Type De Site !\n";
    }

    if(!$('#sites').val().trim()){
        good = false;
        message += "Veuillez Renseigner Un Site !\n";
    }
    
    if(!good){
            good = false;
            $('#validation_edit').val(message);
            $('#modalEditSite').modal('hide');
            $('#error_edit').attr('data-backdrop', 'static');
            $('#error_edit').attr('data-keyboard', false);
            $('#error_edit').modal('show');
    }else{
            $.ajax({
                type: 'PUT',
                url: 'editSite',
                data: $('#siteFormEdit').serialize(),
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                    if(data.length == 1){
                        location.reload();
                    }else{
                        alert("Veuillez Modifier Votre Site Car Déja Existant !");
                    }
                }
            })
    }
});

$(document).on('click', '#btnClose', function(){
    location.reload();
});

$(function() { 
    $('#btnClose, #btnExit').click(function() { 
        $('#siteFormInsert')[0].reset();
    }); 
}); 

$(document).ready(function(){
    $('#btnExit_site').on('click', function(){
        $('#siteFormEdit')[0].reset();
    });
})

$(document).on('click', '#ajouttyp', function(){
    $('#modalSite').modal('hide');
    $('#modalType').attr('data-backdrop', 'static');
    $('#modalType').attr('data-keyboard', false);
    $('#modalType').modal('show');
});


$(document).on('click', '#Klos', function(){
    $('#modalType').modal('hide');
    $('#modalSite').attr('data-backdrop', 'static');
    $('#modalSite').attr('data-keyboard', false);
    $('#modalSite').modal('show');
});