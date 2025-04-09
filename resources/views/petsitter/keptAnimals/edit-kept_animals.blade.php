<x-app-layout>

    <body class="bg-gray-100 font-sans">

        <div class="max-w-5xl mx-auto mt-12 bg-white p-8 rounded-2xl shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-3xl font-bold text-gray-800">🐾 Animaux gardés</h1>
                <form action="{{ route('list-kept_animals', ['client' => Auth::user()->id]) }}" method="GET">
                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                    <button type="submit" class="bg-green-500 hover:bg-green-300 text-white p-2 rounded-md" title="Lister">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </form>
            </div>

            <p class="text-gray-600 mb-8">Ajoute les types d'animaux que tu peux garder avec les conditions spécifiques si nécessaire.</p>

            <!-- Formulaire -->
            <form action="{{ route('kept_animals.update', $keptAnimal->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                @csrf
                @method('PUT')
                <div>
                    <label class="block mb-1 font-medium text-gray-700" for="type">Type d’animal</label>
                    <select id="type" name="animal_type" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                        <option value="">-- Choisir un type d'animal --</option>
                        <option value="Chien" {{ $keptAnimal->animal_type === 'Chien' ? 'selected' : '' }}>Chien</option>
                        <option value="Chat" {{ $keptAnimal->animal_type === 'Chat' ? 'selected' : '' }}>Chat</option>
                        <option value="Lapin" {{ $keptAnimal->animal_type === 'Lapin' ? 'selected' : '' }}>Lapin</option>
                        <option value="Oiseau" {{ $keptAnimal->animal_type === 'Oiseau' ? 'selected' : '' }}>Oiseau</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 font-medium text-gray-700" for="size">Taille acceptée</label>
                    <select id="size" name="animal_size" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                        <option value="">-- Choisir une taille --</option>
                        <option value="Petit" {{ $keptAnimal->animal_size === 'Petit' ? 'selected' : '' }}>Petit</option>
                        <option value="Moyen" {{ $keptAnimal->animal_size === 'Moyen' ? 'selected' : '' }}>Moyen</option>
                        <option value="Grand" {{ $keptAnimal->animal_size === 'Grand' ? 'selected' : '' }}>Grand</option>
                        <option value="Toutes tailles" {{ $keptAnimal->animal_size === 'Toutes tailles' ? 'selected' : '' }}>Toutes tailles</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 font-medium text-gray-700" for="max">Nombre maximum</label>
                    <input type="text" name="max_animals" id="max_animals" value="{{ $keptAnimal->max_animals }}" class="w-full border border-gray-300 rounded-xl px-4 py-2" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-1 font-medium text-gray-700" for="conditions">Conditions spéciales</label>
                    <textarea name="special_conditions" id="special_conditions" placeholder="Ex: Pas de chats agressifs, uniquement chiens vaccinés..." rows="3" class="w-full border border-gray-300 rounded-xl px-4 py-2">{{ $keptAnimal->special_conditions }}</textarea>
                </div>

                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl font-semibold transition duration-300">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </body>
    <div class="mt-20">
        @include('components.footer-connected')
    </div>
</x-app-layout>