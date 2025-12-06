<?php

require_once __DIR__ . '/../../app/Payments/StripeService.php';
require_once __DIR__ . '/../../app/Shipping/ShippingService.php';
require_once __DIR__ . '/../../controladores/carritoController.php';
require_once __DIR__ . '/../../modelos/modelo_pedidos.php';
require_once __DIR__ . '/../../modelos/modelo_detalle_pedido.php';

class StripeController {

    public function checkout() {

        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['carrito'])) die("Carrito vacío");

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
        $gran_total = $total_productos + $costo_envio;

        $amount = intval($gran_total * 100);

        $description = generar_descripcion_carrito();

        $stripe = new StripeService();

        try {
            $session = $stripe->createCheckoutSession($amount, $description);

            header("Location: " . $session->url);
            exit;

        } catch (Exception $e) {
            die("Error Stripe: " . $e->getMessage());
        }
    }


    public function success() {

        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_GET['session_id'])) die("Pago inválido");

        $stripe = new StripeService();
        $session = $stripe->getCheckoutSession($_GET['session_id']);

        if ($session->payment_status !== 'paid')
            die("Pago no completado.");

        $nombre    = $_SESSION["nombre_cliente"];
        $correo    = $_SESSION["correo_cliente"];
        $telefono  = $_SESSION["telefono_cliente"];
        $ubicacion = $_SESSION["ubicacion_cliente"];

        $carrito_json = json_encode($_SESSION["carrito"]);

        $total_mxn = obtener_total_monetario() + $_SESSION["costo_envio"];

        // Igual que PayPal
        $pedido_id = crear_pedidos(
            $nombre,
            $total_mxn,
            $carrito_json,
            $ubicacion,
            $correo,
            $telefono,
            "stripe",
            "pendiente",
            $_SESSION['tipo_envio'],
            $_SESSION['costo_envio'],
            "stripe",
            $session->id
        );

        foreach ($_SESSION['carrito'] as $prod) {
            crear_detalle_pedido(
                $pedido_id,
                $prod['id'],
                $prod['cantidad'],
                $prod['precio'],
                $prod['cantidad'] * $prod['precio']
            );
        }

        $_SESSION['carrito'] = [];

        header("Location: ../../pages/carrito/index.php?status=success");
        exit;
    }

    public function cancel() {
        echo "<h1>Pago cancelado</h1>";
    }
}
