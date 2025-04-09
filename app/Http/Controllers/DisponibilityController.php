<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disponibility;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Client;

class DisponibilityController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'days' => 'required|array',
            'hours' => 'required|array',
            'remarks' => 'nullable|string',
        ]);

        //dd(auth()->user()->client());
        //dd(auth()->user(), auth()->client());


        $client = auth()->user()->client;

        if (!$client) {
            return back()->withErrors(['client' => 'Aucun client associé à cet utilisateur.']);
        }

        Disponibility::create([
            'client_id' => $client->id,
            'day' => $validated['days'],
            'hours' => $validated['hours'],
            'remarks' => $validated['remarks'] ?? null,
        ]);

        return back()->with('success', 'Disponibilité enregistrée avec succès.');
    }

    public function update(Request $request, $id)
    {
        $disponibility = Disponibility::findOrFail($id);

        $disponibility->update([
            'day' => $request->input('days'),
            'hours' => $request->input('hours'),
            'remarks' => $request->input('remarks'),
        ]);

        return redirect()->back()->with('success', 'Disponibilité mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $disponibility = Disponibility::findOrFail($id);
        $disponibility->delete();
        return redirect()->back()->with('success', 'Disponibilité supprimée avec succès.');
    }
}
