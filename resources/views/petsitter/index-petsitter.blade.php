<div class="dashboard max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-md">
    <h1 class="text-2xl font-bold mb-6">Bienvenue sur votre espace Pet Sitter</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="card bg-slate-100 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-slate-800">Statut du profil</h3>
            <p class="text-slate-600 mt-2">En attente de vérification</p>
        </div>

        <div class="card bg-slate-100 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-slate-800">Prochaines gardes</h3>
            <p class="text-slate-600 mt-2">Aucune garde prévue pour le moment</p>
        </div>

        <div class="card bg-slate-100 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-slate-800">Garde(s) effectuée(s)</h3>
            <p class="text-slate-600 mt-2">Aucune garde complétée pour le moment</p>
        </div>

        <div class="card bg-slate-100 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-slate-800">Note moyenne</h3>
            <p class="text-slate-600 mt-2">0 / 5 ⭐</p>
        </div>

        <div class="card bg-slate-100 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-slate-800">Statut du profil</h3>
            <p class="text-slate-600 mt-2">En attente de vérification</p>
        </div>
    </div>

    @php
    $client = auth()->user()?->client;
    @endphp

    @if ($client)
        @unless ($client->disponibilities()->exists())
            <div class="alert mt-8 p-4 bg-red-100 text-red-800 border border-red-300 rounded-lg">
                <strong class="font-semibold">⚠️ Disponibilités manquantes :</strong>
                Veuillez <a href="{{ route('disponibilites') }}" class="underline text-yellow-900 font-medium hover:text-yellow-700">ajouter vos disponibilités</a> pour que votre profil soit visible.
            </div>
        @endunless

        @unless ($client->keptAnimals()->exists())
            <div class="alert mt-4 p-4 bg-red-100 text-red-800 border border-red-300 rounded-lg">
                <strong class="font-semibold">⚠️ Animaux gardés non renseignés :</strong>
                Veuillez <a href="{{ route('kept_animals') }}" class="underline text-red-900 font-medium hover:text-red-700">renseigner les types d’animaux</a> que vous pouvez garder pour que votre profil soit visible.
            </div>
        @endunless
    @endif

</div>
<div class="mt-20">
    @include('components.footer-connected')
</div>
