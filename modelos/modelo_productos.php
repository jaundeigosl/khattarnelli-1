<?php

include_once "../../paths.php";
include_once "../../db/database.php";

function obtener_datos_productos() {

    try {
        $conexion = Database::getInstance(DB_CONFIG)->getConnection();

        $query = "SELECT id, nombre, precio, descripcion, imagen 
                  FROM productos 
                  ORDER BY created_at DESC 
                  LIMIT 50";

        $stmt = $conexion->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}
