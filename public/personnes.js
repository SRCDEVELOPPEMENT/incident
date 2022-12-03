$('#btnAddPersonne').on('click', function(){

    let reg =  /^[^a-z\^A-Z\^`~!@#$%^&*()_+={}\[\]|\\:;“’<,>.?๐฿]+$/;

    let good = true;
    let message = "";

    let tab = $(this).attr('data-personnes');
    
    let personnes = JSON.parse(tab);

    if(!$('#nom').val().trim()){
    good = false;
    message+="Veuillez Renseigner Un Nom !\n";
    }

    if(!$('#phone').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Numéro De Téléphone !\n";
    }else{
        if(reg.test($('#phone').val())){
        if($('#phone').val().length == 9){
            if(parseInt($('#phone').val().slice(0, 1)) != 6){
                good = false;
                message+="Format Du Numéro De Téléphone Incorrect !\n";            
            }else{
                let second = parseInt($('#phone').val().slice(1, 2));
                if(second != 5 && second != 6 && second != 7 && second != 8 && second != 9){
                    good = false;
                    message+="Format Du Numéro De Téléphone Incorrect !\n";
                }else{
                    let yes = true;
                    personnes.forEach(personne => {
                        if(parseInt(personne.telephone) == parseInt($('#phone').val())){
                            yes = false;
                        }
                    });
                    if(!yes){
                        good = false;
                        message+="Veuillez Changer Le Numéro De Téléphone Car Déja Existant !\n";
                    }
                }
            }
        }else{
            good = false;
            message+="Format Du Numéro De Téléphone Incorrect !\n";        
        }
      }else{
        good = false;
        message+="Format Du Numéro De Téléphone Incorrect !\n";        
      }   
    }

    if($('#matricule').val().trim()){
        let yes = true;
        personnes.forEach(personne => {
            if(personne.matricule == $('#matricule').val().trim()){
                yes = false;
            }
        });
        if(!yes){
            good = false;
            message+="Veuillez Renseigner Un Autre Matricule Car Déja Existant !\n";
        }
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
        url: "createPersonne",
        data: $('#personneFormInsert').serialize(),
         headers:{
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
        success: function(data){

            $('#btnAddPersonne').attr('data-personnes', JSON.stringify(data[1]));
            
            let personne = data[0];
            if(personne){
                $('#dataTable').prepend(`
                <tr style="font-size:15px; color:black;">
                    <td><label>${ personne.fullname }</label></td>
                    <td><label>${ personne.matricule ? personne.matricule : '' }</label></td>
                    <td><label> ${ personne.telephone }</label></td>
                    <td><label> ${ personne.vehicules ? personne.vehicules.Immatriculation : ''} </label></td>
                    <td><label> ${ personne.postes ? personne.postes.intitulePoste : ''} </label></td>
                    <td> 
                        <div class='row'>
                        <button class="btn btn-info" id="btnEdit" data-id=${personne.id} data-telephone=${personne.telephone}  data-fullname=${personne.fullname} data-vehicule_id=${personne.vehicule_id} data-poste_id=${personne.poste_id} data-matricule=${personne.matricule}><span class="icon text-white-80"><i class="fas fa-edit"></i></span></button>
                        <button class="btn btn-danger" id="btnDelete" data-id=${personne.id}><span class="icon text-white-80"><i class="fas fa-trash"></i></span></button>
                        <button class="btn btn-primary" id="btnView" data-id=${personne.id} data-telephone=${personne.telephone}  data-fullname=${personne.fullname} data-vehicule_id=${personne.vehicule_id} data-poste_id=${personne.poste_id} data-matricule=${personne.matricule}><span class="icon text-white-80"><i class="fas fa-eye"></i></span></button>
                        </div>
                    </td>
                </tr>
                `)
                $("#personneFormInsert")[0].reset();
                }
            }                
        })
    }    
});


$(document).on('click', '#btnEdit', function(){

    let id = $(this).attr('data-id');
    let fullname = $(this).attr('data-fullname');
    let telephone = $(this).attr('data-telephone');
    let matricule = $(this).attr('data-matricule');
    let poste = $(this).attr('data-poste_id');
    let vehicule = $(this).attr('data-vehicule_id');

    $("#personneFormEdit")[0].reset();
    
    $('.form-group #id').val(id);
    $('.form-group #noms').val(fullname);
    $('.form-group #phones').val(telephone);
    $('.form-group #matricules').val(matricule);
    $('.form-group #vehicules').val(vehicule);
    $('.form-group #postes').val(poste);
    
    $('#modalEditPersonne').attr('data-backdrop', 'static');
    $('#modalEditPersonne').attr('data-keyboard', 'false');
    $('#modalEditPersonne').modal('show');

})


$('#btnEditPersonne').on('click', function(){

    let reg =  /^[^a-z\^A-Z\^`~!@#$%^&*()_+={}\[\]|\\:;“’<,>.?๐฿]+$/;

    let good = true;
    let message = "";

    let personnes = JSON.parse($('#btnAddPersonne').attr('data-personnes'));

    if(!$('#noms').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Nom !\n";
    }
    if(!$('#phones').val().trim()){
        good = false;
        message+="Veuillez Renseigner Un Téléphone !\n";
    }else{
        if(reg.test($('#phones').val())){
            if($('#phones').val().length == 9){
                if(parseInt($('#phones').val().slice(0, 1)) != 6){
                    good = false;
                    message+="Format Du Numéro De Téléphone Incorrect !\n";            
                }else{
                    let second = parseInt($('#phones').val().slice(1, 2));
                    if(second != 5 && second != 6 && second != 7 && second != 8 && second != 9){
                        good = false;
                        message+="Format Du Numéro De Téléphone Incorrect !\n";
                    }else{
                        let Qte = 0;
                        let array = [];
                        
                        personnes.forEach(personne =>{
                            if(parseInt(personne.id) != parseInt($('#id').val())){
                                array.push(personne);
                            }
                        });
                        array.forEach(personne => {
                            if(parseInt(personne.telephone) == parseInt($('#phones').val())){
                                Qte +=1;
                            }
                        });

                        if(Qte > 0){
                            good = false;
                            message+="Veuillez Changer Le Numéro De Téléphone Car Déja Existant !\n";
                        }
                    }
                }
            }else{
                good = false;
                message+="Format Du Numéro De Téléphone Incorrect !\n";        
            }
        }else{
            good = false;
            message+="Format Du Numéro De Téléphone Incorrect !\n";        
        }
    }

    if($('#matricules').val().trim()){
        let Qte = 0;
        let array = [];
        
        personnes.forEach(personne =>{
            if(parseInt(personne.id) != parseInt($('#id').val())){
                array.push(personne);
            }
        });
        array.forEach(personne => {
            if(personne.matricule == $('#matricules').val().trim()){
                Qte +=1;
            }
        });

        if(Qte > 0){
            good = false;
            message+="Veuillez Changer Le Matricule Car Déja Existant !\n";
        }
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
                url: 'editPersonne',
                data: $('#personneFormEdit').serialize(),
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
    let courriers = JSON.parse($(this).attr('data-courriers'));
    let good = true;
    courriers.forEach(courrier => {
        if(courrier.coursier_id == parseInt($(this).attr('data-id')) ||
           courrier.emetteur_id == parseInt($(this).attr('data-id')) || 
           courrier.recepteur_id == parseInt($(this).attr('data-id')) || 
           courrier.recepteur_effectif_id == parseInt($(this).attr('data-id')) ||
           courrier.chauffeur_id == parseInt($(this).attr('data-id')) ||
           courrier.destinateur_id == parseInt($(this).attr('data-id')))
        {
            good = false;
        }
    });
    if(!good){
        alert("Vous Ne Pouvez Pas Supprimer Cette Personne "+ $(this).attr('data-fullname') +" Car Il Est Associé A D'autres Modules !");
    }else{
        if(confirm("Voulez-Vous Vraiment Supprimer Cette Personne : "+ $(this).attr('data-fullname') +" ?") == true){
                $.ajax({
                    type: 'GET',
                    url: 'deletePersonne',
                    data: { id: $(this).attr('data-id')},
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(){
                        location.reload();
                    }
            })
        }
    }
})

$(document).on('click', '#btnClose', function(){
    location.reload();
})

$(function() { 

    $('#btnClose, #btnExit').click(function() { 
        $('#personneFormInsert')[0].reset();
    }); 
}); 