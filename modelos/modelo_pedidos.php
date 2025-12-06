<?php

include_once "../../paths.php";
include_once "../../db/database.php";

function obtener_datos_pedidos() {

    try {
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();

        $stmt = $conexion->query("
            SELECT id, nombre, total, productos, ubicacion, correo, telefono, metodo_de_pago, 
                   estado, created_at, tipo_envio, costo_envio 
            FROM pedidos 
            ORDER BY created_at DESC 
            LIMIT 50
        ");
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}

function crear_pedidos(
    $nombre,
    $total,
    $productos,
    $ubicacion,
    $correo,
    $telefono,
    $metodo_pago,
    $estado,
    $tipo_envio,
    $costo_envio,
    $payment_gateway,
    $transaction_id
) {
    try {
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();

        $query = "INSERT INTO pedidos 
            (nombre, total, productos, ubicacion, correo, telefono, metodo_de_pago, 
             estado, tipo_envio, costo_envio, payment_gateway, transaction_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conexion->prepare($query);
        $stmt->execute([
            $nombre,
            $total,
            $productos,
            $ubicacion,
            $correo,
            $telefono,
            $metodo_pago,
            $estado,
            $tipo_envio,
            $costo_envio,
            $payment_gateway,
            $transaction_id
        ]);

    } catch (\PDOException $e) {
        die("ERROR BD: " . $e->getMessage());
    }
}


function actualizar_pedidos($id, $estado){

    try {
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();

        $stmt = $conexion->prepare("UPDATE pedidos SET estado = ? WHERE id = ?");
        $stmt->execute([$estado, $id]);

    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}

function borrar_pedidos($id){

    try {
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();

        $stmt = $conexion->prepare("DELETE FROM pedidos WHERE id = ?");
        $stmt->execute([$id]);

    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}

function obtener_pedido_por_id($id) {

    try {
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();

        $sql = "SELECT * FROM pedidos WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}

function actualizar_estado_pedido($id, $estado) {

    try {
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();

        $sql = "UPDATE pedidos SET estado = ? WHERE id = ?";
        $stmt = $conexion->prepare($sql);

        return $stmt->execute([$estado, $id]);

    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}



