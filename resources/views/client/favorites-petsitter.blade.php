<x-app-layout>
    <div class="flex h-screen">
        <!-- Section liste des favoris -->
        <div class="w-full bg-white dark:bg-gray-800 p-6 overflow-y-auto">
            @if ($favorites->isEmpty())
                <div class="flex flex-col items-center justify-center h-full text-center text-gray-500 dark:text-gray-300">
                    <p class="text-xl font-semibold mb-4">Aucun petsitter ajouté en favori pour le moment.</p>
                    <a href="{{ route('dashboard') }}" class="inline-block px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                        Retour au dashboard
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-2">
                    @foreach ($favorites as $favorite)
                        <!-- tout ton code actuel pour afficher les favoris -->
                    @endforeach
                </div>
            @endif
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-2">
                @foreach ($favorites as $favorite)
                @php
                $petsitter = $favorite->petsitter;
                @endphp
                <a href="{{ route('petsitter.show', $petsitter->id) }}" class="group block">
                    <div class="relative bg-white dark:bg-gray-700 rounded-xl shadow-md p-4 text-center transition transform hover:scale-105">
                        <!-- Bouton pour retirer le favori -->
                        <form action="{{ route('favorites.destroy', $favorite->id) }}" method="POST" class="absolute top-3 right-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="transition p-2 rounded-full bg-red-500 hover:bg-red-600" title="Retirer des favoris">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 stroke-current fill-white" viewBox="0 0 24 24">
                                    <path d="M12 21C12 21 4 13.5 4 8.5C4 6.01472 6.01472 4 8.5 4C10.0858 4 11.5 4.90196 12 6.08197C12.5 4.90196 13.9142 4 15.5 4C17.9853 4 20 6.01472 20 8.5C20 13.5 12 21 12 21Z" />
                                </svg>
                            </button>
                        </form>

                        <!-- Image du petsitter -->
                        <img src="{{ $petsitter->picture ? asset('storage/' . $petsitter->picture) : asset('images/utilisateur.png') }}"
                            alt="Petsitter"
                            class="w-20 h-20 mx-auto rounded-full object-cover border border-gray-300" />

                        <!-- Informations du petsitter -->
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
                                        <span class="font-medium text-gray-800 dark:text-gray-100">
                                            {{ ucfirst($animal->animal_type) }}
                                        </span>
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
    </div>
    <div class="mt-auto">
        @include('components.footer-connected')
    </div>
</x-app-layout>