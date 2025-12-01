<?php

include_once "../../paths.php";
include_once "../../db/database.php";

function obtener_datos_productos() {

    try {
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();

        $datos = [];
        $numero_productos = 15;

        $query = "SELECT nombre, precio, descripcion,imagen FROM productos ORDER BY fecha DESC LIMIT ?";
        $stmt = $conexion->prepare($query);
        if( $stmt->execute([$numero_productos])){
            $datos = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $datos;

    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

}

function crear_producto($nombre, $precio, $descripcion, $imagen){

    try {
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();

        $query = "INSERT INTO productos (nombre, precio, descripcion, imagen) VALUES(?, ?, ?, ?);";
        $stmt = $conexion->prepare($query);
        $stmt->execute([$nombre, $precio, $descripcion, $imagen]);

    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

}


function actualizar_producto($id, $nombre, $precio, $descripcion, $imagen){
    try {
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();

        $query = "UPDATE productos nombre = ?, precio = ? , descripcion= ? , imagen = ? WHERE id = ?;";
        $stmt = $conexion->prepare($query);
        $stmt->execute([$nombre, $precio, $descripcion, $imagen]);

    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}

function borrar_producto($id){

    try {
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();

        $query = "DELETE FROM productos WHERE id = ?;";
        $stmt = $conexion->prepare($query);
        $stmt->execute([$id]);

    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

}