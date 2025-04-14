<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informations du profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Mettez à jour les informations de profil et l'adresse e-mail de votre compte.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="flex items-center space-x-4">
            <div class="relative w-24 h-24">
                <img 
                    id="image-preview"
                    src="{{ auth()->user()?->client?->picture ? asset('storage/' . auth()->user()->client->picture) : asset('images/utilisateur.png') }}"
                    alt="Photo de profil" 
                    class="object-cover w-full h-full rounded-full"
                >

                @if(auth()->user()?->client?->picture)
                    <form action="{{ route('profile.delete-image') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Changer type="button" en type="submit" -->
                        <button type="submit" id="delete-image" class="absolute top-0 right-0 bg-red-500 text-white p-1 rounded-full hover:bg-red-600" title="Supprimer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                            </svg>
                        </button>
                    </form>
                @endif
            </div>

            <div>
                <x-input-label for="photo" :value="__('Photo de profil')" />
                <input 
                    id="photo" 
                    name="picture" 
                    type="file" 
                    accept="image/*" 
                    class="block mt-1 w-full text-sm text-gray-900 dark:text-white
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-green-500 file:text-white
                        hover:file:bg-green-700
                        dark:file:bg-green-500 dark:hover:file:bg-green-600
                        cursor-pointer"
                >
                <x-input-error class="mt-2" :messages="$errors->get('picture')" />
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('Nom')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $client->name ?? '')" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Prénom')" />
            <x-text-input id="name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $client->first_name ?? '')" required autofocus autocomplete="first_name" />
            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>

        @php
            $maxDate = \Carbon\Carbon::now()->subYears(18)->format('Y-m-d');
        @endphp

        <div>
            <x-input-label for="date_of_birth" :value="__('Date de naissance')" />

            <x-text-input
                id="date_of_birth"
                name="date_of_birth"
                type="date"
                class="mt-1 block w-full"
                :value="old('date_of_birth', $client->date_of_birth ?? '')"
                :max="$maxDate"
                required
                autocomplete="bday" />

            <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" />
        </div>

        {{-- <div>
            <x-input-label for="name" :value="__('Adresse')" />
            <x-text-input id="name" name="address" type="text" class="mt-1 block w-full" :value="old('adress', $client->address ?? '')" required autofocus autocomplete="adress" />
            <x-input-error class="mt-2" :messages="$errors->get('adress')" />
        </div> --}}

        <div class="mt-4 grid grid-cols-4 gap-2">
            <div>
                <x-input-label for="street" :value="__('Rue')" />
                <x-text-input id="street" class="mt-1 w-full" type="text" name="street" :value="old('street', optional(json_decode($client->address, true))['street'] ?? '')" required />
            </div>
            <div>
                <x-input-label for="postal_code" :value="__('Code Postal')" />
                <x-text-input id="postal_code" class="mt-1 w-full" type="text" name="postal_code" :value="old('street', optional(json_decode($client->address, true))['postal_code'] ?? '')"  required />
            </div>
            <div>
                <x-input-label for="city" :value="__('Ville')" />
                <x-text-input id="city" class="mt-1 w-full" type="text" name="city" :value="old('street', optional(json_decode($client->address, true))['city'] ?? '')" required />
            </div>
            <div>
                <x-input-label for="country" :value="__('Pays')" />
                <x-text-input id="country" class="mt-1 w-full" type="text" name="country" value="France" readonly />
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('Vous êtes ?')" />
            <x-text-input id="name" name="type_client" type="text" class="mt-1 block w-full" :value="old('type_client', $client->type_client ?? '')" required autofocus autocomplete="type_client" disabled />
            <x-input-error class="mt-2" :messages="$errors->get('type_client')" />
        </div>
        <!-- Input type_client -->
        <div>
            <x-text-input id="name" name="type_client" type="text" class="" :value="old('type_client', $client->type_client ?? '')" required autofocus autocomplete="type_client" hidden />
            <x-input-error class="mt-2" :messages="$errors->get('type_client')" />
        </div>


        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email ?? '')" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    {{ __('Votre adresse e-mail n\'est pas vérifiée.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        {{ __('Cliquez ici pour renvoyer l\'e-mail de vérification.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ __('Un nouveau lien de vérification a été envoyé à votre adresse e-mail.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="flex items-center gap-4 mt-5">
            <x-primary-button>{{ __('Sauvegarder') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600 dark:text-gray-400">{{ __('Sauvegardé.') }}</p>
            @endif
        </div>
    </form>
</section>

<!-- Script pour voir l'image -->
<script>
    document.getElementById('photo').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('delete-image').addEventListener('click', function() {
        document.getElementById('image-preview').src = "{{ asset('images/utilisateur.png') }}";
        document.getElementById('photo').value = "";
    });

    document.getElementById('delete-image').addEventListener('click', function(event) {
        event.preventDefault();
        if (confirm("Voulez-vous vraiment supprimer cette image ?")) {
            document.getElementById('image-preview').src = "{{ asset('images/utilisateur.png') }}";
            document.getElementById('photo').value = "";
        }
    });
</script>