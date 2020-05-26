<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        if (!is_null($user->stripe_connect_id)) {
            return redirect()->route('stripe.login');
        }
        $session = request()->session()->getId();
        $url = config('services.stripe.connect') . $session;
        return redirect($url);
    }
}
