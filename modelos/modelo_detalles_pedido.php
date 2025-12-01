<?php

include_once "../../paths.php";
include_once "../../db/database.php";

function obtener_datos_detalles_pedido() {

    try {
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();
    } catch (\PDOException $e) {
         throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    $datos = [];
    
    $stmt = $pdo->query("SELECT nombre, total, productos ,ubicacion, correo, telefono, metodo_de_pago, estado FROM detalles_pedido");
    $datos['detalles_pedido'] = $stmt->fetchAll();

    return $datos;
}

function crear_detalles_pedido($pedido_id, $producto_id, $cantidad, $precio_unitario){

    try {
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();

        $query = "INSERT INTO detalles_pedido (pedido_id, producto_id, cantidad, precio_unitario) VALUES(?, ?, ?, ?);";
        $stmt = $conexion->prepre($query);
        $stmt->execute([$pedido_id, $producto_id, $cantidad, $precio_unitario]);
        
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

}