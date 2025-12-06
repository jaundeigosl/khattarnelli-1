<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../app/Payments/PayPalService.php';
require_once __DIR__ . '/../../app/Shipping/ShippingService.php';
require_once __DIR__ . '/../../controladores/carritoController.php';
require_once __DIR__ . '/../../modelos/modelo_pedidos.php';

class PayPalController {

    public function checkout() {

        if (session_status() === PHP_SESSION_NONE) session_start();

        $_SESSION["nombre_cliente"]    = $_POST["nombre_cliente"] ?? null;
        $_SESSION["correo_cliente"]    = $_POST["correo_cliente"] ?? null;
        $_SESSION["telefono_cliente"]  = $_POST["telefono_cliente"] ?? null;
        $_SESSION["ubicacion_cliente"] = $_POST["ubicacion_cliente"] ?? null;


        $tipo_envio = $_POST['envio'] ?? 'normal';

        $shipping = new ShippingService();
        $cantidad = obtener_total_carrito();
        $costo_envio = $shipping->calcularEnvio($cantidad, $tipo_envio);

        $_SESSION['tipo_envio'] = $tipo_envio;
        $_SESSION['costo_envio'] = $costo_envio;

        $total_productos = obtener_total_monetario();

        $total_mxn = $total_productos + $costo_envio;
        // Total en MXN (sin convertir)
        $amount = number_format($total_mxn, 2, '.', '');


        $description = generar_descripcion_carrito();

        $paypal = new PayPalService();
        $response = $paypal->purchase($amount, $description);

        if ($response->isRedirect()) $response->redirect();
        else echo "Error: " . $response->getMessage();
    }


public function success() {

    if (session_status() === PHP_SESSION_NONE) session_start();

    if (!isset($_GET['paymentId'], $_GET['PayerID'])) 
        die("Pago inválido");

    $paypal = new PayPalService();
    $response = $paypal->completePurchase();

    if (!$response->isSuccessful()) 
        die("Error en PayPal: " . $response->getMessage());

    // Datos devueltos por PayPal
    $data = $response->getData();
    $transaction_id = $data["id"] ?? null;

    // Calcular total real
    $total = obtener_total_monetario() + ($_SESSION["costo_envio"] ?? 0);

    // Registrar en la BD
    crear_pedidos(
        $_SESSION["nombre_cliente"],
        $total,
        json_encode($_SESSION["carrito"]),
        $_SESSION["ubicacion_cliente"],
        $_SESSION["correo_cliente"],
        $_SESSION["telefono_cliente"],
        "paypal",
        "pendiente",
        $_SESSION["tipo_envio"],
        $_SESSION["costo_envio"],
        "paypal",
        $transaction_id
    );

    // Vaciar carrito
    $_SESSION["carrito"] = [];

    // Redirigir de vuelta al carrito con mensaje de éxito
    header("Location: ../../pages/carrito/index.php?status=success");
    exit;
}

}
