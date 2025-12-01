<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Administración | Pedidos</title>
    <link rel="stylesheet" href="pedidos_styles.css"> 
</head>
<body>

    <header class="header">
        <h1>Panel de Administración</h1>
        <div class="header-actions">
            <a href="dashboard.php" class="btn-header btn-back">📦 Productos</a>
            <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
        </div>
    </header>

    <div class="container">
        <div class="dashboard-header">
            <h2>🛒 Gestión de Órdenes</h2>
            </div>

        <table class="productos-table"> <thead>
                <tr>
                    <th>ID Orden</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#202300101</td>
                    <td>Juan Pérez</td>
                    <td>2023-11-28</td>
                    <td>$21.49</td>
                    <td><span class="status-badge status-pending">Pendiente</span></td>
                    <td class="crud-actions">
                        <a href="orden_ver.php?id=202300101" class="btn btn-read">Ver Detalle</a>
                        <a href="orden_editar_estado.php?id=202300101" class="btn btn-update">Cambiar Estado</a>
                        <a href="orden_cancelar.php?id=202300101" class="btn btn-delete" onclick="return confirm('¿Deseas cancelar esta orden?');">Cancelar</a>
                    </td>
                </tr>

                <tr>
                    <td>#202300099</td>
                    <td>María López</td>
                    <td>2023-11-27</td>
                    <td>$54.90</td>
                    <td><span class="status-badge status-completed">Completada</span></td>
                    <td class="crud-actions">
                        <a href="orden_ver.php?id=202300099" class="btn btn-read">Ver Detalle</a>
                        <a href="orden_editar_estado.php?id=202300099" class="btn btn-update">Cambiar Estado</a>
                        <a href="#" class="btn btn-delete disabled">Cancelar</a> 
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>

</body>
</html>