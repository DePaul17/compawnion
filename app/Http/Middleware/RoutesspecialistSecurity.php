<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RoutesSpecialistSecurity
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->client && $user->client->type_client === 'specialist') {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', "Accès refusé.");
    }
}