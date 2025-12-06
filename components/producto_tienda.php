<?php 

include "../../modelos/modelo_productos.php";

$productos = obtener_datos_productos();
?>
<div class="container" style="padding: 20px;">
    <h1>Nuestros Productos</h1>

    <div class="productos-grid" style="display:grid; grid-template-columns:repeat(auto-fill,minmax(250px,1fr)); gap:20px;">
        
        <?php if (empty($productos)): ?>
            <p>No hay productos disponibles.</p>
        <?php endif; ?>

        <?php foreach ($productos as $p): ?>
            <div class="producto-card" style="border:1px solid #ccc; padding:15px; border-radius:8px;">
                
                <img src="<?php echo BASE_URL . $p['imagen']; ?>" 
                     alt="<?php echo $p['nombre']; ?>" 
                     style="width:100%; border-radius:5px;">

                <h3><?php echo htmlspecialchars($p['nombre']); ?></h3>

                <p><?php echo htmlspecialchars($p['descripcion']); ?></p>

                <strong>$<?php echo number_format($p['precio'], 2); ?></strong>

                <br><br>

                <a href="<?php echo BASE_URL; ?>pages/carrito/add.php?id=<?php echo $p['id']; ?>&redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">
                    Añadir al carrito
                </a>


            </div>
        <?php endforeach; ?>
    </div>
</div>