$('#btn_add_cate').on('click', function(){
    
    let good = true;
    let message = "";

    if(!$('#cat_name').val().trim()){
        good = false;
        message+="Veuillez Renseigner Une Catégorie !\n";
    }

    if(!$('#dept').val().trim()){
        good = false;
        message+="Veuillez Choisir Un Département !\n";
    }

    if(!good){
        good = false;
        $('#validation').val(message);
        $('#modal_add_categorie').modal('hide');
        $('#Falco').attr('data-backdrop', 'static');
        $('#Falco').attr('data-keyboard', false);
        $('#Falco').modal('show');
    }else{
        $.ajax({
            type: 'POST',
            url: "createCategorie",
            data: $('#frmaddcati').serialize(),
             headers:{
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
                success: function(data){
                    if(data.length == 1){
                        $(this).attr('data-regions', JSON.stringify(data[1]));
        
                        let categorie = data[0];
                        if(categorie){
                            $('#dataTable-1').prepend(`
                                <tr>
                                    <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input">
                                        <label class="custom-control-label"></label>
                                    </div>
                                    </td>
                                    <td></td>
                                    <td>${categorie.name}</td>
                                    <td>${categorie.departements.name}</td>
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
                            $("#frmaddcati")[0].reset();
                        }
                    }else{
                        $('#validation_et').val('Veuillez Modifier Votre Catégorie Car Déja Existant !');
                        $('#modal_add_categorie').modal('hide');
                        $('#jean').attr('data-backdrop', 'static');
                        $('#jean').attr('data-keyboard', false);
                        $('#jean').modal('show');
                    }
                }
            });
     
    }    
});

$(document).on('click', '#dismiss_btn', function(){
    $('#Falco').modal('hide');
    $('#modal_add_categorie').attr('data-backdrop', 'static');
    $('#modal_add_categorie').attr('data-keyboard', false);
    $('#modal_add_categorie').modal('show');
});

$(document).on('click', '#dismibtn', function(){
    $('#jean').modal('hide');
    $('#modal_add_categorie').attr('data-backdrop', 'static');
    $('#modal_add_categorie').attr('data-keyboard', false);
    $('#modal_add_categorie').modal('show');
});

$(document).on('click', '#dismiss_btn_edito', function(){
    $('#editCat').modal('hide');
    $('#categ').attr('data-backdrop', 'static');
    $('#categ').attr('data-keyboard', false);
    $('#categ').modal('show');
});


$('#btnEditregion').on('click', function(){

        let good = true;
        let message = "";

        if(!$('#regions').val().trim()){
            good = false;
            message+="Veuillez Renseigner Une Région !\n";
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
                url: 'editRegion',
                data: $('#regionFormEdit').serialize(),
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                    if(data.length == 1){
                        location.reload();
                    }else{
                        alert('Veuillez Modifier Votre Région Car Déja Existant');
                    }
                }
            })
        }
})


$(document).on('click', '#supp', function(){
    let incidents = JSON.parse($(this).attr('data-incidents'));
    let categorie = JSON.parse($(this).attr('data-categorie'));

    let good = true;

    incidents.forEach(incident => {
        if(parseInt(incident.categorie_id) == parseInt(categorie.id)){good = false;}
    });
    if(good){
        if(confirm("Voulez-Vous Vraiment Supprimer Cette Catégorie : "+ categorie.name +" ?") == true){
                $.ajax({
                    type: 'DELETE',
                    url: 'deleteCategorie',
                    data: { id: categorie.id},
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(data){
                        if(data.length > 0){
                            location.reload();
                        }
                    }
            })
        }
    }else{
        $('#validation_tara').val("Vous Ne Pouvez Pas Supprimer Cette Catégorie : "+ categorie.name +" Car Il Est Associé A Un Incident !");
        $('#tara').attr('data-backdrop', 'static');
        $('#tara').attr('data-keyboard', false);
        $('#tara').modal('show');        
    }
})

$(document).on('click', '#btnClose', function(){
    location.reload();
});

$(function() {
    $('#btnExit').click(function() {
        $('#regionFormInsert')[0].reset();
    });
});

$(document).on('click', '#btnExitCat', function(){
    location.reload();
});

$(document).on('click', '#edit_cati', function(){
    let categorie = JSON.parse($(this).attr('data-cat'));
    $('#id_cat').val(categorie.id);
    $('#cat_names').val(categorie.name);
    $('#depts').val(categorie.departement_id);
});

$(document).on('click', '#btn_edite_cate', function(){
    let good = true;
    let message = "";

    if(!$('#cat_names').val().trim()){
        good = false;
        message+="Veuillez Renseigner Une Catégorie !\n";
    }
    if(!$('#depts').val()){
        good = false;
        message+="Veuillez Choisir Un Département !\n";
    }
    if(!good){
        good = false;
        $('#validationedito').val(message);
        $('#categ').modal('hide');
        $('#editCat').attr('data-backdrop', 'static');
        $('#editCat').attr('data-keyboard', false);
        $('#editCat').modal('show');
    }else{
        $.ajax({
            type: 'PUT',
            url: 'editCategorie',
            data: $('#frmeditscati').serialize(),
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                if(data.length > 0 ){
                    location.reload();
                }
            }
        })
    }
});