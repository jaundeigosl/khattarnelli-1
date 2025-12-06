<?php
include "../../paths.php";
include "../../controladores/carritoController.php";

vaciar_carrito();
header("Location: pages/carrito/index.php");
exit;
