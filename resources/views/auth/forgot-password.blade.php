<x-guest-layout>

        <p style="margin-top: 8rem;"></p>

        <div class="text-sm text-white" style="font-family: Century Gothic; font-size: 20px;margin-bottom:3em;">
            {{ __('Mot de passe oublié ? Aucun problème. Vous Pouvez Le Reinitialiser.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors  method="POST" action="{{ route('password.email') }}" -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form>
            @csrf
            <!-- Username -->
            <div style="font-family: Century Gothic;">
                <x-label style=" color:white; margin-bottom:1em;" for="password" :value="__('Nom D\'utilisateur')" />

                <x-input style="margin-bottom:1em;" id="username" class="block mt-1 w-full" type="text" name="username" autofocus />
            </div>

            <!-- Password -->
            <div style="font-family: Century Gothic;">
                <x-label style=" color:white; margin-bottom:1em;" for="password" :value="__('Nouveau Mot De Passe')" />

                <x-input style="margin-bottom:1em;" id="password" class="block mt-1 w-full" type="password" name="password" autofocus />
            </div>

            <div style="font-family: Century Gothic;">
                <x-label style=" color:white; margin-bottom:1em;" for="password" :value="__('Confirmer Le Nouveau Mot De Passe')" />

                <x-input id="confirmpassword" class="block mt-1 w-full" type="password" name="password" autofocus />
            </div>

            <div id="btnReset" class="flex items-center justify-end mt-4" style="font-family: Century Gothic;">
                <button style="background-color:black; color:white; padding:0.7em; border-radius:2em;" type="button">
                    {{ __('Réinitialisation Du Mot De Passe') }}
                </button>
            </div>
        </form>
        </br>
        <hr>
        <div class="flex items-center justify-start mt-4" style="font-family: Century Gothic;">
                <button type="button" style="background-color: black; color:white; width:120px; height:40px; border-radius: 6px;" onclick="window.location='{{ url('login') }}'">
                        <i class="fa fa-reply fa-lg mr-2"></i>
                        <span class="mr-2">{{ __('RETOUR') }}</span>
                </button>
        </div>
</x-guest-layout>

<script>
    $(document).ready(function(){
        $(document).on('click', '#btnReset', function(){
            let reg =  /^(?=.*[0-9])(?=.*[a-z])(?=.*[!"#$%&'()*+,-./:;<=>?@[\]^_`{|}~])/;
            let good = true;
            let message = "";

            if(!$('#username').val().trim()){
                good = false;
                message+="Veuillez Renseigner Votre Nom D'utilisateur !\n";
            }
            if(!$('#password').val().trim()){
                good = false;
                message+="Veuillez Renseigner Le Mot De Passe !\n";
            }else{
                if(!$('#confirmpassword').val().trim()){
                    good = false;
                    message+="Veuillez Confirmer Le Mot De Passe !\n";
                }else{
                    if(!($('#password').val().trim() == $('#confirmpassword').val().trim())){
                        good = false;
                        message+="Veuillez Renseigner Des Mot De Passe Identique !\n";
                    }else{
                            if($('#password').val().trim().length < 6){
                                good = false;
                                message+="Votre Mot De Passe Doit Contenir Au Moins 6 Caractères !\n"; 
                            }else{
                                if(!$('#password').val().trim().match(reg)){
                                    good = false;
                                    message+="Le Format De Votre Mot De Passe Est Incorrect, Caractères Spéciaux Requis !\n";     
                                }
                            }
                    }
                }
            }

            if(!good){
                good = false;
                alert(message);
            }else{
                $.ajax({
                    type: 'POST',
                    url: "reinitialize",
                    data: {
                    password: $('#password').val(),
                    username: $('#username').val(),
                    },
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data){
                        if(data.length == 2){
                        //window.location.href = 'http://localhost:8000/login';
                        }
                    } 
                })
            }
        });
    })
</script>