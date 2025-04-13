<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Client;
use App\Models\Favorite;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function __invoke()
    {
        $client = Client::where('user_id', Auth::id())->first();

        $petsitters = Client::with(['user', 'disponibilities', 'keptAnimals'])
            ->where('type_client', 'petsitter')
            ->get();

        $favorites = Favorite::where('client_id', $client->id)
            ->pluck('id', 'petsitter_id')
            ->toArray();

        return view('dashboard', compact('client', 'petsitters', 'favorites'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
