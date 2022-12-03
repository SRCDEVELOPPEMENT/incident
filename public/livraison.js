$('#btnAddLivraison').on('click', function(){
    let reg =  /^[^a-z\^A-Z\^`~!@#$%^&*()_+={}\[\]|\\:;“’<,>.?๐฿]+$/;
    let good = true;
    let message = "";

    if(!$('#type_delivery').val().trim()){
        good = false;
        message+="Veuillez Séléctionner Un Type De Livraison !\n";
    }
    if(!$('#order_number').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Numéro De Bon De Commande !\n";
    }
    if(!$('#delivery_date').val().trim()){
        good = false;
        message+="Veuillez Renseigner Une Date De Livraison !\n";
    }else{
        let date_saisi = $('#delivery_date').val().split('-')[0] +""+ $('#delivery_date').val().split('-')[1] +""+ $('#delivery_date').val().split('-')[2];

        let date_today = new Date ().toISOString ().split ('T')[0];
        let today = date_today.split('-')[0] +""+ date_today.split('-')[1] +""+ date_today.split('-')[2];
        
        if(parseInt(date_saisi) < parseInt(today)){
            good = false;
            message+="Veuillez Renseigner Une Date De Livraison Ultérieure A La Date Actuelle !\n";
        }
    }
    if(!$('#vehicule_id').val().trim()){
        good = false;
        message+="Veuillez Choisir Un Véhicule De Livraison !\n";
    }
    if(!$('#itinerary').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Itinéraire !\n";
    }
    if(!$('#nom_client').val().trim()){
        good = false;
        message+="Veuillez Renseigner Le Nom Du Client !\n";
    }
    if(!$('#phone_client').val().trim()){
        good = false;
        message+="Veuillez Renseigner Le Téléphone Du Client !\n";
    }else{
        if(reg.test($('#phone_client').val())){
            if($('#phone_client').val().length == 9){
                if(parseInt($('#phone_client').val().slice(0, 1)) != 6){
                    good = false;
                    message+="Format Du Numéro De Téléphone Du Destinateur Incorrect !\n";            
                }else{
                    let second = parseInt($('#phone_client').val().slice(1, 2));
                    if(second != 5 && second != 6 && second != 7 && second != 8 && second != 9){
                        good = false;
                        message+="Format Du Numéro De Téléphone Du Destinateur Incorrect !\n";
                    }
                }
            }else{
                good = false;
                message+="Format Du Numéro De Téléphone Du Destinateur Incorrect !\n";        
            }
        }else{
            good = false;
            message+="Format Du Numéro De Téléphone Du Destinateur Incorrect !\n";
        }
    }

    if(!good){
        good = false;
        $('#validation').val(message);
        $('#errorvalidationsModals').attr('data-backdrop', 'static');
        $('#errorvalidationsModals').attr('data-keyboard', false);
        $('#errorvalidationsModals').modal('show');
    }else{
        $('#observation_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="observation_conf">${$('#observation').val().trim()}</span>`);   
        $('#client_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="client_conf">${$('#nom_client').val().trim() +' '+ $('#phone_client').val().trim()}</span>`);   
        $('#itineraire_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="itineraire_conf">${$('#itinerary').val().trim()}</span>`);
        $('#order_number_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="order_number_conf">${$('#order_number').val().trim()}</span>`);
        $('#destination_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="destination_conf">${$("#destination").val()}</span>`);
        $('#tonnage_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="tonnage_conf">${$("#tonnage").val()}</span>`);
        $('#distance_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="distance_conf">${$("#distance").val()}</span>`);
        $('#recette_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="recette_conf">${$("#recipe_id option:selected").text()}</span>`);
        $('#car_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="car_conf">${$("#vehicule_id option:selected").text()}</span>`);
        $('#date_conf').replaceWith(`<span style="color: black; font-size: 20px;" id="date_conf">${$("#delivery_date").val()}</span>`);
        $('#modalConfirmationSaveLivraison').attr('data-backdrop', 'static');
        $('#modalConfirmationSaveLivraison').attr('data-keyboard', false);
        $('#modalConfirmationSaveLivraison').modal('show');
    }    
});


$(document).on('click', '#conf_save_livraison', function(){
    $.ajax({
        type: 'POST',
        url: "createLivraison",
        data: $('#livraisonFormInsert').serialize(),
         headers:{
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
        success: function(data){
            if(data.length == 2){
                $(this).attr('data-livraisons', JSON.stringify(data[1]));

                let livraison = data[0];
                if(livraison){
                    $('#dataTable').prepend(`
                    <tr style="font-size:15px; color:black;">
                        <td><label>${livraison.order_number}</label></td>
                        <td><label></label></td>
                        <td><label></label></td>
                        <td><label>${livraison.state}</label></td>
                        <td><label>${livraison.delivery_date}</label></td>
                        <td><label>${livraison.delivery_amount ? livraison.delivery_amount : '0'}</label></td>
                        <td><label>${livraison.vehicules ? livraison.vehicules.Immatriculation : ''}</label></td>
                        <td><label>${livraison.itinerary}</label></td>
                        <td><label>${livraison.observation ? livraison.observation : ''}</label></td>
                        <td>
                            <div class='row'>
                            <button class="btn btn-sm btn-info mr-2" id="btnEdit"><span class="icon text-white-80"><i class="fas fa-edit"></i></span>Editer</button>
                            <button class="btn btn-sm btn-danger mr-2" id="btnDelete"><span class="icon text-white-80"><i class="fas fa-trash"></i></span>Supprimer</button>
                            </div>
                        </td>
                    </tr>
                    `)
                    $("#livraisonFormInsert")[0].reset();
                    $('#modalConfirmationSaveLivraison').modal('toggle');
                }
            }else{
                $('#validation').val('Veuillez Modifier Votre Région Car Déja Existant !');
                $('#errorvalidationsModals').attr('data-backdrop', 'static');
                $('#errorvalidationsModals').attr('data-keyboard', false);
                $('#errorvalidationsModals').modal('show');        
            }
        }               
        })
});

$(document).on('click', '#btnClose', function(){
    location.reload();
});



$(document).on('click', '#btnEdit', function(){

    let id = $(this).attr('data-id');
    let livraison = JSON.parse($(this).attr('data-livraisons'));
    if(parseInt(livraison.distance) > 0){
        $('#tonnages').prop('disabled', true);
        $('#recipe_ids').prop('disabled', true);
        $('#recipe_ids').append(`<option selected value="">Selectionner Une Recètte</option>`);
    }else{
        $('#distances').prop('disabled', true);
    }

    $("#livraisonFormEdit")[0].reset();
    
    $('.form-group #id').val(id);
    $('.form-group #order_numbers').val(livraison.order_number);
    $('.form-group #states').val(livraison.state);
    $('.form-group #delivery_dates').val(livraison.delivery_date);
    $('.form-group #really_delivery_date').val(livraison.really_delivery_date);
    $('.form-group #destinations').val(livraison.destination);
    $('.form-group #tonnages').val(livraison.tonnage);
    $('.form-group #distances').val(livraison.distance);
    $('.form-group #recipe_ids').val(livraison.recipe_id);
    $('.form-group #vehicule_ids').val(livraison.vehicule_id);
    $('.form-group #nom_clients').val(livraison.nom_client);
    $('.form-group #phone_clients').val(livraison.phone_client);
    $('.form-group #itinerarys').val(livraison.itinerary);
    $('.form-group #observations').val(livraison.observation);

    $('#modalEditlivraison').attr('data-backdrop', 'static');
    $('#modalEditlivraison').attr('data-keyboard', 'false');
    $('#modalEditlivraison').modal('show');

})


$('#btnEditLivraison').on('click', function(){
    let reg =  /^[^a-z\^A-Z\^`~!@#$%^&*()_+={}\[\]|\\:;“’<,>.?๐฿]+$/;
        let good = true;
        let message = "";

        if(!$('#order_numbers').val().trim()){
            good = false;
            message+="Veuillez Renseigner Un Numéro De Bon De Commande !\n";
        }
        if(!$('#delivery_dates').val().trim()){
            good = false;
            message+="Veuillez Renseigner Une Date De Livraison !\n";
        }
        if(!$('#really_delivery_date').val().trim()){
            good = false;
            message+="Veuillez Renseigner La Date Réelle De Livraison !\n";
        }
        if(!$('#itinerarys').val().trim()){
            good = false;
            message+="Veuillez Renseigner Un Itinéraire !\n";
        }
        if(!$('#nom_clients').val().trim()){
            good = false;
            message+="Veuillez Renseigner Le Nom Du Client !\n";
        }
        if(!$('#phone_clients').val().trim()){
            good = false;
            message+="Veuillez Renseigner Le Téléphone Du Client !\n";
        }else{
            if(reg.test($('#phone_clients').val())){
                if($('#phone_clients').val().length == 9){
                    if(parseInt($('#phone_clients').val().slice(0, 1)) != 6){
                        good = false;
                        message+="Format Du Numéro De Téléphone Du Destinateur Incorrect !\n";            
                    }else{
                        let second = parseInt($('#phone_clients').val().slice(1, 2));
                        if(second != 5 && second != 6 && second != 7 && second != 8 && second != 9){
                            good = false;
                            message+="Format Du Numéro De Téléphone Du Destinateur Incorrect !\n";
                        }
                    }
                }else{
                    good = false;
                    message+="Format Du Numéro De Téléphone Du Destinateur Incorrect !\n";        
                }
            }else{
                good = false;
                message+="Format Du Numéro De Téléphone Du Destinateur Incorrect !\n";
            }
        }    
        if(!$('#vehicule_ids').val().trim()){
            good = false;
            message+="Veuillez Choisir Un Véhicule De Livraison !\n";
        }      
        if(!good){
            good = false;
            $('#validation').val(message);
            $('#errorvalidationsModals').attr('data-backdrop', 'static');
            $('#errorvalidationsModals').attr('data-keyboard', false);
            $('#errorvalidationsModals').modal('show');
        }else{
            $.ajax({
                type: 'PUT',
                url: 'editLivraison',
                data: $('#livraisonFormEdit').serialize(),
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                    console.log(data);
                    if(parseInt(data[0]) == 1){
                        location.reload();
                    }else{
                        alert('Veuillez Modifier Votre Livraison Car Déja Existant');
                    }
                }
            })
        }
})


$(document).on('click', '#btnDelete', function(){
    if(confirm("Voulez-Vous Vraiment Supprimer Cette Livraison ?") == true){
        $.ajax({
            type: 'GET',
            url: 'deleteLivraison',
            data: { id: $(this).attr('data-id')},
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(element){
                if(parseInt(element[0]) == 1){
                    location.reload();
                }
            }
    })
    }    
});

$(document).on('input', '#tonnage', function(){
    if($('#tonnage').val() && $('#recipe_id').val()){
        $('#distance').prop('disabled', true);

        let recettes = JSON.parse($('select[id="recipe_id"]').attr('data-r'));
        let rectte_selectionne = recettes.find(r => r.id == $('select[id="recipe_id"]').val())
        let montant = parseInt($('#tonnage').val()) * rectte_selectionne.value;
        $('#vue_amount').val(montant);
    }else{
        $('#vue_amount').val('');
        $('#distance').prop('disabled', false);
    }
});


//edit livraison
$(document).on('input', '#tonnages', function(){
    if($('#tonnages').val() || $('#recipe_id').val()){
        $('#distances').prop('disabled', true);
    }else{
        $('#distances').prop('disabled', false);
    }
});

$(document).on('change', '#recipe_ids', function(){
    if($('#recipe_ids').val()){
        $('#distances').prop('disabled', true);
    }else{
        $('#distances').prop('disabled', false);
    }
});

$(document).on('input', '#distances', function(){
    if($('#distances').val()){
        $('#tonnages').prop('disabled', true);
        $('#recipe_ids').prop('disabled', true);
    }else{
        $('#tonnages').prop('disabled', false);
        $('#recipe_ids').prop('disabled', false);
    }
});

$(document).on('click', '#btnAnnuler', function(){
    $("#livraisonFormInsert")[0].reset();
    $('#modalLivraison').modal('toggle');
    $('#recipe_id').prop('disabled', false);
    $('#distance').prop('disabled', false);
    $('#tonnage').prop('disabled', false);
    $('#vue_amount').prop('disabled', false);
    location.reload();
});

$(document).on('change', '#type_delivery', function(){
    if($(this).val() == 1){
        $('#tonnage').val('');
        $('#tonnage').prop('disabled', true);
        $('#recipe_id').prop('disabled', true);
        $('#recipe_id').append(`<option value="" selected></option>`)
        $('#distance').prop('disabled', true);
        $('#consommation_id').prop('disabled', true);
        
    }else{
        $('#tonnage').prop('disabled', false);
        $('#recipe_id').prop('disabled', false);
        $('#distance').prop('disabled', false);
        $('#consommation_id').prop('disabled', false);
    }
});

$(document).on('change', '#recipe_id', function(){
    if($('#tonnage').val() && $('#recipe_id').val()){
        $('#distance').prop('disabled', true);
        // let recettes = JSON.parse($('select[id="recipe_id"]').attr('data-r'));
        // let rectte_selectionne = recettes.find(r => r.id == $('select[id="recipe_id"]').val())
        // let montant = parseInt($('#tonnage').val()) * rectte_selectionne.value;
        // $('#vue_amount').val(montant);
    }else{
        $('#vue_amount').val('');
        $('#distance').prop('disabled', false);
    }
});



$(document).on('input', '#distance', function(){
    if($('#recipe_id').val() && $('#distance').val()){
        $('#tonnage').prop('disabled', true);

        let recettes = JSON.parse($('select[id="recipe_id"]').attr('data-r'));
        let recette_selectionne = recettes.find(r => r.id == $('select[id="recipe_id"]').val())
        let montant = (parseInt($('#distance').val()) * recette_selectionne.value)/10;
        $('#vue_amount').val(montant);
    }else{
        $('#vue_amount').val('');
        $('#tonnage').prop('disabled', false);
    }
})
