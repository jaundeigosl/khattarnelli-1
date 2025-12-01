<?php

include_once "config.php";

$host = $db_config['db']['host'];
$user = $db_config['db']['user'];
$pass = $db_config['db']['pass'];
$db_name = $db_config['db']['name']; 
$options = $db_config['db']['options'];

try {

    //conexion al server mysql

    $dsn_server = "mysql:host={$host};charset=utf8mb4"; 
    
    $conexion_server = new PDO($dsn_server, $user, $pass, $options);
    
    $sql = file_get_contents("creation.sql");
    
    $conexion_server->exec($sql);

    //conexion a la bd
    $dsn_db = "mysql:host={$host};dbname={$db_name};charset=utf8mb4";
    $conexion_db = new PDO($dsn_db, $user, $pass, $options);
    $hashed_passw = password_hash("admin123", PASSWORD_DEFAULT);
    
    $create_user_sql = "INSERT INTO usuarios (nombre, passw) VALUES (?, ?)";
    $stmt = $conexion_db->prepare($create_user_sql);
    $stmt->execute(['admin', $hashed_passw]);

}catch(PDOException $error) {
    echo $error->getMessage();
}


?>