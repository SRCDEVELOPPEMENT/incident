$(document).on('click', '#btnType_Site', function(){
    if($('#type_site').val().trim()){
        //let types = JSON.parse($(this).attr('data-types'));
        $.ajax({
            type: 'POST',
            url: 'TypeSite',
            data: {
                name : $('#type_site').val(),
                description : $('#descr').val(),
            },
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                if(data.length == 1){
                    let type = data[0];
                    $('#dataTable-1').append(`
                    <tr style="font-size:15px;">
                        <td><label>${type.name}</label></td>
                        <td>
                            <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted sr-only">Action</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                    <a
                                        id="btn_edi" 
                                        class="dropdown-item" 
                                        href="#"
                                        data-backdrop="static"
                                        data-keyboard="false"
                                        data-toggle="modal"
                                        data-target="#">
                                        <span class="fe fe-edit-2 mr-4"></span>
                                        Edit
                                    </a>
                                    <a
                                        id="btnDelete"
                                        data-users=""
                                        class="dropdown-item" href="#">
                                        <span class="fe fe-x mr-4"></span>
                                        Supprimer
                                    </a>
                            </div>
                        </td>
                    </tr>
                    `)
                    $('#type_site').val('');
                }else{
                    //alert("Veuillez Modifier Votre Site Car Déja Existant !");
                }
            }
        })
    }else{
        $('#validation').val('Veuillez Renseigner Un Type De Site !');
        $('#modalType').modal('hide');
        $('#errorvalidationsModals').attr('data-backdrop', 'static');
        $('#errorvalidationsModals').attr('data-keyboard', false);
        $('#errorvalidationsModals').modal('show');
    }
});

$(document).on('click', '#btnDelete', function(){
    
    if(confirm("Voulez-Vous Vraiment Supprimer Ce Type De Site : "+$(this).attr('data-name')+" ?") == true){
            $.ajax({
                type: 'DELETE',
                url: 'deleteType',
                data: { id: $(this).attr('data-type')},
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(){
                    location.reload();
                }
        })
    }
})


$(document).on('click', '#Klos', function(){
    location.reload();
});

$(document).on('click', '#dismiss_btn1', function(){
    $('#errorvalidationsModals').modal('hide');
    $('#modalType').attr('data-backdrop', 'static');
    $('#modalType').attr('data-keyboard', false);
    $('#modalType').modal('show');
});

