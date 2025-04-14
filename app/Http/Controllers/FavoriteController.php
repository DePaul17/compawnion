<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Client;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $clientConnecte = auth()->user()->client;

        if ($clientConnecte->type_client !== 'client') {
            return back()->with('error', 'Seuls les clients peuvent accéder à leurs favoris.');
        }

        $favorites = Favorite::with(['petsitter.user', 'petsitter.disponibilities', 'petsitter.keptAnimals'])
            ->where('client_id', $clientConnecte->id)
            ->get();

        return view('client.favorites-petsitter', compact('favorites'));
    }

    public function store(Request $request)
    {
        $clientConnecte = auth()->user()->client;

        if ($clientConnecte->type_client !== 'client') {
            return back()->with('error', 'Seuls les clients peuvent ajouter un petsitter en favoris.');
        }

        $request->validate([
            'petsitter_id' => 'required|exists:clients,id',
        ]);

        $petsitter = Client::find($request->petsitter_id);

        if ($petsitter->type_client !== 'petsitter') {
            return back()->with('error', 'Le client sélectionné n\'est pas un petsitter.');
        }

        $exists = Favorite::where('client_id', $clientConnecte->id)
            ->where('petsitter_id', $petsitter->id)
            ->exists();

        if ($exists) {
            return back()->with('info', 'Ce petsitter est déjà dans vos favoris.');
        }

        Favorite::create([
            'client_id'    => $clientConnecte->id,
            'petsitter_id' => $petsitter->id,
        ]);

        return back()->with('success', 'Le petsitter a été ajouté à vos favoris.');
    }

    public function destroy($id)
    {
        $favorite = Favorite::findOrFail($id);

        if ($favorite->client_id != auth()->user()->client->id) {
            return back()->with('error', 'Opération non autorisée !');
        }

        $favorite->delete();

        return back()->with('success', 'Le favori a été supprimé.');
    }
}
