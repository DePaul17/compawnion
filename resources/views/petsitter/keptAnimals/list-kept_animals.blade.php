<x-app-layout>

    <body class="bg-gray-100 font-sans">
        <div class="max-w-5xl mx-auto mt-12 bg-white p-8 rounded-2xl shadow-lg">
            <form action="{{ route('kept_animals') }}">
                <button type="submit" class="bg-gray-100 hover:bg-gray-100 text-gray-500 p-2 rounded-md" title="Retour">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </form>

            <!-- Tableau -->
            <div class="mt-5 overflow-x-auto">
                <table class="w-full text-left border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                    <thead class="bg-gray-100">
                        <tr class="text-sm text-gray-700">
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3">Taille</th>
                            <th class="px-4 py-3">Nombre max</th>
                            <th class="px-4 py-3">Conditions</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white text-gray-800">
                        @forelse($keptAnimals as $animal)
                            <tr class="border-t border-gray-200 hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $animal->animal_type }}</td>
                                <td class="px-4 py-3">{{ $animal->animal_size }}</td>
                                <td class="px-4 py-3">{{ $animal->max_animals }}</td>
                                <td class="px-4 py-3">{{ $animal->special_conditions ?? 'Aucune' }}</td>
                                <td class="px-4 py-3 flex gap-2">
                                    <form action="{{ route('kept_animals.edit', $animal->id) }}" method="GET">
                                        <button type="submit" class="bg-green-500 hover:bg-green-300 text-white p-2 rounded-md" title="Editer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6 6L5 21l1.5-6.5L15.232 5.232z" />
                                            </svg>
                                        </button>
                                    </form> 
                                    <form action="{{ route('kept_animals.destroy', $animal->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-md" title="Retirer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                    <!-- Boutons Modifier / Supprimer ici -->
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-4">Aucun animal pour le moment.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </body>
    <div class="mt-20">
        @include('components.footer-connected')
    </div>
</x-app-layout>