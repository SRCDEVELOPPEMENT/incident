$('#btnSaveRole').on('click', function(){

    let good = true;
    let message = "";

    if(!$('#role').val().trim()){
    good = false;
    message+="Veuillez Renseigner Un Rôle !\n";
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
                $('#dataTable').prepend(`
                <tr>
                    <td> ${role.name} </td>
                    <td> 
                        <div class='row'>
                            <button class="btn btn-sm btn-info mr-2" data-id=${role.id} data-role=${ role.name }><span class="icon text-white-80"><i class="fas fa-edit"></i></span>Editer</button>
                            <button class="btn btn-sm btn-danger mr-2"  id="btnDelete" data-id=${role.id}><span class="icon text-white-80"><i class="fas fa-trash"></i></span>Supprimer</button>
                        </div>
                    </td>
                </tr>
                `)
                $("#roleFormInsert")[0].reset();
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

$(document).on('click', '#btnEdit', function(){

    let id = $(this).attr('data-id');
    let role = $(this).attr('data-role');
    let description = $(this).attr('data-description');

    $('.form-group #id').val(id);
    $('.form-group #roles').val(role);
    $('.form-group #Descriptions').val(description ? description : '');

    $('#modalEdit').attr('data-backdrop', 'static');
    $('#modalEdit').attr('data-keyboard', 'false');
    $('#modalEdit').modal('show');

})

$('#btnEditRole').on('click', function(){

    let good = true;
    let message = "";

    if(!$('#roles').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Role !\n";
        }
        
        if(!good){
            good = false;
            alert(message);
        }else{
            $.ajax({
                type: 'POST',
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
})

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