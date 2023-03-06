$(document).on('click', 'button[name="chanceux"]', function(){
    
    if($('#deepartes').val()){

        if($('#deepartes').val() && isNaN($('#deepartes').val())){

            if($('#sity').val()){
                
                //let user_incis = [];
                //let users_incidents = JSON.parse($('#deepartes').attr('data-users_incidents'));

                // for (let e = 0; e < users_incidents.length; e++) {
                //     const ui = users_incidents[e];
                    
                //     if(
                //         (ui.incident_number == $(this).attr('data-incident_number')) &&
                //         (ui.isTrigger === '1')){

                //             user_incis.push(ui);
                //     }
                // }

                let count = 0;
                // for (let index = 0; index < users_incidents.length; index++) {
                //     const ui = users_incidents[index];
                //     if(ui.incident_number == $('select[name="users_s"]').attr('data-number')){
                //         if(ui.user_id == $('select[name="users_s"]').val()){
                //             if(ui.isTrigger === '0'){
                //                 count +=1;
                //             }
                //         }
                //     }
                // }
        
                if(count == 0){

                    $.ajax({

                        type: 'POST',
                        url: 'user_assignation',
                        data: {
                            number: $(this).attr('data-incident_number'),
                            site_id: $('#sity').val(),
                        },
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data){
                            if(data.length > 0 ){
                                location.reload();
                            }
                        }
                    });

                }else{
                    $('#texting_elt').val('Ce Département A Déja été Associé A cette Incident !');
                    $('#assign_incident').modal('hide');
                    $('#assi').attr('data-backdrop', 'static');
                    $('#assi').attr('data-keyboard', false);
                    $('#assi').modal('show');
                }
        
            }else{
                $('#texting_elt').val('Veuillez Choisir Un Site !');
                $('#assign_incident').modal('hide');
                $('#assi').attr('data-backdrop', 'static');
                $('#assi').attr('data-keyboard', false);
                $('#assi').modal('show');        
            }
        }else{
            //let users_incidents = JSON.parse($('select[name="users_s"]').attr('data-users_incidents'));

            let count = 0;
            // for (let index = 0; index < users_incidents.length; index++) {
            //     const ui = users_incidents[index];
            //     if(ui.incident_number == $('select[name="users_s"]').attr('data-number')){
            //         if(ui.user_id == $('select[name="users_s"]').val()){
            //             if(ui.isTrigger === '0'){
            //                 count +=1;
            //             }
            //         }
            //     }
            // }
    
            if(count == 0){

                $.ajax({
                    type: 'POST',
                    url: 'user_assignation',
                    data: {
                        number: $(this).attr('data-incident_number'),
                        departement_id: $('#deepartes').val(),
                    },
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data){
                        if(data.length > 0 ){
                            location.reload();
                        }
                    }
                });

            }else{
                $('#texting_elt').val('Ce Département A Déja été Associé A cette Incident !');
                $('#assign_incident').modal('hide');
                $('#assi').attr('data-backdrop', 'static');
                $('#assi').attr('data-keyboard', false);
                $('#assi').modal('show');
            }
    
        }

    }else{
        $('#texting_elt').val('Veuillez Choisir Un Département !');
        $('#assign_incident').modal('hide');
        $('#assi').attr('data-backdrop', 'static');
        $('#assi').attr('data-keyboard', false);
        $('#assi').modal('show');
    }
});


$(document).on('click', '#close_assine', function(){

    let departements = JSON.parse($('#deepartes').attr('data-departements'));
    let types = JSON.parse($('#deepartes').attr('data-types'));

    $('#nino').remove();

    $('#deepartes').empty().append(`<option selected value="">Choisissez...</option>`);

    for (let r = 0; r < departements.length; r++) {
        const departement = departements[r];
        
        $('#deepartes').append(`<option value="${departement.id}">${departement.name}</option>`);
    }

    for (let r = 0; r < types.length; r++) {
        const type = types[r];
        
        $('#deepartes').append(`<option value="${type.name}">${type.name}</option>`);
    }


});

