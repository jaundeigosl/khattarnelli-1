<?php

include_once "../../paths.php";
include_once "../../db/database.php";

function obtener_datos_pedidos() {

    try {
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();

        $datos = [];
    
        $stmt = $pdo->query("SELECT nombre, total, productos ,ubicacion, correo, telefono, metodo_de_pago, estado FROM pedidos ORDER BY fecha DESC LIMIT 15");
        $datos['ultimos_pedidos'] = $stmt->fetchAll();

        return $datos;

    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

}

function crear_pedidos($nombre, $total, $productos, $ubicacion, $correo, $telefono, $metodo_de_pago, $estado){
    try {

        $conexion = Database::getInstance(DB_CONFIG)->getConnection();

        $query = "INSERT INTO pedidos (nombre, total, productos ,ubicacion, correo, telefono, metodo_de_pago, estado) VALUES(?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt = $conexion->prepre($query);
        $stmt->execute([$nombre, $total, $productos, $ubicacion, $correo, $telefono, $metodo_de_pago, $estado]);

        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
}

function actualizar_pedidos($id, $estado){

    try{
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();

        $query = "UPDATE pedidos SET estado = ? WHERE id = ?;";
        $stmt = $conexion->prepre($query);
        $stmt->execute([$estado , $id]);

    }catch(\PDOException $e){
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

}

function borrar_pedidos($id){

    try{
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();

        $query = "DELETE FROM pedidos WHERE id = ?";
        $stmt = $conexion->prepre($query);
        $stmt->execute([$id]);

    }catch(\PDOException $e){
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

}