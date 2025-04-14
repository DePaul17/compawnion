<?php

namespace App\Http\Controllers;

use App\Models\Client;
class PetsitterController extends Controller
{
    public function show($id)
    {
        $petsitter = Client::with(['disponibilities', 'keptAnimals'])->where('type_client', 'petsitter')->findOrFail($id);

        return view('client.show-favorites-petsitter', compact('petsitter'));
    }
}