$(document).on('click', '#btncros', function(){
    $('#assi').modal('hide');
    $('#assign_incident').attr('data-backdrop', 'static');
    $('#assign_incident').attr('data-keyboard', false);
    $('#assign_incident').modal('show');
});


$(document).on('click', '#revocation', function(){

        let mon_entiter = JSON.parse($(this).attr('data-entite'));
        let utilisateur = JSON.parse($(this).attr('data-entite_utilisateur'));

        if(mon_entiter.region){
            $.ajax({
                type: 'DELETE',
                url: "revoke_entiter",
                data: {
                    site: mon_entiter.id,
                    user_id: utilisateur.id,
                    number: $(this).attr('data-number'),
                },
                 headers:{
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                success: function(){
                        location.reload();
                    } 
            });    
    
        }else{
            $.ajax({
                type: 'DELETE',
                url: "revoke_entiter",
                data: {
                    user_id: utilisateur.id,
                    departement: mon_entiter.id,
                    number: $(this).attr('data-number'),
                },
                 headers:{
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                success: function(){
                        location.reload();
                    } 
            });    
    
        }

});

$(document).on('click', '#revocation_modification', function(){
    
    let mon_entiter = JSON.parse($(this).attr('data-entite'));
    let utilisateur = JSON.parse($(this).attr('data-entite_utilisateur'));

    if(mon_entiter.region){
        $.ajax({
            type: 'PUT',
            url: "revoke_modif",
            data: {
                site: mon_entiter.id,
                user_id: utilisateur.id,
                number: $(this).attr('data-number'),
            },
             headers:{
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            success: function(){
                    location.reload();
                } 
        });    

    }else{
        $.ajax({
            type: 'PUT',
            url: "revoke_modif",
            data: {
                user_id: utilisateur.id,
                departement: mon_entiter.id,
                number: $(this).attr('data-number'),
            },
             headers:{
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            success: function(){
                    location.reload();
                }
        });    

    }

});


$(document).on('change', 'select[name="deepartes"]', function(){
    let allSites = [];
    let sites = JSON.parse($(this).attr('data-sites'));
    let types = JSON.parse($(this).attr('data-types'));

    if($(this).val()){
        
        if(isNaN($(this).val())){

            for (let index = 0; index < types.length; index++) {
                const type = types[index];
                if(type.name == $(this).val()){
                    for (let j = 0; j < sites.length; j++) {
                        const site = sites[j];
                        if(site.type_id == type.id){
                            allSites.push(site);
                        }
                    }
                }
            }


            if(allSites.length > 0){

                $('#nino').remove();
                $('#devdocs').append(`
                    <div id="nino" class="form-group my-4">
                        <label for="sity"><span class="fe fe-navigation-2 mr-4"></span>Site De L'incident <span style="color:red;"> *</span></label>
                        <select style="font-size: 1.2em;" data-sites="{{ $sites }}" class="form-control custom-select border-success" id="sity">
                            <option selected value="">Choisissez...</option>
                        </select>
                    </div>
                `);
                for (let i = 0; i < allSites.length; i++) {
                    const sit = allSites[i];
                    $('#sity').append(`<option value="${sit.id}">${sit.name}</option>`);
                }

            }else{

                $('#nino').remove();
                $('#devdocs').append(`
                    <div id="nino" class="form-group my-4">
                        <label for="sity"><span class="fe fe-navigation-2 mr-4"></span>Site De L'incident <span style="color:red;"> *</span></label>
                        <select style="font-size: 1.2em;" data-sites="{{ $sites }}" class="form-control custom-select border-primary" id="sity">
                            <option selected value="">Choisissez...</option>
                        </select>
                    </div>
                `);

                $('#sity').empty().append(`<option value="">AUCUNE OPTION DISPONIBLE</option>`);
            } 

        }else{
            $('#nino').remove();
        }
        
    }else{
        $('#nino').remove();
    }
});
