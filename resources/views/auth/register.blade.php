<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="#!">
                <x-application-logo />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}" autocomplete="off">
            @csrf

            <!-- FullName -->
            <div>
                <x-label for="fullname" :value="__('Nom Complèt')"></x-label>
                <x-input id="fullname" class="block mt-1 w-full" type="text" name="fullname" :value="old('fullname')" required autofocus />
            </div>

            <!-- Matricule -->
            <!-- <div>
                <x-label for="matricule" :value="__('Matricule')" />
                <x-input id="matricule" class="block mt-1 w-full" type="text" name="matricule" :value="old('matricule')" required autofocus />
            </div> -->

            <!-- Email Address -->
            <!-- <div>
                <x-label for="email" :value="__('Email')" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" autofocus autocomplete="on"/>
            </div> -->

            <!-- Téléphone -->
            <!-- <div class="mt-4">
                <x-label for="telephone" :value="__('Téléphone')" />
                <x-input id="telephone" class="block mt-1 w-full" type="number" name="telephone" :value="old('telephone')" required />
            </div> -->


            <!-- Site -->
            <!-- <div class="mt-4">
                <x-label for="site_id" :value="__('Site')" />

                <select class="block mt-1 w-full" id="site_id" name="site_id">
                                    <option value="">Selectionnez Un Site</option>
                                    
                                    
                                    
                </select>
            </div> -->

            <!-- Login -->
            <div class="mt-4">
                <x-label for="login" :value="__('Nom Utilisateur')" />

                <x-input id="login" class="block mt-1 w-full" type="text" name="login" required/>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Mot De Passe')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>



            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirmer Le Mot De Passe')" />

                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="on"/>
            </div>


            <!-- Role -->
            <div class="mt-4">
                <x-label for="role" :value="__('Role')" />

                <select class="block mt-1 w-full" id="role" name="roles">
                                    <option value="SuperAdmin">SuperAdmin</option>
                </select>
            </div>


            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Déja Inscrit ?') }}
                </a>
                
                <x-button class="ml-4">
                    {{ __('Inscription') }}
                </x-button>                
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
