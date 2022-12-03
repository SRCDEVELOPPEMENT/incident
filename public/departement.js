$(document).on('click', '#btn_add_unique_dept', function(){
    let good = true;
    let message = "";

    if(!$('#dept_name').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Département !\n";
    }

    if(!good){
        good = false;
        $('#validation').val(message);
        $('#modal_add_departement').modal('hide');
        $('#Falco').attr('data-backdrop', 'static');
        $('#Falco').attr('data-keyboard', false);
        $('#Falco').modal('show');
    }else{
        $.ajax({
            type: 'POST',
            url: "createDepartement",
            data: $('#frmdeparts').serialize(),
             headers:{
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             success: function(dept){
                if(dept.length > 0){
                    $('#frmdeparts')[0].reset();
                }else{
                    $('#frmdeparts')[0].reset();
                    alert('Département Déja Existant !');
                }
             }
        })
    }
});

$(document).on('click', '#btn_edi', function(){
    let departement = JSON.parse($(this).attr('data-dept'));
    $('#id').val(departement.id);
    $('#dept_edit').val(departement.name);
});

$(document).on('click', '#btn_edit_unique_dept', function(){
    let good = true;
    let message = "";

    if(!$('#dept_edit').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Département !\n";
    }

    if(!good){
        good = false;
        $('#validation').val(message);
        $('#modal_edit_departement').modal('hide');
        $('#Falco').attr('data-backdrop', 'static');
        $('#Falco').attr('data-keyboard', false);
        $('#Falco').modal('show');
    }else{
        $.ajax({
            type: 'PUT',
            url: "editDepartement",
            data: $('#frmeditdept').serialize(),
             headers:{
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             success: function(dept){
                if(dept.length > 0){
                    location.reload();
                }
             }
        })
    }
});


$(document).on('click', '#dismiss_btn', function(){
    $('#Falco').modal('hide');
    $('#modal_add_departement').attr('data-backdrop', 'static');
    $('#modal_add_departement').attr('data-keyboard', false);
    $('#modal_add_departement').modal('show');
});

$(document).on('click', '#btnDelete', function(){
    let departement = JSON.parse($(this).attr('data-departement'));
    let categories = JSON.parse($(this).attr('data-categories'));

    let good = true;

    categories.forEach(categorie => {
        if(categorie.departement_id == departement.id){
            good = false;
        }
    });
    if(good){
        if(confirm("Voulez-Vous Vraiment Supprimer Ce Département "+ departement.name +" ?") == true){
                $.ajax({
                    type: 'DELETE',
                    url: 'deleteDepartement',
                    data: { id: departement.id},
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
        $('#val_dep').val("Vous Ne Pouvez Pas Supprimer Ce Département "+ $(this).attr('data-intituleSite') +" Car Il Est Associé A Des Catégories !");
        $('#deee').attr('data-backdrop', 'static');
        $('#deee').attr('data-keyboard', false);
        $('#deee').modal('show');        
    }
});

$(document).on('click', '#btnExitModaldepart', function(){
    location.reload();
});