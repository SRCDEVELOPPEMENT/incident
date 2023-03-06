$('#btnSaveRole').on('click', function(){

    let good = true;
    let message = "";

    if(!$('#role').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Rôle !\n";
    }
    
    if(!$('#description').val().trim()){
        good = false;
        message+="Veuillez Renseigner Une Description !\n";
    }

    if(!good){
        good = false;
        $('#modalRole').modal('hide');
        $('#validation').val(message);
        $('#errorvalidationsModals').attr('data-backdrop', 'static');
        $('#errorvalidationsModals').attr('data-keyboard', false);
        $('#errorvalidationsModals').modal('show');
    }else{
        $.ajax({
        type: 'POST',
        url: "createRole",
        data: $('#roleFormInsert').serialize(),
         headers:{
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
        success: function(data){
            if(data.length == 2){
                let role = data[0];
                $('#dataTable-1').prepend(`
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input">
                            <label class="custom-control-label"></label>
                        </div>
                    </td>
                    <td></td>
                    <td> ${role.name} </td>
                    <td>
                        <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="text-muted sr-only">Action</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            @can('editer-role')
                                <a class="dropdown-item" href="{{ route('roles.edit',${role.id}) }}">Editer</a>
                            @endcan

                            @can('supprimer-role')
                                <a 
                                    class="dropdown-item" 
                                    href="#" id="btnDelete" 
                                    >
                                    Supprimer
                                </a>
                            @endcan
                        </div>
                    </td>
                </tr>
                `)
                location.reload();
            }else{
                $('#validation').val(data[0]);
                $('#modalRole').modal('hide');
                $('#errorvalidationsModals').attr('data-backdrop', 'static');
                $('#errorvalidationsModals').attr('data-keyboard', false);
                $('#errorvalidationsModals').modal('show');        
            }
        }                
     })
    }    
});

$(document).on('click', '#btn_edi', function(){
    let role = JSON.parse($(this).attr('data-role'));
    $('#id').val(role.id);
    $('#roles').val(role.name);
    $('#descriptions').val(role.description);
});

$(document).on('click', '#btnEditRole', function(){
    let good = true;
    let message = "";

    if(!$('#roles').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Rôle !\n";
    }
    
    if(!$('#descriptions').val().trim()){
        good = false;
        message+="Veuillez Renseigner Une Description !\n";
    }

    if(!good){
        good = false;
        $('#modalEdit').modal('hide');
        $('#validation_edit').val(message);
        $('#role_edit').attr('data-backdrop', 'static');
        $('#role_edit').attr('data-keyboard', false);
        $('#role_edit').modal('show');
    }else{
        $.ajax({
            type: 'PUT',
            url: 'editRole',
            data: $('#roleFormEdit').serialize(),
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(){
                    location.reload();
            }
        })
    }

});

$(document).on('click', '#btn_attribution', function(){
    $.ajax({
        type: 'get',
        url: 'editPermissionRole',
        data: {
            id: $(this).attr('data-id'),
        },
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data){
            console.log(data[1])
            $('#tbodys').append(`
                <?php
                    for ($i=0; $i < count(${data[1]}); $i++) {
                        $permission = ${data[1]}[$i];
                        <tr>
                            <td>
                                <li style="list-style-type:none;">
                                        <label for="checkid" style="word-wrap:break-word;">
                                        <input style="vertical-align:middle; font-size:25px; margin-right:1em;" id="checkid"  type="checkbox" value="test" />testdata
                                        </label>
                                </li>
                            </td>
                            <td>
                                ${data[0].description}
                            </td>
                        </tr>
                    }
                ?>
            `);
        }
    })

    $('#id_role').val($(this).attr('data-id'));
    $('#ril').replaceWith(`<span class="badge badge-success" id="ril">${$(this).attr('data-intituleRole')}</span>`)
});

$(document).on('click', '#dismiss_btn_rol', function(){
    $('#errorvalidationsModals').modal('hide');
    $('#modalRole').attr('data-backdrop', 'static');
    $('#modalRole').attr('data-keyboard', false);
    $('#modalRole').modal('show');
});


$(document).on('click', '#btnExit', function(){
    location.reload();
});

$(function() {
    $('#btnFermer').click(function() {
        $('#roleFormInsert')[0].reset();
    });
}); 


$(function() {
    $('#btnLock').click(function() {
        $('#permissionFormInsert')[0].reset();
    });
}); 


$(document).on('click', '#btnDelete', function(){
    if(confirm("Voulez-Vous Vraiment Supprimer Ce Role : "+ $(this).attr('data-intituleRole') +" ?") == true){
            $.ajax({
                type: 'GET',
                url: 'deleteRole',
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

$(document).on('click', '#btnFermer', function(){
    $('#form_roles_add')[0].reset();
});

$(document).on('click', '#btnattrPerm', function(){
    $.ajax({
        type: 'PUT',
        url: 'setPermissionRole',
        data: $('#permissionFormInsert').serialize(),
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data){
            if(data.length > 1){
                location.reload();
            }else{
                alert(data[0]);
            }
        }
    })
});

$(document).on('click', '#dismiss_editions', function(){
    $('#role_edit').modal('hide');
    $('#modalEdit').attr('data-backdrop', 'static');
    $('#modalEdit').attr('data-keyboard', false);
    $('#modalEdit').modal('show');
});