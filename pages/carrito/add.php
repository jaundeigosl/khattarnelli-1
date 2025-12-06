<?php

include "../../paths.php";
include "../../modelos/modelo_productos.php";
include "../../controladores/carritoController.php";

if (!isset($_GET['id'])) {
    die("Producto no especificado");
}

$id = $_GET['id'];

// Obtener producto exacto
$conexion = Database::getInstance(DB_CONFIG)->getConnection();
$stmt = $conexion->prepare("SELECT id, nombre, precio, imagen FROM productos WHERE id = ?");
$stmt->execute([$id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    die("Producto no encontrado");
}

agregar_al_carrito(
    $producto['id'],
    $producto['nombre'],
    $producto['precio'],
    $producto['imagen']
);

// REDIRECCIÓN CONTROLADA
$redirect = $_GET['redirect'] ?? BASE_URL . "pages/productos/productos.php";

header("Location: $redirect");
exit;
