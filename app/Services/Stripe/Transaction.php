<?php

namespace App\Services\Stripe;

use App\Product;
use App\User;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Transfer;
use App\Payment;

class Transaction
{
    public static function create(User $user, Product $product)
    {
        // Initial data
        $amount = $product->price;
        $payout = $amount * 0.90;
        Stripe::setApiKey(config('services.stripe.secret'));

        // Create a Stripe charge from the customer purchase


        // Pay funds to seller, with platform fees extracted


        // Save transaction to database
    }
}