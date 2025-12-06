<?php
require_once "../../modelos/modelo_pedidos.php";

$id = $_GET["id"];
$pedido = obtener_pedido_por_id($id);

echo "<p><strong>Cliente:</strong> {$pedido['nombre']}</p>";
echo "<p><strong>Correo:</strong> {$pedido['correo']}</p>";
echo "<p><strong>Teléfono:</strong> {$pedido['telefono']}</p>";
echo "<p><strong>Dirección:</strong> {$pedido['ubicacion']}</p>";
echo "<p><strong>Total:</strong> $" . number_format($pedido["total"],2) . "</p>";
echo "<hr>";
echo "<h4>Productos:</h4>";

$productos = json_decode($pedido["productos"], true);

if (!is_array($productos)) {
    echo "<p>No hay productos registrados.</p>";
    exit;
}

foreach ($productos as $prod) {
    echo "<p>- {$prod['nombre']} ({$prod['cantidad']} x {$prod['precio']})</p>";
}

