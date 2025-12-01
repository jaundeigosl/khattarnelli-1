<?php

include_once BASE_URL."modelos/modelo_productos";

$productos = obtener_datos_productos();

include_once BASE_URL. "admin_pages/dasboard/dasboard.php";

?>