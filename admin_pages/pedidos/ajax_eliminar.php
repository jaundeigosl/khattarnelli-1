<?php
require_once "../../modelos/modelo_pedidos.php";

$id = $_GET["id"];

eliminar_pedido($id);

echo json_encode(["ok" => true]);
