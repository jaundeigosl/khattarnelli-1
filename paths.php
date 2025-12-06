<?php
$base_dir = __DIR__;
include_once $base_dir . '/vendor/autoload.php'; 


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable($base_dir);
$dotenv->load();

define("BASE_URL", $_ENV['APP_BASE_URL']); 
define('ROOT_PATH',  $_ENV['APP_BASE_ROOT']);
include_once $base_dir . '/db/config.php'; 

define("DB_CONFIG", $db_config);

?>