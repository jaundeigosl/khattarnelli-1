<?php
session_start();

if(isset($_SESSION['user'])) {
    header("Location: ../dashboard/dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Administrativo | Dashboard</title>
    <link rel="stylesheet" href="login_styles.css"> 
</head>
<body>

    <div class="login-container">
        <h2>Panel de Administración</h2>
        <img src="../../images/logo/ChatGPT Image 19 nov 2025, 13_26_41.png" class="logo">
        
        <form action="../../auth/auth_user.php" method="POST" class="login-form">
            
            <div class="form-group">
                <label for="username">Nombre de Usuario:</label>
                <input type="text" id="username" name="username" required 
                       value="<?php echo isset($_GET['username']) ? htmlspecialchars($_GET['username']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn-login">Iniciar Sesión</button>
            
            <?php 
                if (isset($_GET['error'])) { 
                    echo '<p class="error-message">Credenciales incorrectas.</p>'; 
                }
            ?>
        </form>
    </div>

</body>
</html>