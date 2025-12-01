<?php
$base_dir = __DIR__;
include_once $base_dir . '/vendor/autoload.php'; 

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable($base_dir);
$dotenv->load();

define("BASE_URL", $_ENV['APP_BASE_URL']); 

include_once $base_dir . '/db/config.php'; 

define("DB_CONFIG", $db_config);

?>