<?php include_once "../../auth/middleware.php";?>

<?php
require_once "../../modelos/modelo_pedidos.php";

$pedidos = obtener_datos_pedidos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedidos</title>
    <link rel="stylesheet" href="pedidos_styles.css">
</head>
<body>

    <header class="header">
        <h1>Panel de Administración</h1>
        <div class="header-actions">
            <a href="../dashboard/dashboard.php" class="btn-header">Ver Productos</a>
            <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
        </div>
    </header>

<h2>🛒 Gestión de Órdenes</h2>

<table class="productos-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Tipo envío</th>
            <th>Costo envío</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>

    <?php foreach ($pedidos as $p): ?>
        <tr id="row-<?= $p['id'] ?>">
            <td>#<?= $p["id"] ?></td>
            <td><?= htmlspecialchars($p["nombre"]) ?></td>
            <td><?= $p["created_at"] ?></td>
            <td>$<?= number_format($p["total"], 2) ?></td>
            
            <td>
                <span id="estado-<?= $p['id'] ?>" 
                      class="status-badge <?= $p["estado"] == "pendiente" ? "status-pending" : "status-completed" ?>">
                    <?= ucfirst($p["estado"]) ?>
                </span>
            </td>

            <td><?= $p["tipo_envio"] ?></td>
            <td>$<?= number_format($p["costo_envio"], 2) ?></td>

            <td class="crud-actions">
                <button class="btn btn-read" onclick="abrirModal(<?= $p['id'] ?>)">Ver Detalle</button>
                <button class="btn btn-update" onclick="cambiarEstado(<?= $p['id'] ?>)">Cambiar Estado</button>
                <button class="btn btn-delete" onclick="eliminarPedido(<?= $p['id'] ?>)">Eliminar</button>
            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>
<!-- MODAL -->
<div id="modalDetalle" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>

        <h2>Detalle de Pedido</h2>
        <div id="modal-body-content">
            Cargando...
        </div>
    </div>
</div>

<script>
function abrirModal(id) {
    document.getElementById("modalDetalle").style.display = "block";

    fetch("ajax_detalle.php?id=" + id)
        .then(res => res.text())
        .then(html => {
            document.getElementById("modal-body-content").innerHTML = html;
        });
}

function cerrarModal() {
    document.getElementById("modalDetalle").style.display = "none";
}

/* Cambiar estado */
function cambiarEstado(id) {
    if (!confirm("¿Cambiar estado de este pedido?")) return;

    fetch("ajax_cambiar_estado.php?id=" + id)
        .then(res => res.json())
        .then(data => {
            if (data.ok) {
                let badge = document.getElementById("estado-" + id);
                badge.textContent = data.nuevo_estado;
                badge.className = "status-badge " + 
                    (data.nuevo_estado == "pendiente" ? "status-pending" : "status-completed");
            }
        });
}

/* Eliminar */
function eliminarPedido(id) {
    if (!confirm("¿Eliminar este pedido?")) return;

    fetch("ajax_eliminar.php?id=" + id)
        .then(res => res.json())
        .then(data => {
            if (data.ok) {
                document.getElementById("row-" + id).remove();
            }
        });
}
</script>


</body>
</html>
