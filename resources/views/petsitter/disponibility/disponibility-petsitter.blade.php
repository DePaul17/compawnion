<x-app-layout>

    <body class="bg-gray-100 min-h-screen p-7">
        @php
        $client = auth()->user()->client;
        $lastDisponibility = $client?->disponibilities()->latest()->first();
        @endphp

        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- FORMULAIRE -->
            <div class="{{ $lastDisponibility ? ' mt-20 col-span-4 md:col-span-3' : 'mt-20 col-span-6 md:col-start-1 md:col-span-4' }} bg-white rounded-xl shadow p-8">
                <h1 class="text-2xl font-bold mb-6">Mes disponibilités</h1>

                <form id="disponibility-form" action="{{ route('disponibilities.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">
                    <input type="hidden" name="id" id="disponibility-id" value="">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jours</label>
                        <div class="flex flex-wrap gap-4">
                            @foreach([
                            'Monday' => 'Lundi',
                            'Tuesday' => 'Mardi',
                            'Wednesday' => 'Mercredi',
                            'Thursday' => 'Jeudi',
                            'Friday' => 'Vendredi',
                            'Saturday' => 'Samedi',
                            'Sunday' => 'Dimanche'
                            ] as $dayValue => $dayLabel)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="days[]" value="{{ $dayValue }}" class="border-gray-300 rounded-md mr-2"> {{ $dayLabel }}
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Créneaux disponibles</label>
                        <div class="flex flex-wrap gap-4">
                            @foreach([
                            'morning' => 'Matin (8h - 12h)',
                            'afternoon' => 'Après-midi (12h - 18h)',
                            'evening' => 'Soir (18h - 22h)'
                            ] as $slot => $label)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="hours[]" value="{{ $slot }}" class="border-gray-300 rounded-md mr-2"> {{ $label }}
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Remarques</label>
                        <textarea id="notes" name="remarks" rows="3" class="w-full p-2 border border-gray-300 rounded-md"></textarea>
                    </div>

                    <div class="text-right">
                        <button type="reset" class="bg-gray-100 text-gray-950 px-4 py-2 rounded-md"><u>Annuler</u></button>
                        <button type="submit" id="form-submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>

            @if($lastDisponibility)
            <!-- RÉSUMÉ -->
            <div class="mt-20 col-span-4 md:col-span-1 bg-white rounded-xl shadow p-6 h-fit">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-700">Résumé</h2>
                    <div class="flex items-center gap-2">
                        <button id="edit-button" class="hover:bg-green-500 text-gray-700 hover:text-white p-2 rounded-md" title="Modifier">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6 6L5 21l1.5-6.5L15.232 5.232z" />
                            </svg>
                        </button>
                        <form action="{{ route('disponibilities.destroy', $lastDisponibility->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="hover:bg-red-700 text-gray-700 hover:text-white p-2 rounded-md" title="Supprimer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="text-sm text-gray-800 space-y-2">
                    <p><strong>Jours :</strong> {{ implode(', ', array_map(fn($d) => [
                            'Monday' => 'Lundi',
                            'Tuesday' => 'Mardi',
                            'Wednesday' => 'Mercredi',
                            'Thursday' => 'Jeudi',
                            'Friday' => 'Vendredi',
                            'Saturday' => 'Samedi',
                            'Sunday' => 'Dimanche',
                        ][$d] ?? $d, $lastDisponibility->day)) }}</p>

                    <p><strong>Créneaux :</strong> {{ implode(', ', array_map(fn($h) => [
                            'morning' => 'Matin (8h - 12h)',
                            'afternoon' => 'Après-midi (12h - 18h)',
                            'evening' => 'Soir (18h - 22h)',
                        ][$h] ?? $h, $lastDisponibility->hours)) }}</p>

                    <p><strong>Remarques :</strong> {{ $lastDisponibility->remarks ?? 'Aucune' }}</p>
                </div>
            </div>
            @endif
        </div>

        <script>
            const disponibilite = {!! json_encode($lastDisponibility) !!};

            document.getElementById('edit-button').addEventListener('click', function() {
                if (!disponibilite) return;

                // Reset les cases
                document.querySelectorAll('input[type="checkbox"]').forEach(el => el.checked = false);

                // Jours
                disponibilite.day.forEach(day => {
                    const checkbox = document.querySelector(`input[name="days[]"][value="${day}"]`);
                    if (checkbox) checkbox.checked = true;
                });

                // Créneaux
                disponibilite.hours.forEach(hour => {
                    const checkbox = document.querySelector(`input[name="hours[]"][value="${hour}"]`);
                    if (checkbox) checkbox.checked = true;
                });

                // Remarques
                document.getElementById('notes').value = disponibilite.remarks || '';

                // Passer en mode modification
                const form = document.getElementById('disponibility-form');
                form.action = `/disponibilities/${disponibilite.id}`;
                document.getElementById('form-method').value = 'PUT';
                document.getElementById('disponibility-id').value = disponibilite.id;

                // Changer le bouton
                document.getElementById('form-submit').textContent = "Mettre à jour";
            });

            document.querySelector('button[type="reset"]').addEventListener('click', function() {
                // Réinitialiser le texte du bouton submit
                document.getElementById('form-submit').textContent = "Enregistrer";
            });
        </script>
    </body>
    <div class="mt-20">
        @include('components.footer-connected')
    </div>
</x-app-layout>