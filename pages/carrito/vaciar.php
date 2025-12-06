<?php
include "../../paths.php";
include "../../controladores/carritoController.php";

vaciar_carrito();

header("Location: index.php");
exit;
