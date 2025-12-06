<?php

require_once __DIR__ . '/../app/Shipping/ShippingService.php';

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

function agregar_al_carrito($id, $nombre, $precio, $imagen) {

    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]['cantidad'] += 1;
        return;
    }

    $_SESSION['carrito'][$id] = [
        "id" => $id,
        "nombre" => $nombre,
        "precio" => floatval($precio),
        "imagen" => $imagen,
        "cantidad" => 1
    ];
}

function eliminar_del_carrito($id) {
    if (isset($_SESSION['carrito'][$id])) {
        unset($_SESSION['carrito'][$id]);
    }
}

function vaciar_carrito() {
    $_SESSION['carrito'] = []; 
}

function obtener_total_carrito() {
    $total = 0;
    foreach ($_SESSION['carrito'] as $item) {
        $total += $item['cantidad'];
    }
    return $total;
}

function generar_descripcion_carrito() {
    if (!isset($_SESSION['carrito'])) return "Carrito vacío";

    $nombres = [];
    foreach ($_SESSION['carrito'] as $p) {
        $nombres[] = $p['nombre'] . " x" . $p['cantidad'];
    }

    return implode(", ", $nombres);
}

function obtener_costo_envio($tipo = 'normal') {
    $cantidad = obtener_total_carrito();
    $shipping = new ShippingService();
    return $shipping->calcularEnvio($cantidad, $tipo);
}


function obtener_total_monetario() {
    if (!isset($_SESSION['carrito'])) return 0;
    $total = 0;

    foreach ($_SESSION['carrito'] as $p) {
        $total += $p['precio'] * $p['cantidad'];
    }

    return $total;
}

function obtener_total_con_envio($tipo = 'normal') {
    return obtener_total_monetario() + obtener_costo_envio($tipo);
}
