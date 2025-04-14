<x-app-layout>
    @if(!$client)
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Bienvenue sur Compawnion, vous pouvez maintenant créer votre profil !') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mt-4">
                            <x-input-label for="name" :value="__('Nom')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Prénom')" />

                            <x-text-input id="password" class="block mt-1 w-full"
                                type="text"
                                name="first_name"
                                required autocomplete="first name" />

                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                        </div>

                        <div class="mt-4" x-data="{ maxDate: '' }" x-init="
                                const today = new Date();
                                today.setFullYear(today.getFullYear() - 18);
                                maxDate = today.toISOString().split('T')[0];
                            ">
                            <x-input-label for="date_of_birth" :value="__('Date de naissance')" />

                            <input
                                x-bind:max="maxDate"
                                id="date_of_birth"
                                class="block mt-1 w-full bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                type="date"
                                name="date_of_birth"
                                required
                                autocomplete="bday" />

                            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                        </div>

                        <!-- <div class="mt-4">
                            <x-input-label for="address" :value="__('Adresse')" />

                            <x-text-input id="address" class="block mt-1 w-full"
                                type="text"
                                name="address"
                                required autocomplete="address" />

                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div> -->

                        <div class="mt-4 grid grid-cols-4 gap-2">
                            <div>
                                <x-input-label for="street" :value="__('Rue')" />
                                <x-text-input id="street" class="mt-1 w-full" type="text" name="street" required />
                            </div>
                            <div>
                                <x-input-label for="postal_code" :value="__('Code Postal')" />
                                <x-text-input id="postal_code" class="mt-1 w-full" type="text" name="postal_code" required />
                            </div>
                            <div>
                                <x-input-label for="city" :value="__('Ville')" />
                                <x-text-input id="city" class="mt-1 w-full" type="text" name="city" required />
                            </div>
                            <div>
                                <x-input-label for="country" :value="__('Pays')" />
                                <x-text-input id="country" class="mt-1 w-full" type="text" name="country" value="France" readonly />
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="type_client" :value="__('Vous êtes')" />

                            <select id="type_client" name="type_client" required
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500
                                    bg-white text-dark-900 dark:bg-gray-900 dark:border-dark-600">
                                <option value="">-- Sélectionnez --</option>
                                <option value="client">Un(e) client(e)</option>
                                <option value="petsitter">Un(e) Pet Sitter</option>
                                <option value="specialist">Un(e) spécialist(e)</option>
                            </select>

                            <x-input-error :messages="$errors->get('type_client')" class="mt-2" />
                        </div>

                        <div id="identity_document_field" class="mt-4 hidden">
                            <x-input-label for="piece_identite" :value="__('Pièce d\'identité (recto/verso)')" />
                            <input type="file" id="identity_document" name="identity_document"
                                class="block mt-1 w-full text-sm text-gray-900 dark:text-white
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-green-500 file:text-white
                                    hover:file:bg-green-700
                                    dark:file:bg-green-500 dark:hover:file:bg-green-600
                                    cursor-pointer" required />
                            <x-input-error :messages="$errors->get('piece_identite')" class="mt-2" />
                        </div>

                        <div id="petsitter_certificate_acaced_field" class="mt-6 hidden">
                            <x-input-label for="petsitter_certificate_acaced" :value="__('Attestation de Connaissances pour les Animaux de Compagnie (ACACED)')" />
                            <input type="file" id="petsitter_certificate_acaced" name="petsitter_certificate_acaced"
                                class="block mt-1 w-full text-sm text-gray-900 dark:text-white
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-green-500 file:text-white
                                    hover:file:bg-green-700
                                    dark:file:bg-green-500 dark:hover:file:bg-green-600
                                    cursor-pointer" required />
                            <x-input-error :messages="$errors->get('petsitter_certificate_acaced')" class="mt-2" />
                        </div>

                        <div id="attestation_field" class="mt-4 hidden">
                            <x-input-label for="attestation" :value="__('Attestation')" />
                            <input type="file" id="attestation" name="attestation"
                                class="block mt-1 w-full text-sm text-gray-900 dark:text-white
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-green-500 file:text-white
                                hover:file:bg-green-700
                                dark:file:bg-green-500 dark:hover:file:bg-green-600
                                cursor-pointer" required />
                            <x-input-error :messages="$errors->get('attestation')" class="mt-2" />
                        </div>

                        <script src="{{ asset('js/dashboard-file-input-required.js') }}"></script>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Créer') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @elseif (auth()->user()->client && auth()->user()->client->type_client === 'client')
    @include('client.index-client', ['petsitters' => $petsitters])
    @elseif (auth()->user()->client && auth()->user()->client->type_client === 'petsitter')
    <br><br><br><br> @include('petsitter.index-petsitter')
    @elseif (auth()->user()->client && auth()->user()->client->type_client === 'specialist')
    <h5>Votre profil [specialist] est créé</h5>
    @endif

</x-app-layout>