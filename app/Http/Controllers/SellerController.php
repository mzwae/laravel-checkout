<?php

namespace App\Http\Controllers;

use App\Services\Stripe\Seller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Account;

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

        // Redirect Stripe to create account
        return redirect($url);
    }


    public function login()
    {
        $user = Auth::user();
        Stripe::setApiKey(config('services.stripe.secret'));
        $account_link = Account::createLoginLink($user->stripe_connect_id);

        // Redirect Stripe to Connect Account
        return redirect($account_link->url);
    }


    // Save a Stripe Connect Account
    public function save(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'state' => 'required'
        ]);

        $session = DB::table('session')->where('id', $request->state)->first();
        $data = Seller::create($request->code);
        User::find($session->user_id)->update(['stripe_connect_id' => $data->stripe_user_id]);
        return redirect()->route('products')->with('success', 'Account information has been saved.');

    }


}
