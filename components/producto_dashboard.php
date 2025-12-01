
<tbody>
    <tr>
        <td><?php echo $producto["id"]?></td>
        <td><?php echo $producto["nombre"]?></td>
        <td><?php echo $producto['precio']?></td>
        <td><?php echo $producto['descripcion']?></td>
        <td class="crud-actions">
            <a href="productos_ver.php?id=1" class="btn btn-read">Ver</a>
            <a href="productos_editar.php?id=1" class="btn btn-update">Editar</a>
            <a href="productos_borrar.php?id=1" class="btn btn-delete" onclick="return confirm('¿Seguro que quieres eliminar este producto?');">Eliminar</a>
        </td>
    </tr>
                
</tbody>