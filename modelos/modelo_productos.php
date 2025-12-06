<?php

require_once __DIR__ . "/../paths.php";

require_once __DIR__ . "../../db/database.php";

function obtener_datos_productos($offset = 0, $limit = 50) {

    try {
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();

        $query = "SELECT id, nombre, precio, descripcion, imagen 
                  FROM productos 
                  ORDER BY created_at DESC 
                  LIMIT :limit OFFSET :offset"; 

        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        throw new PDOException("Error al obtener los productos ");
    }
}

function crear_datos_producto($datos){

    try{

        $conexion = Database::getInstance(DB_CONFIG)->getConnection();
        $query = "INSERT INTO productos (nombre, precio, descripcion, imagen) VALUES (:nombre, :precio, :descripcion, :imagen)";
        $stmt = $conexion->prepare($query);
        $stmt->execute($datos);
        return $conexion->lastInsertId();

    }catch(PDOException $e){
        throw new PDOException("Error al crear el producto");
    }

}

function actualizar_datos_producto( $id,  $datos){
    try {
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();

        $query = "UPDATE productos SET nombre = :nombre, precio = :precio, descripcion = :descripcion, 
                  imagen = :imagen, updated_at = CURRENT_TIMESTAMP() WHERE id = :id";
        
        $stmt = $conexion->prepare($query);
        
        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':precio', $datos['precio']);
        $stmt->bindParam(':descripcion', $datos['descripcion']);
        $stmt->bindParam(':imagen', $datos['imagen']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        $stmt->execute();
        
        return $stmt->rowCount() > 0; 
        
    } catch (PDOException $e) {
        throw new PDOException("Error al actualizar producto: " . $e->getMessage(), (int)$e->getCode());
    }
}

function borrar_datos_producto($id){
    try {
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();

        $query = "DELETE FROM productos WHERE id = :id";
        
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
        
    } catch (PDOException $e) {
        throw new PDOException("Error al borrar producto: " . $e->getMessage(), (int)$e->getCode());
    }

}

function obtener_producto_por_id($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
