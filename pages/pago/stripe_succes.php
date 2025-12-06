<?php
require_once __DIR__ . '/../../controladores/pago/StripeController.php';
$controller = new StripeController();
$controller->success();
