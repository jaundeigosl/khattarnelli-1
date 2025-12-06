<?php

require_once __DIR__ . '/../../paths.php';


use Omnipay\Omnipay;

class PayPalService {

    private $gateway;

    public function __construct() {
        $this->gateway = Omnipay::create('PayPal_Rest');

        $this->gateway->setClientId($_ENV['PAYPAL_CLIENT_ID']);
        $this->gateway->setSecret($_ENV['PAYPAL_CLIENT_SECRET']);
        $this->gateway->setTestMode($_ENV['PAYPAL_MODE'] === 'sandbox');
    }

    public function purchase($amount, $description) {
        return $this->gateway->purchase([
            'amount' => $amount,
            'currency' => 'MXN',
            'description' => $description,
            'returnUrl' => $_ENV['PAYPAL_RETURN_URL'],
            'cancelUrl' => $_ENV['PAYPAL_CANCEL_URL'],
        ])->send();
    }

    public function completePurchase() {
        return $this->gateway->completePurchase([
            'payer_id' => $_GET['PayerID'] ?? null,
            'transactionReference' => $_GET['paymentId'] ?? null,
        ])->send();
    }
}
