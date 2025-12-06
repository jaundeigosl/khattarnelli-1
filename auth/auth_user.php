<?php
session_start();
include_once "../modelos/modelo_usuarios.php";

if(isset($_POST['username']) && isset($_POST['password'])) {
    try {
        $usuario = ModeloUsuarios::verificarCredenciales($_POST['username'], $_POST['password']);
        
        if($usuario) {
            $_SESSION['user'] = $usuario;
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_role'] = $usuario['rol'] ?? 'user'; // Valor por defecto
            
            $_SESSION['login_time'] = time();
            
            // SOLUCIÓN: Ruta corregida
            header("Location: ../dashboard/dashboard.php");
            exit();
        } else {
            header("Location: ../login/login.php?error=1");
            exit();
        }
    } catch (Exception $e) {
        error_log("Error de autenticación: " . $e->getMessage());
        header("Location: ../login/login.php?error=2");
        exit();
    }
} else {
    header("Location: ../login/login.php");
    exit();
}
?>