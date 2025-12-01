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

function crear_pedidos($nombre, $total, $productos, $ubicacion, $correo, $telefono, $metodo_de_pago, $estado){
    try {
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    $query = "INSERT INTO detalles_pedido (nombre, total, productos ,ubicacion, correo, telefono, metodo_de_pago, estado) VALUES(?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = $conexion->prepre($query);
    $stmt->execute([$nombre, $total, $productos, $ubicacion, $correo, $telefono, $metodo_de_pago, $estado]);
}

function actualizar_pedidos($id, $estado){

    try{
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();
    }catch(\PDOException $e){
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    $query = "UPDATE detalles_pedido SET estado = ? WHERE id = ?;";
    $stmt = $conexion->prepre($query);
    $stmt->execute([$estado , $id]);

}

function borrar_pedidos($id){

    try{
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();
    }catch(\PDOException $e){
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    $query = "DELETE FROM detalles_pedido WHERE id = ?";
    $stmt = $conexion->prepre($query);
    $stmt->execute([$id]);

}