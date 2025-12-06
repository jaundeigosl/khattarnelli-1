<?php include_once "../../paths.php";?>

<?php include_once "../../auth/middleware.php";?>

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
            <a href="../../auth/logout.php" class="btn-logout">Cerrar Sesión</a>
        </div>
    </header>

    <div class="container">
        <?php 
        // Lógica de manejo de mensajes (CORREGIDO)
        if (isset($_GET['status'])): 
            $status = htmlspecialchars($_GET['status']);
            $message = htmlspecialchars($_GET['message'] ?? '');
            $action_performed = htmlspecialchars($_GET['action'] ?? '');
            
            if ($status === 'error'): 
        ?>
            <p style="color: red; padding: 10px; background: #fdd; border: 1px solid #f00;">
                ❌ Error en la acción <?php echo $action_performed; ?>: <?php echo $message; ?>
            </p>
        <?php elseif ($status === 'success'): ?>
            <p style="color: green; padding: 10px; background: #dfd; border: 1px solid #0f0;">
                ✅ Operación (<?php echo $action_performed; ?>) realizada con éxito.
            </p>
        <?php endif; 
        endif; 
        ?>

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
                        // Uso de data-atributos para JS
                        $data_attrs = "data-id='{$producto['id']}' data-nombre='{$producto['nombre']}' data-precio='{$producto['precio']}' data-descripcion='{$producto['descripcion']}'";
                ?>
                    <tr <?php echo $data_attrs; ?>>
                        <td><?php echo htmlspecialchars($producto['id']); ?></td>
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td>$<?php echo htmlspecialchars($producto['precio']); ?></td>
                        <td><?php echo htmlspecialchars(substr($producto['descripcion'], 0, 50)) . '...'; ?></td>
                        <td>
                            <button class="btn btn-info edit-btn" data-id="<?php echo $producto['id']; ?>">✏️ Editar</button>
                            
                            <form action="<?php echo BASE_URL . 'controladores/controlador_productos.php'; ?>" method="POST" style="display: inline;" onsubmit="return confirm('¿Confirma que desea borrar el producto ID: <?php echo $producto['id']; ?>?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($producto['id']); ?>">
                                <button type="submit" class="btn btn-danger">🗑️ Borrar</button>
                            </form>
                        </td>
                    </tr>
                    <?php 
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
            
            <form action="<?php echo BASE_URL . 'controladores/controlador_productos.php'; ?>" method="POST" enctype="multipart/form-data"> 
                <input type="hidden" name="action" value="create"> <div class="form-group">
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
    
    <div id="editar-producto-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn-edit">&times;</span>
            <h3>Editar Producto: <span id="producto-nombre-edit"></span></h3>
            
            <form action="<?php echo BASE_URL . 'controladores/controlador_productos.php'; ?>" method="POST" enctype="multipart/form-data"> 
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" id="edit-id">
                
                <div class="form-group">
                    <label for="edit-nombre">Nombre del Producto:</label>
                    <input type="text" id="edit-nombre" name="nombre" required>
                </div>
                
                <div class="form-group">
                    <label for="edit-precio">Precio:</label>
                    <input type="number" id="edit-precio" name="precio" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="edit-descripcion">Descripción:</label>
                    <textarea id="edit-descripcion" name="descripcion" rows="3" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="edit-imagen">Imagen del Producto (Cambiar):</label>
                    <input type="file" id="edit-imagen" name="imagen" accept="image/*">
                    <small>Deja vacío para conservar la imagen actual.</small>
                </div>

                <button type="submit" class="btn btn-primary">Actualizar</button>
                <button type="button" class="btn btn-secondary" id="cancelar-edit-btn">Cancelar</button>
            </form>
        </div>
    </div>
        
    <script src="../../js/modals/modal_script.js"></script> 
</body>
</html>