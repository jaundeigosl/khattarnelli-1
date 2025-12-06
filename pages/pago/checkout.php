<?php
require '../../controladores/pago/PayPalController.php';

$controller = new PayPalController();
$controller->checkout();
