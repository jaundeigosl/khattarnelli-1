

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
        <form action="verificar_login.php" method="POST" class="login-form">
            
            <div class="form-group">
                <label for="nombre">Nombre de Usuario:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            
            <div class="form-group">
                <label for="passw">Contraseña:</label>
                <input type="password" id="passw" name="passw" required>
            </div>
            
            <button type="submit" class="btn-login">Iniciar Sesión</button>
            
            <?php 
                // Asegúrate de incluir esto en tu archivo PHP real
                // if (isset($_GET['error'])) { echo '<p class="error-message">Credenciales incorrectas.</p>'; }
            ?>
        </form>
    </div>

</body>
</html>