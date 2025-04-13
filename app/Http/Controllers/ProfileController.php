<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Client;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (Client::where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Profil client déjà existant.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'date_of_birth' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->toDateString()],
            //'address' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'type_client' => 'required|string|in:client,petsitter,specialist',

            // conditionnels :
            'identity_document' => 'sometimes|required_if:type_client,petsitter,specialist|file|mimes:pdf,jpg,jpeg,png',
            'attestation' => 'sometimes|required_if:type_client,specialist|file|mimes:pdf,jpg,jpeg,png',
            'petsitter_certificate_acaced' => 'sometimes|required_if:type_client,petsitter|file|mimes:pdf,jpg,jpeg,png',
            'verificate' => 'sometimes|required_if:type_client,petsitter|file|mimes:pdf,jpg,jpeg,png',
            'picture' => 'sometimes|required_if:type_client,petsitter|file|mimes:pdf,jpg,jpeg,png',
        ]);

        // stockage fichiers
        $identityDocumentPath = $request->hasFile('identity_document')
            ? $request->file('identity_document')->store('documents', 'public')
            : null;

        $attestationPath = $request->hasFile('attestation')
            ? $request->file('attestation')->store('documents', 'public')
            : null;

        $certificatePath = $request->hasFile('petsitter_certificate_acaced')
            ? $request->file('petsitter_certificate_acaced')->store('documents', 'public')
            : null;

        $verificatePath = $request->hasFile('verificate')
            ? $request->file('verificate')->store('documents', 'public')
            : null;

        $picturePath = $request->hasFile('picture')
            ? $request->file('picture')->store('documents', 'public')
            : null;


        // enregistrement en base
        Client::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'first_name' => $validated['first_name'],
            'date_of_birth' => $validated['date_of_birth'],
            //'address' => $validated['address'],
            'address' => json_encode([
                'street'      => $validated['street'],
                'postal_code' => $validated['postal_code'],
                'city'        => $validated['city'],
                'country'     => $validated['country'],
            ]),
            'type_client' => $validated['type_client'],
            'identity_document' => $identityDocumentPath,
            'attestation' => $attestationPath,
            'petsitter_certificate_acaced' => $certificatePath,
            'verificate' => $verificatePath,
            'picture' => $picturePath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Profil client créé avec succès.');
    }

    public function edit(Request $request): View
    {
        $client = Client::where('user_id', $request->user()->id)->first();
        return view('profile.edit', [
            'user' => $request->user(),
            'client' => $client,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->only('email'));
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();

        $client = $user->client;

        if ($client) {
            if ($request->hasFile('picture')) {
                //dd($request->file('picture'));
                $file = $request->file('picture');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('profile', $filename, 'public');
                $client->picture = $path;
            } else {
                dd('Oops!');
            }

            // Mise à jour des autres champs
            $client->name = $request->input('name');
            $client->first_name = $request->input('first_name');
            $client->date_of_birth = $request->input('date_of_birth');
            $client->address = $request->input('address');
            $client->type_client = $request->input('type_client');
            $client->save();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function deleteImage(Request $request): RedirectResponse
    {
        $client = $request->user()->client;

        if ($request->has('delete_picture') && $request->boolean('delete_picture')) {
            if ($client && $client->picture) {
                if (Storage::disk('public')->exists($client->picture)) {
                    Storage::disk('public')->delete($client->picture);
                }

                $client->picture = null;
            }
        }

        $client->save();

        return redirect()->route('profile.edit')->with('status', 'Profil mis à jour avec succès.');
    }

    public function becomePetsitter()
    {
        return view('client.become-petsitter');
    }

    public function showDashboard()
    {
        $petsitters = Client::with('user')
            ->where('type_client', 'petsitter')
            ->get();

        return view('dashboard', compact('petsitters'));
    }
}
