<?php
include "../../paths.php";
include "../../controladores/carritoController.php";

if (!isset($_GET['id'])) {
    die("Error: falta ID del producto.");
}

$id = $_GET['id'];

eliminar_del_carrito($id);

// Redireccionar correctamente
header("Location: index.php");
exit;
