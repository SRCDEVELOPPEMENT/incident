$(document).on('click', '#btnSaveBattle', function(){
    let good = true;
    let message = "";

    if(!$('#cat1').val().trim()){
        good = false;
        message+="Veuillez Renseigner La Catégorie Du Travail !\n";
    }else{
        if(!$('#description1').val().trim()){
            good = false;
            message+="Veuillez Décrire Le Travail !\n";
        }else{
            if(!$('#cat2').val().trim() && $('#description2').val().trim()){
                good = false;
                message+="Veuillez Renseigner La Catégorie Du Travail 2 !\n";
            }else if($('#cat2').val().trim() && !$('#description2').val().trim()){
                good = false;
                message+="Veuillez Renseigner La Description Du Travail 2 !\n";
            }
        }
    }

    if($('#cat2').val().trim() && !$('#cat1').val().trim()){
        good = false;
        message+="Veuillez Tout D'abord Renseigner Les Informations Du Travail 1 !\n";
    }
    if(!good){
        good = false;
        alert(message);
    }else{
        $.ajax({
            type: 'POST',
            url: "createBattle",
            data: $('#frm_bat').serialize(),
             headers:{
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             success: function(battle){
                if(battle.length > 0){
                    $('#frm_bat')[0].reset();
                    alert('Travail Enrégistré Avec Succèss !');
                }
             }
        })    
    }
});


$(document).on('click', '#bat_boy', function(){
    location.reload();
});

$(document).on('click', '#bnt_battle', function(){
    let number = $(this).attr('data-number');
    $('#num_In').val(number);
});