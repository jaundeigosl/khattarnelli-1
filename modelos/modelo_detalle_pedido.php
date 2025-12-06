<?php

include_once "../../paths.php";
include_once "../../db/database.php";

function crear_detalle_pedido($pedido_id, $producto_id, $cantidad, $precio_unitario, $subtotal)
{
    $conexion = Database::getInstance(DB_CONFIG)->getConnection();

    $sql = "INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad, precio_unitario, subtotal)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);
    $stmt->execute([$pedido_id, $producto_id, $cantidad, $precio_unitario, $subtotal]);
}
