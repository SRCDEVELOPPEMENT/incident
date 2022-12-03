$('#btnSaveSite').on('click', function(){

    let reg =  /^[^a-z\^A-Z\^`~!@#$%^&*()_+={}\[\]|\\:;“’<,>.?๐฿]+$/;

    let good = true;
    let message = "";

    let tab = $('#conf_save_site').attr('data-sites');

    let sites = JSON.parse(tab);

    if(!$('#site').val().trim()){
        good = false;
        message += "Veuillez Renseigner Un Site !\n";
    }

    if(!$('#site_type').val().trim()){
        good = false;
        message += "Veuillez Renseigner Un Type De Site !\n";
    }
    if(!$('#region').val().trim()){
        good = false;
        message += "Veuillez Renseigner Une Région !\n";
    }

    if(!good){
        good = false;
        $('#validation').val(message);
        $('#errorvalidationsModals').attr('data-backdrop', 'static');
        $('#errorvalidationsModals').attr('data-keyboard', false);
        $('#errorvalidationsModals').modal('show');
    }else{
        $('#site_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="site_conf">${$('#site').val().trim()}</span>`);
        $('#region_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="region_conf">${$("#region option:selected").text()}</span>`);
        $('#type_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="type_conf">${$("#site_type").val()}</span>`);
        $('#modalConfirmationSaveSite').attr('data-backdrop', 'static');
        $('#modalConfirmationSaveSite').attr('data-keyboard', false);
        $('#modalConfirmationSaveSite').modal('show');
    }
})

$(document).on('click', '#conf_save_site', function(){
    $.ajax({
        type: 'POST',
        url: 'createSite',
        data: $('#siteFormInsert').serialize(),
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(data){
          if(data.length == 2){
            $(this).attr('data-sites', JSON.stringify(data[1]));

            let site = data[0];
            if(site){
                $('#dataTable').prepend(`
                                <tr style="font-size:15px; color:black;">
                                    <td><label>${site.site_name}</label></td>
                                    <td><label> ${site.site_type} </label></td>
                                    <td><label> ${site.regions.region_name} </label></td>
                                    <td> 
                                        <div class='row'>
                                            <button class="btn btn-sm btn-info btn-icon-split mr-2" data-site=${site} id="btnEdit" data-id=${site.id} data-intituleSite=${site.intituleSite }>
                                                <span class="icon text-white-80">
                                                    <i class="fas fa-lg fa-building"></i>
                                                    <i class="fas fa-sm fa-pen mr-2"></i>
                                                </span>
                                                <span class="text">Editer</span>
                                            </button>

                                            <button class="btn btn-sm btn-danger btn-icon-split" id="btnDelete">
                                                <span class="icon text-white-80">
                                                    <i class="fas fa-lg fa-building"></i>
                                                    <i class="fas fa-sm fa-times"></i>
                                                </span>
                                                <span class="text">Supprimer</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                `);
               $('#siteFormInsert')[0].reset();
               $('#modalConfirmationSaveSite').modal('toggle');
            }
          }else{
            $('#validation').val('Veuillez Modifier Votre Site Car Déja Existant !');
            $('#errorvalidationsModals').attr('data-backdrop', 'static');
            $('#errorvalidationsModals').attr('data-keyboard', false);
            $('#errorvalidationsModals').modal('show');    
          }
        }
    })
})

$(document).on('click', '#btnEdit', function(){

    let newSite = JSON.parse($(this).attr('data-site'));

    $("#siteFormEdit")[0].reset();
    
    $('.form-group #id').val(newSite.id);
    $('.form-group #sites').val(newSite.site_name);
    $('.form-group #regions').val(newSite.region_id);
    $('.form-group #site_types').val(newSite.site_type);
    $('#modalEditSite').attr('data-backdrop', 'static');
    $('#modalEditSite').attr('data-keyboard', 'false');
    $('#modalEditSite').modal('show');
    
})


$(document).on('click', '#btnDelete', function(){
    let users = JSON.parse($(this).attr('data-users'));
    let good = true;

    users.forEach(user => {
        if(user.site_id == $(this).attr('data-id')){
            good = false;
        }
    });
    if(good){
        if(confirm("Voulez-Vous Vraiment Supprimer Ce Site "+ $(this).attr('data-site_name') +" ?") == true){
                $.ajax({
                    type: 'GET',
                    url: 'deleteSite',
                    data: { id: $(this).attr('data-id')},
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(){
                        location.reload();
                    }
            })
        }
    }else{
        $('#validation').val("Vous Ne Pouvez Pas Supprimer Ce Site "+ $(this).attr('data-intituleSite') +" Car Il Est Associé A D'autres Modules !");
        $('#errorvalidationsModals').attr('data-backdrop', 'static');
        $('#errorvalidationsModals').attr('data-keyboard', false);
        $('#errorvalidationsModals').modal('show');        
    }
})



$('#btnEditSite').on('click', function(){

    let good = true;
    let message = "";

    if(!$('#sites').val().trim()){
        good = false;
        message += "Veuillez Renseigner Un Site !\n";
    }

    if(!$('#site_types').val().trim()){
        good = false;
        message += "Veuillez Renseigner Un Type De Site !\n";
    }
    if(!$('#regions').val().trim()){
        good = false;
        message += "Veuillez Renseigner Une Région !\n";
    }
        
    if(!good){
            good = false;
            $('#validation').val(message);
            $('#errorvalidationsModals').attr('data-backdrop', 'static');
            $('#errorvalidationsModals').attr('data-keyboard', false);
            $('#errorvalidationsModals').modal('show');
    }else{
            $.ajax({
                type: 'POST',
                url: 'editSite',
                data: $('#siteFormEdit').serialize(),
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                    if(data.length == 1){
                        $('#siteFormEdit')[0].reset();
                        location.reload();
                    }else{
                        alert("Veuillez Modifier Votre Site Car Déja Existant !");
                    }
                }
            })
    }
})

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