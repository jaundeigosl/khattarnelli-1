<?php

function isActive($link_path, $current_uri) {

    if($link_path === $current_uri){
        return "active";
    }

    return '';  
}

include_once __DIR__ . "/../controladores/carritoController.php"; 
$items = obtener_total_carrito(); 


?>

<header>
    <div class="container">
        <nav class="navbar">
            <div class="logo">
                <img src="<?php echo BASE_URL; ?>images/logo/ChatGPT Image 19 nov 2025, 13_26_41.png" alt="Kattarnelly logo">
            </div>
            <ul class="nav-links">

                <?php $home_link = BASE_URL . 'index.php'; ?>
                <?php $actual_uri = $_SERVER['REQUEST_URI']; ?>

                <li><a href="<?php echo $home_link; ?>" class="<?php echo isActive($home_link, $actual_uri); ?>">Inicio</a></li>
                
                <?php $productos_link = BASE_URL . 'pages/productos/productos.php'; ?>
                <li><a href="<?php echo $productos_link; ?>" class="<?php echo isActive($productos_link, $actual_uri); ?>">Productos</a></li>
                
                <?php $nosotros_link = BASE_URL . 'pages/nosotros/nosotros.php'; ?>
                <li><a href="<?php echo $nosotros_link; ?>" class="<?php echo isActive($nosotros_link, $actual_uri); ?>">Nosotros</a></li>

                <?php $preparacion_link = BASE_URL . 'pages/preparacion/preparacion.php'; ?>
                <li><a href="<?php echo $preparacion_link; ?>" class="<?php echo isActive($preparacion_link, $actual_uri); ?>">Preparación</a></li>

                <?php $contacto_link = BASE_URL . 'pages/contacto/contacto.php' ?>
                <li><a href="<?php echo $contacto_link; ?>" class="<?php echo isActive($contacto_link, $actual_uri); ?>">Contacto</a></li>
            <li>
                <a href="<?php echo BASE_URL; ?>pages/carrito/index.php" style="font-size:20px;">
                    🛒 (<?php echo $items; ?>)
                </a>
            </li>    
            </ul>
            
            </nav>
    </div>
</header>