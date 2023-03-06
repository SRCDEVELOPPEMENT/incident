$('#btnAddPermission').on('click', function(){
    let good = true;
    let message = "";

    if(!$('#name').val().trim()){
    good = false;
    message+="Veuillez Renseigner Une Permission !\n";
    }
    if(!$('#description').val().trim()){
        good = false;
        message+="Veuillez Renseigner Une Description !\n";
    }
    
    if(!good){
        good = false;
        $('#validation').val(message);
        $('#modalPermission').modal('hide');
        $('#errorvalidationsModals').attr('data-backdrop', 'static');
        $('#errorvalidationsModals').attr('data-keyboard', false);
        $('#errorvalidationsModals').modal('show');                  
}else{
        $.ajax({
            type: 'POST',
            url: "createPermission",
            data: $('#permissionFormInsert').serialize(),
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success(data){
                if(data.length == 1){
                    if(data[0]){
                        let permission = data[0];
                        $('#dataTable').prepend(`
                        <tr>
                            <td><label style="font-size:1.1em;">${permission.name}</label></td>
                            <td>
                                <button class="btn btn-sm btn-info btn-icon-split mr-2" id="btnEdit" data-id=${permission.id} data-name=${permission.name}>
                                    <span class="icon text-white-80">
                                        <i class="fas fa-lock-open fa-lg"></i>
                                        <i class="fas fa-sm fa-pen mr-2"></i>
                                    </span>
                                    <span class="text">Editer</span>
                                </button>
                                <button class="btn btn-sm btn-danger btn-icon-split mr-2" id="btnDelete" data-id=${permission.id}>
                                    <span class="icon text-white-80">
                                    <i class="fas fa-lock-open fa-lg"></i>
                                        <i class="fas fa-sm fa-times mr-2"></i>
                                    </span>
                                    <span class="text">Supprimer</span>
                                </button>
                                <button class="btn btn-sm btn-primary btn-icon-split" id="btnView" data-id=${permission.id} data-name=${permission.name}>
                                    <span class="icon text-white-80">
                                    <i class="fas fa-lock-open fa-lg"></i>
                                        <i class="fas fa-sm fa-eye mr-2"></i>
                                    </span>
                                    <span class="text">Vue</span>
                                </button>
                            </td>
                        </tr>
                        `)
                        $("#permissionFormInsert")[0].reset();    
                    }
              }else{
                  $('#validation').val('Veuillez Modifier Votre Permission Car Déja Existant !');
                  $('#errorvalidationsModals').attr('data-backdrop', 'static');
                  $('#errorvalidationsModals').attr('data-keyboard', false);
                  $('#errorvalidationsModals').modal('show');                  
              }
            }
        })
    }

})

$(document).on('click', '#dismiss_btn_perm', function(){
    $('#errorvalidationsModals').modal('hide');
    $('#modalPermission').attr('data-backdrop', 'static');
    $('#modalPermission').attr('data-keyboard', false);
    $('#modalPermission').modal('show');
});


$(document).on('click', '#btnEdit', function(){

    let id = $(this).attr('data-id');
    let name = $(this).attr('data-name');
    let description = $(this).attr('data-description');

    $("#permissionFormEdit")[0].reset();
    
    $('.form-group #id').val(id);
    $('.form-group #names').val(name);
    $('.form-group #descriptions').val(description);

    $('#modalEditPermission').attr('data-backdrop', 'static');
    $('#modalEditPermission').attr('data-keyboard', 'false');
    $('#modalEditPermission').modal('show');

})


$('#btnEditPermission').on('click', function(){

    let good = true;
    let message = "";

    if(!$('#names').val().trim()){
        good = false;
        message+="Veuillez Renseigner Une Permission !\n";
    }
    if(!$('#descriptions').val().trim()){
        good = false;
        message+="Veuillez Renseigner Une Description !\n";
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
                url: 'editPermission',
                data: $('#permissionFormEdit').serialize(),
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                    if(data.length == 1){
                        location.reload();
                    }else{
                        alert('Veuillez Modifier Votre Permission Car Déja Existant');
                    }
                }
            })
    }
})


$(document).on('click', '#btnDelete', function(){
    let namepermission = $(this).attr('data-name');
    
    if(confirm("Voulez-Vous Vraiment Supprimer Cette Permission : "+namepermission+" ?") == true){
            $.ajax({
                type: 'GET',
                url: 'deletePermission',
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

// $(document).on('click', '#btnClose', function(){
//     location.reload();
// });

$(function() { 

    $('#btnreset').click(function() { 
        $('#permissionFormInsert')[0].reset();
    }); 
}); 