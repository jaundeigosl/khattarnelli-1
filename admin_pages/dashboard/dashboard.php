<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Administración | Productos</title>
    <link rel="stylesheet" href="dashboard_styles.css"> 
</head>
<body>

    <header class="header">
        <h1>Panel de Administración</h1>
        <div class="header-actions">
            <a href="../pedidos/pedidos.php" class="btn-header">Ver Órdenes</a>
            <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
        </div>
    </header>

    <div class="container">
        <?php if (isset($error_message)): ?>
            <p style="color: red; padding: 10px; background: #fdd; border: 1px solid #f00;"><?php echo htmlspecialchars($error_message); ?></p>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'success'): ?>
            <p style="color: green; padding: 10px; background: #dfd; border: 1px solid #0f0;">Producto creado exitosamente.</p>
        <?php endif; ?>

        <div class="dashboard-header">
            <h2>📦 Gestión de Productos</h2>
            <button id="abrir-modal-btn" class="btn btn-primary">➕ Agregar Nuevo Producto</button>
        </div>

        <table class="productos-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Descripción</th>
                    <th>Acciones CRUD</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                if (!empty($productos)): 
                    foreach ($productos as $producto): 

                        include BASE_URL . "components/producto_dashboard.php";

                    endforeach;
                else: 
                ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">⚠️ No se encontraron productos para mostrar.</td>
                    </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div id="crear-producto-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h3>Crear Nuevo Producto</h3>
            
            <form action="dashboard_controller.php" method="POST" enctype="multipart/form-data"> 
                <input type="hidden" name="action" value="crear_producto">
                
                <div class="form-group">
                    <label for="nombre">Nombre del Producto:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                
                <div class="form-group">
                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" rows="3" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="imagen">Imagen del Producto:</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" required>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" id="cancelar-modal-btn">Cancelar</button>
            </form>
        </div>
    </div>
        
    <script src="../../js/modals/modal_script.js"></script> 
</body>
</html>