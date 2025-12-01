<?php

class Database {
    // Variable estática para almacenar la única instancia (Singleton)
    private static $instance = null;
    
    // Objeto PDO para la conexión
    private $connection;

    // Constructor privado para evitar la creación de instancias con 'new'
    private function __construct($db_config) {
        $this->connect($db_config);
    }

    // Método de conexión real
    private function connect($db_config) {
        $host = $db_config['db']['host'];
        $user = $db_config['db']['user'];
        $pass = $db_config['db']['pass'];
        $db_name = $db_config['db']['name']; // Usamos 'name' como en tu config
        $options = $db_config['db']['options'];

        $dsn = "mysql:host={$host};dbname={$db_name};charset=utf8mb4";

        try {
            $this->connection = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            // Si la conexión falla, detenemos el script y mostramos el error
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    /**
     * Método estático público para obtener la única instancia de la clase.
     * Si no existe, la crea.
     */
    public static function getInstance($db_config) {
        if (self::$instance === null) {
            self::$instance = new Database($db_config);
        }
        return self::$instance;
    }

    /**
     * Devuelve el objeto PDO. Este es el método que usarás en tu aplicación.
     */
    public function getConnection() {
        return $this->connection;
    }

    // Prevenir clonación y deserialización
    private function __clone() {}
    public function __wakeup() {}
}