<?php
include_once '../../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__."/..");
$dotenv->load();

$host = $_ENV['DB_HOST'];
$name = $_ENV['DB_DATABASE'];
$username = $_ENV['DB_USERNAME'];
$passw = $_ENV['DB_PASSWORD'];

$db_config = [
    'db' => [
        'host' => $host,
        'user' => $username,
        'pass' => $passw,
        'name' => $name,
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
        
    ]
];

?>