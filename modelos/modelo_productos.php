<?php

include_once "../../paths.php";
include_once "../../db/database.php";

function obtener_datos_productos() {

    try {
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();
    } catch (\PDOException $e) {
         throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    $datos = [];
    
    $stmt = $pdo->query("SELECT nombre, precio, descripcion,imagen FROM productos ORDER BY fecha DESC LIMIT 15");
    $datos['ultimos_productos'] = $stmt->fetchAll();

    return $datos;
}

function crear_producto($nombre, $precio, $descripcion, $imagen){}

function actualizar_producto($nombre, $precio, $descripcion, $imagen){}

function borrar_producto(){}