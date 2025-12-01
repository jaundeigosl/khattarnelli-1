<?php

include_once "../../paths.php";
include_once "../../db/database.php";

function obtener_datos_pedidos() {

    try {
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();
    } catch (\PDOException $e) {
         throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    $datos = [];
    
    $stmt = $pdo->query("SELECT nombre, total, productos ,ubicacion, correo, telefono, metodo_de_pago, estado FROM pedidos ORDER BY fecha DESC LIMIT 15");
    $datos['ultimos_pedidos'] = $stmt->fetchAll();

    return $datos;
}

function crear_pedidos($nombre, $total, $productos, $ubicacion, $correo, $telefono, $metodo_de_pago, $estado){
    try {
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    $query = ""
}

function actualizar_pedidos($nombre, $total, $productos, $ubicacion, $correo, $telefono, $metodo_de_pago, $estado){}

function borrar_pedidos(){}