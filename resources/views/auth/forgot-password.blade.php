<x-guest-layout>

        <p style="margin-top: 15rem;"></p>

        <div class="mb-4 text-sm text-white" style="font-family: Century Gothic; font-size: 17px;">
            {{ __('Mot de passe oublié ? Aucun problème. Indiquez-nous simplement votre adresse e-mail et nous vous enverrons par e-mail un lien de réinitialisation de mot de passe qui vous permettra d\'en choisir un nouveau.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div style="font-family: Century Gothic;">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4" style="font-family: Century Gothic;">
                <x-button>
                    {{ __('Lien de réinitialisation du mot de passe') }}
                </x-button>
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
