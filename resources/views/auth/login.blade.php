<x-guest-layout>
        <div style="margin-top: 8rem;"></div>
        <x-auth-session-status class="mb-2" :status="session('status')" />

        <!-- Validation Errors -->

        @if(count($errors) > 0 )
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <ul class="p-0 m-0" style="list-style: none;">
                        @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
        @endif

        <div style="width:800px; margin:0 auto;">
            <div style="margin-top:2em; margin-bottom: 1em; text-align:center;">
                    <h4 style="font-weight:bold;">
                        <span style="color:#1F541D; font-size:30px; font-family: Century Gotic;">SOREPCO. SA</span>
                    </h4>
                    <span style="color:#1F541D; font-size:20px; font-family:Brush Script MT;">Toujours les meilleurs prix.</span></br></br>
                    <h7 style="color: white; font-size:20px;">Avec Tracking-Incident Manager  et suivez </br>plus objectivement les Incidents à l’échelle du groupe Sorepco</h7>
            </div>
            <div style="border: 1px solid; padding-left: 80px; padding-top:25px; padding-bottom:25px; box-shadow: 10px 15px;">
                <p style="color:white; font-family: Century Gothic; font-size: 30px; margin-bottom:1em; text-align:center;">
                    TRACKING-INCIDENT
                </p>
                <form method="POST" action="{{ route('login') }}" style="margin-left:4em;">
                    @csrf
                    <!-- Nom Utilisateur -->
                    <div>
                        <div class="row">
                            <label style="font-size: 15px; margin-left:1rem; color:white; font-family: Century Gothic;" for="login">Nom Utilisateur</label>
                        </div>

                        <x-input style="width:32rem;font-family: Century Gothic; border-radius: 3em;" id="login" for="login" class="mt-1" type="text" name="login" :value="old('login')" required autofocus autocomplete="off"/>
                    </div>
                    

                    <!-- Password -->
                    <div class="mt-4">
                        <div class="row">
                            <label style="font-size: 15px; margin-left:1rem; color:white; font-family: Century Gothic;" for="password">Mot De Passe</label>
                        </div>
                        <x-input style="width:32rem; border-radius: 3em;" id="password" for="password" class="mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input style="border-radius: 15px;" id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                            <span style="font-size: 15px; color:white; font-family: Century Gothic;" class="ml-2 text-gray-600">{{ __('Se Souvenir De Moi') }}</span>
                        </label>
                    </div>

                    <div style="width:32rem;" class="flex items-center justify-end mt-4">
                        <x-button style="font-family: Century Gothic;">
                            {{ __('Connexion') }}
                        </x-button>
                    </div>
                     <!-- <div class="flex items-center justify-start mt-4" style="font-family: Century Gothic;">
                        @if (Route::has('password.request'))
                            <a style="font-weight: bold;" class="underline text-lg text-white hover:text-gray-900" href="{{ route('password.request') }}">
                                {{ __('Mot De Passe Oublier ?') }}
                            </a>
                        @endif
                    </div> -->

                    
                    <!-- <div class="flex items-center justify-start mt-4" style="font-family: Century Gothic;">
                            <button type="button" style="background-color: black; color:white; width:120px; height:40px; border-radius: 6px;" onclick="window.location='{{ url('/') }}'">
                                <i class="fa fa-reply fa-lg mr-2"></i>
                                <span class="mr-2">{{ __('RETOUR') }}</span>
                            </button>
                    </div> -->
                    <!-- <div class="mt-8">
                        <p style="color:white; font-family: Century Gothic;">
                            {{ __('Pas De Compte ?') }}
                            <a href="{{ url('register') }}" style="padding: 8px; border-radius:5px; background-color:#374151; color:white;" class="ml-3">
                            {{ __('Créer Un Compte') }}
                            </a>
                        </p>
                    </div> -->
                </form>
            </div>
        </div>
        
</x-guest-layout>