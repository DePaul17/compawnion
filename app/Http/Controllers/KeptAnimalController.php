<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KeptAnimal;
use Illuminate\Support\Facades\Auth;

class KeptAnimalController extends Controller
{
    public function show()
    {
        $client = Auth::user(); // ou Client::find($id); selon le contexte
        return view('petsitter.keptAnimals.kept_animals', compact('client'));
    }

    public function store(Request $request)
    {
        // Validation de base sans la règle unique
        $request->validate([
            'animal_type'      => 'required',
            'animal_size'      => 'required',
            'max_animals'      => 'required',
            'special_conditions' => 'nullable',
        ]);

        // Vérification manuelle de l'existence de l'animal_type
        if (KeptAnimal::where('animal_type', $request->input('animal_type'))->exists()) {
            return redirect()->back()->withErrors([
                'animal_type' => 'Cet type animal existe déjà.',
            ]);
        }

        $client = auth()->user()->client;

        if (!$client) {
            return back()->withErrors(['client' => 'Aucun client associé à cet utilisateur.']);
        }

        KeptAnimal::create([
            'client_id'          => $client->id,
            'animal_type'        => $request->input('animal_type'),
            'animal_size'        => $request->input('animal_size'),
            'max_animals'        => $request->input('max_animals'),
            'special_conditions' => $request->input('special_conditions'),
        ]);

        return redirect()->back()->with('success', 'Animal enregistré avec succès.');
    }

    public function index(Request $request)
    {
        $clientId = $request->query('client_id');

        if (!$clientId) {
            return back()->with('error', 'Aucun client ID fourni.');
        }

        $keptAnimals = KeptAnimal::where('client_id', $clientId)->get();

        return view('petsitter.keptAnimals.list-kept_animals', compact('keptAnimals', 'clientId'));
    }

    public function edit($id)
    {
        $client = Auth::user()->client;
        $keptAnimal = KeptAnimal::findOrFail($id);
        return view('petsitter.keptAnimals.edit-kept_animals', compact('keptAnimal', 'client'));
    }

    public function update(Request $request, $id)
    {
        $keptAnimal = KeptAnimal::findOrFail($id);

        $request->validate([
            'animal_type'      => 'required',
            'animal_size'      => 'required',
            'max_animals'      => 'required',
            'special_conditions' => 'nullable',
        ]);

        if (KeptAnimal::where('animal_type', $request->input('animal_type'))
            ->where('id', '<>', $keptAnimal->id)
            ->exists()
        ) {
            return redirect()->back()->withErrors([
                'animal_type' => 'Cet type animal existe déjà.',
            ]);
        }

        $keptAnimal->update($request->only([
            'animal_type',
            'animal_size',
            'max_animals',
            'special_conditions',
        ]));

        return redirect()->route('list-kept_animals', ['client' => $keptAnimal->client_id])
            ->with('success', 'Animal gardé mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $keptAnimal = KeptAnimal::findOrFail($id);
        $keptAnimal->delete();
        return redirect()->route('list-kept_animals', ['client' => $keptAnimal->client_id])
            ->with('success', 'Animal gardé supprimé avec succès.');
    }
}
