
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
            <a href="ordenes.php" class="btn-header">Ver Órdenes</a>
            <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
        </div>
    </header>

    <div class="container">
        <div class="dashboard-header">
            <h2>📦 Gestión de Productos</h2>
            <a href="productos_crear.php" class="btn btn-primary">➕ Agregar Nuevo Producto</a>
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
            
            <?php for(){};
            

            
            ?>


        </table>
    </div>

</body>
</html>