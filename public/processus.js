$('#btn_add_process').on('click', function(){
    
    let good = true;
    let message = "";

    if(!$('#pro_name').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Procéssus !\n";
    }

    if(!good){
        good = false;
        $('#validation').val(message);
        $('#modal_add_processus').modal('hide');
        $('#gaby').attr('data-backdrop', 'static');
        $('#gaby').attr('data-keyboard', false);
        $('#gaby').modal('show');
    }else{
        $.ajax({
            type: 'POST',
            url: "createProcessus",
            data: $('#frmprocessus').serialize(),
             headers:{
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
                success: function(data){
                    if(data.length == 1){
                        let processus = data[0];
                        if(processus){
                            $('#dataTable-1').prepend(`
                                <tr>
                                    <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input">
                                        <label class="custom-control-label"></label>
                                    </div>
                                    </td>
                                    <td></td>
                                    <td>${processus.name}</td>
                                    <td>${processus.description ? processus.description : ''}</td>
                                    <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted sr-only">Action</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">Edit</a>
                                        <a class="dropdown-item" href="#">Remove</a>
                                    </div>
                                    </td>
                                </tr>
                            `)
                            $("#frmprocessus")[0].reset();
                        }
                    }else{
                        $('#validation').val('Veuillez Modifier Votre Catégorie Car Déja Existant !');
                        $('#modal_add_processus').modal('hide');
                        $('#gaby').attr('data-backdrop', 'static');
                        $('#gaby').attr('data-keyboard', false);
                        $('#gaby').modal('show');        
                    }
                }
        });
    }  
});

$(document).on('click', '#dismiss_btn', function(){
    $('#gaby').modal('hide');
    $('#modal_add_processus').attr('data-backdrop', 'static');
    $('#modal_add_processus').attr('data-keyboard', false);
    $('#modal_add_processus').modal('show');
});

$(document).on('click', '#sia_btn', function(){
    $('#sia').modal('hide');
    $('#modal_edit_processus').attr('data-backdrop', 'static');
    $('#modal_edit_processus').attr('data-keyboard', false);
    $('#modal_edit_processus').modal('show');
});

$(document).on('click', '#btnExitp', function(){
    location.reload();
});


$(document).on('click', '#btn_edi_po', function(){

    let processus = JSON.parse($(this).attr('data-pro'));

    $('#id').val(processus.id);
    $('#p_edit').val(processus.name);
    $('#de_edit').val(processus.description);
});


$('#btn_editpr').on('click', function(){

        let good = true;
        let message = "";

        if(!$('#p_edit').val().trim()){
            good = false;
            message+="Veuillez Renseigner Un Procéssus !\n";
        }
        
        if(!good){
            good = false;
            $('#val_sia').val(message);
            $('#modal_edit_processus').modal('hide');
            $('#sia').attr('data-backdrop', 'static');
            $('#sia').attr('data-keyboard', false);
            $('#sia').modal('show');
        }else{
            $.ajax({
                type: 'PUT',
                url: 'editProcessus',
                data: $('#frmedit_pos').serialize(),
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                    if(data.length == 1){
                        location.reload();
                    }else{
                        $('#val_pros').val('Veuillez Modifier Votre Procéssus Car Déja Existant');
                        $('#eren').attr('data-backdrop', 'static');
                        $('#eren').attr('data-keyboard', false);
                        $('#eren').modal('show');
                    }
                }
            })
        }
})


$(document).on('click', '#btnDelete', function(){
    let incidents = JSON.parse($(this).attr('data-incidents'));
    let processus = JSON.parse($(this).attr('data-processus'));

    let good = true;

    incidents.forEach(incident => {
        if(incident.proces_id == processus.id){
            good = false;
        }
    });
    if(good){
        if(confirm("Voulez-Vous Vraiment Supprimer Ce Procéssus "+ processus.name +" ?") == true){
                $.ajax({
                    type: 'DELETE',
                    url: 'deleteProcessus',
                    data: { id: processus.id},
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(data){
                        if(data.length > 0){
                            location.reload();
                        }
                    }
            });
        }
    }else{
        $('#val_pros').val("Vous Ne Pouvez Pas Supprimer Ce Procéssus "+ processus.name +" Car Il Est Associé A Un Incident !");
        $('#eren').attr('data-backdrop', 'static');
        $('#eren').attr('data-keyboard', false);
        $('#eren').modal('show');        
    }
});

$(document).on('click', '#btnExitCat', function(){
    location.reload();
});