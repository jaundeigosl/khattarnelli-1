<?php

include_once "../paths.php";
include_once "../db/database.php";

class ModeloUsuarios {
    
    public static function obtenerUsuarioPorUsername($username) {
        try {
            $conexion = Database::getInstance(DB_CONFIG)->getConnection();

            $query = "SELECT id, nombre, passw
                      FROM usuarios 
                      WHERE nombre = :username
                      LIMIT 1";

            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new PDOException("Error al obtener el usuario: " . $e->getMessage(), (int)$e->getCode());
        }
    }

    public static function verificarCredenciales($username, $password) {
        try {
            $usuario = self::obtenerUsuarioPorUsername($username);
            
            if (!$usuario) {
                return false;
            }

            // IMPORTANTE: Acceder al campo 'passw' no 'password'
            if (password_verify($password, $usuario['passw'])) {
                unset($usuario['passw']);
                return $usuario;
            }

            return false;

        } catch (PDOException $e) {
            throw new PDOException("Error al verificar credenciales: " . $e->getMessage(), (int)$e->getCode());
        }
    }
}