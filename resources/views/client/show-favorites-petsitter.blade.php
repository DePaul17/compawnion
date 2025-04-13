<x-app-layout>
    <div class="flex h-screen">
        <!-- Colonne de gauche : Détails du petsitter -->
        <div class="w-3/5 bg-white dark:bg-gray-800 p-6 overflow-y-auto">
            <div class="bg-white dark:bg-gray-700 rounded-xl shadow-md p-6">
                <!-- En-tête avec image et informations basiques -->
                <div class="flex items-center">
                    <img src="{{ $petsitter->picture ? asset('storage/' . $petsitter->picture) : asset('images/utilisateur.png') }}"
                        alt="Petsitter"
                        class="w-24 h-24 rounded-full object-cover border border-gray-300">
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $petsitter->first_name }}</h2>
                        <p class="text-gray-500 dark:text-gray-300">
                            {{ json_decode($petsitter->address, true)['city'] ?? '' }}
                        </p>
                        <!-- Par exemple, une note en dur pour l'instant -->
                        <p class="text-yellow-500">⭐ 1.0</p>
                    </div>
                </div>

                <!-- Section Disponibilités -->
                @if ($petsitter->disponibilities->count())
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Disponibilités</h3>
                    <ul class="list-disc list-inside mt-2">
                        @foreach ($petsitter->disponibilities as $dispo)
                        <li class="mb-2">
                            <!-- Jours -->
                            <div class="mb-1">
                                @foreach ((array) $dispo->day as $day)
                                @php
                                $days = [
                                'Monday' => 'Lundi',
                                'Tuesday' => 'Mardi',
                                'Wednesday' => 'Mercredi',
                                'Thursday' => 'Jeudi',
                                'Friday' => 'Vendredi',
                                'Saturday' => 'Samedi',
                                'Sunday' => 'Dimanche'
                                ];
                                @endphp
                                <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold mr-1 px-2 py-0.5 rounded dark:bg-green-900 dark:text-green-100">
                                    {{ $days[$day] ?? $day }}
                                </span>
                                @endforeach
                            </div>
                            <!-- Heures -->
                            <div class="mb-1">
                                @foreach ((array) $dispo->hours as $hour)
                                @php
                                $hoursTranslation = [
                                'morning' => 'Matin',
                                'afternoon' => 'Après-midi',
                                'evening' => 'Soir'
                                ];
                                @endphp
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium mr-1 px-2 py-0.5 rounded dark:bg-blue-900 dark:text-blue-100">
                                    {{ $hoursTranslation[$hour] ?? $hour }}
                                </span>
                                @endforeach
                            </div>
                            <!-- Remarques -->
                            @if (!empty($dispo->remarks))
                            <div class="text-xs text-gray-500 dark:text-gray-400 italic">
                                {{ $dispo->remarks }}
                            </div>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Section Animaux gardés -->
                @if ($petsitter->keptAnimals->count())
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Animaux gardés</h3>
                    <ul class="space-y-2 mt-2">
                        @foreach ($petsitter->keptAnimals as $animal)
                        <li class="bg-gray-100 dark:bg-gray-800 p-2 rounded-md shadow-sm">
                            <div class="flex flex-col">
                                <span class="font-medium text-gray-800 dark:text-gray-100">
                                    {{ ucfirst($animal->animal_type) }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    Taille : {{ ucfirst($animal->animal_size) }} | Max : {{ $animal->max_animals }}
                                </span>
                                @if (!empty($animal->special_conditions))
                                <span class="text-xs text-neutral-950 dark:text-orange-400 italic mt-1">
                                    {{ $animal->special_conditions }}
                                </span>
                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>

        <!-- Colonne de droite : Carte Google -->
        @php
        $address = json_decode($petsitter->address, true);
        $city = !empty($address['city']) ? $address['city'] : 'Paris';
        $cityEncoded = urlencode($city);
        @endphp

        <div class="w-2/5 h-full">
            <iframe
                src="https://maps.google.com/maps?q={{ $cityEncoded }}&center={{ $cityEncoded }}&t=&z=13&ie=UTF8&iwloc=&output=embed"
                width="100%"
                height="100%"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                class="rounded-none">
            </iframe>
        </div>
    </div>
    <div class="mt-auto">
        @include('components.footer-connected')
    </div>
</x-app-layout>