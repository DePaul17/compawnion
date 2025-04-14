<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function create()
    {
        Subscription::create([
            'user_id' => Auth::id(),
            'key_subscription' => Str::random(32),
            'paid' => 'no',
        ]);

        return back()->with('success', 'Abonnement créé !');
    }
}
