<?php
include_once "../paths.php"; 
include_once BASE_URL."modelos/modelo_productos.php";

function manejar_subida_imagen() {
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $nombre_archivo = basename($_FILES['imagen']['name']);
        $ruta_destino = BASE_URL . 'imagenes/' . $nombre_archivo;
        
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) {
            return $nombre_archivo;
        }
    }
    throw new Exception("Error al subir la imagen.");
}

function crear_producto() {
    if (empty($_POST['nombre']) || empty($_POST['precio']) || empty($_POST['descripcion']) || empty($_FILES['imagen']['name'])) {
        throw new Exception("Faltan datos obligatorios para crear el producto.");
    }
    
    try {
        $nombre_imagen = manejar_subida_imagen();
        
        $datos = [
            'nombre'      => $_POST['nombre'],
            'precio'      => $_POST['precio'],
            'descripcion' => $_POST['descripcion'],
            'imagen'      => $nombre_imagen 
        ];
        
        return crear_datos_producto($datos);
        
    } catch (PDOException $e) {
        throw new Exception("Error al guardar el producto: " . $e->getMessage());
    }
}

function actualizar_producto(){
    if (empty($_POST['id'])) {
        throw new Exception("No se encontró el ID del producto para la actualización.");
    }

    $datos = [];
    
    if (!empty($_POST['nombre'])) $datos['nombre'] = $_POST['nombre'];
    if (!empty($_POST['precio'])) $datos['precio'] = $_POST['precio'];
    if (!empty($_POST['descripcion'])) $datos['descripcion'] = $_POST['descripcion'];
    
    if (!empty($_FILES['imagen']['name'])) {
        $datos['imagen'] = manejar_subida_imagen();
    }

    if (empty($datos)) {
        throw new Exception("No hay datos para actualizar.");
    }

    try {
        $id = (int) $_POST['id'];
        return actualizar_datos_producto($id, $datos);
                
    } catch (PDOException $e) {
        throw new Exception("Error al actualizar el producto: " . $e->getMessage());
    }
}

function borrar_producto(){

    try{

        $id =(int) $_POST['id'];

        return borrar_datos_producto($id);

    }catch(PDOException $e){
        throw new Exception("Error al borrar el producto: " . $e->getMessage());
    }

}

$metodo = $_SERVER['REQUEST_METHOD'];
$action = $_POST['action'];

if ($metodo === "POST") {
    
    try {
        $producto_id = null;

        switch ($action) {
            case 'create':
                $producto_id = crear_producto();
                $message = "Producto creado con éxito.";
                break;
            
            case 'update':
                $producto_id = actualizar_producto();
                $message = "Producto actualizado con éxito.";
                break;
            
            case 'delete':
                $producto_id = borrar_producto();
                $message = "Producto borrado con éxito.";
                break;
                
            default:
                http_response_code(400);
                throw new Exception("Acción no válida o faltante.");
        }
        
        header('Location: ' . BASE_URL . 'controladores/controlador_dashboard.php?action=view_dashboard&status=success&message=' . urlencode($message));
        exit;
        
    } catch (Exception $e) {
        $error_code = ($e->getCode() !== 0) ? $e->getCode() : 500;
        http_response_code($error_code);
        header('Location: ' . BASE_URL . 'controladores/controlador_dashboard.php?action=view_dashboard&status=error&message=' . urlencode($e->getMessage()));
        exit;
    }

} else {
    http_response_code(405);
    die("Método no permitido.");
}
?>