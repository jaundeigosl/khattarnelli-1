<?php

define('SESSION_TIMEOUT', 1800);
define('SESSION_REGENERATE_TIME', 300); 
define('LOGIN_URL', '../login/login.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['last_regeneration'])) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
} elseif (time() - $_SESSION['last_regeneration'] > SESSION_REGENERATE_TIME) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

if (!isset($_SESSION['user'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['ajax'])) {
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    }
    
    header("Location: " . LOGIN_URL . "?error=not_logged_in");
    exit();
}

if (isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT) {
        session_unset();
        session_destroy();
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        header("Location: " . LOGIN_URL . "?error=timeout");
        exit();
    }
}

$_SESSION['last_activity'] = time();

?>