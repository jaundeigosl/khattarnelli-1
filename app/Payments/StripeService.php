<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeService {

    public function __construct() {
        Stripe::setApiKey($_ENV['STRIPE_SECRET']);
    }

    public function createCheckoutSession($amount, $description) {

        return Session::create([
            'payment_method_types' => ['card'],

            'line_items' => [[
                'price_data' => [
                    'currency' => 'mxn', 
                    'product_data' => [
                        'name' => $description
                    ],
                    'unit_amount' => $amount,
                ],
                'quantity' => 1,
            ]],

            'mode' => 'payment',

            'success_url' => BASE_URL . '/pages/pago/stripe_success.php?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => BASE_URL . '/pages/pago/stripe_cancel.php',
        ]);
    }

    public function getCheckoutSession($session_id) {
        return Session::retrieve($session_id);
    }
}
