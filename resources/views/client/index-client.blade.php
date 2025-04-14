<body class="bg-zinc-100 dark:bg-zinc-50 text-zinc-50 dark:text-zinc-50 m-0 font-sans">
    <div class="flex h-screen">
        <!-- Section Liste des Petsitters -->
        <div class="w-3/5 p-6 overflow-y-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($petsitters as $petsitter)
                <a href="{{ route('petsitter.show', $petsitter->id) }}" class="group block">
                    <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-md p-4 text-center transition transform hover:scale-105">
                        <!-- Bouton favori -->
                        @php
                        $isFavorite = array_key_exists($petsitter->id, $favorites);
                        @endphp
                        <form action="{{ $isFavorite ? route('favorites.destroy', $favorites[$petsitter->id]) : route('favorites.store') }}" method="POST">
                            @csrf
                            @if ($isFavorite)
                            @method('DELETE')
                            @else
                            <!-- Champ caché pour l'ajout, requis par la validation du controller -->
                            <input type="hidden" name="petsitter_id" value="{{ $petsitter->id }}">
                            @endif

                            <button type="submit" class="absolute top-3 right-3 transition p-2 rounded-full 
                                    {{ $isFavorite ? 'bg-red-500 hover:bg-red-600' : 'bg-green-400 hover:bg-green-500' }}"
                                title="{{ $isFavorite ? 'Retirer des favoris' : 'Ajouter aux favoris' }}">
                                <!-- Icône cœur avec remplissage conditionnel -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 stroke-current {{ $isFavorite ? 'fill-white' : 'fill-transparent' }}" viewBox="0 0 24 24">
                                    <path d="M12 21C12 21 4 13.5 4 8.5C4 6.01472 6.01472 4 8.5 4C10.0858 4 11.5 4.90196 12 6.08197C12.5 4.90196 13.9142 4 15.5 4C17.9853 4 20 6.01472 20 8.5C20 13.5 12 21 12 21Z" />
                                </svg>
                            </button>
                        </form>

                        <!-- Image -->
                        <img src="{{ $petsitter->picture ? asset('storage/' . $petsitter->picture) : asset('images/utilisateur.png') }}"
                            alt="Petsitter"
                            class="w-20 h-20 mx-auto rounded-full object-cover border border-gray-300" />

                        <!-- Infos -->
                        <div class="mt-3">
                            <div class="flex items-center justify-center">
                                <h4 class="text-lg font-semibold">{{ $petsitter->first_name }}</h4>
                                <p class="text-yellow-500 ml-2">⭐ 1.0</p>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-300">
                                {{ json_decode($petsitter->address, true)['city'] ?? '' }}
                            </p>
                        </div>

                        <!-- Disponibilités -->
                        @if ($petsitter->disponibilities->count())
                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                            <strong>Disponibilités :</strong>
                            <ul class="list-disc list-inside">
                                @foreach ($petsitter->disponibilities as $dispo)
                                <li class="text-sm text-gray-700 dark:text-gray-200 mb-2">
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
                                        'Sunday' => 'Dimanche',
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
                                        'evening' => 'Soir',
                                        ];
                                        @endphp
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium mr-1 px-2 py-0.5 rounded dark:bg-blue-900 dark:text-blue-100">
                                            {{ $hoursTranslation[$hour] ?? $hour }}
                                        </span>
                                        @endforeach
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Animaux gardés -->
                        @if ($petsitter->keptAnimals->count())
                        <div class="mt-3 text-sm text-gray-600 dark:text-gray-300 text-left">
                            <strong class="block mb-1">Animaux gardés :</strong>
                            <ul class="space-y-2">
                                @foreach ($petsitter->keptAnimals as $animal)
                                <li class="bg-gray-100 dark:bg-gray-800 p-2 rounded-md shadow-sm">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-800 dark:text-gray-100">{{ ucfirst($animal->animal_type) }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            Taille : {{ ucfirst($animal->animal_size) }} | Max : {{ $animal->max_animals }}
                                        </span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Section Filtres de recherche -->
        <div class="w-2/5 p-6">
            <div class="bg-white dark:bg-gray-800 rounded-md shadow-md p-6 h-[90vh] flex flex-col">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Rechercher un petsitter</h2>

                <form action="" method="GET" class="space-y-6">
                    <!-- Filtre Ville -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ville</label>
                        <input type="text" id="city" name="city" placeholder="Entrez une ville"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                    </div>
                    <!-- Filtre Disponibilité (Jour) -->
                    <div>
                        <label for="day" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jour</label>
                        <select id="day" name="day"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                            <option value="">Tous</option>
                            <option value="Monday">Lundi</option>
                            <option value="Tuesday">Mardi</option>
                            <option value="Wednesday">Mercredi</option>
                            <option value="Thursday">Jeudi</option>
                            <option value="Friday">Vendredi</option>
                            <option value="Saturday">Samedi</option>
                            <option value="Sunday">Dimanche</option>
                        </select>
                    </div>
                    <!-- Filtre Disponibilité (Heure) -->
                    <div>
                        <label for="hour" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Heure</label>
                        <select id="hour" name="hour"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-400 focus:ring focus:ring-green-400 focus:ring-opacity-50">
                            <option value="">Toutes</option>
                            <option value="morning">Matin</option>
                            <option value="afternoon">Après-midi</option>
                            <option value="evening">Soir</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit"
                            class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-500 hover:bg-green-400 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Rechercher
                        </button>
                    </div>
                </form>

                <!-- Image en bas qui prend le reste de la hauteur -->
                <div class="flex-1 mt-6 overflow-hidden rounded-md">
                    <img src="{{ asset('images/about-2.jpg') }}" alt="Animaux"
                        class="w-full h-full object-cover rounded-md" />
                </div>
            </div>
        </div>
    </div>
</body>
<div class="mt-auto">
    @include('components.footer-connected')
</div>