<?php
require_once "../../modelos/modelo_pedidos.php";

$id = $_GET["id"];
$pedido = obtener_pedido_por_id($id);

$nuevo = $pedido["estado"] == "pendiente" ? "completado" : "pendiente";

actualizar_estado_pedido($id, $nuevo);

echo json_encode(["ok" => true, "nuevo_estado" => $nuevo]);
