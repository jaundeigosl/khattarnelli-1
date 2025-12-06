<?php

require_once "../../modelos/modelo_pedidos.php";

if (!isset($_GET['id']) || !isset($_GET['estado'])) {
    die("Solicitud inválida");
}

$id = intval($_GET['id']);
$estado = $_GET['estado'];

// Validación básica
$estados_validos = ["Pendiente", "Enviado", "Cancelado"];

if (!in_array($estado, $estados_validos)) {
    die("Estado no permitido");
}

actualizar_pedidos($id, $estado);

// Redirige de vuelta al panel
header("Location: ../../pages/admin/pedidos.php?msg=estado_actualizado");
exit;
