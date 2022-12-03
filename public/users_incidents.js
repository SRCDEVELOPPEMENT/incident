$(document).on('click', 'button[name="chanceux"]', function(){
console.log($('#users_s').val())
    if($('select[name="users_s"]').val()){
        $.ajax({
            type: 'POST',
            url: 'assign_user',
            data: {
                number: $(this).attr('data-incident_number'),
                id_user: $('select[name="users_s"]').val(),
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
        alert('Veuillez Sélèctionner Un Utilisateur !');
    }
});